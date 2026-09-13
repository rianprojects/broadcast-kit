<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\UserPromptModel;

class Transactions extends BaseController
{
    protected $transModel;
    protected $userPromptModel;

    public function __construct()
    {
        $this->transModel = new TransactionModel();
        $this->userPromptModel = new UserPromptModel();
    }

    public function index()
    {
        // Ambil data transaksi gabung dengan tabel users & prompts
        $transactions = $this->transModel
            ->select('transactions.*, users.username, ai_prompts.title as prompt_title')
            ->join('users', 'users.id = transactions.user_id')
            ->join('ai_prompts', 'ai_prompts.id = transactions.prompt_id')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Manage Transactions',
            'transactions' => $transactions
        ];

        return view('admin/transactions/index', $data);
    }

    // LOGIKA PERSETUJUAN
    public function approve($id)
    {
        $trans = $this->transModel->find($id);

        // PERBAIKAN: Kita buat lebih fleksibel, jika status 'pending' ATAU kosong/null
        if ($trans && ($trans['status'] == 'pending' || empty($trans['status']))) {
            
            // 1. Update Status Transaksi jadi Approved
            $this->transModel->update($id, ['status' => 'approved']);

            // 2. Buka Kunci Prompt (Masukkan ke tabel user_prompts)
            $exists = $this->userPromptModel->where('user_id', $trans['user_id'])
                                            ->where('prompt_id', $trans['prompt_id'])
                                            ->first();
            
            if (!$exists) {
                $this->userPromptModel->save([
                    'user_id' => $trans['user_id'],
                    'prompt_id' => $trans['prompt_id']
                ]);
            }

            return redirect()->to('admin/transactions')->with('success', 'Transaksi disetujui! Prompt user telah dibuka.');
        }

        return redirect()->to('admin/transactions')->with('error', 'Gagal: Transaksi sudah diproses atau data tidak lengkap.');
    }

    // LOGIKA PENOLAKAN
    public function reject($id)
    {
        $this->transModel->update($id, ['status' => 'rejected']);
        return redirect()->back()->with('success', 'Transaksi ditolak.');
    }
}