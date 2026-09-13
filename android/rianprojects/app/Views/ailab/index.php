<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 relative min-h-[80vh]">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob pointer-events-none"></div>
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000 pointer-events-none"></div>
    <div class="absolute -bottom-32 left-1/2 w-96 h-96 bg-cyan-500/10 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000 pointer-events-none"></div>

    <div class="text-center mb-16 relative z-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 border border-slate-200 dark:border-slate-700">
            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
            Rian Projects Labs
        </div>
        
        <h1 class="text-5xl md:text-6xl font-black text-slate-900 dark:text-white mb-6 font-outfit tracking-tight">
            The <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">AI Laboratory</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto text-base md:text-lg leading-relaxed">
            Eksplorasi berbagai alat cerdas bertenaga Generative AI yang dirancang khusus untuk mempercepat alur kerja Anda. Dari analisis kode hingga pembuatan konten jurnalistik.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
        
        <?php foreach ($tools as $tool): ?>
        
        <?php if($tool['status'] === 'Active'): ?>
            <a href="<?= $tool['link'] ?>" class="group block relative h-full">
                <div class="absolute -inset-0.5 bg-gradient-to-r <?= $tool['color'] ?> rounded-[1.5rem] opacity-0 group-hover:opacity-100 transition duration-500 blur-sm group-hover:duration-200"></div>
                
                <div class="relative h-full bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 p-8 rounded-[1rem] shadow-sm hover:shadow-xl transition-all flex flex-col backdrop-blur-xl">
                    
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 rounded-2xl <?= $tool['bg_color'] ?> flex items-center justify-center text-2xl <?= $tool['icon_color'] ?> shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <i class="<?= $tool['icon'] ?>"></i>
                        </div>
                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-500 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                            Ai Aktif
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-slate-800 dark:text-white mb-3 font-outfit group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:<?= $tool['color'] ?> transition-all">
                        <?= $tool['name'] ?>
                    </h3>
                    
                    <p class="text-sm text-slate-500 dark:text-slate-400 flex-1 leading-relaxed mb-6">
                        <?= $tool['description'] ?>
                    </p>

                    <div class="mt-auto flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-4">
                        <div class="flex gap-2">
                            <?php foreach($tool['tags'] as $tag): ?>
                                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">#<?= $tag ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:bg-slate-100 dark:group-hover:bg-slate-700 group-hover:<?= $tool['icon_color'] ?> transition-colors">
                            <i class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform"></i>
                        </div>
                    </div>
                </div>
            </a>

        <?php else: ?>
            <div class="block relative h-full opacity-60 grayscale-[50%] cursor-not-allowed">
                <div class="relative h-full bg-white/50 dark:bg-slate-900/50 border border-slate-200 border-dashed dark:border-slate-800 p-8 rounded-[1rem] flex flex-col">
                    
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-2xl text-slate-400 shadow-inner">
                            <i class="<?= $tool['icon'] ?>"></i>
                        </div>
                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                            Dalam Perbaikan
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-slate-800 dark:text-white mb-3 font-outfit">
                        <?= $tool['name'] ?>
                    </h3>
                    
                    <p class="text-sm text-slate-500 dark:text-slate-400 flex-1 leading-relaxed mb-6">
                        <?= $tool['description'] ?>
                    </p>

                    <div class="mt-auto flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-4">
                        <div class="flex gap-2">
                            <?php foreach($tool['tags'] as $tag): ?>
                                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">#<?= $tag ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-300 dark:text-slate-600">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php endforeach; ?>
        
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9162789903606130"crossorigin="anonymous"></script>
            <ins class="adsbygoogle"
                 style="display:block; text-align:center;"
                 data-ad-layout="in-article"
                 data-ad-format="fluid"
                 data-ad-client="ca-pub-9162789903606130"
                 data-ad-slot="3169858937">
            </ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        
    </div>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>

</div>

<?= $this->endSection() ?>