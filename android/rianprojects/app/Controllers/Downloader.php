<?php

namespace App\Controllers;

class Downloader extends BaseController
{
    public function index()
    {
        $data = [
            'title'      => 'Video Downloader - Rian Projects',
            'meta_desc'  => 'Unduh video kualitas HD, slide gambar carousel, hingga story dari TikTok, Instagram, dan X (Twitter) secara utuh tanpa watermark.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Tools'          => 'tools', 
                'Video Downloader' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-600'
        ];
        
        return view('tools/tools_downloader', $data);
    }

    public function extractLink()
    {
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 30, MINUTE) === false) {
            return $this->response->setStatusCode(429)->setJSON(['error' => 'Limit request tercapai. Tunggu sebentar.']);
        }

        $url = trim((string) $this->request->getPost('url'));

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'URL tidak valid. Masukkan URL yang benar.']);
        }

        $domain = parse_url($url, PHP_URL_HOST);

        try {
            if (strpos($domain, 'tiktok.com') !== false || strpos($domain, 'tiktok.v') !== false) {
                return $this->extractTikTok($url);
            } elseif (strpos($domain, 'instagram.com') !== false) {
                return $this->extractInstagram($url);
            } elseif (strpos($domain, 'douyin.com') !== false) {

                
                
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Douyin belum tersedia saat ini. Hanya melayani TikTok, Instagram, dan X (Twitter).']);
            } elseif (strpos($domain, 'twitter.com') !== false || strpos($domain, 'x.com') !== false) {
                return $this->extractX($url);
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Platform belum didukung. Hanya melayani TikTok, Instagram, dan X (Twitter).']);
            }
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    public function extractAll()
    {
        $throttler = \Config\Services::throttler();

        if ($throttler->check(md5($this->request->getIPAddress()), 20, MINUTE) === false) {
            return $this->response->setStatusCode(429)->setJSON(['error' => 'Limit request tercapai. Tunggu sebentar.']);
        }

        $platform = trim((string) $this->request->getPost('platform'));
        $username = trim((string) $this->request->getPost('username'));
        $username = ltrim($username, '@');
        $cursor   = (int) $this->request->getPost('cursor');
        $cursor   = max(0, $cursor);

        if (empty($username) || !preg_match('/^[A-Za-z0-9._]{1,40}$/', $username)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Username tidak valid. Hanya huruf, angka, titik, dan underscore.']);
        }

        try {
            switch ($platform) {
                case 'tiktok_story':
                    return $this->extractTikTokStory($username);
                case 'tiktok_profile':
                    return $this->extractTikTokProfile($username, $cursor);
                case 'ig_story':
                    return $this->extractIgStory($username);
                case 'ig_profile':
                    return $this->extractIgProfile($username);
                default:
                    return $this->response->setStatusCode(400)->setJSON(['error' => 'Mode download all belum didukung untuk platform ini.']);
            }
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    private function extractTikTok($url)
    {
        $apiUrl = "https://www.tikwm.com/api/?url=" . urlencode($url) . "&hd=1";
        $response = $this->fetchApi($apiUrl);
        $data = json_decode($response, true);

        if (isset($data['code']) && $data['code'] === 0 && isset($data['data'])) {
            $ttData = $data['data'];
            
            $result = [
                'platform'  => 'TikTok',
                'title'     => $ttData['title'] ?? 'Video TikTok',
                'author'    => $ttData['author']['nickname'] ?? 'Unknown',
                'thumbnail' => $ttData['cover'] ?? '',
                'type'      => 'video',
                'media'     => [],
                'audio'     => $ttData['music'] ?? ''
            ];

            if (isset($ttData['images']) && is_array($ttData['images'])) {
                $result['type'] = 'image';
                foreach ($ttData['images'] as $imgUrl) {
                    $result['media'][] = [
                        'url' => $imgUrl,
                        'type' => 'image'
                    ];
                }
                $result['thumbnail'] = $ttData['images'][0]; 
            } else {
                $result['type'] = 'video';
                $result['media'][] = [
                    'url_hd' => $ttData['hdplay'] ?? $ttData['play'],
                    'url_sd' => $ttData['play'] ?? '',
                    'type' => 'video'
                ];
            }

            return $this->response->setJSON(['success' => true, 'data' => $result]);
        }

        return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal mengambil data TikTok. Link mungkin private atau dihapus.']);
    }

    private function extractX($url)
    {
        preg_match('/(?:x\.com|twitter\.com)\/([a-zA-Z0-9_]+)\/status\/([0-9]+)/', $url, $matches);
        
        if (!isset($matches[1]) || !isset($matches[2])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'URL X/Twitter tidak valid. Pastikan link berisi status ID.']);
        }
        
        $username = $matches[1];
        $tweetId = $matches[2];
        $apiUrl = "https://api.vxtwitter.com/" . $username . "/status/" . $tweetId;
        $response = $this->fetchApi($apiUrl);
        $data = json_decode($response, true);
        
        if (!$data || isset($data['error'])) {
             return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal mengambil data. Pastikan akun pembuat postingan tidak digembok (Private).']);
        }

        if (!isset($data['media_extended']) || empty($data['media_extended'])) {
             return $this->response->setStatusCode(400)->setJSON(['error' => 'Tidak ditemukan media pada postingan ini.']);
        }

        $videos = [];
        foreach ($data['media_extended'] as $media) {
            if ($media['type'] === 'video' || $media['type'] === 'gif') {
                $videos[] = [
                    'label'     => 'Video MP4 (Auto HD)',
                    'url'       => $media['url'],
                    'thumbnail' => $media['thumbnail_url'] ?? 'https://via.placeholder.com/640x360.png?text=X+Video'
                ];
            }
        }

        if (empty($videos)) {
             return $this->response->setStatusCode(400)->setJSON(['error' => 'Postingan ini hanya berisi gambar/teks. Universal Downloader versi ini khusus untuk Video X.']);
        }

        $result = [
            'platform'  => 'X / Twitter',
            'title'     => $data['text'] ?? 'Postingan X',
            'author'    => $data['user_name'] ?? $username,
            'thumbnail' => $data['media_extended'][0]['thumbnail_url'] ?? '',
            'type'      => 'video_x',
            'media'     => $videos
        ];

        return $this->response->setJSON(['success' => true, 'data' => $result]);
    }

    private function extractDouyin($url)
    {
        $page = "https://savetik.co/en2";
        $pageResp = $this->fetchApi($page);
        if (empty($pageResp)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal menghubungi server. Coba lagi beberapa saat.']);
        }

        if (!preg_match('/var k_token="([^"]+)"/', $pageResp, $tokenM)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal mengambil token server. Coba lagi beberapa saat.']);
        }
        $token = $tokenM[1];

        $response = $this->fetchApi('https://savetik.co/api/ajaxSearch', [
            'Referer: ' . $page,
            'X-Requested-With: XMLHttpRequest',
            'Content-Type: application/x-www-form-urlencoded',
        ], ['q' => $url, 't' => 'media', 'lang' => 'en', 'token' => $token]);

        if (empty($response)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal mengambil data Douyin. Link mungkin tidak valid atau privat.']);
        }

        $decoded = json_decode($response, true);
        $html = $decoded['data'] ?? '';
        if (empty($html)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal mengambil data Douyin. Link mungkin tidak valid atau privat.']);
        }

        preg_match_all('/href=["\']?(https:\/\/dl\.snapcdn\.app\/get\?token=[^"\'>\s]+)["\']?/', $html, $dlMatches);
        $dlUrls = $dlMatches[1] ?? [];
        if (empty($dlUrls)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Tidak ditemukan media pada link ini.']);
        }

        $videoUrl = '';
        $audioUrl = '';
        $imageUrls = [];

        foreach ($dlUrls as $dlUrl) {
            $parts = explode('token=', $dlUrl, 2);
            if (count($parts) < 2) {
                continue;
            }
            $payload = $this->decodeJwtPayload($parts[1]);
            $fname = $payload['filename'] ?? '';
            $direct = $payload['url'] ?? '';
            $check = $direct ?: $fname;

            if (str_ends_with($fname, '.mp3') || strpos($check, '.mp3') !== false) {
                $audioUrl = $dlUrl;
            } elseif (str_ends_with($fname, '-hd.mp4')) {
                $videoUrl = $dlUrl; 
            } elseif (str_ends_with($fname, '.mp4') && empty($videoUrl)) {
                $videoUrl = $dlUrl;
            } elseif (preg_match('/\.(jpg|jpeg|webp|png)/i', $check)) {
                $imageUrls[] = $dlUrl;
            }
        }

        if (empty($videoUrl) && empty($imageUrls) && !empty($dlUrls)) {
            $videoUrl = $dlUrls[0];
        }

        if (empty($videoUrl) && empty($imageUrls)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Tidak ditemukan media yang dapat diunduh dari link ini.']);
        }

        $result = [
            'platform' => 'Douyin',
            'title'    => 'Video Douyin',
            'author'   => 'Douyin',
            'audio'    => $audioUrl,
            'media'    => [],
        ];

        if (!empty($imageUrls)) {
            $result['type'] = 'image';
            foreach ($imageUrls as $imgUrl) {
                $result['media'][] = ['url' => $imgUrl, 'type' => 'image'];
            }
            $result['thumbnail'] = $imageUrls[0];
        } else {
            $result['type'] = 'video';
            $result['media'][] = [
                'url_hd' => $videoUrl,
                'url_sd' => $videoUrl,
                'type'   => 'video',
            ];
            $result['thumbnail'] = '';
        }

        return $this->response->setJSON(['success' => true, 'data' => $result]);
    }

    private function extractInstagram($url)
    {
        $isReel = (strpos($url, '/reel/') !== false);

        $response = $this->fetchApi('https://api.instasave.website/media', [
            'Content-Type: application/x-www-form-urlencoded',
            'Origin: https://instasave.website',
            'Referer: https://instasave.website/',
        ], ['url' => $url, 't' => 'media', 'lang' => 'en']);

        $items = [];
        if (!empty($response)) {
            $items = $this->parseInstasaveCdnUrls($response, $isReel);
        }

        if (empty($items)) {
            $token = $this->getSnapinstaToken();
            if ($token) {
                $response2 = $this->fetchApi('https://snap-insta.to/api/ajaxSearch', [
                    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                    'Origin: https://snap-insta.to',
                    'Referer: https://snap-insta.to/en/highlights-downloader',
                    'X-Requested-With: XMLHttpRequest',
                ], [
                    'q' => $url, 't' => 'media', 'lang' => 'en', 'v' => 'v2',
                    'k_exp' => $token['exp'], 'k_token' => $token['token'],
                ]);
                if (!empty($response2)) {
                    $items = $this->parseSnapinstaItems($response2, $isReel);
                }
            }
        }

        if (empty($items)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal mengambil media Instagram. Pastikan akun tidak private dan link benar (post/reel).']);
        }

        $media = [];
        $firstImage = null;
        foreach ($items as $it) {
            $entry = [
                'type'      => $it['type'],
                'url'       => $it['url'],
                'thumbnail' => $it['type'] === 'image' ? $it['url'] : ($it['thumbnail'] ?? ''),
            ];
            if ($entry['type'] === 'image' && $firstImage === null) {
                $firstImage = $entry['url'];
            }
            $media[] = $entry;
        }
        
        if ($firstImage) {
            foreach ($media as &$m) {
                if ($m['type'] === 'video' && $m['thumbnail'] === '') {
                    $m['thumbnail'] = $firstImage;
                }
            }
            unset($m);
        }

        $result = [
            'platform'  => 'Instagram',
            'title'     => $isReel ? 'Reels Instagram' : 'Post Instagram',
            'author'    => '',
            'thumbnail' => $media[0]['thumbnail'] ?? '',
            'type'      => count($media) > 1 ? 'carousel' : 'single',
            'media'     => $media,
        ];

        return $this->response->setJSON(['success' => true, 'data' => $result]);
    }

    private function getSnapinstaToken(): ?array
    {
        $resp = $this->fetchApi('https://snap-insta.to/en/highlights-downloader', [
            'Referer: https://snap-insta.to/',
        ]);
        if (empty($resp)) {
            return null;
        }
        if (!preg_match('/k_token\s*=\s*"([a-f0-9]+)"/', $resp, $tokenM)) {
            return null;
        }
        if (!preg_match('/k_exp\s*=\s*"(\d+)"/', $resp, $expM)) {
            return null;
        }
        return ['token' => $tokenM[1], 'exp' => $expM[1]];
    }

    private function parseSnapinstaItems(string $html, bool $isReel): array
    {
        $htmlContent = $html;
        $decoded = json_decode($html, true);
        if (is_array($decoded) && ($decoded['status'] ?? null) === 'ok') {
            $htmlContent = $decoded['data'] ?? '';
        }

        preg_match_all('/<li>(.*?)<\/li>/s', $htmlContent, $liMatches);
        $items = $liMatches[1] ?? [];

        $results = [];
        foreach ($items as $idx => $item) {
            $isVideo = (strpos($item, 'icon-dlvideo') !== false);
            $isImage = (strpos($item, 'icon-dlimage') !== false);

            if ($isImage) {
                if (preg_match('/<option\s+value="(https:\/\/dl\.snapcdn\.app\/get\?token=[^"]+)"/', $item, $m)) {
                    $results[] = ['type' => 'image', 'url' => $m[1], 'thumbnail' => $m[1]];
                    continue;
                }
            }

            if ($isVideo) {
                if (preg_match('/title="Download Video"\s+href="(https:\/\/dl\.snapcdn\.app\/get\?token=[^"]+)"/', $item, $m)) {
                    $results[] = ['type' => 'video', 'url' => $m[1], 'thumbnail' => ''];
                    continue;
                }
                if (preg_match('/href="(https:\/\/dl\.snapcdn\.app\/get\?token=[^"]+)"[^>]*title="Download Video"/', $item, $m)) {
                    $results[] = ['type' => 'video', 'url' => $m[1], 'thumbnail' => ''];
                    continue;
                }
                preg_match_all('/href="(https:\/\/dl\.snapcdn\.app\/get\?token=[^"]+)"/', $item, $all);
                if (!empty($all[1])) {
                    $results[] = ['type' => 'video', 'url' => end($all[1]), 'thumbnail' => ''];
                    continue;
                }
            }

            if (preg_match('/(?:href="|value=")(https:\/\/dl\.snapcdn\.app\/get\?token=[^"]+)"/', $item, $m)) {
                $results[] = ['type' => $isVideo ? 'video' : 'image', 'url' => $m[1], 'thumbnail' => $isVideo ? '' : $m[1]];
            }
        }

        if ($isReel) {
            $videoOnly = array_values(array_filter($results, fn($r) => $r['type'] === 'video'));
            return !empty($videoOnly) ? $videoOnly : $results;
        }

        return $results;
    }

    private function extractIgProfile($username)
    {
        $token = $this->getSnapinstaToken();
        if (!$token) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal menghubungi server. Coba lagi beberapa saat.']);
        }

        $profileUrl = "https://www.instagram.com/{$username}/";

        $response = $this->fetchApi('https://snap-insta.to/api/ajaxSearch', [
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'Origin: https://snap-insta.to',
            'Referer: https://snap-insta.to/en/profile-downloader',
            'X-Requested-With: XMLHttpRequest',
        ], [
            'q' => $profileUrl, 't' => 'media', 'lang' => 'en', 'v' => 'v2',
            'k_exp' => $token['exp'], 'k_token' => $token['token'],
        ]);

        if (empty($response)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal mengambil data profil. Coba lagi beberapa saat.']);
        }

        $items = $this->parseSnapinstaItems($response, false);

        if (empty($items)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Profil tidak ditemukan, private, atau tidak punya post.']);
        }

        $firstImage = null;
        foreach ($items as $it) {
            if ($it['type'] === 'image') {
                $firstImage = $it['url'];
                break;
            }
        }
        if ($firstImage) {
            foreach ($items as &$it) {
                if ($it['type'] === 'video' && empty($it['thumbnail'])) {
                    $it['thumbnail'] = $firstImage;
                }
            }
            unset($it);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'platform' => 'Instagram Profile',
                'username' => $username,
                'items'    => $items,
            ]
        ]);
    }

    
    private function normalizeDdtikUrl(?string $path): string
    {
        if (empty($path)) {
            return '';
        }
        if (stripos($path, 'http://') === 0 || stripos($path, 'https://') === 0) {
            return $path;
        }
        return 'https://ddtik.com' . $path;
    }

    private function extractTikTokProfile($username, $cursor = 0)
    {
        $apiUrl = "https://ddtik.com/api/profile-videos?" . http_build_query([
            'username' => $username,
            'cursor'   => $cursor,
        ]);
        $response = $this->fetchApi($apiUrl, [
            'Referer: https://ddtik.com/tiktok-viewer'
        ]);
        $data = json_decode($response, true);

        if (!$data || empty($data['success']) || empty($data['data'])) {
            
            if ($cursor === 0) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Profil tidak ditemukan, private, atau tidak punya video.']);
            }
            
            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'platform'   => 'TikTok Profile',
                    'username'   => $username,
                    'items'      => [],
                    'hasMore'    => false,
                    'nextCursor' => 0,
                ]
            ]);
        }

        $pageData = $data['data'];
        $videos = $pageData['videos'] ?? [];
        $items = [];

        foreach ($videos as $v) {
            if (!empty($v['isCarousel']) && !empty($v['images'])) {
                foreach ($v['images'] as $img) {
                    $imgUrl = $this->normalizeDdtikUrl($img);
                    if ($imgUrl) {
                        $items[] = [
                            'type'      => 'image',
                            'url'       => $imgUrl,
                            'thumbnail' => $imgUrl,
                        ];
                    }
                }
            } else {
                $vurl = $this->normalizeDdtikUrl($v['hdplay'] ?? $v['play'] ?? null);
                if ($vurl) {
                    $thumb = $this->normalizeDdtikUrl(
                        $v['cover'] ?? $v['dynamicCover'] ?? $v['originCover'] ?? $v['thumbnail'] ?? null
                    );
                    $items[] = [
                        'type'      => 'video',
                        'url'       => $vurl,
                        'thumbnail' => $thumb,
                    ];
                }
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'platform'   => 'TikTok Profile',
                'username'   => $username,
                'items'      => $items,
                'hasMore'    => !empty($pageData['hasMore']),
                'nextCursor' => (int) ($pageData['nextCursor'] ?? 0),
            ]
        ]);
    }

    private function extractTikTokStory($username)
    {
        $apiUrl = "https://ddtik.com/api/user-story?" . http_build_query(['username' => $username]);
        $response = $this->fetchApi($apiUrl, [
            'Referer: https://ddtik.com/tiktok-story-viewer'
        ]);
        $data = json_decode($response, true);

        if (!$data || empty($data['success'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Story tidak ditemukan. Akun tidak punya story aktif atau username salah.']);
        }

        $stories = $data['data']['stories'] ?? [];
        if (empty($stories)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Akun ini tidak memiliki story aktif saat ini.']);
        }

        $items = [];
        foreach ($stories as $st) {
            if (!empty($st['isImage'])) {
                $imgUrl = $this->normalizeDdtikUrl($st['imageUrl'] ?? null);
                if ($imgUrl) {
                    $items[] = [
                        'type'      => 'image',
                        'url'       => $imgUrl,
                        'thumbnail' => $imgUrl,
                    ];
                }
            } else {
                $videoUrl = $this->normalizeDdtikUrl($st['play'] ?? null);
                if ($videoUrl) {
                    $thumb = $this->normalizeDdtikUrl(
                        $st['cover'] ?? $st['dynamicCover'] ?? $st['originCover'] ?? $st['thumbnail'] ?? null
                    );
                    $items[] = [
                        'type'      => 'video',
                        'url'       => $videoUrl,
                        'thumbnail' => $thumb,
                    ];
                }
            }
        }

        if (empty($items)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Story ditemukan tapi gagal diproses.']);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'platform' => 'TikTok Story',
                'username' => $username,
                'items'    => $items,
            ]
        ]);
    }

    private function extractIgStory($username)
    {
        $apiUrl = "https://api.instasave.website/story";
        $response = $this->fetchApi($apiUrl, [
            'Content-Type: application/x-www-form-urlencoded',
            'Origin: https://instasave.website',
            'Referer: https://instasave.website/',
        ], ['url' => $username]);

        if (empty($response)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Gagal mengambil story. Coba lagi beberapa saat.']);
        }

        $items = $this->parseInstasaveCdnUrls($response);

        if (empty($items)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Story tidak ditemukan. Akun tidak punya story aktif, private, atau username salah.']);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'platform' => 'Instagram Story',
                'username' => $username,
                'items'    => $items,
            ]
        ]);
    }

    private function parseInstasaveCdnUrls(string $raw, bool $isReel = false): array
    {
        $raw = str_replace(['\\x20', '\\x22'], [' ', '"'], $raw);
        preg_match_all('/https:\/\/cdn\.instasave\.website\/\?token=[A-Za-z0-9._-]+/', $raw, $matches);
        $cdnUrls = $matches[0] ?? [];

        $videoExt = ['.mp4', '.mov', '.mkv', '.webm'];
        $videos = [];
        $photos = [];
        $seen = [];

        foreach ($cdnUrls as $u) {
            $parts = explode('token=', $u, 2);
            if (count($parts) < 2) {
                continue;
            }
            $token = $parts[1];
            $payload = $this->decodeJwtPayload($token);
            $fname = $payload['filename'] ?? '';
            $force = !empty($payload['force']);
            $ext = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
            $ext = $ext ? '.' . $ext : '';
            $isVideo = in_array($ext, $videoExt, true);

            if (isset($seen[$fname]) && $fname !== '') {
                continue;
            }

            if ($isVideo && $force) {
                $seen[$fname] = true;
                $videos[] = ['type' => 'video', 'url' => $u, 'thumbnail' => '', 'filename' => $fname];
            } elseif (!$isVideo && !$force) {
                $seen[$fname] = true;
                $photos[] = ['type' => 'image', 'url' => $u, 'thumbnail' => $u, 'filename' => $fname];
            }
        }

        
        if (!empty($photos)) {
            $fallbackThumb = $photos[0]['thumbnail'];
            foreach ($videos as &$v) {
                if ($v['thumbnail'] === '') {
                    $v['thumbnail'] = $fallbackThumb;
                }
            }
            unset($v);
        }

        if ($isReel) {
            return $videos;
        }

        return array_merge($photos, $videos);
    }

    private function decodeJwtPayload(string $token): array
    {
        $parts = explode('.', $token);
        if (count($parts) < 2) {
            return [];
        }
        $part = $parts[1];
        $padded = str_pad($part, strlen($part) + (4 - strlen($part) % 4) % 4, '=');
        $decoded = base64_decode(strtr($padded, '-_', '+/'));
        if ($decoded === false) {
            return [];
        }
        $json = json_decode($decoded, true);
        return is_array($json) ? $json : [];
    }

    private function fetchApi($url, array $extraHeaders = [], ?array $postFields = null) {
        $ch = curl_init();
        $headers = array_merge([
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ], $extraHeaders);

        $opts = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
        ];

        if ($postFields !== null) {
            $opts[CURLOPT_POST] = true;
            $opts[CURLOPT_POSTFIELDS] = http_build_query($postFields);
        }

        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function resolveProxyReferer(string $domain): ?string
    {
        $map = [
            'ddtik.com'              => 'https://ddtik.com/',
            'instasave.website'      => 'https://instasave.website/',
            'cdn.instasave.website'  => 'https://instasave.website/',
            'snap-insta.to'          => 'https://snap-insta.to/',
            'snapcdn.app'            => 'https://snap-insta.to/',
            'tikwm.com'              => 'https://www.tikwm.com/',
        ];

        foreach ($map as $needle => $referer) {
            if (stripos($domain, $needle) !== false) {
                return $referer;
            }
        }

        return null;
    }

    private function isProxyDomainAllowed(?string $domain): bool
    {
        $allowedDomains = [
            'twitter.com', 'x.com', 'twimg.com', 'vxtwitter.com',
            'tiktok.com', 'tikwm.com', 'tiktokcdn.com', 'tiktokv.com',
            'tiktokcdn-us.com', 'bytefcdn.com', 'bytecdn.cn', 'douyinvod.com',
            'ddtik.com',
            'instasave.website', 'cdn.instasave.website',
            'snap-insta.to', 'snapcdn.app', 'fbcdn.net', 'cdninstagram.com',
        ];

        if (!$domain) {
            return false;
        }

        foreach ($allowedDomains as $allowed) {
            if (stripos($domain, $allowed) !== false) {
                return true;
            }
        }

        return false;
    }

    private function streamProxy(string $url, string $defaultContentType)
    {
        $domain = parse_url($url, PHP_URL_HOST);

        if (!$this->isProxyDomainAllowed($domain)) {
            return $this->response->setStatusCode(403)->setBody('Domain tidak diizinkan oleh proxy. Domain terdeteksi: ' . $domain);
        }

        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: ' . $defaultContentType);
        header('Access-Control-Allow-Origin: ' . base_url());
        header('Cache-Control: no-cache');

        $referer = $this->resolveProxyReferer((string) $domain);
        $headers = ['User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'];
        if ($referer) {
            $headers[] = 'Referer: ' . $referer;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_WRITEFUNCTION => function ($ch, $chunk) {
                echo $chunk;
                return strlen($chunk);
            },
        ]);

        curl_exec($ch);
        curl_close($ch);
        exit;
    }

    public function videoProxy()
    {
        $url = $this->request->getGet('url');

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->response->setStatusCode(400)->setBody('URL Video tidak valid.');
        }

        return $this->streamProxy($url, 'video/mp4');
    }

    public function imageProxy()
    {
        $url = $this->request->getGet('url');

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->response->setStatusCode(400)->setBody('URL Gambar tidak valid.');
        }

        return $this->streamProxy($url, 'image/jpeg');
    }

    public function downloadMedia()
    {
        $url = $this->request->getGet('url');
        $type = $this->request->getGet('type') ?? 'video';

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->response->setStatusCode(400)->setBody('URL tidak valid.');
        }

        if (ob_get_level()) {
            ob_end_clean();
        }

        $ext = ($type === 'audio') ? 'mp3' : (($type === 'image') ? 'jpg' : 'mp4');
        $filename = 'RianProjects_Downloader_' . time() . '.' . $ext;

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');

        $domain = parse_url($url, PHP_URL_HOST);
        $referer = $this->resolveProxyReferer((string) $domain);
        $headers = ['User-Agent: Mozilla/5.0'];
        if ($referer) {
            $headers[] = 'Referer: ' . $referer;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_WRITEFUNCTION => function ($ch, $chunk) {
                echo $chunk;
                return strlen($chunk);
            },
        ]);

        curl_exec($ch);
        curl_close($ch);
        exit;
    }

    public function downloadZip()
    {
        return redirect()->back()->with('error', 'Mohon maaf, fitur Download ZIP sedang dinonaktifkan sementara untuk menjaga performa server. Silakan unduh satu per satu.');
    }
}