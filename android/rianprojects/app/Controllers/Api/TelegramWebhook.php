<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\WithdrawalModel;
use App\Models\UserModel;

class TelegramWebhook extends BaseController
{
    public function processWithdraw()
    {

        $secretToken = $this->request->getPost('secret_token');
        if ($secretToken !== env('TELEGRAM_SECRET_TOKEN')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $id     = $this->request->getPost('id');
        $action = $this->request->getPost('action');
        
        $wdModel   = new WithdrawalModel();
        $userModel = new UserModel();
        $wd        = $wdModel->find($id);

        if (!$wd || $wd['status'] != 'pending') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid/sudah diproses']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        if ($action == 'approve') {
            $wdModel->update($id, ['status' => 'completed']);
        } elseif ($action == 'reject') {
            $wdModel->update($id, [
                'status' => 'rejected',
                'notes'  => 'Ditolak oleh Admin via Telegram Bot.'
            ]);
            

            $user = $userModel->find($wd['user_id']);
            $userModel->update($wd['user_id'], [
                'balance' => $user['balance'] + $wd['amount']
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'DB Error']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Status updated to ' . $action]);
    }
    
    public function processTransaction()
    {
        
        $secretToken = $this->request->getPost('secret_token');
        if ($secretToken !== env('TELEGRAM_SECRET_TOKEN')) { 
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $id     = $this->request->getPost('id');
        $action = $this->request->getPost('action'); 

        $db = \Config\Database::connect();
        $builder = $db->table('transactions');
        $trx = $builder->where('id', $id)->get()->getRowArray();

        if (!$trx || $trx['status'] != 'pending') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid/sudah diproses']);
        }


        $newStatus = ($action == 'approve') ? 'approved' : 'rejected';
        $builder->where('id', $id)->update(['status' => $newStatus]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Status updated to ' . $newStatus]);
    }
}