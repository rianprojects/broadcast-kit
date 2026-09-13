<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Settings extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        
        $settings = $this->db->table('settings')->where('id', 1)->get()->getRowArray();
        if (!$settings) {
            $settings = [
                'site_name' => '', 'site_title' => '', 'site_description' => '',
                'site_keywords' => '', 'footer_text' => '', 
                'social_facebook' => '', 'social_instagram' => '', 'social_github' => '',
                'recaptcha_enabled' => 1, 'payment_mode' => 'manual'
            ];
        }

        $data = [
            'title'    => 'Pengaturan Website',
            'settings' => $settings
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $data = [
            'site_name'        => $this->request->getPost('site_name'),
            'site_title'       => $this->request->getPost('site_title'),
            'site_description' => $this->request->getPost('site_description'),
            'site_keywords'    => $this->request->getPost('site_keywords'),
            'footer_text'      => $this->request->getPost('footer_text'),
            'social_facebook'  => $this->request->getPost('social_facebook'),
            'social_instagram' => $this->request->getPost('social_instagram'),
            'social_github'    => $this->request->getPost('social_github'),
            'recaptcha_enabled' => $this->request->getPost('recaptcha_enabled') ? 1 : 0,
            'payment_mode'     => $this->request->getPost('payment_mode') === 'tripay' ? 'tripay' : 'manual',
        ];

        // Cek apakah data ID 1 sudah ada?
        $exists = $this->db->table('settings')->where('id', 1)->countAllResults();

        if ($exists > 0) {
            $this->db->table('settings')->where('id', 1)->update($data);
        } else {
            $data['id'] = 1;
            $this->db->table('settings')->insert($data);
        }

        return redirect()->to('/admin/settings')->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}