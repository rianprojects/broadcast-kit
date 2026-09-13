<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\AiPromptModel;

class Prompts extends BaseController
{
    protected $promptModel;

    public function __construct()
    {
        $this->promptModel = new AiPromptModel();
        helper(['form', 'url', 'text', 'filesystem']);
    }

    public function index()
    {

        $userId = session()->get('user_id');
        
        $data = [
            'title' => 'Koleksi Prompt Saya',
            'prompts' => $this->promptModel->where('user_id', $userId)
                                           ->orderBy('created_at', 'DESC')
                                           ->findAll()
        ];
        return view('user/prompts/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Upload Karya Baru'];
        return view('user/prompts/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'title' => 'required|min_length[5]',
            'prompt' => 'required|min_length[10]',
            'image' => [
                'rules' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,5048]',
                'errors' => ['uploaded' => 'Wajib upload hasil gambar AI-nya.']
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('image');
        $fileName = $file->getRandomName();
        $fileNameWebp = pathinfo($fileName, PATHINFO_FILENAME) . '.webp';
        
        $uploadPath = 'uploads/prompts';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        \Config\Services::image()
            ->withFile($file->getTempName())
            ->resize(1024, 1024, true, 'height')
            ->convert(IMAGETYPE_WEBP)
            ->save($uploadPath . '/' . $fileNameWebp, 80);

        $slug = url_title($this->request->getPost('title'), '-', true);
        $this->promptModel->save([

            'user_id'       => session()->get('user_id'),
            'title'         => $this->request->getPost('title'),
            'slug'          => $slug . '-' . time(),
            'prompt'        => $this->request->getPost('prompt'),
            'description'   => $this->request->getPost('description'),
            'image'         => $fileNameWebp,
            'creator_name'  => session()->get('username'),
            'type'             => $this->request->getPost('type'),
            'price'            => $this->request->getPost('price') ? $this->request->getPost('price') : 0,
            'social_instagram' => $this->request->getPost('social_instagram'),
            'social_tiktok'    => $this->request->getPost('social_tiktok'),
        ]);

        return redirect()->to('prompts/my')->with('success', 'Prompt berhasil dipublikasikan!');
    }

    public function delete($id)
    {

        $prompt = $this->promptModel->where('id', $id)
                                    ->where('user_id', session()->get('user_id'))
                                    ->first();

        if ($prompt) {
            $path = 'uploads/prompts/' . $prompt['image'];
            if (file_exists($path)) unlink($path);
            $this->promptModel->delete($id);
            return redirect()->to('prompts/my')->with('success', 'Prompt dihapus.');
        }

        return redirect()->to('prompts/my')->with('error', 'Gagal menghapus atau bukan milik Anda.');
    }
}