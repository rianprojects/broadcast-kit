<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $email;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->email = \Config\Services::email();
        helper(['form', 'url', 'text']);
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return session()->get('role') == 'admin' 
                ? redirect()->to('/admin') 
                : redirect()->to('/dashboard');
        }

        return view('auth/login', [
            'title' => 'Login Account',
            'site_key' => env('RECAPTCHA_SITE_KEY'),
            'recaptcha_enabled' => $this->isRecaptchaEnabled()
        ]);
    }

    public function loginProcess()
    {
        $throttler = \Config\Services::throttler();
        $ip = $this->request->getIPAddress();
        if ($throttler->check('login_' . md5($ip), 5, MINUTE) === false) {
            return redirect()->back()->withInput()
                ->with('error', 'Terlalu banyak percobaan login. Silakan tunggu 1 menit.');
        }

        $recaptchaResult = $this->verifyRecaptcha();
        
        if ($recaptchaResult !== true) {
            return redirect()->back()->withInput()->with('error', 'Verifikasi keamanan gagal. Silakan coba lagi.');
        }
    
        $loginId  = $this->request->getPost('email');
        $password = $this->request->getPost('password');
    
        if (empty($loginId) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Email/Username dan Password harus diisi.');
        }
    
        $user = $this->userModel->groupStart()
                                ->where('username', $loginId)
                                ->orWhere('email', $loginId)
                                ->groupEnd()
                                ->first();
    
        if ($user && password_verify($password, $user['password'])) {
    
            if ($user['is_active'] == 0) {
                return redirect()->back()->withInput()
                    ->with('error', 'Akun belum aktif. Silakan cek email Anda.');
            }
    
            // Cek banned
            if ($user['status'] === 'banned') {
                return redirect()->back()->withInput()
                    ->with('error', 'Akun Anda telah diblokir. Hubungi administrator.');
            }
    
            // Gunakan 'user_id' agar konsisten di semua tempat
            session()->set([
                'user_id'    => $user['id'],  // ← fix: ganti 'id' jadi 'user_id'
                'username'   => $user['username'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'full_name'  => $user['full_name'],
                'isLoggedIn' => true,
            ]);
    
            return ($user['role'] == 'admin')
                ? redirect()->to('/admin')
                : redirect()->to('/dashboard');
        }
    
        return redirect()->back()->withInput()
            ->with('error', 'Email/Username atau Password salah.');
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) return redirect()->to('/dashboard');
        
        return view('auth/register', [
            'title' => 'Create Account',
            'site_key' => env('RECAPTCHA_SITE_KEY'),
            'recaptcha_enabled' => $this->isRecaptchaEnabled()
        ]);
    }

    public function registerProcess()
    {
        if (!$this->validate([
            'username' => [
                'rules'  => 'required|min_length[3]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'is_unique' => 'Username sudah dipakai orang lain.'
                ]
            ],
            'email'    => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email ini sudah terdaftar.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'confpassword' => [
                'rules'  => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $recaptchaResult = $this->verifyRecaptcha();
        
        if ($recaptchaResult !== true) {
            log_message('warning', 'reCAPTCHA failed on register: ' . $recaptchaResult);
            return redirect()->back()->withInput()->with('error', 'Verifikasi keamanan gagal. Silakan coba lagi.');
        }

        $token = bin2hex(random_bytes(20));
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role'     => 'user',
            'is_active' => 0,
            'activation_token' => $token
        ]);

        $link = base_url("auth/activate/$token");
        $message = "Halo, terima kasih telah mendaftar.<br><br>Silakan klik link berikut untuk mengaktifkan akun Anda:<br><a href='$link'>$link</a>";
        
        if($this->sendEmail($this->request->getPost('email'), 'Aktivasi Akun AI Prompt', $message)){
            return redirect()->to('/login')->with('success', 'Registrasi berhasil! Cek email untuk aktivasi.');
        } else {
            return redirect()->to('/login')->with('error', 'Registrasi berhasil tapi email gagal terkirim. Hubungi admin.');
        }
    }

    public function activate($token)
    {
        $user = $this->userModel->where('activation_token', $token)->first();

        if ($user) {
            $this->userModel->update($user['id'], [
                'is_active' => 1,
                'activation_token' => null
            ]);
            return redirect()->to('/login')->with('success', 'Akun berhasil diaktifkan! Silakan login.');
        }

        return redirect()->to('/login')->with('error', 'Token aktivasi tidak valid atau sudah dipakai.');
    }

    public function forgot()
    {
        return view('auth/forgot', [
            'title'    => 'Lupa Password',
            'site_key' => env('RECAPTCHA_SITE_KEY'),
            'recaptcha_enabled' => $this->isRecaptchaEnabled()
        ]);
    }

    public function forgotProcess()
    {
        $throttler = \Config\Services::throttler();
        $ip = $this->request->getIPAddress();
        if ($throttler->check('forgot_' . md5($ip), 3, MINUTE) === false) {
            return redirect()->back()->with('error', 'Terlalu banyak permintaan. Silakan tunggu 1 menit.');
        }

        $recaptchaResult = $this->verifyRecaptcha();
        if ($recaptchaResult !== true) {
            return redirect()->back()->with('error', 'Verifikasi keamanan gagal. Silakan coba lagi.');
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(20));
            $this->userModel->update($user['id'], [
                'reset_token' => $token,
                'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
            ]);

            $link = base_url("auth/reset/$token");
            $message = "Klik link ini untuk membuat password baru:<br><a href='$link'>$link</a><br><br>Link expired dalam 1 jam.";

            $this->sendEmail($email, 'Reset Password', $message);
        }

        return redirect()->back()->with('success', 'Jika email terdaftar, link reset telah dikirim.');
    }

    public function reset($token)
    {
        $user = $this->userModel->where('reset_token', $token)
                                ->where('reset_expires >=', date('Y-m-d H:i:s'))
                                ->first();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Link reset password tidak valid atau sudah kadaluarsa.');
        }

        return view('auth/reset', ['title' => 'Reset Password', 'token' => $token]);
    }

    public function resetProcess()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confpassword = $this->request->getPost('confpassword');
    
        if($password !== $confpassword) {
            return redirect()->back()->with('error', 'Password konfirmasi tidak cocok.');
        }
    
        $user = $this->userModel->where('reset_token', $token)->first();
    
        if ($user) {

            $this->userModel->update($user['id'], [
                'password'      => $password, 
                'reset_token'   => null,
                'reset_expires' => null
            ]);
            
            return redirect()->to('/login')->with('success', 'Password berhasil diperbarui! Silakan login.');
        }
    
        return redirect()->to('/login')->with('error', 'Gagal mereset password. Token tidak valid.');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    private function sendEmail($to, $subject, $message)
    {
        $this->email->setFrom(env('email.SMTPUser'), 'Rian Projects');
        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);
        
        return $this->email->send();
    }


private function isRecaptchaEnabled()
{
    $settings = \Config\Database::connect()->table('settings')->where('id', 1)->get()->getRowArray();
    return $settings ? (bool) $settings['recaptcha_enabled'] : true;
}

private function verifyRecaptcha()
{
    if (!$this->isRecaptchaEnabled()) {
        return true;
    }

    $token = $this->request->getPost('g-recaptcha-response');
    $secret = env('RECAPTCHA_SECRET_KEY');
    if (ENVIRONMENT === 'development' && empty($secret)) {
        log_message('info', 'reCAPTCHA skipped - development mode without key');
        return true;
    }
    
    if (empty($token)) {
        return 'Silakan centang "I\'m not a robot"';
    }
    
    if (empty($secret)) {
        log_message('error', 'RECAPTCHA_SECRET_KEY tidak diset di .env');
        return 'Konfigurasi reCAPTCHA tidak valid';
    }

    $credential = [
        'secret'   => $secret,
        'response' => $token,
        'remoteip' => $this->request->getIPAddress()
    ];
    
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($verify, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($verify);
    
    if (curl_errno($verify)) {
        $error = curl_error($verify);
        log_message('error', 'cURL Error: ' . $error);
        curl_close($verify);
        return 'Gagal menghubungi server verifikasi';
    }
    
    $httpCode = curl_getinfo($verify, CURLINFO_HTTP_CODE);
    curl_close($verify);
    if ($httpCode !== 200) {
        log_message('error', 'reCAPTCHA API returned HTTP ' . $httpCode);
        return 'Server verifikasi mengembalikan error ' . $httpCode;
    }
    
    $status = json_decode($response, true);
    log_message('debug', 'reCAPTCHA v2 Response: ' . json_encode($status));
    if (!isset($status['success'])) {
        log_message('error', 'Invalid reCAPTCHA response format');
        return 'Response verifikasi tidak valid';
    }
    
    if (!$status['success']) {
        $errors = isset($status['error-codes']) ? implode(', ', $status['error-codes']) : 'unknown';
        log_message('error', 'reCAPTCHA verification failed: ' . $errors);
        return 'Verifikasi reCAPTCHA gagal';
    }

    return true;
}
}