<?php
namespace App\Controllers;
class Tools extends BaseController
{
    public function index()
    {
        $data = [
            'title'      => 'Kumpulan Tools - Rian Projects',
            'meta_desc'  => 'Jelajahi kumpulan web tools gratis yang super cepat. Mulai dari Video Downloader TikTok/X hingga Advanced QR Code Generator premium.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Tools' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-600'
        ];
        
        return view('tools/index', $data);
    }
    
    public function meme()
    {
        $data = [
            'title'      => 'Instant Meme Generator - Rian Projects',
            'meta_desc'  => 'Buat meme lucu dan viral dalam hitungan detik! Upload foto, tambahkan teks, dan bagikan ekspresi kreatif Anda. Alat pembuat meme gratis, cepat, dan mudah digunakan.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Tools'         => 'tools', 
                'Meme Generator' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-600'
        ];
        return view('tools/meme', $data);
    }
    
    public function qrcode()
    {
        $data = [
            'title'      => 'Advanced QR Code Generator - Rian Projects',
            'meta_desc'  => 'Buat QR Code premium secara instan. Kustomisasi bentuk, warna, dan sisipkan logo Anda di tengah. 100% aman dan diproses murni di perangkat Anda.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Tools'          => 'tools', 
                'QR Generator' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-600'
        ];
        return view('tools/qrcode', $data);
    }

    public function colorcontrast()
    {
        $data = [
            'title'      => 'Color Contrast Checker - Rian Projects',
            'meta_desc'  => 'Cek kontras warna teks & background sesuai standar WCAG AA/AAA. Gratis, instan, dan 100% diproses di browser.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Tools'          => 'tools', 
                'Color Contrast Checker' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-violet-500 to-pink-500'
        ];
        return view('tools/colorcontrast', $data);
    }

    public function gradient()
    {
        $data = [
            'title'      => 'CSS Gradient Generator - Rian Projects',
            'meta_desc'  => 'Buat gradient CSS cantik dengan mudah. Linear, radial, dan conic gradient. Copy kode CSS langsung pakai.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Tools'          => 'tools', 
                'CSS Gradient Generator' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-pink-500'
        ];
        return view('tools/gradient', $data);
    }

    public function boxshadow()
    {
        $data = [
            'title'      => 'Box Shadow Generator - Rian Projects',
            'meta_desc'  => 'Generate CSS box-shadow secara visual dan interaktif. Tambah multiple shadow, atur blur, spread, dan warna. Copy CSS langsung.',
            'meta_image' => base_url('assets/images/logo.png'),
            'breadcrumbs' => [
                'Tools'          => 'tools', 
                'Box Shadow Generator' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-blue-500'
        ];
        return view('tools/boxshadow', $data);
    }

    public function gridbuilder()
    {
        $data = [
            'title'      => 'CSS Grid Builder - Rian Projects',
            'meta_desc'  => 'Bangun layout CSS Grid secara visual. Atur kolom, baris, gap, dan area grid. Dapatkan kode CSS Grid siap pakai.',
            'meta_image' => base_url('assets/images/logo.png'),
            
            'breadcrumbs' => [
                'Tools'          => 'tools', 
                'CSS Grid Builder' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-cyan-500'
        ];
        return view('tools/gridbuilder', $data);
    }
    
    public function palettes()
    {
        $data = [
            'title'      => 'Color Palette Explorer - Rian Projects',
            'meta_desc'  => 'Temukan inspirasi kombinasi warna terbaik...',
            'meta_image' => base_url('assets/images/logo.png'),
            
            'breadcrumbs' => [
                'Tools'          => 'tools', 
                'Color Palettes' => '#'
            ],
            'breadcrumb_color' => 'text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-red-500'
        ];
        return view('tools/palettes', $data);
    }
}