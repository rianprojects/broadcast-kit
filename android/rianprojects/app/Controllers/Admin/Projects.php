<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectModel;

class Projects extends BaseController
{
    protected $projectModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        helper(['form', 'url', 'filesystem']);
    }

    public function index()
    {
        $data = [
            'title'    => 'Manage Projects',
            'projects' => $this->projectModel->orderBy('created_at', 'DESC')->paginate(5, 'projects'),
            'pager'    => $this->projectModel->pager
        ];
        return view('admin/projects/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Project Baru'];
        return view('admin/projects/create', $data);
    }

    public function store()
    {

        if (!$this->validate([
            'title'     => 'required|min_length[3]',
            'thumbnail' => [
 
                'rules' => 'uploaded[thumbnail]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]|max_size[thumbnail,5048]', // Max 5MB gpp, nanti 
                'errors' => [
                    'uploaded' => 'Pilih gambar thumbnail terlebih dahulu.',
                    'is_image' => 'File yang diupload bukan gambar.',
                    'mime_in'  => 'Hanya support JPG, JPEG, PNG, dan WEBP.',
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }


        $file = $this->request->getFile('thumbnail');
        $fileName = $this->uploadImage($file); 

        $this->projectModel->save([
            'title'       => $this->request->getPost('title'),
            'slug'        => url_title($this->request->getPost('title'), '-', true),
            'category'    => $this->request->getPost('category'),
            'client'      => $this->request->getPost('client'),
            'description' => $this->request->getPost('description'),
            'preview_url' => $this->request->getPost('preview_url'),
            'tech_stack'  => $this->request->getPost('tech_stack'),
            'thumbnail'   => $fileName, 
            'meta_title'  => $this->request->getPost('meta_title'),
            'meta_desc'   => $this->request->getPost('meta_desc'),
        ]);

        return redirect()->to('/admin/projects')->with('success', 'Proyek berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $project = $this->projectModel->find($id);
        if (!$project) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data = ['title' => 'Edit Project', 'project' => $project];
        return view('admin/projects/edit', $data);
    }

    public function update($id)
    {
        $project = $this->projectModel->find($id);
        if (!$project) return redirect()->to('/admin/projects')->with('error', 'Data tidak ditemukan.');

        if (!$this->validate([
            'title' => 'required|min_length[3]',
            'thumbnail' => [
                'rules' => 'is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]|max_size[thumbnail,5048]',
            ]
        ])) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'id'          => $id,
            'title'       => $this->request->getPost('title'),
            'slug'        => url_title($this->request->getPost('title'), '-', true),
            'category'    => $this->request->getPost('category'),
            'client'      => $this->request->getPost('client'),
            'description' => $this->request->getPost('description'),
            'preview_url' => $this->request->getPost('preview_url'),
            'tech_stack'  => $this->request->getPost('tech_stack'),
            'meta_title'  => $this->request->getPost('meta_title'),
            'meta_desc'   => $this->request->getPost('meta_desc'),
        ];


        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            

            $oldFile = 'uploads/projects/' . $project['thumbnail'];
            if (file_exists($oldFile) && $project['thumbnail']) {
                unlink($oldFile);
            }


            $fileName = $this->uploadImage($file);
            $data['thumbnail'] = $fileName;
        }

        $this->projectModel->save($data);
        return redirect()->to('/admin/projects')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function delete($id)
    {
        $project = $this->projectModel->find($id);
        if ($project) {
            $filePath = 'uploads/projects/' . $project['thumbnail'];
            if (file_exists($filePath) && $project['thumbnail']) unlink($filePath);
            
            $this->projectModel->delete($id);
            return redirect()->to('/admin/projects')->with('success', 'Proyek telah dihapus.');
        }
        return redirect()->to('/admin/projects')->with('error', 'Gagal menghapus data.');
    }


    private function uploadImage($file)
    {
        if (!$file->isValid()) return null;

        $randomName = $file->getRandomName();
        $nameWithoutExt = pathinfo($randomName, PATHINFO_FILENAME);
        $newName = $nameWithoutExt . '.webp';
        $uploadPath = 'uploads/projects'; 
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $imageService = \Config\Services::image();
        
        $imageService->withFile($file->getTempName())
                     ->resize(1280, 720, true, 'width') 
                     ->convert(IMAGETYPE_WEBP)
                     ->save($uploadPath . '/' . $newName, 80);

        return $newName;
    }
}