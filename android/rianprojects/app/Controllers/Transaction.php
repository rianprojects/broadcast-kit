<?php
namespace App\Controllers;

use App\Models\AiPromptModel;
use App\Models\TransactionModel;
use App\Models\UserPromptModel;
use App\Libraries\IzumiLib;

class Transaction extends BaseController
{
    public function buy($slug)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $promptModel = new AiPromptModel();
        $prompt = $promptModel->where('slug', $slug)->first();

        if (!$prompt || $prompt['type'] == 'free') {
            return redirect()->to('prompts');
        }

        $data = [
            'title' => 'Beli Prompt: ' . $prompt['title'],
            'p' => $prompt,
            'channels' => []
        ];

        $db = \Config\Database::connect();
        $settings = $db->table('settings')->where('id', 1)->get()->getRowArray();
        if (($settings['payment_mode'] ?? 'manual') === 'tripay') {
            $data['channels'] = (new IzumiLib())->getPaymentChannels();
        } else {
            $data['methods'] = (new \App\Models\PaymentMethodModel())
                ->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
        }

        return view('transaction/buy', $data);
    }

    public function createTripay()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $promptModel = new AiPromptModel();
        $prompt = $promptModel->find($this->request->getPost('prompt_id'));
        $method = $this->request->getPost('payment_method');

        if (!$prompt || $prompt['type'] == 'free' || !$method) {
            return redirect()->back()->with('error', 'Data pembelian tidak valid.');
        }

        $merchantRef = 'PROMPT-' . time() . '-' . $prompt['id'];
        $email = session()->get('email') ?? (session()->get('username') . '@izumistore.com');

        $trx = (new IzumiLib())->createTransaction($merchantRef, (int) $prompt['price'], $prompt['title'], $email, $method);

        if (empty($trx['status']) || $trx['status'] !== 'success_tripay') {
            return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . ($trx['message'] ?? $trx['error'] ?? 'unknown error'));
        }

        $transModel = new TransactionModel();
        $transModel->insert([
            'user_id'        => session()->get('user_id'),
            'prompt_id'      => $prompt['id'],
            'amount'         => $prompt['price'],
            'status'         => 'pending',
            'merchant_ref'   => $trx['merchant_ref'],
            'payment_method' => $trx['payment_method'],
            'reference'      => $trx['reference'],
            'checkout_url'   => $trx['checkout_url'],
        ]);

        // QRIS punya qr_url (gambar QR dari izumistore) -> tampilkan langsung, bukan redirect.
        if (!empty($trx['qr_url'])) {
            return view('transaction/qris', [
                'title' => 'Scan QRIS',
                'p'     => $prompt,
                'trx'   => $trx,
            ]);
        }

        return redirect()->to($trx['checkout_url']);
    }

    /** Dipanggil AJAX dari modal di halaman prompt detail — selalu QRIS, balikin JSON (bukan redirect/view). */
    public function createQrisAjax()
    {
        if (!session()->get('isLoggedIn')) return $this->response->setStatusCode(401)->setJSON(['error' => 'Silakan login dulu.']);

        $promptModel = new AiPromptModel();
        $prompt = $promptModel->find($this->request->getPost('prompt_id'));

        if (!$prompt || $prompt['type'] == 'free') {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Prompt tidak valid.']);
        }

        $merchantRef = 'PROMPT-' . time() . '-' . $prompt['id'];
        $email = session()->get('email') ?? (session()->get('username') . '@izumistore.com');

        $trx = (new IzumiLib())->createTransaction($merchantRef, (int) $prompt['price'], $prompt['title'], $email, 'QRIS');

        if (empty($trx['status']) || $trx['status'] !== 'success_tripay' || empty($trx['qr_url'])) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $trx['message'] ?? $trx['error'] ?? 'Gagal membuat QRIS.']);
        }

        (new TransactionModel())->insert([
            'user_id'        => session()->get('user_id'),
            'prompt_id'      => $prompt['id'],
            'amount'         => $prompt['price'],
            'status'         => 'pending',
            'merchant_ref'   => $trx['merchant_ref'],
            'payment_method' => $trx['payment_method'],
            'reference'      => $trx['reference'],
            'checkout_url'   => $trx['checkout_url'],
        ]);

        return $this->response->setJSON([
            'merchant_ref' => $trx['merchant_ref'],
            'qr_url'       => $trx['qr_url'],
            'amount'       => $prompt['price'],
        ]);
    }

    public function status($merchantRef)
    {
        if (!session()->get('isLoggedIn')) return $this->response->setStatusCode(401)->setJSON(['status' => 'unauthorized']);

        $transModel = new TransactionModel();
        $trans = $transModel->where('merchant_ref', $merchantRef)
            ->where('user_id', session()->get('user_id'))
            ->first();

        if (!$trans) return $this->response->setStatusCode(404)->setJSON(['status' => 'not_found']);

        if ($trans['status'] === 'pending') {
            $remoteStatus = (new IzumiLib())->checkStatus($merchantRef);

            if ($remoteStatus === 'PAID') {
                $transModel->update($trans['id'], ['status' => 'approved']);
                $trans['status'] = 'approved';

                $userPromptModel = new UserPromptModel();
                $exists = $userPromptModel->where('user_id', $trans['user_id'])
                    ->where('prompt_id', $trans['prompt_id'])->first();
                if (!$exists) {
                    $userPromptModel->save(['user_id' => $trans['user_id'], 'prompt_id' => $trans['prompt_id']]);
                }
            } elseif (in_array($remoteStatus, ['EXPIRED', 'FAILED'])) {
                $transModel->update($trans['id'], ['status' => 'rejected']);
                $trans['status'] = 'rejected';
            }
        }

        return $this->response->setJSON(['status' => $trans['status']]);
    }

    public function process()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $promptId = $this->request->getPost('prompt_id');

        $promptModel = new \App\Models\AiPromptModel();
        $promptData  = $promptModel->find($promptId);

        if (!$promptData || $promptData['type'] == 'free') {
            return redirect()->to('prompts')->with('error', 'Prompt tidak valid.');
        }

        $price = $promptData['price'];

        if (!$this->validate([
            'proof' => 'uploaded[proof]|is_image[proof]|max_size[proof,2048]'
        ])) {
            return redirect()->back()->with('error', 'Silakan upload bukti transfer (JPG/PNG maksimal 2MB).');
        }

        $file = $this->request->getFile('proof');
        $fileName = $file->getRandomName();
        $file->move('uploads/proofs', $fileName);

        $transModel = new \App\Models\TransactionModel();
        $transModel->insert([
            'user_id'     => session()->get('user_id'),
            'prompt_id'   => $promptId,
            'amount'      => $price,
            'proof_image' => $fileName,
            'status'      => 'pending'
        ]);

        $transactionId = $transModel->getInsertID();
        $promptTitle   = $promptData['title'];
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId   = env('TELEGRAM_CHAT_ID');

        $proofUrl = base_url('uploads/proofs/' . $fileName); 
        $username = session()->get('username');

        $pesan_telegram = "🚨 *NEW PAYMENT RECEIVED* 🚨\n\n"
            . "👤 *Pembeli:* " . $username . "\n"
            . "🛒 *Prompt:* " . $promptTitle . "\n"
            . "💰 *Nominal:* Rp " . number_format($price, 0, ',', '.') . "\n"
            . "📄 *Bukti TF:* [Klik untuk lihat gambar](" . $proofUrl . ")\n\n"
            . "⚠️ _Silakan cek mutasi, lalu klik tombol di bawah ini:_";

        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '✅ Approve (Buka Akses)', 'callback_data' => 'trx_approve_' . $transactionId]
                ],
                [
                    ['text' => '❌ Reject (Tolak Pembayaran)', 'callback_data' => 'trx_reject_' . $transactionId]
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

        return redirect()->to('dashboard')->with('success', 'Pembayaran dikirim! Menunggu konfirmasi admin.');
    }
}