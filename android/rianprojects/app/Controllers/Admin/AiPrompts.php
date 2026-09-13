<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AiPromptModel;

class AiPrompts extends BaseController
{
    protected $promptModel;

    public function __construct()
    {
        $this->promptModel = new AiPromptModel();
        helper(['form', 'url', 'filesystem', 'text']);
    }

    public function index()
    {
        $data = [
            'title' => 'Manage AI Prompts',
            'prompts' => $this->promptModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/aiprompts/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add AI Prompt',
            'prompt_data' => null
        ];
        return view('admin/aiprompts/form', $data);
    }

    public function edit($id)
    {
        $prompt = $this->promptModel->find($id);
        if (!$prompt) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data = [
            'title' => 'Edit AI Prompt',
            'prompt_data' => $prompt
        ];
        return view('admin/aiprompts/form', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        

        $rules = [
            'title'        => 'required|min_length[5]',
            'prompt'       => 'required',
            'creator_name' => 'required',
            'type'         => 'required|in_list[free,premium]'
        ];


        if ($type === 'premium') {
            $rules['price'] = 'required|numeric|greater_than[0]';
        }


        if (empty($id)) {
            $rules['image'] = 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,10048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $slug = url_title($this->request->getPost('title'), '-', true);
        
        $data = [
            'id'               => $id,
            'user_id'          => session()->get('user_id'),
            'title'            => $this->request->getPost('title'),
            'slug'             => $slug . '-' . time(),
            'description'      => $this->request->getPost('description'),
            'prompt'           => $this->request->getPost('prompt'),
            'creator_name'     => $this->request->getPost('creator_name'),
            'type'             => $type,
            'price'            => ($type === 'free') ? 0 : $this->request->getPost('price'),
            'social_instagram' => $this->request->getPost('social_instagram'),
            'social_tiktok'    => $this->request->getPost('social_tiktok'),
            'social_facebook'  => $this->request->getPost('social_facebook'),
            'social_threads'   => $this->request->getPost('social_threads'),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {

            if (!empty($id)) {
                $oldData = $this->promptModel->find($id);
                if ($oldData['image'] && file_exists('uploads/prompts/' . $oldData['image'])) {
                    unlink('uploads/prompts/' . $oldData['image']);
                }
            }

            $fileNameWebp = $file->getRandomName() . '.webp';
            $uploadPath = 'uploads/prompts';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

            \Config\Services::image()
                ->withFile($file->getTempName())
                ->resize(1024, 1024, true, 'height')
                ->convert(IMAGETYPE_WEBP)
                ->save($uploadPath . '/' . $fileNameWebp, 80);

            $data['image'] = $fileNameWebp;
        }

        $this->promptModel->save($data);

        return redirect()->to('/admin/ai-prompts')->with('success', 'Prompt saved successfully!');
    }

    public function delete($id)
    {
        $prompt = $this->promptModel->find($id);
        if ($prompt) {
            $path = 'uploads/prompts/' . $prompt['image'];
            if (file_exists($path)) unlink($path);
            $this->promptModel->delete($id);
        }
        return redirect()->to('/admin/ai-prompts')->with('success', 'Deleted successfully');
    }
}