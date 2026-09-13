<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<div class="pt-24 pb-8 sm:pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 tracking-tight font-outfit">
            Blog & <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-500">Articles</span>
        </h1>
        <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
            Berbagi pengetahuan tentang pengembangan web, tips coding, dan teknologi terbaru.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    
    <?php if(!empty($categories)): ?>
    <div class="flex flex-nowrap sm:flex-wrap justify-start sm:justify-center items-center gap-2 sm:gap-3 mb-10 overflow-x-auto pb-4 scrollbar-hide px-1" style="-webkit-overflow-scrolling: touch;">
        
        <a href="<?= base_url('blog') ?>" 
           class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-300 border flex-shrink-0 <?= ($active_category === 'all' || empty($active_category)) ? 'bg-pink-500 border-pink-500 text-white shadow-lg shadow-pink-500/30 scale-105' : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:border-pink-400' ?>">
            Semua
        </a>

        <?php foreach($categories as $cat): ?>
            <a href="<?= base_url('blog?category=' . urlencode($cat)) ?>" 
               class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-300 border flex-shrink-0 <?= ($active_category === $cat) ? 'bg-pink-500 border-pink-500 text-white shadow-lg shadow-pink-500/30 scale-105' : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:border-pink-400' ?>">
                <?= esc($cat) ?>
            </a>
        <?php endforeach; ?>
        
    </div>
    <?php endif; ?>

    <?php if(empty($posts)): ?>
        <div class="text-center py-20 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 mb-4">
                <i class="fa-regular fa-newspaper text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-700 dark:text-slate-300">Belum ada artikel</h3>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Belum ada artikel yang diterbitkan untuk kategori ini.</p>
            <?php if($active_category !== 'all'): ?>
                <a href="<?= base_url('blog') ?>" class="inline-block mt-4 text-pink-500 font-bold hover:text-pink-600 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Semua Artikel
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <?php foreach($posts as $post): ?>
            
            <article class="flex flex-col border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group h-full bg-white dark:bg-slate-900/50">
                
                <a href="<?= base_url('blog/' . $post['slug']) ?>" class="aspect-video overflow-hidden bg-slate-100 dark:bg-slate-800 relative">
                    <?php if(!empty($post['featured_image'])): ?>
                        <img src="<?= base_url('uploads/blog/' . $post['featured_image']) ?>" alt="<?= esc($post['title']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-600">
                            <i class="fa-solid fa-image text-4xl"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="absolute top-4 left-4 z-10">
                        <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm text-pink-600 dark:text-pink-400 rounded-lg shadow-sm border border-white/20 dark:border-slate-700/50">
                            <?= esc($post['category'] ?? 'General') ?>
                        </span>
                    </div>
                </a>

                <div class="p-5 sm:p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-4 text-[11px] sm:text-xs text-slate-400 mb-3 font-semibold tracking-wide">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-pink-500"></i> <?= date('d M Y', strtotime($post['created_at'])) ?>
                        </span>
                    </div>

                    <h2 class="text-lg sm:text-xl font-bold text-slate-800 dark:text-white mb-3 line-clamp-2 font-outfit group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors">
                        <a href="<?= base_url('blog/' . $post['slug']) ?>">
                            <?= esc($post['title']) ?>
                        </a>
                    </h2>

                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-5 line-clamp-3 leading-relaxed flex-grow">
                        <?= esc(substr(strip_tags($post['content']), 0, 150)) ?>...
                    </p>

                    <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-800">
                        <a href="<?= base_url('blog/' . $post['slug']) ?>" class="inline-flex items-center text-xs sm:text-sm font-bold text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300 transition-colors">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-[10px] sm:text-xs transition-transform group-hover:translate-x-1.5"></i>
                        </a>
                    </div>
                </div>
            </article>
            
            <?php endforeach; ?>
        </div>

        <?php if (isset($pager) && $pager->getPageCount() > 1) : ?>
            <div class="mt-16 flex justify-center w-full animate-fade-in">
                <div class="inline-flex p-2">
                    <?= $pager->links('default', 'tailwind_full') ?>
                </div>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>

<style>
  
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>

<?= $this->endSection() ?>