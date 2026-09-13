<?php
namespace App\Controllers;

class Pages extends BaseController
{
    public function terms()
    {
        $data = ['title' => 'Terms of Service - AI Prompt Library'];
        return view('frontend/terms', $data);
    }

    public function privacy()
    {
        $data = ['title' => 'Privacy Policy - AI Prompt Library'];
        return view('frontend/privacy', $data);
    }
}