<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                        dark: { 900: '#0f172a' } // Slate 900
                    }
                }
            }
        }
        
        // Auto Dark Mode Detection
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <style>
        /* Animasi Floating untuk angka 404 */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .bg-grid {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(99, 102, 241, 0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(99, 102, 241, 0.05) 1px, transparent 1px);
        }
        .dark .bg-grid {
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 font-sans transition-colors duration-500 min-h-screen flex items-center justify-center relative overflow-hidden bg-grid">

    <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="text-center relative z-10 px-6 max-w-2xl mx-auto">
        
        <div class="mb-8 animate-float inline-block">
            <div class="relative">
                <i class="fa-solid fa-satellite-dish text-9xl text-slate-200 dark:text-slate-800"></i>
                <i class="fa-solid fa-circle-exclamation text-5xl text-indigo-500 absolute -top-2 -right-2 bg-slate-50 dark:bg-slate-950 rounded-full border-4 border-slate-50 dark:border-slate-950"></i>
            </div>
        </div>

        <h1 class="text-8xl md:text-9xl font-black font-outfit text-slate-900 dark:text-white tracking-tighter mb-2">
            4<span class="text-indigo-500">0</span>4
        </h1>

        <h2 class="text-2xl md:text-3xl font-bold text-slate-700 dark:text-slate-300 mb-4 font-outfit">
            Halaman Tidak Ditemukan
        </h2>
        <p class="text-slate-500 dark:text-slate-400 mb-10 text-lg leading-relaxed">
            Ups! Sepertinya kamu tersesat di antariksa digital. Halaman yang kamu cari mungkin sudah dipindahkan, dihapus, atau memang tidak pernah ada.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/30 flex items-center justify-center gap-2 group">
                <i class="fa-solid fa-house group-hover:-translate-y-0.5 transition-transform"></i> Kembali ke Home
            </a>
            
            <button onclick="history.back()" class="w-full sm:w-auto px-8 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali Sebelumnya
            </button>
        </div>

    </div>

    <div class="absolute bottom-6 w-full text-center">
        <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">
            &copy; <?= date('Y') ?> Rian Projects
        </p>
    </div>

</body>
</html>