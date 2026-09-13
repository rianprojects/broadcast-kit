<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<div class="pt-16 pb-20 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-down" data-aos-duration="800">
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white mb-4 font-outfit tracking-tight">
                AI Prompt <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500">Library</span>
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                Koleksi kurasi prompt terbaik. Jelajahi gaya baru, salin prompt-nya, dan mulai berkreasi.
            </p>
        </div>

        <div class="columns-1 md:columns-2 lg:columns-3 gap-8 space-y-8">
            
            <?php 
            $delay = 0; 
            foreach($prompts as $p): 
                $delay += 100;
                if($delay > 300) $delay = 100; 
            ?>
            
            <div data-aos="fade-up" data-aos-delay="<?= $delay ?>" data-aos-duration="600" class="break-inside-avoid group relative rounded-[2rem] border border-slate-200/50 dark:border-slate-800/50 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 overflow-hidden bg-transparent">
                
                <div class="relative overflow-hidden rounded-t-[2rem] bg-slate-100/50 dark:bg-slate-900/50">
                    <a href="<?= base_url('prompt/' . $p['slug']) ?>" class="block">
                        <img src="<?= base_url('uploads/prompts/' . $p['image']) ?>" alt="<?= esc($p['title']) ?>" class="w-full h-auto transform group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    
                    <div class="absolute top-4 left-4 flex items-center gap-2 bg-white/90 dark:bg-black/80 backdrop-blur-md py-1.5 px-3 rounded-full shadow-lg border border-white/20">
                        <div class="w-5 h-5 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white text-[10px] font-bold">
                            <?= substr(strtoupper($p['creator_name']), 0, 1) ?>
                        </div>
                        <span class="text-xs font-bold text-slate-800 dark:text-white"><?= esc($p['creator_name']) ?></span>
                    </div>

                    <?php if($p['type'] == 'premium'): ?>
                    <div class="absolute top-4 right-4 bg-amber-500 text-white p-2 rounded-xl shadow-lg border border-amber-400 animate-bounce-slow">
                        <i class="fa-solid fa-crown text-xs"></i>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="p-6 bg-transparent">
                    <div class="relative mb-6">
                        <div class="p-4 rounded-2xl bg-white/30 dark:bg-slate-900/30 backdrop-blur-sm border border-slate-200/50 dark:border-slate-700/50 group-hover:border-indigo-200 dark:group-hover:border-indigo-900/50 transition-colors">
                            <?php if($p['type'] == 'premium'): ?>
                                <p class="text-xs font-mono text-slate-400 leading-relaxed line-clamp-2 blur-[4px] select-none">
                                    Lorem ipsum dolor sit amet prompt premium secret command logic hidden here for protection...
                                </p>
                            <?php else: ?>
                                <p class="text-xs font-mono text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-3">
                                   <?= esc(html_entity_decode(strip_tags($p['prompt']))) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-[1fr,auto] gap-3">
                        
                        <?php if($p['type'] == 'premium'): ?>
                            <a href="<?= base_url('prompt/' . $p['slug']) ?>" class="flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold text-sm hover:from-amber-600 hover:to-orange-600 active:scale-95 transition-all shadow-md">
                                <i class="fa-solid fa-unlock"></i>
                                <span>Unlock Prompt</span>
                            </a>
                        <?php else: ?>
                            <button data-prompt="<?= esc(str_replace(["\r", "\n"], ' ', html_entity_decode(strip_tags($p['prompt'])))) ?>" onclick="copyPrompt(this)" class="flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-slate-900/10 dark:bg-white/10 text-slate-900 dark:text-white backdrop-blur-md border border-slate-900/20 dark:border-white/20 font-bold text-sm hover:bg-slate-900 hover:text-white dark:hover:bg-white dark:hover:text-slate-900 active:scale-95 transition-all shadow-sm">
                                <i class="fa-regular fa-copy"></i>
                                <span>Copy Prompt</span>
                            </button>
                        <?php endif; ?>
                        
                        <button onclick="sharePrompt('<?= base_url('prompt/' . $p['slug']) ?>', '<?= esc($p['title']) ?>')" class="w-12 flex items-center justify-center rounded-xl border-2 border-slate-200/50 dark:border-slate-700/50 text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-200 dark:hover:border-indigo-900/50 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-all" title="Share Prompt">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>

                    </div>

                    <div class="flex gap-4 mt-5 pt-4 border-t border-slate-200/50 dark:border-slate-800/50 justify-center opacity-60 hover:opacity-100 transition-opacity">
                        <?php if($p['social_instagram']): ?>
                            <a href="<?= $p['social_instagram'] ?>" target="_blank" class="text-slate-500 dark:text-slate-400 hover:text-pink-600 transition"><i class="fa-brands fa-instagram text-lg"></i></a>
                        <?php endif; ?>
                        <?php if($p['social_tiktok']): ?>
                            <a href="<?= $p['social_tiktok'] ?>" target="_blank" class="text-slate-500 dark:text-slate-400 hover:text-black dark:hover:text-white transition"><i class="fa-brands fa-tiktok text-lg"></i></a>
                        <?php endif; ?>
                        <?php if($p['social_facebook']): ?>
                            <a href="<?= $p['social_facebook'] ?>" target="_blank" class="text-slate-500 dark:text-slate-400 hover:text-blue-600 transition"><i class="fa-brands fa-facebook text-lg"></i></a>
                        <?php endif; ?>
                        <?php if($p['social_threads']): ?>
                            <a href="<?= $p['social_threads'] ?>" target="_blank" class="text-slate-500 dark:text-slate-400 hover:text-black dark:hover:text-white transition"><i class="fa-brands fa-threads text-lg"></i></a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>

        </div>
        
        <div class="mt-20 flex justify-center" data-aos="fade-up" data-aos-duration="800">
            <?= $pager->links('default', 'tailwind_full') ?>
        </div>

    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true, 
        offset: 50, 
    });

    function copyPrompt(btn) {
        const textToCopy = btn.getAttribute('data-prompt');

        navigator.clipboard.writeText(textToCopy).then(() => {
            const span = btn.querySelector('span');
            const icon = btn.querySelector('i');
            const originalText = span.innerText;
            const originalIconClass = icon.className;
            const originalClasses = btn.className;
            
            span.innerText = 'Copied!';
            icon.className = 'fa-solid fa-check';
            
            btn.className = 'flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-emerald-500 text-white font-bold text-sm shadow-lg shadow-emerald-500/30 transition-all';
            
            setTimeout(() => {
                span.innerText = originalText;
                icon.className = originalIconClass;
                btn.className = originalClasses;
            }, 2000);
        }).catch(err => {
            console.error('Copy failed', err);
            alert('Gagal menyalin teks!');
        });
    }

    function sharePrompt(url, title) {
        if (navigator.share) {
            navigator.share({
                title: title,
                text: 'Check out this awesome AI Prompt!',
                url: url
            }).catch(console.error);
        } else {
            navigator.clipboard.writeText(url);
            alert('Link berhasil disalin ke clipboard!');
        }
    }
</script>

<style>
@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
.animate-bounce-slow {
    animation: bounce-slow 2s infinite;
}
</style>

<?= $this->endSection() ?>