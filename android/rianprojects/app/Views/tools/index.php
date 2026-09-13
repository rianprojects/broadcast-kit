<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto py-12 sm:py-16 px-4 sm:px-6 lg:px-8 min-h-[80vh]">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-12 sm:mb-16">
        <div class="inline-flex items-center justify-center p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl mb-4 text-indigo-500">
            <i class="fa-solid fa-toolbox text-2xl sm:text-3xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit tracking-tight">
            Koleksi <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-600">Alat Digital</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto text-sm sm:text-base px-2 leading-relaxed">
            Kumpulan alat bantu utilitas berbasis web untuk mempermudah alur kerja dan kebutuhan digital Anda. Didesain cepat, responsif, dan mudah digunakan.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        

        <a href="<?= base_url('tools/downloader') ?>" class="group block bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:shadow-2xl hover:shadow-sky-500/10 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden backdrop-blur-xl">
            
            <div class="absolute top-5 right-5 z-20">
                <div class="relative">
                    <div class="absolute inset-0 bg-sky-400 rounded-full blur opacity-40 animate-pulse"></div>
                    <span class="relative inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-sky-100 dark:bg-sky-900/50 text-sky-600 dark:text-sky-300 border border-sky-200 dark:border-sky-800 shadow-sm">
                        <i class="fa-solid fa-fire text-orange-500"></i> Popular
                    </span>
                </div>
            </div>

            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-bl from-sky-400/20 to-indigo-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-sky-50 dark:bg-sky-900/30 text-sky-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-cloud-arrow-down"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-sky-500 transition-colors pr-16">All Media Downloader</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8 line-clamp-3">
                    Unduh video kualitas HD, slide gambar carousel, hingga story dari TikTok, Instagram, dan X (Twitter) secara utuh tanpa watermark.
                </p>
                <div class="flex items-center text-sky-500 font-bold text-sm mt-auto">
                    Gunakan Tool <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>
        
        <a href="<?= base_url('tools/qrcode') ?>" class="group block bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden backdrop-blur-xl">
            
            <div class="absolute top-5 right-5 z-20">
                <div class="relative">
                    <div class="absolute inset-0 bg-green-400 rounded-full blur opacity-40 animate-pulse"></div>
                    <span class="relative inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-300 border border-green-200 dark:border-green-800 shadow-sm">
                       <i class="fa-solid fa-fire text-orange-500"></i> Popular
                    </span>
                </div>
            </div>

            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-bl from-green-400/20 to-indigo-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-green-50 dark:bg-green-900/30 text-green-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-green-500 transition-colors pr-20">QR Code Generator</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8 line-clamp-3">
                    Buat Barcode Anda lebih menarik dan terlihat Profesional tanpa expired.
                </p>
                <div class="flex items-center text-green-500 font-bold text-sm mt-auto">
                    Gunakan Tool <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>
        
        <a href="<?= base_url('tools/palettes') ?>" class="group block bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:shadow-2xl hover:shadow-pink-500/10 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden backdrop-blur-xl">
            
            <div class="absolute top-5 right-5 z-20">
                <div class="relative">
                    <div class="absolute inset-0 bg-pink-400 rounded-full blur opacity-40 animate-pulse"></div>
                    <span class="relative inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-pink-100 dark:bg-pink-900/50 text-pink-600 dark:text-pink-300 border border-pink-200 dark:border-pink-800 shadow-sm">
                       <i class="fa-solid fa-fire text-orange-500"></i> Popular
                    </span>
                </div>
            </div>

            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-bl from-pink-400/20 to-indigo-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-pink-50 dark:bg-pink-900/30 text-pink-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-pink-500 transition-colors pr-20">Color Palette Explorer</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8 line-clamp-3">
                    Temukan inspirasi kombinasi warna terbaik bergaya Color Hunt untuk proyek desain dan website Anda. Salin kode HEX dengan satu klik.
                </p>
                <div class="flex items-center text-pink-500 font-bold text-sm mt-auto">
                    Gunakan Tool <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>


        <a href="<?= base_url('tools/meme') ?>" class="group block bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden backdrop-blur-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-bl from-purple-400/20 to-pink-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-900/30 text-purple-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-face-laugh-squint"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-purple-500 transition-colors">Meme Generator</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8 line-clamp-3">
                    Buat meme lucu dan viral secara instan! Upload foto, tambahkan teks kustom, dan download hasilnya dalam hitungan detik.
                </p>
                <div class="flex items-center text-purple-500 font-bold text-sm mt-auto">
                    Bikin Meme Sekarang <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>
        
        <a href="<?= base_url('tools/color-contrast') ?>" class="group block bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:shadow-2xl hover:shadow-violet-500/10 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden backdrop-blur-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-bl from-violet-400/20 to-pink-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-violet-50 dark:bg-violet-900/30 text-violet-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-violet-500 transition-colors">Color Contrast Checker</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8 line-clamp-3">
                    Cek kontras warna teks & background sesuai standar WCAG AA/AAA untuk aksesibilitas web yang lebih baik.
                </p>
                <div class="flex items-center text-violet-500 font-bold text-sm mt-auto">
                    Gunakan Tool <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>


        <a href="<?= base_url('tools/gradient-generator') ?>" class="group block bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden backdrop-blur-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-bl from-orange-400/20 to-pink-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 dark:bg-orange-900/30 text-orange-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-orange-500 transition-colors">CSS Gradient Generator</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8 line-clamp-3">
                    Buat gradient CSS cantik secara visual. Linear, radial, conic — dengan color stop bebas dan preset siap pakai.
                </p>
                <div class="flex items-center text-orange-500 font-bold text-sm mt-auto">
                    Gunakan Tool <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>


        <a href="<?= base_url('tools/box-shadow') ?>" class="group block bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden backdrop-blur-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-bl from-purple-400/20 to-blue-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-900/30 text-purple-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-purple-500 transition-colors">Box Shadow Generator</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8 line-clamp-3">
                    Generate CSS box-shadow secara visual dan interaktif. Multi-layer, inset, blur, spread — copy CSS langsung pakai.
                </p>
                <div class="flex items-center text-purple-500 font-bold text-sm mt-auto">
                    Gunakan Tool <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>


        <a href="<?= base_url('tools/grid-builder') ?>" class="group block bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden backdrop-blur-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-bl from-blue-400/20 to-cyan-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-table-cells-large"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-blue-500 transition-colors">CSS Grid Builder</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8 line-clamp-3">
                    Bangun layout CSS Grid secara visual dan interaktif. Atur kolom, baris, gap, dan dapatkan kode CSS siap pakai.
                </p>
                <div class="flex items-center text-blue-500 font-bold text-sm mt-auto">
                    Gunakan Tool <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>
        
        <div class="group block bg-slate-50 dark:bg-slate-900/40 p-6 sm:p-8 rounded-[2rem] border border-slate-200 border-dashed dark:border-slate-800 relative overflow-hidden opacity-70">
            <div class="relative z-10 flex flex-col h-full">
                <div class="w-14 h-14 rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-2xl mb-6">
                    <i class="fa-solid fa-code"></i>
                </div>
                
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Segera Hadir</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-8">
                    Tool baru sedang dalam tahap pengembangan dan akan segera ditambahkan ke halaman ini.
                </p>

                <div class="flex items-center text-slate-400 font-bold text-sm mt-auto cursor-not-allowed">
                    <i class="fa-solid fa-lock mr-2"></i> Belum Tersedia
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>