<?php

namespace App\Controllers;

use App\Models\ProjectModel;

class Home extends BaseController
{

    public function index()
    {

        $agent = $this->request->getUserAgent();
        $db = \Config\Database::connect();
        $currentBrowser = 'Unknown Browser';
        $currentOS      = 'Unknown OS';

        if ($agent->isBrowser()) {
            $currentBrowser = $agent->getBrowser() . ' ' . $agent->getVersion();
            $currentOS      = $agent->getPlatform();
        } elseif ($agent->isRobot()) {
            $currentBrowser = $agent->getRobot();
            $currentOS      = 'Robot/Bot';
        } elseif ($agent->isMobile()) {
            $currentBrowser = $agent->getMobile();
            $currentOS      = $agent->getPlatform();
        } else {
            $currentBrowser = 'Unidentified User Agent';
        }

        if (empty($currentOS) || $currentOS == 'Unknown Platform' || $currentOS == 'Unknown OS') {
            $agentString = $agent->getAgentString();
            if (stripos($agentString, 'Windows') !== false) $currentOS = 'Windows';
            elseif (stripos($agentString, 'Android') !== false) $currentOS = 'Android';
            elseif (stripos($agentString, 'iPhone') !== false) $currentOS = 'iOS';
            elseif (stripos($agentString, 'Mac') !== false) $currentOS = 'Mac OS';
            elseif (stripos($agentString, 'Linux') !== false) $currentOS = 'Linux';
            elseif (stripos($agentString, 'X11') !== false) $currentOS = 'UNIX';
        }

        try {
            $db->table('visitor_logs')->insert([
                'ip_address' => $this->request->getIPAddress(),
                'os'         => $currentOS,
                'browser'    => $currentBrowser,
                'url'        => current_url(),
                'user_agent' => $agent->getAgentString(),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
           
        }
        
        $model = new ProjectModel();
        
        $data = [
            'title'    => 'Rian Projects',
            'meta_desc' => 'Jasa Pembuatan Website profesional',
            'projects' => $model->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('frontend/index', $data);
    }


    public function detail($slug)
    {
        $model = new ProjectModel();
        $project = $model->where('slug', $slug)->first();
        
        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($project);
        }
        
        return view('frontend/detail', [
            'title'   => $project['title'] . ' - Rian Projects',
            'project' => $project,
            'meta_desc'  => $project['meta_desc'] ?? substr(strip_tags($project['description']), 0, 150),
            'meta_image' => base_url('uploads/projects/' . $project['thumbnail'])
        ]);
    }
}