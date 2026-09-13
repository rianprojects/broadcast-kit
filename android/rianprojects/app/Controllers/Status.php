<?php

namespace App\Controllers;

class Status extends BaseController
{
    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $monitors = $this->db->table('uptime_monitors')->get()->getResultArray();

        foreach ($monitors as &$m) {

            $history = $this->db->table('uptime_history')
                                ->where('monitor_id', $m['id'])
                                ->orderBy('created_at', 'DESC')
                                ->limit(20)
                                ->get()
                                ->getResultArray();
            
            $m['history'] = array_reverse($history);
            $totalChecks = count($history);
            $upChecks = 0;
            foreach($history as $h) {
                if($h['status'] == 'up') $upChecks++;
            }
            $m['uptime_percent'] = $totalChecks > 0 ? round(($upChecks / $totalChecks) * 100) : 0;
        }

        return view('frontend/status', [
            'title' => 'System Status',
            'monitors' => $monitors
        ]);
    }

    public function check()
    {
        $key = $this->request->getGet('key');
        if ($key !== 'RIAN_MONITOR_2024') {
            return $this->response->setStatusCode(403)->setBody('Invalid Key');
        }

        $monitors = $this->db->table('uptime_monitors')->get()->getResultArray();
        
        foreach ($monitors as $m) {
            $start = microtime(true);
            $targetUrl = $m['url'];
            
            if (strpos($targetUrl, 'generativelanguage.googleapis.com') !== false) {
                $targetUrl .= "?key=" . getenv('PING_GEMINI_KEY');
            }
            
            $ch = curl_init($targetUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true); 
            curl_setopt($ch, CURLOPT_NOBODY, false); 
            
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');

            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $end = microtime(true);
            curl_close($ch);
            
            $responseTime = round(($end - $start) * 1000);
            $status = ($httpCode >= 200 && $httpCode < 400) ? 'up' : 'down';
            
            if ($status === 'up') {
                if ($responseTime <= 100) {
                    $displayStatus = 'up';
                } elseif ($responseTime > 100 && $responseTime <= 150) {
                    $displayStatus = 'slow';
                } else {
                    $displayStatus = 'bad';
                }
            } else {
                $displayStatus = 'down';
            }
            
            $this->db->table('uptime_monitors')->where('id', $m['id'])->update([
                'status'        => $displayStatus,
                'last_response' => $responseTime,
                'last_checked'  => date('Y-m-d H:i:s')
            ]);

            $this->db->table('uptime_history')->insert([
                'monitor_id'    => $m['id'],
                'response_time' => $responseTime,
                'status'        => $status,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
        }

        return "Pengecekan Selesai: " . date('Y-m-d H:i:s');
    }
}