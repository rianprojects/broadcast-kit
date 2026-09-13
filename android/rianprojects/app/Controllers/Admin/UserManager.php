<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManager extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Pengguna',
            'users' => $this->userModel->where('role !=', 'admin')->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/users/index', $data);
    }

    public function verifyUser($id)
    {
        $this->userModel->update($id, [
            'is_active' => 1,
            'activation_token' => null
        ]);
        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil diverifikasi manual!');
    }

    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $newPassword = bin2hex(random_bytes(6));
        $this->userModel->update($id, ['password' => $newPassword]);

        $emailService = \Config\Services::email();
        $emailService->setFrom(env('email.SMTPUser'), 'Rian Projects');
        $emailService->setTo($user['email']);
        $emailService->setSubject('Reset Password oleh Admin');
        $emailService->setMessage("Password akun Anda telah direset oleh administrator.<br><br>Password baru Anda: <strong>{$newPassword}</strong><br><br>Harap segera login dan ganti password Anda.");
        $emailService->send();

        return redirect()->back()->with('success', 'Password direset dan dikirim ke email user.');
    }

    public function loginAs($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->back()->with('error', 'User tidak ditemukan.');
    
        $session = session();
        $adminId = $session->get('user_id') ?? $session->get('id') ?? $session->get('userId');
        $session->set('admin_backup_data', [
            'user_id'    => $adminId,
            'username'   => $session->get('username'),
            'email'      => $session->get('email'),
            'role'       => $session->get('role'),
        ]);
        $session->set('admin_user_id', $adminId);
    
        $session->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
            'logged_in'  => true,
        ]);
    
        return redirect()->to(base_url('dashboard'))
            ->with('success', 'Login sebagai ' . $user['username']);
    }

    public function logoutAs()
    {
        $session = session();
        $adminBackupData = $session->get('admin_backup_data');

        if (!$adminBackupData || empty($adminBackupData['user_id']) || ($adminBackupData['role'] ?? '') !== 'admin') {
            $session->destroy();
            return redirect()->to(base_url('login'))->with('error', 'Sesi admin tidak valid.');
        }
    
        $session->remove([
            'user_id', 'username', 'email', 'role',
            'isLoggedIn', 'logged_in',
            'admin_user_id', 'admin_backup_data'
        ]);
    
        $session->set([
            'user_id'    => $adminBackupData['user_id'],
            'username'   => $adminBackupData['username'],
            'email'      => $adminBackupData['email'],
            'role'       => $adminBackupData['role'],
            'isLoggedIn' => true,
            'logged_in'  => true,
        ]);
    
        return redirect()->to(base_url('admin/users'))->with('success', 'Berhasil kembali sebagai Admin.');
    }
    

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if ($user) {

            $this->userModel->delete($id);
            return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil dihapus secara permanen.');
        }
        return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');
    }

    public function toggleBan($id)
    {
        $user = $this->userModel->find($id);
        if ($user) {
            $newStatus = ($user['status'] == 'active') ? 'banned' : 'active';
            $this->userModel->update($id, ['status' => $newStatus]);
            return redirect()->to(base_url('admin/users'))->with('success', 'Status user diperbarui!');
        }
        return redirect()->to(base_url('admin/users'))->with('error', 'Gagal memproses.');
    }
}