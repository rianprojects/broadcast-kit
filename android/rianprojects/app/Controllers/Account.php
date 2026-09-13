<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\WithdrawalModel;

class Account extends BaseController
{
    public function settings()
    {
        $userModel = new UserModel();
        $data = [
            'title' => 'Pengaturan Akun',
            'user'  => $userModel->find(session()->get('user_id')) 
        ];
        return view('user/user_settings', $data);
    }

    public function updateSettings()
    {

        $userId = session()->get('user_id');

        if (empty($userId)) {
            return redirect()->to('/login')->with('error', 'Sesi Anda telah habis atau ID tidak ditemukan. Silakan login kembali.');
        }

        $data = [
            'phone'             => trim((string) $this->request->getPost('phone')),
            'bank_name'         => trim((string) $this->request->getPost('bank_name')),
            'bank_account'      => trim((string) $this->request->getPost('bank_account')),
            'bank_account_name' => trim((string) $this->request->getPost('bank_account_name')),
        ];

        $userModel = new UserModel();
        $userModel->where('id', $userId)->set($data)->update();

        return redirect()->to(base_url('dashboard'))->with('success', 'Data rekening & profil berhasil diperbarui!');
    }

    public function wallet()
    {
        $userModel = new UserModel();
        $withdrawModel = new WithdrawalModel();
        $userId = session()->get('user_id');

        $data = [
            'title'       => 'Dompet & Pendapatan',
            'user'        => $userModel->find($userId),
            'withdrawals' => $withdrawModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('user/user_wallet', $data);
    }

    public function requestWithdraw()
    {
        $userModel = new UserModel();
        $withdrawModel = new WithdrawalModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);
        
        $bankName        = $user['bank_name'] ?? '';
        $bankAccount     = $user['bank_account'] ?? '';
        $bankAccountName = $user['bank_account_name'] ?? '';
        $balance         = $user['balance'] ?? 0;
        $username        = $user['username'] ?? 'Member'; 

        if(empty($bankName) || empty($bankAccount) || empty($bankAccountName)) {
            return redirect()->to('dashboard/settings')->with('error', 'Harap isi data Lengkap Rekening (termasuk Nama Pemilik) terlebih dahulu sebelum menarik dana!');
        }

        $amount = (int) $this->request->getPost('amount');

        if ($amount < 50000) {
            return redirect()->back()->with('error', 'Minimal penarikan adalah Rp 50.000!');
        }
        
        if ($amount > $balance) {
            return redirect()->back()->with('error', 'Saldo Anda tidak mencukupi!');
        }

        $transfer_fee = ($amount > 1000000) ? 0 : 7500; 
        $platform_fee = $amount * 0.03; 
        $net_amount   = $amount - $transfer_fee - $platform_fee;

        if ($net_amount <= 0) {
            return redirect()->back()->with('error', 'Nominal penarikan terlalu kecil setelah dipotong biaya admin.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        
        $newBalance = $balance - $amount;
        $userModel->update($userId, ['balance' => $newBalance]);

        $withdrawModel->save([
            'user_id'           => $userId,
            'amount'            => $amount,
            'transfer_fee'      => $transfer_fee,
            'platform_fee'      => $platform_fee,
            'net_amount'        => $net_amount,
            'bank_name'         => $bankName,
            'bank_account'      => $bankAccount,
            'bank_account_name' => $bankAccountName,
            'status'            => 'pending'
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Uang Anda aman, silakan coba lagi nanti.');
        }
        
        $withdrawId = $withdrawModel->getInsertID();
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId   = env('TELEGRAM_CHAT_ID');

        $pesan_telegram = "🚨 *NEW WITHDRAWAL REQUEST* 🚨\n\n"
            . "👤 *User:* " . $username . "\n"
            . "🏦 *Bank:* " . $bankName . "\n"
            . "💳 *Rekening:* `" . $bankAccount . "`\n"
            . "📛 *A.N:* " . $bankAccountName . "\n\n"
            . "💰 *Nominal Bersih: Rp " . number_format($net_amount, 0, ',', '.') . "*\n\n"
            . "⚠️ _Silakan transfer secara manual, lalu klik tombol di bawah ini:_";

        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '✅ Sudah Ditransfer (Approve)', 'callback_data' => 'wd_approve_' . $withdrawId]
                ],
                [
                    ['text' => '❌ Tolak & Refund (Reject)', 'callback_data' => 'wd_reject_' . $withdrawId]
                ]
            ]
        ];

        $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage";
        $data = [
            'chat_id'      => $chatId,
            'text'         => $pesan_telegram,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard)
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
        curl_exec($ch);
        curl_close($ch);

        return redirect()->back()->with('success', 'Permintaan penarikan dana berhasil dikirim! Silakan tunggu proses 1-3 hari kerja.');
    }
}