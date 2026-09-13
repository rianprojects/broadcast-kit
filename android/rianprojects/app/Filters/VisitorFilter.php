<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class VisitorFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        $uri = service('uri');
        $segment = $uri->getTotalSegments() > 0 ? $uri->getSegment(1) : '';
        
        if ($segment === 'admin' || $request->isAJAX()) {
            return;
        }

        $db = \Config\Database::connect();
        $agent = $request->getUserAgent();
        $os = $agent->getPlatform();
        if (empty($os) || $os === 'Unknown Platform') {
            $os = 'Unknown';
        }

        if ($agent->isBrowser()) {
            $browser = $agent->getBrowser() . ' ' . $agent->getVersion();
        } elseif ($agent->isRobot()) {
            $browser = 'Robot: ' . $agent->getRobot();
        } elseif ($agent->isMobile()) {
            $browser = 'Mobile: ' . $agent->getMobile();
        } else {
            $browser = 'Unknown';
        }
        
        $db->table('visitor_logs')->insert([
            'ip_address'  => $request->getIPAddress(),
            'os'          => $os,
            'browser'     => $browser,
            'user_agent'  => $agent->getAgentString(),
            'url_visited' => (string)$uri,
        ]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}