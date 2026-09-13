<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WithdrawalModel;
use App\Models\UserModel;

class WithdrawalManager extends BaseController
{
    public function index()
    {
        $wdModel = new WithdrawalModel();
        $withdrawals = $wdModel->select('withdrawals.*, users.username, users.email')
                               ->join('users', 'users.id = withdrawals.user_id')
                               ->orderBy('withdrawals.created_at', 'DESC')
                               ->findAll();

        $data = [
            'title'       => 'Kelola Penarikan Dana',
            'withdrawals' => $withdrawals
        ];

        return view('admin/withdrawals/index', $data);
    }

    public function process()
    {
        $wdModel   = new WithdrawalModel();
        $userModel = new UserModel();

        $id     = $this->request->getPost('id');
        $action = $this->request->getPost('action');
        $notes  = trim($this->request->getPost('notes'));

        $wd = $wdModel->find($id);


        if (!$wd || $wd['status'] != 'pending') {
            return redirect()->back()->with('error', 'Data tidak valid atau sudah diproses.');
        }


        $db = \Config\Database::connect();
        $db->transStart();

        if ($action == 'approve') {
            $wdModel->update($id, ['status' => 'completed']);
        } elseif ($action == 'reject') {

            $wdModel->update($id, [
                'status' => 'rejected',
                'notes'  => $notes
            ]);

            $user = $userModel->find($wd['user_id']);
            $userModel->update($wd['user_id'], [
                'balance' => $user['balance'] + $wd['amount']
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem!');
        }

        $msg = ($action == 'approve') ? 'Penarikan berhasil disetujui!' : 'Penarikan ditolak dan saldo telah dikembalikan ke user.';
        return redirect()->back()->with('success', $msg);
    }
}