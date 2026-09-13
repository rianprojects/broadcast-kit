<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard'; ?> | Rian Projects</title>
    
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
                            900: '#0f172a', 
                            800: '#1e293b', 
                        }
                    },
                    backdropBlur: {
                        xs: '2px',
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

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        
        .bg-grid {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(99, 102, 241, 0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(99, 102, 241, 0.05) 1px, transparent 1px);
        }
        .dark .bg-grid {
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }

        .navbar-blur {
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.75);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        .dark .navbar-blur {
            background-color: rgba(15, 23, 42, 0.75);
            border-bottom: 1px solid rgba(51, 65, 85, 0.8);
        }


        .navbar-scrolled {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .dark .navbar-scrolled {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
        }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
    </style>

    <?= $this->renderSection('extra_head') ?>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 antialiased font-sans transition-colors duration-500 bg-grid" 
      x-data="{ 
          sidebarOpen: false, 
          darkMode: localStorage.theme === 'dark',
          toggleTheme() {
              this.darkMode = !this.darkMode;
              if (this.darkMode) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } 
              else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; }
          }
      }">
    
    <?php if (session()->has('admin_user_id')) : ?>
        <div class="sticky top-0 z-[9999] bg-amber-500 text-white py-2 px-4 shadow-lg flex justify-between items-center backdrop-blur-md bg-opacity-90">
            <div class="text-sm font-bold">
                <i class="fa-solid fa-eye mr-2"></i> Kamu sedang melihat sebagai: <span class="underline"><?= session()->get('username') ?></span>
            </div>
            <a href="<?= base_url('admin/users/logout-as') ?>" class="bg-white text-amber-600 px-4 py-1 rounded-lg text-xs font-black uppercase hover:bg-slate-100 transition">
                Kembali ke Admin
            </a>
        </div>
    <?php endif; ?>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 backdrop-blur-sm lg:hidden transition-opacity"></div>

    <div class="flex h-screen overflow-hidden">
        
        <?= $this->include('partials/sidebar') ?>

        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <header id="navbar" class="navbar-blur flex items-center justify-between px-6 py-4 sticky top-0 z-10 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="text-slate-500 lg:hidden hover:text-indigo-600 p-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-lg font-bold text-slate-700 dark:text-slate-200 capitalize font-outfit">
                        <?= $title ?? 'Dashboard' ?>
                    </h2>
                </div>
                
                <div class="flex items-center gap-4">

                    <button @click="toggleTheme()" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-yellow-400 transition-all focus:outline-none">
                        <i class="fa-solid text-lg transition-transform duration-500 rotate-0 dark:-rotate-180" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                    </button>
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-700">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-200"><?= session()->get('username') ?></p>
                            <p class="text-[10px] uppercase font-bold tracking-wider text-slate-500 dark:text-slate-400">Administrator</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 ring-2 ring-white dark:ring-slate-800">
                            <span class="font-bold text-sm font-outfit"><?= substr(strtoupper(session()->get('username') ?? 'A'), 0, 1) ?></span>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 transition-all duration-500 scroll-smooth">
                <div class="max-w-7xl mx-auto pb-20">
                    <?= $this->include('partials/alert') ?>
                    <?= $this->renderSection('content') ?>
                </div>
            </main>

        </div>
    </div>
    
    <script>

        const navbar = document.getElementById('navbar');
        const mainContent = navbar.nextElementSibling;
        
        if (mainContent) {
            mainContent.addEventListener('scroll', function() {
                if (this.scrollTop > 10) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });
        }
    </script>
    
    <?= $this->renderSection('scripts') ?>
    <?= $this->renderSection('extra_scripts') ?>
</body>
</html>