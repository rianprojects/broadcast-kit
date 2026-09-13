<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
    
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        $userId = $session->get('user_id');
    
        if ($userId) {
            $userModel = new UserModel();
            $user = $userModel->find($userId);
    
            if (!$user) {
                $session->destroy();
                return redirect()->to('/login')->with('error', 'Akun tidak ditemukan.');
            }
    
            if ($user['status'] === 'banned') {
                $session->destroy();
                return redirect()->to('/login')
                    ->with('error', 'Akun Anda telah diblokir. Hubungi administrator.');
            }
        }
    
        if ($arguments) {
            if (!in_array($session->get('role'), $arguments)) {
                return redirect()->to('/dashboard')
                    ->with('error', 'Akses Ditolak! Halaman ini khusus Administrator.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}