<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;

class Posts extends BaseController
{
    protected $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        helper(['form', 'url', 'filesystem', 'text']);
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Blog Posts',
            'posts' => $this->postModel->getPostsWithAuthor(5), 
            'pager' => $this->postModel->pager 
        ];
        
        return view('admin/posts/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tulis Artikel Baru'];
        return view('admin/posts/create', $data);
    }

    public function save() 
    {
        if (!$this->validate([
            'title'          => 'required|min_length[5]',
            'content'        => 'required',
            'featured_image' => [
                'rules'  => 'uploaded[featured_image]|is_image[featured_image]|mime_in[featured_image,image/jpg,image/jpeg,image/png,image/webp]|max_size[featured_image,2048]',
                'errors' => [
                    'uploaded' => 'Wajib upload gambar cover.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $file = $this->request->getFile('featured_image');
        $fileName = $this->uploadImage($file);
        $this->postModel->save([
            'title'          => $this->request->getVar('title'),
            'slug'           => url_title($this->request->getVar('title'), '-', true),
            'content'        => $this->request->getVar('content'),
            'featured_image' => $fileName,
            'status'         => $this->request->getVar('status'),
            'author_id'      => session()->get('user_id'),
            'category'       => $this->request->getVar('category') ?: 'General',
            'tags'           => $this->request->getVar('tags'),
            'meta_title'     => $this->request->getVar('meta_title'),
            'meta_desc'      => $this->request->getVar('meta_desc'),
        ]);

        return redirect()->to('/admin/posts')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function edit($id)
    {
        $post = $this->postModel->find($id);
        if (!$post) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data = ['title' => 'Edit Artikel', 'post' => $post];
        return view('admin/posts/edit', $data);
    }

    public function update($id)
    {
        $post = $this->postModel->find($id);
        if (!$post) return redirect()->to('/admin/posts')->with('error', 'Artikel tidak ditemukan.');
        if (!$this->validate([
            'title'   => 'required|min_length[5]',
            'content' => 'required',
            'featured_image' => [
                'rules' => 'is_image[featured_image]|mime_in[featured_image,image/jpg,image/jpeg,image/png,image/webp]|max_size[featured_image,2048]',
            ]
        ])) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'id'             => $id,
            'title'          => $this->request->getVar('title'),
            'slug'           => url_title($this->request->getVar('title'), '-', true),
            'content'        => $this->request->getVar('content'),
            'status'         => $this->request->getVar('status'),
            'category'       => $this->request->getVar('category') ?: 'General',
            'tags'           => $this->request->getVar('tags'),
            'meta_title'     => $this->request->getVar('meta_title'),
            'meta_desc'      => $this->request->getVar('meta_desc'),
        ];

        $file = $this->request->getFile('featured_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $oldFile = 'uploads/blog/' . $post['featured_image'];
            if (file_exists($oldFile) && !empty($post['featured_image'])) {
                unlink($oldFile);
            }
            $data['featured_image'] = $this->uploadImage($file);
        }

        $this->postModel->save($data);
        return redirect()->to('/admin/posts')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function delete($id)
    {
        $post = $this->postModel->find($id);
        if ($post) {
            $filePath = 'uploads/blog/' . $post['featured_image'];
            if (file_exists($filePath) && !empty($post['featured_image'])) {
                unlink($filePath);
            }
            
            $this->postModel->delete($id);
            return redirect()->to('/admin/posts')->with('success', 'Artikel dihapus.');
        }
        return redirect()->to('/admin/posts')->with('error', 'Gagal menghapus.');
    }

    private function uploadImage($file)
    {
        if (!$file->isValid()) return null;

        $uploadPath = 'uploads/blog'; 
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $newName = $file->getRandomName(); 
        $newName = pathinfo($newName, PATHINFO_FILENAME) . '.webp';
        
        \Config\Services::image()
            ->withFile($file->getTempName())
            ->resize(1200, 800, true, 'width')
            ->convert(IMAGETYPE_WEBP)
            ->save($uploadPath . '/' . $newName, 80);

        return $newName;
    }
}