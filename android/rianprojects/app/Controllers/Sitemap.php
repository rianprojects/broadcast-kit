<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\PostModel;

class Sitemap extends BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();
        $postModel    = new PostModel(); 
        $projects = $projectModel->orderBy('created_at', 'DESC')->findAll();
        $posts    = $postModel->where('status', 'published')->orderBy('created_at', 'DESC')->findAll();
        $this->response->setContentType('text/xml');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<?xml-stylesheet type="text/xsl" href="' . base_url('sitemap.xsl') . '"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $xml .= '<url>';
        $xml .= '<loc>' . base_url() . '</loc>';
        $xml .= '<lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';
        
        $staticPages = [

            ['url' => 'tools',                  'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => 'tools/downloader',       'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => 'tools/qrcode',           'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => 'tools/meme',             'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => 'tools/colorcontrast',    'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => 'tools/gradient',         'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => 'tools/boxshadow',        'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => 'tools/gridbuilder',      'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => 'tools/palettes',         'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => 'ailab',                  'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => 'ailab/imaging',          'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => 'ailab/blogai',           'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => 'ailab/code-reviewer',    'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => 'ailab/social-media',     'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => 'ailab/cv-scanner',       'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => 'ailab/newsai',           'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => 'ailab/chat',             'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => 'ailab/youtube-summarizer','priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => 'ailab/data-analyst',     'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => 'ailab/text-detector',    'priority' => '0.7', 'changefreq' => 'weekly'],
        ];
    
    foreach ($staticPages as $page) {
        $xml .= '<url>';
        $xml .= '<loc>' . base_url($page['url']) . '</loc>';
        $xml .= '<lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>';
        $xml .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
        $xml .= '<priority>' . $page['priority'] . '</priority>';
        $xml .= '</url>';
    }


        foreach ($projects as $proj) {
            $xml .= '<url>';
            $xml .= '<loc>' . base_url('project/' . $proj['slug']) . '</loc>';
            $date = $proj['updated_at'] ?? $proj['created_at'];
            $xml .= '<lastmod>' . date('Y-m-d\TH:i:sP', strtotime($date)) . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }


        foreach ($posts as $post) {
            $xml .= '<url>';
            $xml .= '<loc>' . base_url('blog/' . $post['slug']) . '</loc>';
            $date = $post['updated_at'] ?? $post['created_at'];
            $xml .= '<lastmod>' . date('Y-m-d\TH:i:sP', strtotime($date)) . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.9</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $this->response->setBody($xml);
    }
}