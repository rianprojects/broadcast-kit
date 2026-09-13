<?php

namespace App\Controllers;

use App\Models\AiPromptModel;
use App\Models\CommentModel;

class Prompts extends BaseController
{
    public function index()
    {
        $model = new AiPromptModel();
        
        $data = [
            'title' => 'AI Prompt Library - Rian Projects',
            'prompts' => $model->orderBy('created_at', 'DESC')->paginate(9),
            'pager' => $model->pager
        ];
        
        return view('frontend/prompts_list', $data);
    }
    
    public function detail($slug)
    {
        $model = new AiPromptModel();
        $userPromptModel = new \App\Models\UserPromptModel();
        
        $prompt = $model->where('slug', $slug)->first();

        if (!$prompt) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $isOwned = false;
        $isLoggedIn = session()->get('isLoggedIn');
        $userId = session()->get('user_id');

        if ($isLoggedIn && $prompt['user_id'] == $userId) {
            $isOwned = true;
        }

        elseif ($isLoggedIn && session()->get('role') == 'admin') {
            $isOwned = true;
        }

        elseif ($isLoggedIn) {
            $check = $userPromptModel->where('user_id', $userId)
                                     ->where('prompt_id', $prompt['id'])
                                     ->first();
            if ($check) $isOwned = true;
        }

        if ($prompt['type'] == 'free') {
            $isOwned = true;
        }

        $commentModel = new CommentModel();
        $comments = $commentModel->where('prompt_id', $prompt['id'])
                                 ->orderBy('created_at', 'DESC') 
                                 ->findAll();

        $settings = \Config\Database::connect()->table('settings')->where('id', 1)->get()->getRowArray();
        $paymentMode = $settings['payment_mode'] ?? 'manual';

        $paymentMethods = [];
        if ($paymentMode === 'manual') {
            $paymentMethods = (new \App\Models\PaymentMethodModel())
                ->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
        }

        $data = [
            'title' => $prompt['title'] . ' - AI Prompt Library',
            'p' => $prompt,
            'isOwned' => $isOwned,
            'meta_desc' => $prompt['description'] ?? substr($prompt['prompt'], 0, 150),
            'meta_image' => base_url('uploads/prompts/' . $prompt['image']),
            'comments' => $comments,
            'paymentMode' => $paymentMode,
            'paymentMethods' => $paymentMethods,
        ];

        return view('frontend/prompts_detail', $data);
    }


    public function addComment()
    {

        $rules = [
            'prompt_id' => 'required|numeric',
            'name'      => [
                'rules'  => 'required|trim|min_length[3]|max_length[50]',
                'errors' => [
                    'required'   => 'Nama wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.',
                    'max_length' => 'Nama maksimal 50 karakter.'
                ]
            ],
            'comment'   => [
                'rules'  => 'required|trim|min_length[5]|max_length[1000]',
                'errors' => [
                    'required'   => 'Komentar tidak boleh kosong.',
                    'min_length' => 'Komentar terlalu pendek, minimal 5 karakter.',
                    'max_length' => 'Komentar kepanjangan, maksimal 1000 karakter.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            $firstError = reset($errors); 
            return redirect()->back()->withInput()->with('error', $firstError);
        }

        $commentModel = new CommentModel();
        
        $commentModel->save([
            'prompt_id' => $this->request->getPost('prompt_id'),
            'name'      => trim($this->request->getPost('name')), 
            'comment'   => trim($this->request->getPost('comment'))
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan! 🚀');
    }
    
    public function deleteComment($id)
    {
        
        if (session()->get('role') != 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak! Anda bukan admin.');
        }

        $commentModel = new \App\Models\CommentModel();

        $comment = $commentModel->find($id);
        if ($comment) {
            $commentModel->delete($id);
            return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Komentar tidak ditemukan.');
    }
}