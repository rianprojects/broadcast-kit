<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AiToolModel;
use CodeIgniter\Throttle\Throttler;

class AiLab extends BaseController
{
    protected $db;
    protected $aiToolModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->aiToolModel = new AiToolModel();
        helper(['url', 'form']);
    }
    
    private function isToolActive($slug)
    {
        $tool = $this->aiToolModel->where('slug', $slug)->first();
        
        if (!$tool) {
            return false;
        }

        if ($tool['status'] === 'Active') {
            return true;
        }

        if (session()->get('role') === 'admin') {
            return true;
        }
        
        return false;
    }
    
    public function index()
    {
        $dbTools = $this->db->table('ai_tools')->get()->getResultArray();
        
        $tools = [];
        foreach ($dbTools as $t) {
            $t['tags'] = array_map('trim', explode(',', $t['tags']));
            $t['link'] = base_url($t['link']);
            $tools[] = $t;
        }

        return view('ailab/index', [
            'title'     => 'AI Laboratory - Rian Projects',
            'meta_desc' => 'Jelajahi berbagai alat kecerdasan buatan (AI) inovatif di AI Laboratory - Rian Projects. Temukan solusi AI untuk gambar, artikel, review kode, data analitik, dan banyak lagi.',
            'tools'     => $tools,
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'AI Labs' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500'
        ]);
    }

    public function imaging()
    {
        if (!$this->isToolActive('image-generator')) {
            return redirect()->to(base_url('ailab'))->with('error', 'Mohon maaf, fitur AI Image Studio sedang dinonaktifkan untuk maintenance.');
        }
        return view('ailab/imaging', [
            'title'     => 'AI Image Generator',
            'meta_desc' => 'Buat gambar unik, realistis, dan menakjubkan secara instan dengan AI Image Generator dari Rian Projects hanya dengan menggunakan teks.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'AI Image Generator' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500'
        ]);
    }

    public function blogai()
    {
        if (!$this->isToolActive('seo-blog')) {
            return redirect()->to(base_url('ailab'))->with('error', 'Mohon maaf, fitur SEO Content Writer sedang dinonaktifkan untuk maintenance.');
        }
        return view('ailab/blogai', [
            'title'     => 'SEO Content Writer - Rian Projects',
            'meta_desc' => 'Hasilkan artikel blog yang SEO-friendly, menarik, dan berkualitas tinggi secara otomatis dengan bantuan AI SEO Content Writer dari Rian Projects.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'SEO Content Writer' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500'
            
        ]);
    }

    public function codeReviewer()
    {
        if (!$this->isToolActive('code-reviewer')) {
            return redirect()->to(base_url('ailab'))->with('error', 'Mohon maaf, fitur AI Code Reviewer sedang dinonaktifkan untuk maintenance.');
        }
        return view('ailab/code_reviewer', [
            'title'     => 'AI Code Reviewer - Rian Projects',
            'meta_desc' => 'Analisis dan tingkatkan kualitas kode pemrograman Anda dengan AI Code Reviewer. Temukan bug, kerentanan, dan dapatkan saran perbaikan secara instan.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'AI Code Reviewer' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-orange-500"'
        ]);
    }

    public function socialMedia()
    {
        if (!$this->isToolActive('social-media')) {
            return redirect()->to(base_url('ailab'))->with('error', 'Mohon maaf, fitur Viral Post Generator sedang dinonaktifkan untuk maintenance.');
        }
        return view('ailab/social_media', [
            'title'     => 'Viral Post Generator - Rian Projects',
            'meta_desc' => 'Buat caption dan konten media sosial yang menarik, interaktif, dan berpotensi viral dengan mudah menggunakan Viral Post Generator dari Rian Projects.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'Viral Post Generator' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-violet-500 to-fuchsia-500'
        ]);
    }

    public function cvScanner()
    {
        if (!$this->isToolActive('cv-scanner')) {
            return redirect()->to(base_url('ailab'))->with('error', 'Mohon maaf, fitur Smart CV Scanner sedang dinonaktifkan untuk maintenance.');
        }
        return view('ailab/cv_scanner', [
            'title'     => 'Smart CV Scanner - Rian Projects',
            'meta_desc' => 'Pindai, evaluasi, dan optimalkan Curriculum Vitae (CV) Anda dengan Smart CV Scanner berbasis AI untuk meningkatkan peluang lolos sistem ATS perusahaan.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'Smart CV Scanner' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-orange-500'
        ]);
    }

    public function newsai()
    {
        if (!$this->isToolActive('news-generator')) {
            return redirect()->to(base_url('ailab'))->with('error', 'Mohon maaf, fitur AI News Generator sedang dinonaktifkan untuk maintenance.');
        }
        return view('ailab/newsai', [
            'title'     => 'AI News Generator - Rian Projects',
            'meta_desc' => 'Tulis draf berita, press release, atau artikel jurnalistik dengan cepat, akurat, dan profesional menggunakan AI News Generator dari Rian Projects.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'AI News Generator' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 to-blue-500'
        ]);
    }

    public function chat()
    {
        if (!$this->isToolActive('ai-assistant')) {
             return redirect()->to(base_url('ailab'))->with('error', 'Mohon maaf, fitur Smart AI Assistant sedang dinonaktifkan untuk maintenance.');
        }
        return view('ailab/aichat', [
            'title'     => 'AI Smart Assistant - Rian Projects',
            'meta_desc' => 'Dapatkan jawaban, ide, dan bantuan instan untuk berbagai tugas Anda dari AI Smart Assistant yang cerdas dan responsif dari Rian Projects.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'Smart AI Assistant' => '#',
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-violet-500 to-fuchsia-500'
        ]);
    }

    public function youtubeSummarizer()
    {
        if (!$this->isToolActive('youtube-summarizer')) {
             return redirect()->to(base_url('ailab'))->with('error', 'Mohon maaf, fitur YouTube Summarizer sedang dinonaktifkan untuk maintenance.');
        }
        return view('ailab/youtube_summarizer', [
            'title'     => 'YouTube Video Summarizer - Rian Projects',
            'meta_desc' => 'Hemat waktu Anda! Ringkas video YouTube yang panjang menjadi poin-poin penting yang mudah dipahami dengan YouTube Video Summarizer dari Rian Projects.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'YouTube Summarizer' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-600'
        ]);
    }
    
    public function dataAnalyst()
    {
        if (!$this->isToolActive('data-analyst')) {
             return redirect()->to(base_url('ailab'))->with('error', 'Mohon maaf, fitur Smart Data Analyst sedang dinonaktifkan untuk maintenance.');
        }
        return view('ailab/data_analyst', [
            'title'     => 'Smart Data Analyst - Rian Projects',
            'meta_desc' => 'Analisis data kompleks dengan mudah, temukan tren, dan dapatkan insight berharga untuk pengambilan keputusan dengan Smart Data Analyst berbasis AI.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'Smart Data Analyst' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500'
        ]);
    }
    

    public function textDetector()
    {
        $data = [
            'title'      => 'AI Text Detector - Rian Projects',
            'meta_desc'  => 'Deteksi tulisan buatan AI dengan akurasi tinggi.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Ai Labs'          => 'ailab', 
                'AI Text Detector' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-500 to-pink-600'
        ];
        
        return view('ailab/ai_text_detector', $data);
    }

    public function analyzeText()
    {
        try {
            $text = $this->request->getPost('text');
            $apiKey = trim((string) $this->request->getPost('apiKey'));

            if (empty($text) || strlen($text) < 50) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Teks terlalu pendek. Minimal 50 karakter.']);
            }

            if (empty($apiKey)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'API Key wajib diisi! Silakan klik pengaturan di sebelah kiri.']);
            }

            $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

            $prompt = 'Analisis teks berikut. Berapa persen probabilitas buatan AI? Kembalikan HANYA format JSON tanpa markdown: { "ai_percentage": 0-100, "human_percentage": 0-100, "summary": "bahasa indonesia", "highlighted_html": "teks asli dengan tag <mark class=\'bg-rose-500/30 text-rose-800 px-1 rounded\'> untuk bagian AI" }. Teks: "' . $text . '"';

            $payload = [
                "contents" => [["parts" => [["text" => $prompt]]]],
                "generationConfig" => ["temperature" => 0.2]
            ];

            $ch = curl_init($apiUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_TIMEOUT => 60
            ]);
            
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err) {
                return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => 'Koneksi ke Google AI terputus: ' . $err]);
            }

            $data = json_decode($response, true);


            if (isset($data['error'])) {
                 return $this->response->setStatusCode(400)->setJSON([
                     'success' => false, 
                     'error' => 'Ditolak oleh Gemini: ' . $data['error']['message']
                 ]);
            }

            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $rawText = $data['candidates'][0]['content']['parts'][0]['text'];
                $rawJson = trim(str_replace(['```json', '```'], '', $rawText));
                
                $parsedJson = json_decode($rawJson, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    return $this->response->setJSON(['success' => true, 'data' => $parsedJson]);
                } else {
                    return $this->response->setStatusCode(500)->setJSON([
                        'success' => false, 
                        'error' => 'AI membalas dengan format yang salah. Coba klik deteksi lagi.'
                    ]);
                }
            }

            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => 'AI Gagal merespon dengan data yang valid.']);

        } catch (\Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => 'Server CI4 Error: ' . $e->getMessage()]);
        }
    }

    public function extractFile()
    {
        $file = $this->request->getFile('file');
        $userApiKey = trim((string) $this->request->getPost('apiKey'));

        if (!$file || !$file->isValid()) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'File tidak valid atau gagal diupload.']);
        }

        $ext = strtolower($file->getExtension());
        $filePath = $file->getTempName();
        $mimeType = $file->getMimeType();
        $extractedText = '';

        try {
            if ($ext === 'docx') {
                $zip = new \ZipArchive;
                if ($zip->open($filePath) === TRUE) {
                    if (($index = $zip->locateName('word/document.xml')) !== false) {
                        $content = $zip->getFromIndex($index);
                        $content = str_replace('</w:p>', "\n\n", $content);
                        $extractedText = strip_tags($content);
                    }
                    $zip->close();
                }
            } elseif ($ext === 'xlsx' || $ext === 'xls') {
                $zip = new \ZipArchive;
                if ($zip->open($filePath) === TRUE) {
                    if (($index = $zip->locateName('xl/sharedStrings.xml')) !== false) {
                        $content = $zip->getFromIndex($index);
                        $content = str_replace('</si>', "\n", $content);
                        $extractedText = strip_tags($content);
                    }
                    $zip->close();
                }
            } elseif (in_array($ext, ['pdf', 'png', 'jpg', 'jpeg'])) {
                
                if (empty($userApiKey)) {
                    return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Wajib memasukkan API Key di menu pengaturan untuk mengekstrak teks dari PDF atau Gambar.']);
                }
                
                $extractedText = $this->extractWithGemini($filePath, $mimeType, $userApiKey);
                
            } else {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Format file tidak didukung. Gunakan PDF, DOCX, XLSX, atau Gambar.']);
            }

            if (empty(trim($extractedText))) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Gagal mengekstrak teks, atau file kosong.']);
            }

            return $this->response->setJSON(['success' => true, 'text' => trim($extractedText)]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => 'Terjadi kesalahan sistem saat membaca file.']);
        }
    }

    private function extractWithGemini($filePath, $mimeType, $apiKey)
    {
        $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;
        $base64Data = base64_encode(file_get_contents($filePath));

        $payload = [
            "contents" => [[
                "parts" => [
                    ["text" => "Ekstrak seluruh teks dari dokumen/gambar ini. Kembalikan HANYA teks aslinya tanpa tambahan komentar apapun."],
                    ["inlineData" => ["mimeType" => $mimeType, "data" => $base64Data]]
                ]
            ]],
            "generationConfig" => ["temperature" => 0.0]
        ];

        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);
        
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    // =================================================================
    // 1. GENERATE IMAGE API
    // =================================================================
    public function generateImage()
    {
        if (!$this->isToolActive('image-generator')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Fitur sedang offline.']);
        }
        
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 10, MINUTE) === false) {
            return $this->response->setStatusCode(429)->setJSON([
                'error' => 'Limit server lokal tercapai. Silakan tunggu 1 menit untuk mencegah spam.'
            ]);
        }

        $apiKey  = $this->request->getPost('apiKey');
        $prompt  = $this->request->getPost('prompt');
        $aiModel = $this->request->getPost('aiModel') ?? 'gemini-2.5-flash-image';

        if (empty($apiKey) || empty($prompt)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'API Key dan Prompt wajib diisi.']);
        }

        $parts = [];
        $parts[] = ["text" => "Generate a high-quality image based on these constraints. " . $prompt];

        $imageFields = ['reference_image', 'subject_image', 'clothes_image'];
        foreach ($imageFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $mimeType = $file->getClientMimeType();
                $base64Data = base64_encode(file_get_contents($file->getTempName()));
                
                $parts[] = [
                    "inline_data" => [
                        "mime_type" => $mimeType,
                        "data" => $base64Data
                    ]
                ];
            }
        }

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/" . $aiModel . ":generateContent?key=" . $apiKey;

        $payload = [
            "contents" => [
                [
                    "parts" => $parts
                ]
            ]
        ];

        $client = \Config\Services::curlrequest();
        
        try {
            $response = $client->post($apiUrl, [
                'json' => $payload,
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 90,
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody(), true);

            if ($statusCode === 429) {
                return $this->response->setStatusCode(429)->setJSON(['error' => 'Limit API Google tercapai (Terlalu banyak request).']);
            }

            if ($statusCode >= 400) {
                $errorMsg = $result['error']['message'] ?? 'Terjadi kesalahan pada server AI Google.';
                return $this->response->setStatusCode($statusCode)->setJSON(['error' => $errorMsg]);
            }

            return $this->response->setJSON($result);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal terhubung ke API Gemini: Jaringan bermasalah.']);
        }
    }

    // =================================================================
    // 2. GENERATE BLOG / SEO CONTENT API (WITH DEEP RESEARCH & SOURCES)
    // =================================================================
    public function generateContent()
    {
        if (!$this->isToolActive('seo-blog')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Fitur sedang offline.']);
        }
        
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 15, MINUTE) === false) {
            return $this->response->setStatusCode(429)->setJSON(['error' => 'Limit lokal tercapai. Tunggu sebentar.']);
        }

        $apiKey   = trim($this->request->getPost('apiKey') ?? '');
        $aiModel  = trim($this->request->getPost('aiModel') ?? 'gemini-2.5-flash');
        $topic    = trim($this->request->getPost('topic') ?? '');
        $keywords = trim($this->request->getPost('keywords') ?? '');
        $tone     = trim($this->request->getPost('tone') ?? 'Santai & Natural');

        if (empty($apiKey) || empty($topic)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Topik dan API Key wajib diisi.']);
        }

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$aiModel}:generateContent?key={$apiKey}";
        $currentYear = date('Y');

        $payload = [
            "systemInstruction" => [
                "parts" => [
                    ["text" => "Anda adalah AI Deep Researcher dan Senior SEO Content Writer. Saat ini adalah tahun {$currentYear}. Anda HARUS melakukan penelusuran internet untuk mendapatkan data, statistik, dan tren paling mutakhir. \n\nGAYA PENULISAN: {$tone}. Tulis sealami mungkin (90% human-like), hindari frasa klise AI (seperti 'Di era digital ini...', 'Kesimpulannya...', 'Penting untuk diingat bahwa...'), gunakan teknik parafrase yang luwes, kalimat yang mengalir, dan kosakata yang variatif. Artikel harus sangat informatif, faktual, dan tidak berhalusinasi."]
                ]
            ],
            "contents" => [
                [
                    "parts" => [
                        ["text" => "Target Keywords: " . $keywords . "\n\n" . $topic]
                    ]
                ]
            ],
            
            "tools" => [
                [
                    "googleSearch" => new \stdClass()
                ]
            ]
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200) {
            $responseData = json_decode($response, true);
            $errorMsg = $responseData['error']['message'] ?? "Gagal terhubung ke AI (HTTP $httpCode). $curlError";
            return $this->response->setStatusCode($httpCode ?: 500)->setJSON(['error' => $errorMsg]);
        }

        $responseData = json_decode($response, true);
        
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $sources = [];
            if (isset($responseData['candidates'][0]['groundingMetadata']['groundingChunks'])) {
                foreach ($responseData['candidates'][0]['groundingMetadata']['groundingChunks'] as $chunk) {
                    if (isset($chunk['web']['uri']) && isset($chunk['web']['title'])) {
                        $url = $chunk['web']['uri'];
                        if (!array_search($url, array_column($sources, 'url'))) {
                            $sources[] = [
                                'title' => $chunk['web']['title'],
                                'url'   => $url
                            ];
                        }
                    }
                }
            }

            return $this->response->setJSON([
                'content' => $responseData['candidates'][0]['content']['parts'][0]['text'],
                'sources' => $sources
            ]);
        }

        return $this->response->setStatusCode(500)->setJSON(['error' => 'AI tidak memberikan respon teks yang valid.']);
    }

    // =================================================================
    // 3. AI CODE REVIEWER API
    // =================================================================
    public function analyzeCode()
    {
        if (!$this->isToolActive('code-reviewer')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Fitur sedang offline.']);
        }
        
        $apiKey    = $this->request->getPost('apiKey');
        $code      = $this->request->getPost('code');
        $framework = $this->request->getPost('framework');
        $aiModel   = $this->request->getPost('aiModel') ?? 'gemini-2.5-flash';

        if (empty($apiKey) || empty($code)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'API Key dan Kode wajib diisi.']);
        }

        $systemInstructions = "Anda adalah Senior Software Engineer di tahun 2026. Tugas Anda adalah melakukan Code Review pada kode yang diberikan. Fokus pada framework/bahasa: {$framework}. "
                            . "Berikan output dalam format HTML murni persis seperti ini: "
                            . "<h3>🚨 Analisis Keamanan & Bug</h3><p>[Jelaskan celah keamanan seperti SQLi/XSS atau bug jika ada, jika aman sebutkan aman]</p>"
                            . "<h3>💡 Saran Optimasi</h3><p>[Jelaskan cara membuat kode lebih bersih/cepat]</p>"
                            . "<h3>💻 Kode yang Dioptimalkan</h3><pre><code>[Tulis kode perbaikan di sini]</code></pre>";

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/" . $aiModel . ":generateContent?key=" . $apiKey;

        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $systemInstructions . "\n\nKode untuk di-review:\n" . $code]
                    ]
                ]
            ]
        ];

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->post($apiUrl, [
                'json' => $payload,
                'timeout' => 60,
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody(), true);

            if ($statusCode === 429) {
                return $this->response->setStatusCode(429)->setJSON(['error' => 'Model sedang sibuk / Limit API tercapai. Silakan coba model Flash-Lite di dropdown.']);
            }

            if ($statusCode >= 400) {
                $errorMsg = $result['error']['message'] ?? 'Terjadi kesalahan pada server AI.';
                return $this->response->setStatusCode($statusCode)->setJSON(['error' => $errorMsg]);
            }
            
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $htmlContent = $result['candidates'][0]['content']['parts'][0]['text'];
                return $this->response->setJSON(['content' => $htmlContent]);
            }

            return $this->response->setStatusCode(500)->setJSON(['error' => 'AI tidak memberikan respon valid.']);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Kesalahan jaringan.']);
        }
    }

    // =================================================================
    // 4. SOCIAL MEDIA GENERATOR API
    // =================================================================
    public function generateSocial()
    {
        if (!$this->isToolActive('social-media')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Fitur sedang offline.']);
        }
        
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 15, MINUTE) === false) {
            return $this->response->setStatusCode(429)->setJSON(['error' => 'Limit lokal tercapai. Tunggu sebentar.']);
        }

        $apiKey   = preg_replace('/\s+/', '', (string) $this->request->getPost('apiKey'));
        $inputType= $this->request->getPost('inputType'); 
        $topic    = trim((string) $this->request->getPost('topic')); 
        $platform = $this->request->getPost('platform');
        $tone     = $this->request->getPost('tone');
        $aiModel  = preg_replace('/\s+/', '', (string) $this->request->getPost('aiModel'));
        
        if (empty($aiModel)) $aiModel = 'gemini-2.5-flash';

        if (empty($apiKey)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'API Key wajib diisi.']);
        }

        $systemInstructions = "Anda adalah seorang copywriter manusia dan kreator konten asli berpengalaman di bidang sosial media marketing lebih dari 10 tahun, BUKAN AI. "
                            . "Tugas Anda membuat 3 VARIASI draf postingan organik untuk platform: {$platform}. "
                            . "Gaya bahasa yang WAJIB digunakan: {$tone}. "
                            . "ATURAN KETAT PENULISAN: "
                            . "1. ANTI-ROBOT: DILARANG KERAS menggunakan frasa template AI (Pernahkah kamu..., Di era digital ini..., Kesimpulannya...). "
                            . "2. FLOW NATURAL: Gunakan panjang kalimat yang bervariasi. Buat jeda baris (<br>) yang tidak beraturan. "
                            . "3. STRUKTUR TERSIRAT: Harus ada Hook, Isi, CTA, tapi DILARANG menuliskan labelnya. "
                            . "ATURAN OUTPUT MUTLAK: Anda HANYA boleh membalas dalam format JSON ARRAY murni. DILARANG menambahkan teks basa-basi sebelum atau sesudah JSON. "
                            . "Gunakan struktur ini: "
                            . '[{"score": 95, "content": "<p>Teks...</p>"}, {"score": 88, "content": "<p>Teks...</p>"}, {"score": 92, "content": "<p>Teks...</p>"}] '
                            . "Keterangan: 'score' adalah Skor Viral (angka 1-100). 'content' adalah isi postingan berformat HTML murni (<p>, <br>, <strong>).";

        $payload = [
            "system_instruction" => [
                "parts" => [ ["text" => $systemInstructions] ]
            ],
            "contents" => [
                [
                    "parts" => [] 
                ]
            ]
        ];

        if ($inputType === 'text') {
            if (empty($topic)) return $this->response->setStatusCode(400)->setJSON(['error' => 'Materi / Topik tidak boleh kosong.']);
            $payload['contents'][0]['parts'][] = ["text" => "Materi/Topik yang harus dijadikan postingan:\n" . $topic];
            
        } else if ($inputType === 'image') {
            $imageFile = $this->request->getFile('poster_image');
            if (!$imageFile || !$imageFile->isValid()) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File poster/gambar wajib diunggah.']);
            }
            
            $mimeType = $imageFile->getClientMimeType();
            $base64Data = base64_encode(file_get_contents($imageFile->getTempName()));
            
            $payload['contents'][0]['parts'][] = ["text" => "Tolong analisis isi, teks, dan konteks dari gambar/poster terlampir ini, lalu buatkan caption sosial media yang menarik."];
            $payload['contents'][0]['parts'][] = [
                "inline_data" => [
                    "mime_type" => $mimeType,
                    "data" => $base64Data
                ]
            ];
            
            if (!empty($topic)) {
                 $payload['contents'][0]['parts'][] = ["text" => "Instruksi tambahan dari user: " . $topic];
            }
        } else {
             return $this->response->setStatusCode(400)->setJSON(['error' => 'Tipe input tidak valid.']);
        }

        $url = sprintf(
            "https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s",
            $aiModel,
            $apiKey
        );

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Accept: application/json"
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || $response === '') {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => "cURL Error internal PHP: " . ($curlError ?: 'Response kosong tanpa pesan error.')
            ]);
        }

        $responseData = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => "Server menerima data yang tidak bisa dibaca (Bukan JSON)."
            ]);
        }

        if ($httpCode !== 200) {
            $errorMsg = $responseData['error']['message'] ?? "Gagal terhubung ke AI (HTTP $httpCode).";
            return $this->response->setStatusCode($httpCode)->setJSON(['error' => $errorMsg]);
        }

        $content = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';

        if (empty($content)) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'AI gagal merangkum konten.'
            ]);
        }

        $cleanContent = preg_replace('/```(?:json|html)?\s*(.*?)\s*```/s', '$1', $content);
        $variations = json_decode(trim($cleanContent), true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($variations)) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'AI gagal menyusun format output menjadi opsi (Bukan Array JSON). Silakan coba lagi.'
            ]);
        }

        return $this->response->setJSON(['variations' => $variations]);
    }

    // =================================================================
    // 5. SMART CV SCANNER API
    // =================================================================
    public function scanCv()
    {
        if (!$this->isToolActive('cv-scanner')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Fitur sedang offline.']);
        }
        
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 10, MINUTE) === false) {
            return $this->response->setStatusCode(429)->setJSON(['error' => 'Limit lokal tercapai. Tunggu sebentar.']);
        }

        $apiKey  = $this->request->getPost('apiKey');
        $aiModel = $this->request->getPost('aiModel') ?? 'gemini-2.5-flash';
        $cvFile  = $this->request->getFile('cv_file');

        if (empty($apiKey) || !$cvFile || !$cvFile->isValid()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'API Key dan File CV wajib diunggah.']);
        }

        $mimeType = $cvFile->getMimeType();
        $allowedMimeTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($mimeType, $allowedMimeTypes)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Format file tidak didukung. Gunakan PDF, JPG, atau PNG.']);
        }

        $base64Data = base64_encode(file_get_contents($cvFile->getTempName()));

        $systemInstructions = "Anda adalah HR Tech Expert & Web Developer di tahun 2026. Analisis CV terlampir dengan sangat teliti. "
                            . "Berikan output dalam format HTML murni persis seperti ini: "
                            . "<h3>🎯 ATS Score & Analisis</h3><p>[Berikan skor 1-100 dan evaluasi singkat kelebihan/kekurangan CV ini]</p>"
                            . "<h3>✨ Ekstraksi Skill</h3><p>[Sebutkan skill utama dalam bentuk list yang rapi]</p>"
                            . "<h3>📦 Data JSON Portofolio</h3><pre><code>[Ekstrak semua data CV menjadi JSON lengkap (Nama, Profil, Kontak, Pengalaman, Pendidikan) yang siap dimasukkan ke database website]</code></pre>";

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/" . $aiModel . ":generateContent?key=" . $apiKey;

        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $systemInstructions],
                        [
                            "inline_data" => [
                                "mime_type" => $mimeType,
                                "data"      => $base64Data
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->post($apiUrl, [
                'json' => $payload,
                'timeout' => 90,
                'http_errors' => false
            ]);

            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody(), true);

            if ($statusCode === 429) {
                return $this->response->setStatusCode(429)->setJSON(['error' => 'Model sibuk / Limit API tercapai. Coba ganti ke model Flash-Lite.']);
            }

            if ($statusCode >= 400) {
                $errorMsg = $result['error']['message'] ?? 'Terjadi kesalahan pada server AI.';
                return $this->response->setStatusCode($statusCode)->setJSON(['error' => $errorMsg]);
            }
            
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $htmlContent = $result['candidates'][0]['content']['parts'][0]['text'];
                return $this->response->setJSON(['content' => $htmlContent]);
            }

            return $this->response->setStatusCode(500)->setJSON(['error' => 'AI tidak memberikan respon valid.']);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Kesalahan jaringan atau timeout.']);
        }
    }
    
    // =================================================================
    // 6. NEWS AI / AUTO JOURNALIST API
    // =================================================================
    public function generateNews()
    {
        if (!$this->isToolActive('news-generator')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Fitur sedang offline.']);
        }
        
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 15, MINUTE) === false) {
            return $this->response->setStatusCode(429)->setJSON(['error' => 'Limit lokal tercapai. Tunggu sebentar.']);
        }

        $apiKey        = $this->request->getPost('apiKey');
        $aiModel       = $this->request->getPost('aiModel') ?? 'gemini-2.5-flash';
        $tone          = $this->request->getPost('tone');
        $articleLength = $this->request->getPost('articleLength') ?? 'Standar (4-6 Paragraf)';
        $fakta         = $this->request->getPost('fakta');
        $deskripsi     = $this->request->getPost('deskripsi');
        $quotesRaw     = $this->request->getPost('quotes');

        if (empty($apiKey) || empty($fakta)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'API Key dan Fakta Utama (5W1H) wajib diisi.']);
        }

        $quotesList = "";
        $quotesArr = json_decode($quotesRaw, true);
        if (is_array($quotesArr) && count($quotesArr) > 0) {
            $quotesList .= "\nKUTIPAN NARASUMBER:\n";
            foreach ($quotesArr as $q) {
                if (!empty($q['name']) && !empty($q['text'])) {
                    $quotesList .= "- " . $q['name'] . ": \"" . $q['text'] . "\"\n";
                }
            }
        }

        $systemInstructions = "Anda adalah Editor in Chief dan Jurnalis Senior Nasional di tahun 2026. Tugas Anda merangkum fakta mentah menjadi artikel berita yang berimbang, tajam, dan sesuai kaidah jurnalistik (Piramida Terbalik). "
                            . "Gaya Penulisan: {$tone}. "
                            . "Target Panjang Artikel: {$articleLength}. Pastikan berita yang Anda tulis sesuai dengan ekspektasi jumlah paragraf ini. "
                            . "Patuhi format output HTML murni tanpa tag Markdown (seperti ```html atau ```). Gunakan tag <h1> untuk judul, <p> untuk paragraf, dan blockquote untuk kutipan. Jangan tambahkan tag html, head, atau body, cukup kontennya saja.";

        $userPrompt = "Fakta Utama (5W1H): {$fakta}\nDeskripsi Tambahan: {$deskripsi}{$quotesList}";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$aiModel}:generateContent?key={$apiKey}";
        $payload = [
            "system_instruction" => [
                "parts" => [ ["text" => $systemInstructions] ]
            ],
            "contents" => [
                [
                    "parts" => [ ["text" => $userPrompt] ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode !== 200) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal terhubung ke AI. Pastikan API Key valid.']);
        }

        $responseData = json_decode($response, true);
        $content = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';

        return $this->response->setJSON(['content' => $content]);
    }
    
    // =================================================================
    // 7. AI CHAT (VISION + MEMORY) - UPDATED FOR GEMINI 2.5 / 3.1
    // =================================================================
    public function sendChat()
    {
        if (!$this->isToolActive('ai-assistant')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Fitur sedang offline.']);
        }
        
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 30, MINUTE) === false) {
            return $this->response->setStatusCode(429)->setJSON(['error' => 'Limit lokal tercapai. Tunggu sebentar.']);
        }

        $apiKey  = $this->request->getPost('apiKey');
        $aiModel = $this->request->getPost('aiModel') ?? 'gemini-2.5-flash'; 
        $message = $this->request->getPost('message');
        $history = $this->request->getPost('history'); 
        $image   = $this->request->getFile('image');

        if (empty($apiKey)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'API Key wajib diisi.']);
        }

        $contents = [];
        $historyArr = json_decode($history, true);
        
        if (is_array($historyArr)) {
            foreach ($historyArr as $chat) {
                $contents[] = [
                    "role" => $chat['role'],
                    "parts" => [ ["text" => $chat['text']] ]
                ];
            }
        }

        $currentParts = [];
        if (!empty($message)) {
            $currentParts[] = ["text" => $message];
        } else {
            $currentParts[] = ["text" => "Tolong jelaskan gambar ini secara detail."];
        }

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $mime = $image->getClientMimeType();
            $base64 = base64_encode(file_get_contents($image->getTempName()));
            
            $currentParts[] = [
                "inline_data" => [
                    "mime_type" => $mime,
                    "data" => $base64
                ]
            ];
        }

        $contents[] = [
            "role" => "user",
            "parts" => $currentParts
        ];

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$aiModel}:generateContent?key={$apiKey}";
        
        $payload = [
            "contents" => $contents
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal terhubung ke AI. Pastikan API Key valid atau model yang dipilih tersedia.']);
        }

        $responseData = json_decode($response, true);
        $content = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';

        return $this->response->setJSON(['content' => $content]);
    }
    
    // =================================================================
    // 8. YOUTUBE SUMMARIZER
    // =================================================================
    public function generateYoutubeSummary()
    {
        if (!$this->isToolActive('youtube-summarizer')) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Fitur sedang offline.']);
        }
        
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 15, MINUTE) === false) {
            return $this->response->setStatusCode(429)->setJSON(['error' => 'Limit lokal tercapai. Tunggu sebentar.']);
        }

        $apiKey   = preg_replace('/\s+/', '', (string) $this->request->getPost('apiKey'));
        $videoUrl = trim((string) $this->request->getPost('videoUrl'));
        $aiModel  = preg_replace('/\s+/', '', (string) $this->request->getPost('aiModel'));
        
        if (empty($aiModel)) $aiModel = 'gemini-2.5-flash';

        if (empty($apiKey) || empty($videoUrl)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'API Key dan URL YouTube wajib diisi.']);
        }

        $oembedUrl = "https://www.youtube.com/oembed?url=" . urlencode($videoUrl) . "&format=json";
        $chYt = curl_init($oembedUrl);
        curl_setopt($chYt, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chYt, CURLOPT_TIMEOUT, 10);
        $ytRes = curl_exec($chYt);
        $ytHttp = curl_getinfo($chYt, CURLINFO_HTTP_CODE);
        curl_close($chYt);
        if ($ytHttp !== 200 || empty($ytRes)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Video tidak ditemukan. Pastikan URL YouTube valid dan publik.']);
        }

        $ytData = json_decode($ytRes, true);
        $videoTitle = $ytData['title'] ?? 'Judul Tidak Diketahui';
        $videoAuthor = $ytData['author_name'] ?? 'Kreator Tidak Diketahui';
        $systemInstructions = "Anda adalah Asisten Penulis yang cerdas. Tugas Anda adalah memberikan poin-poin diskusi atau ringkasan prediktif dari sebuah video YouTube berdasarkan Judul dan Nama Channelnya. Berikan output HTML murni (gunakan <h3>, <ul>, <li>). Fokuskan ringkasan HANYA pada konteks judul yang diberikan.";
        $userPrompt = "Tolong buatkan artikel ringkasan yang menarik dan apa saja yang kemungkinan dibahas dalam video YouTube berikut ini:\n\n"
                    . "Judul Video Asli: '{$videoTitle}'\n"
                    . "Nama Channel: '{$videoAuthor}'\n\n"
                    . "Buatlah sedetail mungkin berdasarkan konteks judul di atas.";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$aiModel}:generateContent?key={$apiKey}";

        $payload = [
            "system_instruction" => [
                "parts" => [ ["text" => $systemInstructions] ]
            ],
            "contents" => [
                [
                    "parts" => [ ["text" => $userPrompt] ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 60
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || empty($response)) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => "Koneksi ke server AI terputus: " . $curlError
            ]);
        }

        $data = json_decode($response, true);

        if ($httpCode !== 200) {
            $err = $data['error']['message'] ?? "Ditolak oleh Google (HTTP $httpCode). Pastikan API Key valid.";
            return $this->response->setStatusCode($httpCode)->setJSON(['error' => $err]);
        }

        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return $this->response->setJSON(['content' => $data['candidates'][0]['content']['parts'][0]['text']]);
        }

        return $this->response->setStatusCode(500)->setJSON([
            'error' => 'AI berhasil diakses tapi ringkasannya kosong.'
        ]);
    }
    
    // =================================================================
    // 9. DATA ANALYST
    // =================================================================
    public function analyzeData()
    {

        $apiKey   = preg_replace('/\s+/', '', (string) $this->request->getPost('apiKey'));
        $aiModel  = trim($this->request->getPost('aiModel') ?? 'gemini-2.5-flash');
        $question = trim($this->request->getPost('question') ?? '');
        $csvFile  = $this->request->getFile('csv_file');

        if (empty($apiKey)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'API Key wajib diisi.']);
        }
        if (empty($question)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Pertanyaan analisis wajib diisi.']);
        }
        if (!$csvFile || !$csvFile->isValid()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'File CSV tidak valid atau gagal diunggah.']);
        }

        $rawCsv = file_get_contents($csvFile->getTempName());
        $csvContent = mb_convert_encoding($rawCsv, 'UTF-8', 'UTF-8, ISO-8859-1, WINDOWS-1252, ASCII');
        
        if (empty(trim($csvContent))) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'File CSV kosong atau tidak bisa dibaca.']);
        }

        $systemInstructions = "Anda adalah seorang Senior Data Analyst dan Ahli Statistik. Tugas Anda adalah membaca, menganalisis, dan mengekstrak insight krusial dari data CSV mentah yang diberikan. Jawablah secara akurat, tajam, dan profesional. Format output menggunakan Markdown yang rapi (buatkan tabel, list, atau poin-poin yang mudah dibaca).";

        $promptText = "Berikut adalah data mentah (CSV) yang harus Anda analisis:\n\n"
                    . "```csv\n" . $csvContent . "\n```\n\n"
                    . "INSTRUKSI ANALISIS DARI SAYA:\n" . $question;

        $payload = [
            "systemInstruction" => [
                "parts" => [ ["text" => $systemInstructions] ]
            ],
            "contents" => [
                [
                    "parts" => [
                        ["text" => $promptText]
                    ]
                ]
            ]
        ];

        $jsonPayload = json_encode($payload);
        if ($jsonPayload === false || json_last_error() !== JSON_ERROR_NONE) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Sistem gagal membaca karakter di dalam CSV. Pastikan file tidak mengandung karakter rusak/korup. (Error: ' . json_last_error_msg() . ')'
            ]);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$aiModel}:generateContent?key={$apiKey}";
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Accept: application/json"
            ],
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || $response === '') {
            $errNo = curl_errno($ch);
            
            if ($errNo === CURLE_OPERATION_TIMEDOUT) {
                $profMsg = "Waktu pemrosesan habis (Timeout). Server AI membutuhkan waktu terlalu lama untuk menganalisis data Anda. Hal ini wajar terjadi pada dataset yang besar atau saat antrean server sedang padat. Silakan coba lagi, atau gunakan file CSV dengan baris yang lebih sedikit.";
                return $this->response->setStatusCode(504)->setJSON(['error' => $profMsg]);
            }
            
            $profMsg = "Terjadi gangguan koneksi jaringan antara server kami dan sistem AI. Mohon pastikan koneksi stabil dan coba beberapa saat lagi.";
            return $this->response->setStatusCode(502)->setJSON(['error' => $profMsg]);
        }

        $responseData = json_decode($response, true);
        if ($httpCode !== 200) {
            $errorMsg = $responseData['error']['message'] ?? "Gagal terhubung ke AI (HTTP $httpCode).";
            return $this->response->setStatusCode($httpCode)->setJSON(['error' => $errorMsg]);
        }

        $content = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';

        if (empty($content)) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'AI gagal menganalisis data ini atau format data terlalu membingungkan.']);
        }

        return $this->response->setJSON(['content' => $content]);
    }
}