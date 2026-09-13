<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<style>
    
    .custom-prose {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #334155;
    }
    .dark .custom-prose { color: #cbd5e1; }

    .custom-prose h1, .custom-prose h2, .custom-prose h3, .custom-prose h4 {
        color: #0f172a;
        font-weight: 800;
        margin-top: 2em;
        margin-bottom: 0.75em;
        line-height: 1.3;
        font-family: 'Outfit', sans-serif;
    }
    .dark .custom-prose h1, .dark .custom-prose h2, .dark .custom-prose h3, .dark .custom-prose h4 {
        color: #f1f5f9; 
    }

    .custom-prose h2 { font-size: 1.75em; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.3em; }
    .dark .custom-prose h2 { border-bottom-color: #1e293b; }
    
    .custom-prose h3 { font-size: 1.5em; }

    .custom-prose p { margin-bottom: 1.5em; }

    .custom-prose ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1.5em; }
    .custom-prose ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1.5em; }
    .custom-prose li { margin-bottom: 0.5em; }

    .custom-prose a { color: #4f46e5; text-decoration: underline; font-weight: 600; }
    .dark .custom-prose a { color: #818cf8; }

    .custom-prose blockquote {
        border-left: 4px solid #6366f1;
        padding-left: 1em;
        font-style: italic;
        color: #64748b;
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 0 1rem 1rem 0;
        margin-bottom: 1.5em;
    }
    .dark .custom-prose blockquote { background: #1e293b; color: #94a3b8; }

    .custom-prose img {
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        margin: 2em auto;
        max-width: 100%;
        height: auto;
    }
    
    .custom-prose pre {
        background: #1e293b;
        color: #e2e8f0;
        padding: 1.5em;
        border-radius: 1rem;
        overflow-x: auto;
        font-family: monospace;
        font-size: 0.9em;
        margin-bottom: 1.5em;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .dark .glass-card {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
</style>

<div class="pt-24 pb-16 ">
    
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-indigo-500/10 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        <nav class="flex justify-center mb-6 text-sm text-slate-500 dark:text-slate-400">
            <a href="<?= base_url('/') ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800 dark:text-slate-200 font-medium truncate max-w-[200px]"><?= $project['title'] ?></span>
        </nav>

        <div class="flex flex-wrap justify-center items-center gap-3 mb-6">
             <span class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 rounded-full border border-indigo-200 dark:border-indigo-500/30">
                <?= $project['category'] ?? 'Web App' ?>
            </span>
            <span class="px-4 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-400 rounded-full border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 flex items-center gap-2">
                <i class="fa-regular fa-calendar"></i> <?= date('d M Y', strtotime($project['created_at'])) ?>
            </span>
        </div>

        <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white mb-6 tracking-tight font-outfit leading-tight">
            <?= $project['title'] ?>
        </h1>
        <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 leading-relaxed max-w-3xl mx-auto">
            <?= $project['meta_desc'] ?? substr(strip_tags($project['description']), 0, 250) . '...' ?>
        </p>

    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="mb-20">
        <div class="border border-slate-200 dark:border-slate-700 rounded-3xl overflow-hidden shadow-2xl bg-slate-100 dark:bg-slate-900 ring-4 ring-slate-50 dark:ring-slate-800">
            
            <div class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4 transition-colors duration-500">
                <div class="flex items-center gap-2 w-full sm:w-auto overflow-hidden">
                    <div class="flex gap-1.5 flex-shrink-0">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    </div>
                    <?php if(!empty($project['preview_url'])): ?>
                    <div class="ml-4 px-4 py-1.5 bg-slate-100 dark:bg-slate-700 rounded-lg text-xs font-mono text-slate-500 dark:text-slate-400 flex items-center gap-2 border border-slate-200 dark:border-slate-600 overflow-hidden shadow-inner">
                        <i class="fa-solid fa-lock text-[10px] flex-shrink-0 text-emerald-500"></i> 
                        <span class="truncate max-w-[250px]"><?= $project['preview_url'] ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="flex items-center bg-slate-100 dark:bg-slate-900/50 rounded-lg p-1 border border-slate-200 dark:border-slate-700">
                    <button onclick="switchFrame('desktop')" id="viewDesktop" class="device-btn active p-2 px-4 rounded-md text-sm font-medium transition-all duration-300 flex items-center gap-2 bg-white dark:bg-slate-700 text-indigo-600 dark:text-white shadow-sm">
                        <i class="fa-solid fa-desktop"></i> <span class="hidden sm:inline">Desktop</span>
                    </button>
                    <button onclick="switchFrame('tablet')" id="viewTablet" class="device-btn p-2 px-4 rounded-md text-sm font-medium transition-all duration-300 flex items-center gap-2 text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-white">
                        <i class="fa-solid fa-tablet-screen-button"></i>
                    </button>
                    <button onclick="switchFrame('mobile')" id="viewMobile" class="device-btn p-2 px-4 rounded-md text-sm font-medium transition-all duration-300 flex items-center gap-2 text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-white">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </button>
                </div>
            </div>

            <div class="relative bg-slate-100 dark:bg-[#0f172a] min-h-[600px] flex justify-center py-10 transition-colors duration-500 overflow-hidden overflow-y-auto">
                <div id="loader" class="absolute inset-0 flex items-center justify-center z-10 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500">
                    <div class="flex flex-col items-center">
                        <i class="fa-solid fa-circle-notch fa-spin text-4xl text-indigo-500 mb-3"></i>
                        <span class="text-slate-600 dark:text-slate-300 font-medium animate-pulse">Memuat Preview...</span>
                    </div>
                </div>

                <?php if(!empty($project['preview_url'])): ?>
                    <div id="frameWrapper" class="relative z-20 w-full h-[700px] bg-white shadow-2xl transition-all duration-500 ease-in-out border border-slate-300 dark:border-slate-600 origin-top">
                        <iframe 
                            src="<?= $project['preview_url'] ?>" 
                            class="w-full h-full bg-white" 
                            frameborder="0"
                            onload="document.getElementById('loader').classList.add('opacity-0'); setTimeout(() => document.getElementById('loader').classList.add('hidden'), 500);"
                        ></iframe>
                    </div>
                <?php else: ?>
                    <div class="relative z-20 w-full h-[500px] flex flex-col items-center justify-center text-slate-400">
                        <i class="fa-solid fa-eye-slash text-6xl mb-4 opacity-50"></i>
                        <p>Live preview not available.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 justify-center mt-10">
            <?php if(!empty($project['preview_url'])): ?>
            <a href="<?= $project['preview_url'] ?>" target="_blank" class="px-8 py-3.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 hover:-translate-y-1 transition-all shadow-lg shadow-indigo-500/30 flex items-center gap-2 group">
                <i class="fa-solid fa-arrow-up-right-from-square group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                Kunjungi Website
            </a>
            <?php endif; ?>
            
            <a href="https://mozystore.my.id" target="_blank" class="px-8 py-3.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 hover:-translate-y-1 transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2 group">
                <i class="fa-solid fa-cart-shopping"></i>
                Beli Source Code
            </a>
            
            <a href="https://wa.me/6282162928130?text=Halo,%20saya%20tertarik%20dengan%20project%20<?= urlencode($project['title']) ?>" target="_blank" class="px-8 py-3.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-white font-bold hover:border-green-500 hover:text-green-600 transition-all shadow-sm flex items-center gap-2 group">
                <i class="fa-brands fa-whatsapp text-xl text-green-500"></i>
                Konsultasi
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 border-t border-slate-200 dark:border-slate-800 pt-16">
        
        <div class="lg:col-span-8">
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-8 flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                    <i class="fa-solid fa-align-left text-lg"></i>
                </span>
                Tentang Proyek
            </h3>
            
            <div class="custom-prose">
                <?= $project['description'] ?>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="glass-card rounded-3xl p-8 sticky top-24">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                    Project Details
                </h3>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <i class="fa-regular fa-building text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Client</p>
                            <p class="font-bold text-slate-800 dark:text-white text-lg leading-tight"><?= $project['client'] ?? 'Personal Project' ?></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
                            <i class="fa-solid fa-layer-group text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Category</p>
                            <p class="font-bold text-slate-800 dark:text-white text-lg leading-tight"><?= $project['category'] ?></p>
                        </div>
                    </div>

                    <div class="h-px bg-slate-100 dark:bg-slate-800 my-4"></div>

                    <div>
                         <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Technologies</p>
                         <div class="flex flex-wrap gap-2">
                            <?php 
                            $stacks = explode(',', $project['tech_stack']);
                            foreach($stacks as $stack): 
                                $stack = trim($stack);
                                if(empty($stack)) continue;
                            ?>
                                <span class="px-3 py-1.5 text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-lg border border-slate-200 dark:border-slate-700 select-none">
                                    <?= $stack ?>
                                </span>
                            <?php endforeach; ?>
                         </div>
                    </div>

                    <div class="pt-4">
                         <button onclick="shareProject()" class="w-full py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold transition shadow-lg shadow-indigo-500/30 flex items-center justify-center gap-2 group active:scale-95">
                            <i class="fa-solid fa-share-nodes group-hover:rotate-12 transition-transform"></i> 
                            Share Project
                         </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    const frameWrapper = document.getElementById('frameWrapper');
    const btns = {
        desktop: document.getElementById('viewDesktop'),
        tablet: document.getElementById('viewTablet'),
        mobile: document.getElementById('viewMobile')
    };

    function switchFrame(mode) {

        Object.values(btns).forEach(btn => {
            btn.className = 'device-btn p-2 px-4 rounded-md text-sm font-medium transition-all duration-300 flex items-center gap-2 text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-white';
            const span = btn.querySelector('span');
            if(span) span.classList.add('hidden');
        });

        const activeBtn = btns[mode];
        activeBtn.className = 'device-btn active p-2 px-4 rounded-md text-sm font-medium transition-all duration-300 flex items-center gap-2 bg-white dark:bg-slate-700 text-indigo-600 dark:text-white shadow-sm ring-1 ring-slate-200 dark:ring-slate-600';
        const activeSpan = activeBtn.querySelector('span');
        if(activeSpan) activeSpan.classList.remove('hidden');

        if (mode === 'mobile') {
            frameWrapper.style.width = '375px';
            frameWrapper.style.borderWidth = '12px 12px 20px 12px';
            frameWrapper.style.borderColor = '#1e293b';
            frameWrapper.style.borderRadius = '30px';
        } else if (mode === 'tablet') {
            frameWrapper.style.width = '768px';
            frameWrapper.style.borderWidth = '12px';
            frameWrapper.style.borderColor = '#1e293b';
            frameWrapper.style.borderRadius = '20px';
        } else {
            frameWrapper.style.width = '100%';
            frameWrapper.style.borderWidth = '0px'; 
            frameWrapper.style.borderColor = '';
            frameWrapper.style.borderRadius = '0px';
        }
    }

    function shareProject() {
        const shareData = {
            title: '<?= addslashes($project['title']) ?>',
            text: 'Check out this amazing project: <?= addslashes($project['title']) ?>',
            url: window.location.href
        };

        if (navigator.share) {
            navigator.share(shareData);
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Link berhasil dicopy!');
        }
    }
</script>

<?= $this->endSection() ?>