<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= $title ?? 'Rian Projects'; ?></title>
    <meta name="description" content="<?= strip_tags($meta_desc ?? 'Portfolio Rian Projects - Web Developer & UI Designer') ?>">
    <meta name="favicon" content="<?= $meta_image ?? base_url('assets/images/logo.png') ?>">
    <meta name="author" content="Rian Projects">
    <meta name="p:domain_verify" content="f86bc4cad4033c606c3377b658f2f1f9"/>
    <link rel="canonical" href="<?= current_url() ?>">
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Person",
      "name": "Rian Projects",
      "url": "<?= base_url() ?>",
      "image": "<?= base_url('logo.png') ?>", 
      "sameAs": [
        "<?= $site_settings['social_github'] ?? '#' ?>",
        "<?= $site_settings['social_instagram'] ?? '#' ?>",
        "<?= $site_settings['social_facebook'] ?? '#' ?>"
      ],
      "jobTitle": "Web Developer",
      "worksFor": {
        "@type": "Organization",
        "name": "Freelance"
      }  
    }
    </script>

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="<?= $title ?? 'Rian Projects' ?>">
    <meta property="og:description" content="<?= strip_tags($meta_desc ?? 'Portfolio Rian Projects') ?>">
    <meta property="og:image" content="<?= $meta_image ?? base_url('assets/images/logo.png') ?>">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $title ?? 'Rian Projects' ?>">
    <meta name="twitter:description" content="<?= strip_tags($meta_desc ?? 'Portfolio Rian Projects') ?>">
    <meta name="twitter:image" content="<?= $meta_image ?? base_url('assets/images/logo.png') ?>">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9162789903606130" crossorigin="anonymous"></script>
    <script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        outfit: ['"Outfit"', 'sans-serif'],
                    },
                    colors: {
                        dark: {
                            900: '#0a0a0f',
                            800: '#131318',
                            700: '#1a1a24',
                        },
                        accent: {
                            primary: '#6366f1',
                            secondary: '#8b5cf6',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'slide-down': 'slideDown 0.5s ease-out',
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        glow: {
                            'from': { boxShadow: '0 0 20px rgba(99, 102, 241, 0.5)' },
                            'to': { boxShadow: '0 0 30px rgba(139, 92, 246, 0.8)' },
                        },
                        slideUp: {
                            'from': { transform: 'translateY(30px)', opacity: '0' },
                            'to': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            'from': { transform: 'translateY(-30px)', opacity: '0' },
                            'to': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            'from': { opacity: '0' },
                            'to': { opacity: '1' },
                        },
                        scaleIn: {
                            'from': { transform: 'scale(0.9)', opacity: '0' },
                            'to': { transform: 'scale(1)', opacity: '1' },
                        }
                    }
                }
            }
        }
        
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            position: relative;
        }
        
        h1, h2, h3, h4, h5, h6 { 
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        .bg-grid {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(99, 102, 241, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(99, 102, 241, 0.03) 1px, transparent 1px);
        }
        
        .dark .bg-grid {
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .dark .glass {
            background: rgba(19, 19, 24, 0.7);
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .dark ::-webkit-scrollbar-track {
            background: #0a0a0f;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #4f46e5, #7c3aed);
        }

        .navbar-blur {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        #mobile-menu {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glow-on-hover:hover {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }

        .dark .glow-on-hover:hover {
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.5);
        }

        .custom-prose h1 { 
            font-size: 2.25rem !important;
            line-height: 2.5rem; 
            font-weight: 800; 
            margin-top: 2rem; 
            margin-bottom: 1rem; 
            color: #1e293b;
        }
        
        .custom-prose h2 { 
            font-size: 1.875rem !important; 
            line-height: 2.25rem; 
            font-weight: 700; 
            margin-top: 1.75rem; 
            margin-bottom: 0.75rem; 
            color: #334155;
        }

        .custom-prose h3 { 
            font-size: 1.5rem !important; 
            line-height: 2rem; 
            font-weight: 600; 
            margin-top: 1.5rem; 
            margin-bottom: 0.75rem; 
        }

        .custom-prose ul { 
            list-style-type: disc !important; 
            padding-left: 1.5rem !important; 
            margin-bottom: 1.25rem;
        }

        .custom-prose ol { 
            list-style-type: decimal !important; 
            padding-left: 1.5rem !important; 
            margin-bottom: 1.25rem;
        }

        .dark .custom-prose h1, 
        .dark .custom-prose h2, 
        .dark .custom-prose h3 { 
            color: #f1f5f9;
        }

    </style>
    
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <meta name="theme-color" content="#6366f1">
    <link rel="apple-touch-icon" href="<?= base_url('assets/rp.png') ?>">

    <?= $this->renderSection('extra_head') ?>
</head>

<body x-data="globalApp()" class="bg-slate-50 dark:bg-dark-900 text-slate-900 dark:text-slate-100 transition-colors duration-500 ease-in-out min-h-screen flex flex-col bg-grid overflow-x-hidden">
    <amp-auto-ads type="adsense" data-ad-client="ca-pub-9162789903606130"> </amp-auto-ads>
    
    <?php if (session()->has('admin_user_id')) : ?>
        <div class="sticky top-0 z-[1000] bg-gradient-to-r from-amber-500 to-orange-600 text-white py-3 px-6 shadow-2xl flex justify-between items-center">
            <div class="text-xs sm:text-sm font-black uppercase tracking-wider">
                <i class="fa-solid fa-mask mr-2"></i> Mode Impersonasi: <?= session()->get('username') ?>
            </div>
            <a href="<?= base_url('admin/users/logout-as') ?>" class="bg-white text-orange-600 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase hover:scale-105 transition-transform shadow-lg">
                Kembali ke Super Admin
            </a>
        </div>
    <?php endif; ?>
    
    <nav class="sticky top-0 z-50 glass navbar-blur border-b border-slate-200/50 dark:border-slate-700/50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <a href="<?= base_url('/') ?>" class="font-bold text-xl gradient-text tracking-wider font-outfit hover:scale-105 transition-transform">
                    RIAN<span class="text-slate-800 dark:text-white">PROJECTS</span>
                </a>
    
                <div class="flex items-center gap-2 md:gap-4">
                    
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="<?= base_url('/') ?>" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                            Beranda
                        </a>
                        
                        <a href="<?= base_url('/#projects') ?>" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                            Proyek
                        </a>
                        <a href="<?= base_url('blog') ?>" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                            Blog
                        </a>
                        <a href="<?= base_url('prompts') ?>" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                            AI Prompt
                        </a>
                        <a href="<?= base_url('ailab') ?>" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                            AI Lab
                        </a>
                        <a href="<?= base_url('tools') ?>" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                            Tools
                        </a>
                        <a href="https://twibbon.rianprojects.my.id/" target="blank" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                            Twibbon
                        </a>
    
                    </div>
    
                    <div class="hidden md:block h-6 w-px bg-slate-200 dark:bg-slate-700 mx-2"></div>
    
                    <button id="theme-toggle" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-all focus:outline-none text-slate-600 dark:text-slate-400">
                        <i class="fa-solid fa-sun text-yellow-500 hidden dark:block"></i>
                        <i class="fa-solid fa-moon block dark:hidden"></i>
                    </button>
    
                    <div class="hidden md:block">
                        <?php if(session()->get('isLoggedIn')): ?>
                            <div class="relative group">
                                <button class="flex items-center gap-3 focus:outline-none py-1">
                                    <div class="text-right hidden lg:block leading-tight">
                                        <p class="text-xs font-bold text-slate-800 dark:text-white">
                                            <?= esc(session()->get('username')) ?>
                                        </p>
                                        <p class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                                            <?= session()->get('role') ?>
                                        </p>
                                    </div>
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white dark:ring-slate-900 group-hover:ring-indigo-500 transition-all">
                                        <?= substr(strtoupper(session()->get('username')), 0, 1) ?>
                                    </div>
                                </button>
    
                                <div class="absolute right-0 top-full pt-2 w-48 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 z-50">
                                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden">
                                        <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800 lg:hidden">
                                            <p class="text-sm font-bold text-slate-900 dark:text-white"><?= esc(session()->get('username')) ?></p>
                                        </div>
                                        
                                        <?php if(session()->get('role') == 'admin'): ?>
                                            <a href="<?= base_url('admin') ?>" class="block px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 transition-colors">
                                                <i class="fa-solid fa-gauge-high mr-2 w-4"></i> Admin Panel
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= base_url('dashboard') ?>" class="block px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 transition-colors">
                                                <i class="fa-solid fa-chart-pie mr-2 w-4"></i> Dashboard
                                            </a>
                                        <?php endif; ?>
    
                                        <a href="<?= base_url('prompts/my') ?>" class="block px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 transition-colors">
                                            <i class="fa-solid fa-layer-group mr-2 w-4"></i> My Prompts
                                        </a>
    
                                        <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>
    
                                        <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2.5 text-sm text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/10 font-medium transition-colors">
                                            <i class="fa-solid fa-power-off mr-2 w-4"></i> Logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="flex items-center gap-2">
                                <a href="<?= base_url('login') ?>" class="px-4 py-2 text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-white transition-colors">
                                    Login
                                </a>
                                <a href="<?= base_url('register') ?>" class="px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold rounded-lg hover:bg-indigo-600 dark:hover:bg-indigo-50 hover:text-white dark:hover:text-indigo-600 transition-all shadow-lg shadow-indigo-500/20">
                                    Sign Up
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
    
                    <button id="mobile-menu-toggle" class="md:hidden p-2 rounded-lg hover:bg-slate-100/50 dark:hover:bg-slate-800/50 transition-colors focus:outline-none">
                        <i class="fa-solid fa-bars text-slate-600 dark:text-slate-300 text-xl"></i>
                    </button>
                </div>
            </div>
    
            <div id="mobile-menu" class="md:hidden overflow-hidden max-h-0 opacity-0 transition-all duration-300 ease-in-out">
                <div class="py-4 space-y-1 border-t border-slate-200/50 dark:border-slate-700/50">
                    
                    <a href="<?= base_url('/') ?>" class="block px-4 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg font-medium">
                        <i class="fa-solid fa-home mr-3 w-5 text-center"></i> Beranda
                    </a>
                    <a href="<?= base_url('/#projects') ?>" class="block px-4 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg font-medium">
                        <i class="fa-solid fa-folder-open mr-3 w-5 text-center"></i> Proyek
                    </a>
                    <!--<a href="<?= base_url('porto') ?>" class="block px-4 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg font-medium">-->
                    <!--    <i class="fa-solid fa-user mr-3 w-5 text-center"></i> Portofolio-->
                    <!--</a>-->
                    <a href="<?= base_url('blog') ?>" class="block px-4 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg font-medium">
                        <i class="fa-solid fa-blog mr-3 w-5 text-center"></i> Blog
                    </a>
                    <a href="<?= base_url('prompts') ?>" class="block px-4 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg font-medium">
                        <i class="fa-solid fa-wand-magic-sparkles mr-3 w-5 text-center"></i> AI Prompt
                    </a>
                    <a href="<?= base_url('ailab') ?>" class="block px-4 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg font-medium">
                        <i class="fa-solid fa-robot mr-3 w-5 text-center"></i> AI Lab
                    </a>
                    <a href="<?= base_url('tools') ?>" class="block px-4 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg font-medium">
                        <i class="fa-solid fa-gear mr-3 w-5 text-center"></i> Tools
                    </a>
    
    
                    <div class="border-t border-slate-100 dark:border-slate-800 my-2"></div>
    
                    <?php if(session()->get('isLoggedIn')): ?>
                        <div class="px-4 py-2 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                <?= substr(strtoupper(session()->get('username')), 0, 1) ?>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-white"><?= esc(session()->get('username')) ?></p>
                                <p class="text-[10px] text-slate-500 uppercase"><?= session()->get('role') ?></p>
                            </div>
                        </div>
    
                        <?php if(session()->get('role') == 'admin'): ?>
                            <a href="<?= base_url('admin') ?>" class="block px-4 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg font-medium">
                                <i class="fa-solid fa-gauge-high mr-3 w-5 text-center"></i> Admin Panel
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('dashboard') ?>" class="block px-4 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg font-medium">
                                <i class="fa-solid fa-chart-pie mr-3 w-5 text-center"></i> Dashboard
                            </a>
                        <?php endif; ?>
    
                        <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2.5 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/10 rounded-lg font-medium">
                            <i class="fa-solid fa-power-off mr-3 w-5 text-center"></i> Logout
                        </a>
    
                    <?php else: ?>
                        <div class="p-4 grid grid-cols-2 gap-3">
                            <a href="<?= base_url('login') ?>" class="flex justify-center items-center py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                                Login
                            </a>
                            <a href="<?= base_url('register') ?>" class="flex justify-center items-center py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/20">
                                Sign Up
                            </a>
                        </div>
                    <?php endif; ?>
    
                </div>
            </div>
        </div>
    </nav>


    <main class="flex-grow relative overflow-hidden">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="glass py-16 mt-10 relative z-10 border-t border-slate-200/50 dark:border-slate-700/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                
                <div class="space-y-4 md:col-span-2">
                    <h3 class="text-2xl font-bold gradient-text font-outfit">
                        RIANPROJECTS
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed max-w-md">
                        Membangun aplikasi web modern dengan passion dan presisi. Mari ciptakan sesuatu yang menakjubkan bersama.
                    </p>
                    <div class="flex gap-3 pt-2">
                        <?php if(!empty($site_settings['social_github'])): ?>
                            <a href="<?= $site_settings['social_github'] ?>" target="_blank" 
                               class="w-11 h-11 rounded-xl glass flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-black-500 hover:text-white transition-all duration-300 hover:scale-110 glow-on-hover"
                               aria-label="Github">
                                <i class="fa-brands fa-github text-xl"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if(!empty($site_settings['social_instagram'])): ?>
                            <a href="<?= $site_settings['social_instagram'] ?>" target="_blank" 
                               class="w-11 h-11 rounded-xl glass flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-600 hover:text-white transition-all duration-300 hover:scale-110 glow-on-hover"
                               aria-label="Instagram">
                                <i class="fa-brands fa-instagram text-xl"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if(!empty($site_settings['social_facebook'])): ?>
                            <a href="<?= $site_settings['social_facebook'] ?>" target="_blank" 
                               class="w-11 h-11 rounded-xl glass flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-black hover:text-white transition-all duration-300 hover:scale-110 glow-on-hover"
                               aria-label="TikTok">
                                <i class="fa-brands fa-tiktok text-xl"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">
                        Tautan Cepat
                    </h4>
                    <div class="flex flex-col space-y-3">
                        <a href="<?= base_url('/') ?>" class="text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm inline-flex items-center group">
                            <i class="fa-solid fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                            Beranda
                        </a>
                        <a href="<?= base_url('/#projects') ?>" class="text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm inline-flex items-center group">
                            <i class="fa-solid fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                            Proyek
                        </a>
                        <a href="<?= base_url('blog') ?>" class="text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm inline-flex items-center group">
                            <i class="fa-solid fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                            Blog
                        </a>
                        <a href="<?= base_url('/status') ?>" class="text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm inline-flex items-center group">
                            <i class="fa-solid fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                            Status Sistem
                        </a>
                        <a href="<?= base_url('/sitemap.xml') ?>" class="text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-sm inline-flex items-center group">
                            <i class="fa-solid fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                            Sitemap
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">
                        Ketersediaan
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="mt-1">
                                <i class="fa-solid fa-circle-check text-green-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 dark:text-slate-400">
                                    Tersedia untuk proyek freelance dan kolaborasi
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 pt-2">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                            <span class="text-xs text-slate-500 dark:text-slate-500">
                                Semua Sistem Beroperasi Normal
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-200/50 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-600 dark:text-slate-400 text-center md:text-left">
                    &copy; <?= date('Y') ?> <?= $site_settings['footer_text'] ?? 'Rian Projects' ?>. Hak cipta dilindungi.
                </p>
                
                <div class="flex items-center gap-4 text-xs text-slate-500 dark:text-slate-500">
                    <a href="<?= base_url('terms') ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">Syarat & Ketentuan</a>
                    <span>•</span>
                    <a href="<?= base_url('privacy') ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <div x-data="globalApp" class="fixed bottom-6 right-4 sm:right-6 z-[9999] flex flex-col items-end gap-3 pointer-events-none">

        <button id="scrollToTopBtn" aria-label="Scroll to top" class="pointer-events-auto w-12 h-12 rounded-2xl bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl border border-slate-200/50 dark:border-slate-700/50 shadow-xl flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-500 dark:hover:text-white transition-all duration-300 opacity-0 translate-y-5 pointer-events-none group">
            <i class="fa-solid fa-arrow-up group-hover:-translate-y-1 transition-transform duration-300"></i>
        </button>

        <div class="pointer-events-auto bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl border border-slate-200/50 dark:border-slate-700/50 p-1.5 rounded-2xl shadow-xl transition-all duration-300 hover:scale-105">
            <div class="gtranslate_wrapper"></div>
        </div>

        <button x-show="showInstallButton" @click="installApp()" style="display: none;" class="pointer-events-auto relative w-14 h-14 bg-gradient-to-tr from-sky-500 to-indigo-600 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 group hover:-translate-y-1">
            <i class="fa-solid fa-download text-2xl group-hover:animate-bounce"></i>
            <span class="absolute right-16 bg-slate-900 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-lg">
                Install Web App
            </span>
        </button>

        <div x-data="askRianWidget()" class="pointer-events-auto relative flex flex-col items-end">
            
            <div x-show="isOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-10 scale-90"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-10 scale-90"
                 class="absolute bottom-[4.5rem] right-0 mb-2 w-[calc(100vw-2.5rem)] sm:w-[350px] bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-3xl shadow-2xl overflow-hidden flex flex-col h-[400px] sm:h-[450px]"
                 style="display: none;">

                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 p-4 flex items-center justify-between shadow-md relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center p-1 shadow-inner">
                            <img src="<?= base_url('images/ai.webp') ?>" alt="AskRian" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-white font-black text-sm tracking-wide">AskRian AI</h3>
                            <div class="flex items-center gap-1 text-indigo-200 text-[10px] font-bold">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span> Online
                            </div>
                        </div>
                    </div>
                    <button @click="isOpen = false" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-1.5 rounded-lg transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div id="askRianScroll" class="flex-1 p-4 overflow-y-auto bg-slate-50 dark:bg-slate-900/50 space-y-4">
                    <div class="flex justify-start">
                        <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-sm px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm max-w-[85%] leading-relaxed">
                            Hai! 👋 Saya AskRian AI. Ada yang ingin kamu tanyakan seputar portofolio, layanan, atau website Rian Projects?
                        </div>
                    </div>
                    <template x-for="(msg, index) in messages" :key="index">
                        <div class="flex" :class="msg.sender === 'user' ? 'justify-end' : 'justify-start'">
                            <div class="text-sm px-4 py-3 shadow-sm max-w-[85%] leading-relaxed custom-prose-chat"
                                 :class="msg.sender === 'user' ? 'bg-indigo-600 text-white rounded-2xl rounded-tr-sm' : 'bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-2xl rounded-tl-sm'"
                                 x-html="msg.text">
                            </div>
                        </div>
                    </template>
                    <div x-show="isTyping" class="flex justify-start">
                        <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm flex items-center gap-1.5 w-16">
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce"></span>
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800">
                    <form @submit.prevent="sendMessage()" class="relative flex items-center">
                        <input type="text" x-model="inputText" :disabled="isTyping" 
                               class="w-full bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white text-sm rounded-full pl-5 pr-12 py-3 outline-none focus:ring-2 focus:ring-indigo-500 border border-transparent disabled:opacity-50" 
                               placeholder="Tanya seputar Rian Projects...">
                        <button type="submit" :disabled="!inputText.trim() || isTyping" 
                                class="absolute right-2 w-8 h-8 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white rounded-full transition-colors">
                            <i class="fa-solid fa-paper-plane text-[10px]"></i>
                        </button>
                    </form>
                </div>
            </div>


            <button @click="isOpen = !isOpen" 
                    class="w-14 h-14 bg-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-300 border-2 border-indigo-100 relative group">
                <img src="<?= base_url('images/ai.webp') ?>" alt="AI" class="w-8 h-8 object-contain group-hover:animate-pulse">
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full border-2 border-white animate-bounce"></span>
                <span class="absolute right-16 bg-slate-900 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-lg">
                    AskRian AI
                </span>
            </button>
        </div>

        <a href="https://wa.me/6282162928130?text=Halo,%20saya%20ingin%20konsultasi%20project" target="_blank" class="pointer-events-auto relative w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 group hover:rotate-12">
            <i class="fa-brands fa-whatsapp text-3xl"></i>
            <span class="absolute right-16 bg-slate-900 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-lg">
                Chat Konsultasi
            </span>
        </a>

    </div>


    <style>

        .custom-prose-chat p { margin-bottom: 0.5rem; }
        .custom-prose-chat p:last-child { margin-bottom: 0; }
        .custom-prose-chat strong { font-weight: 900; }
        .custom-prose-chat br { display: block; margin-bottom: 0.2rem; }
    </style>

    <script>

        window.gtranslateSettings = { 
          "default_language": "id", 
          "native_language_names": false,
          "languages": ["id", "en", "ja", "ar"],
          "wrapper_selector": ".gtranslate_wrapper", 
          "flag_size": 24, 
          "language_names": {
            "id": "ID", "en": "EN", "ja": "JA", "ar": "AR"
          }
        };
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/popup.js" defer></script>
    <script src="<?= base_url('assets/js/credits.js') ?>"></script>

    <script>

        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                htmlElement.classList.toggle('dark');
                localStorage.theme = htmlElement.classList.contains('dark') ? 'dark' : 'light';
            });
        }

        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuToggle && mobileMenu) {
            const menuIcon = mobileMenuToggle.querySelector('i');
            mobileMenuToggle.addEventListener('click', () => {
                const isOpen = mobileMenu.style.maxHeight && mobileMenu.style.maxHeight !== '0px';
                if (isOpen) {
                    mobileMenu.style.maxHeight = '0px';
                    mobileMenu.style.opacity = '0';
                    menuIcon.classList.replace('fa-xmark', 'fa-bars');
                } else {
                    mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
                    mobileMenu.style.opacity = '1';
                    menuIcon.classList.replace('fa-bars', 'fa-xmark');
                }
            });

            document.addEventListener('click', (e) => {
                if (!mobileMenuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.style.maxHeight = '0px';
                    mobileMenu.style.opacity = '0';
                    menuIcon.classList.replace('fa-xmark', 'fa-bars');
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    mobileMenu.style.maxHeight = '0px';
                    mobileMenu.style.opacity = '0';
                    menuIcon.classList.replace('fa-xmark', 'fa-bars');
                }
            });
        }


        const scrollToTopBtn = document.getElementById('scrollToTopBtn');
        if (scrollToTopBtn) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    scrollToTopBtn.classList.remove('opacity-0', 'translate-y-5', 'pointer-events-none');
                    scrollToTopBtn.classList.add('opacity-100', 'translate-y-0');
                } else {
                    scrollToTopBtn.classList.add('opacity-0', 'translate-y-5', 'pointer-events-none');
                    scrollToTopBtn.classList.remove('opacity-100', 'translate-y-0');
                }
            });

            scrollToTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    </script>
    
    <script>

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?= base_url('sw.js') ?>')
                .then(reg => console.log('SW Registered!', reg.scope))
                .catch(err => console.error('SW Registration Failed!', err));
            });
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('globalApp', () => ({
                deferredPrompt: null,
                showInstallButton: false,

                init() {
                    window.addEventListener('beforeinstallprompt', (e) => {
                        e.preventDefault();
                        this.deferredPrompt = e;
                        this.showInstallButton = true;
                    });
                },

                async installApp() {
                    if (!this.deferredPrompt) return;
                    this.deferredPrompt.prompt();
                    const { outcome } = await this.deferredPrompt.userChoice;
                    
                    if (outcome === 'accepted') {
                        this.showInstallButton = false;
                    }
                    this.deferredPrompt = null;
                }
            }));
        });

    </script>
    
    <script>
    function askRianWidget() {
        return {
            isOpen: false,
            inputText: '',
            isTyping: false,
            messages: [], 
            csrfToken: '<?= csrf_hash() ?>', 
    
            async sendMessage() {
                if (!this.inputText.trim()) return;
    
                const userMsg = this.inputText.trim();
                this.messages.push({ sender: 'user', text: userMsg });
                this.inputText = '';
                this.isTyping = true;
                this.scrollToBottom();
    
                let formData = new FormData();
                formData.append('message', userMsg);
                formData.append('<?= csrf_token() ?>', this.csrfToken); // Gunakan token dinamis
    
                try {
                    const response = await fetch('<?= base_url('api/askrian') ?>', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    // Segarkan Token Keamanan (CSRF) untuk chat selanjutnya
                    if (data.csrf) {
                        this.csrfToken = data.csrf;
                    }
                    
                    if (response.ok && data.reply) {
                        this.messages.push({ sender: 'ai', text: data.reply });
                    } else {
                        // Deteksi kalau CI4 melempar error bawaan ('message' atau 'detail')
                        const errorMsg = data.error || data.message || data.detail || 'Terjadi kesalahan internal (Error 500).';
                        this.messages.push({ sender: 'ai', text: '<em class="text-rose-500">' + errorMsg + '</em>' });
                        console.error("Log Error:", data); // Munculkan ke inspect element agar mudah dilacak
                    }
                } catch (error) {
                    this.messages.push({ sender: 'ai', text: '<em class="text-rose-500">Gagal terhubung ke server. Periksa koneksi internet Anda.</em>' });
                    console.error("Fetch Error:", error);
                } finally {
                    this.isTyping = false;
                    this.scrollToBottom();
                }
            },
    
            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('askRianScroll');
                    if (container) {
                        container.scrollTo({
                            top: container.scrollHeight,
                            behavior: 'smooth'
                        });
                    }
                }, 100);
            }
        }
    }
    </script>
    
    <?= $this->renderSection('scripts') ?>
    <?= $this->renderSection('extra_scripts') ?>
</body>
</html>