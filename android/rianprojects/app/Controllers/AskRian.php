<?php
namespace App\Controllers;

class AskRian extends BaseController
{
    public function chat()
    {
        try {
            $message = trim($this->request->getPost('message') ?? '');
            
            if (empty($message)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'Pesan tidak boleh kosong.',
                    'csrf'  => csrf_hash()
                ]);
            }

            $throttler = \Config\Services::throttler();
            if ($throttler->check(md5($this->request->getIPAddress() . '_askrian'), 5, MINUTE) === false) {
                return $this->response->setStatusCode(429)->setJSON([
                    'error' => 'Kamu bertanya terlalu cepat! Tunggu sekitar 1 menit ya.',
                    'csrf'  => csrf_hash()
                ]);
            }

            $envKeys = getenv('GEMINI_API_KEYS') ?: (isset($_ENV['GEMINI_API_KEYS']) ? $_ENV['GEMINI_API_KEYS'] : env('GEMINI_API_KEYS'));
            
            if (empty($envKeys)) {
                return $this->response->setStatusCode(500)->setJSON([
                    'error' => 'Variabel GEMINI_API_KEYS belum ditambahkan di file .env Anda.',
                    'csrf'  => csrf_hash()
                ]);
            }
            
            $apiKeys = array_filter(array_map('trim', explode(',', $envKeys)));
            shuffle($apiKeys); 
            $systemInstructions = "Nama Anda adalah 'AskRian AI', asisten virtual resmi untuk website Rian Projects (rianprojects.my.id). " .
                "ATURAN MUTLAK: Anda HANYA diizinkan menjawab pertanyaan yang berkaitan dengan Rian Projects, layanan Rian (web development, AI, UI/UX), portofolio Rian, atau informasi kontak Rian. " .
                "JIKA PENGGUNA BERTANYA DI LUAR KONTEKS TERSEBUT, ANDA WAJIB MENOLAK dengan sopan dan arahkan mereka kembali untuk bertanya tentang Rian Projects. " .
                "Gunakan bahasa yang profesional, ramah, dan singkat. Format text output harus menggunakan HTML (<p>, <strong>, <br>).".
                "Informasi kontak arahkan ke floating wa, dan ke page https://rianprojects.my.id/porto";

            $payload = [
                "systemInstruction" => ["parts" => [["text" => $systemInstructions]]],
                "contents" => [
                    ["role" => "user", "parts" => [["text" => $message]]]
                ]
            ];

            $jsonPayload = json_encode($payload);
            $success = false;
            $reply = '';
            $lastError = '';

            foreach ($apiKeys as $key) {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$key}";

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $jsonPayload,
                    CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
                    CURLOPT_TIMEOUT => 30
                ]);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($httpCode === 200) {
                    $responseData = json_decode($response, true);
                    $reply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    if (!empty($reply)) {
                        $success = true;
                        break;
                    }
                } elseif ($httpCode === 429) {

                    $lastError = 'Semua kuota API sedang penuh. Coba lagi nanti.';
                    continue; 
                } else {

                    $responseData = json_decode($response, true);
                    $lastError = $responseData['error']['message'] ?? "Error HTTP {$httpCode}";
                    break;
                }
            }

            if (!$success) {
                return $this->response->setStatusCode(500)->setJSON([
                    'error' => 'AskRian AI sedang sangat sibuk: ' . $lastError,
                    'csrf'  => csrf_hash()
                ]);
            }

            $cleanReply = preg_replace('/```html\n?/i', '', $reply);
            $cleanReply = preg_replace('/```\n?/i', '', $cleanReply);

            return $this->response->setJSON([
                'reply' => trim($cleanReply),
                'csrf'  => csrf_hash() 
            ]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Sistem Error: ' . $e->getMessage(),
                'csrf'  => csrf_hash()
            ]);
        }
    }
}