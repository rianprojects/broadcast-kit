<?= $this->extend('layouts/frontend') ?>

<?= $this->section('extra_head') ?>
    <meta property="og:type" content="article">
    <meta property="article:published_time" content="<?= $post['created_at'] ?>">
    <meta property="article:author" content="<?= $post['author_name'] ?? 'Rian Projects' ?>">
    
    <style>

        .custom-prose h1, .custom-prose h2 { 
            font-size: 1.75rem; 
            font-weight: 800; 
            margin-top: 2em; 
            margin-bottom: 0.8em; 
            color: #1e293b; 
            line-height: 1.3; 
            padding-left: 1.25rem;
            border-left: 5px solid #6366f1;
            border-radius: 3px;
        }
        .dark .custom-prose h1, .dark .custom-prose h2 { color: #f8fafc; }
        .custom-prose h3, .custom-prose h4, .custom-prose h5, .custom-prose h6 {
            font-weight: 700; 
            margin-top: 1.8em; 
            margin-bottom: 0.8em; 
            color: #334155; 
            padding-bottom: 0.4em;
            border-bottom: 2px solid #cbd5e1;
        }
        .dark .custom-prose h3, .dark .custom-prose h4, .dark .custom-prose h5, .dark .custom-prose h6 { 
            color: #e2e8f0; 
            border-bottom-color: #334155;
        }

        .custom-prose h3 { font-size: 1.4rem; }
        .custom-prose h4 { font-size: 1.25rem; }
        .custom-prose h5 { font-size: 1.15rem; }
        .custom-prose h6 { font-size: 1.05rem; }
        .custom-prose p { margin-bottom: 1.5em; line-height: 1.8; color: #475569; font-size: 1.1rem; }
        .dark .custom-prose p { color: #cbd5e1; }
        .custom-prose ul, .custom-prose ol { margin-bottom: 1.5em; padding-left: 1.5em; color: #475569; }
        .dark .custom-prose ul, .dark .custom-prose ol { color: #cbd5e1; }
        .custom-prose li { margin-bottom: 0.5em; }
        .custom-prose img { border-radius: 1rem; margin: 2.5em 0; width: 100%; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1); }
        .custom-prose a { color: #4f46e5; text-decoration: underline; font-weight: 600; }
        .custom-prose blockquote { border-left: 4px solid #6366f1; padding-left: 1.25rem; font-style: italic; color: #64748b; margin: 2em 0; background: #f8fafc; padding: 1.5rem; border-radius: 0 1rem 1rem 0; }
        .dark .custom-prose blockquote { background: #1e293b; color: #94a3b8; }
        .custom-prose pre { background: #1e293b; color: #e2e8f0; padding: 1.5rem; border-radius: 0.75rem; overflow-x: auto; margin: 1.5em 0; font-size: 0.9em; border: 1px solid #334155; }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<article class="min-h-screen pt-12 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="max-w-4xl mx-auto text-center mb-12">
            
            <div class="flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-widest text-indigo-600 mb-6">
                <a href="<?= base_url('blog') ?>" class="hover:underline">Blog</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 rounded-full text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800">
                    <?= $post['category'] ?? 'Article' ?>
                </span>
            </div>

            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-tight mb-8 font-outfit">
                <?= esc($post['title']) ?>
            </h1>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 text-sm text-slate-500 dark:text-slate-400 border-y border-slate-100 dark:border-slate-800 py-6">
                
                <div class="flex items-center gap-2">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($post['author_real_name'] ?? 'Rian Projects') ?>&background=6366f1&color=fff" class="w-8 h-8 rounded-full shadow-sm">
                    <span class="font-bold text-slate-700 dark:text-slate-200">
                        <?= esc($post['author_real_name'] ?? 'Rian Projects') ?>
                    </span>
                </div>

                <span class="hidden sm:inline w-1 h-1 bg-slate-300 rounded-full"></span>

                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-calendar"></i>
                    <span><?= date('d F Y', strtotime($post['created_at'])) ?></span>
                </div>

                <span class="hidden sm:inline w-1 h-1 bg-slate-300 rounded-full"></span>

                <div class="flex gap-2">
                    <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-black hover:text-white transition-all text-slate-500">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' ' . current_url()) ?>" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-green-500 hover:text-white transition-all text-slate-500">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all text-slate-500">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                </div>
            </div>
        </header>

        <?php if(!empty($post['featured_image'])): ?>
        <div class="w-full aspect-video rounded-3xl overflow-hidden mb-16 shadow-2xl shadow-indigo-500/10 border border-slate-200 dark:border-slate-800">
            <img src="<?= base_url('uploads/blog/' . $post['featured_image']) ?>" 
                 alt="<?= esc($post['title']) ?>" 
                 class="w-full h-full object-cover">
        </div>
        <?php endif; ?>


        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 relative items-start">
            
            <div class="lg:col-span-8">
                
                <div class="custom-prose dark:prose-invert max-w-none mb-12">
                    <?php 
                    $article_content = $post['content'];
                    
                    if (!empty($related_posts)) {
                        $random_in_article = $related_posts;
                        shuffle($random_in_article);
                        
                        $paragraphs = explode('</p>', $article_content);
                        $total_p = count($paragraphs);
                        
                        if ($total_p > 3) {
                            $interval = 4; 
                            $inserted_count = 0;
                            
                            for ($i = $interval; $i < count($paragraphs); $i += $interval + 1) {

                                if (isset($random_in_article[$inserted_count])) {
                                    $baca_juga = $random_in_article[$inserted_count];
                                    
                                    $baca_juga_html = '
                                    <div class="my-10 p-5 sm:p-6 bg-slate-50 dark:bg-slate-800/40 border-l-4 border-indigo-500 rounded-r-2xl shadow-sm hover:shadow-md transition-all group no-prose">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform">
                                                <i class="fa-solid fa-book-open-reader text-xl"></i>
                                            </div>
                                            <div class="flex-1">
                                                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">BACA JUGA</span>
                                                <a href="'. base_url('blog/' . $baca_juga['slug']) .'" class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2" style="text-decoration: none;">
                                                    '. esc($baca_juga['title']) .'
                                                </a>
                                            </div>
                                        </div>
                                    </div>';
                                    
                                    array_splice($paragraphs, $i, 0, $baca_juga_html);
                                    $inserted_count++;
                                }
                            }

                            $article_content = implode('</p>', $paragraphs);
                            
                        } else {
 
                            $baca_juga = $random_in_article[0];
                            $baca_juga_html = '
                            <div class="my-10 p-5 sm:p-6 bg-slate-50 dark:bg-slate-800/40 border-l-4 border-indigo-500 rounded-r-2xl shadow-sm hover:shadow-md transition-all group no-prose">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-book-open-reader text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">BACA JUGA</span>
                                        <a href="'. base_url('blog/' . $baca_juga['slug']) .'" class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2" style="text-decoration: none;">
                                            '. esc($baca_juga['title']) .'
                                        </a>
                                    </div>
                                </div>
                            </div>';
                            
                            $article_content .= $baca_juga_html;
                        }
                    }
                    
                    echo $article_content;
                    ?>
                </div>
                
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

                <div class="pt-8 border-t border-slate-200 dark:border-slate-800">
                    
                    <?php if(!empty($post['tags'])): ?>
                    <div class="flex flex-wrap gap-2 mb-10">
                        <?php foreach(explode(',', $post['tags']) as $tag): ?>
                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700">#<?= trim($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="p-6 border rounded-3xl border-slate-200 dark:border-slate-800 flex items-center gap-5">
                        <div class="w-16 h-16 flex-shrink-0 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                            <?= substr(strtoupper($post['author_real_name'] ?? 'R'), 0, 1) ?>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Written By</p>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                                <?= esc($post['author_real_name'] ?? 'Rian Projects') ?>
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Web Developer & Tech Enthusiast sharing knowledge.</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="<?= base_url('blog') ?>" class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:gap-3 transition-all">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Blog
                        </a>
                    </div>

                </div>
            </div>

            <aside class="lg:col-span-4 sticky top-32 space-y-8">
                
                <div class=" rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-1 h-6 bg-indigo-500 rounded-full"></div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-lg">Artikel Terkait</h3>
                    </div>

                    <?php if(!empty($related_posts)): ?>
                        <div class="space-y-5">
                            <?php foreach($related_posts as $related): ?>
                            <a href="<?= base_url('blog/' . $related['slug']) ?>" class="group flex gap-4 items-start">
                                <div class="w-20 h-16 rounded-lg overflow-hidden flex-shrink-0 relative bg-slate-200 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                                    <?php if(!empty($related['featured_image'])): ?>
                                        <img src="<?= base_url('uploads/blog/' . $related['featured_image']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2 leading-snug mb-1">
                                        <?= $related['title'] ?>
                                    </h4>
                                    <span class="text-[10px] text-slate-400 flex items-center gap-1">
                                        <i class="fa-regular fa-calendar-days text-[9px]"></i>
                                        <?= date('d M Y', strtotime($related['created_at'])) ?>
                                    </span>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-slate-500 text-center py-4">Belum ada artikel terkait.</p>
                    <?php endif; ?>
                </div>

                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 text-white text-center shadow-xl shadow-indigo-500/20 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-white/20 transition-colors"></div>
                    <i class="fa-regular fa-paper-plane text-3xl mb-3 opacity-90 relative z-10"></i>
                    <h3 class="font-bold text-lg mb-1 relative z-10">Butuh Website?</h3>
                    <p class="text-indigo-100 text-sm mb-4 relative z-10">Konsultasikan kebutuhan digital Anda bersama Rian Projects.</p>
                    <a href="https://wa.me/6282162928130" target="_blank" class="block w-full py-2.5 bg-white text-indigo-600 font-bold rounded-xl hover:bg-indigo-50 transition-colors text-sm shadow-md relative z-10">
                        Chat WhatsApp
                    </a>
                </div>
                
                <?php if(isset($widgets) && !empty($widgets)): ?>
                    <div class="mt-8 space-y-6">
                        <?php foreach($widgets as $w): ?>
                            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            
                                <?php if(!empty($w['title'])): ?>
                                    <div class="px-5 py-2 border-b border-slate-100 dark:border-slate-800">
                                        <h4 class="font-bold text-slate-800 dark:text-white text-sm uppercase tracking-wider">
                                            <?= esc($w['title']) ?>
                                        </h4>
                                    </div>
                                <?php endif; ?>
                
                                <div class="p-2 custom-prose custom-widget-content text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                                    <?= $w['content'] ?> </div>
                
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <style>
                    .custom-widget-content iframe, 
                    .custom-widget-content img {
                        width: 100% !important;
                        height: auto;
                        border-radius: 0.5rem;
                    }
                    .custom-widget-content iframe {
                        aspect-ratio: 16 / 9;
                    }
                </style>

            </aside>

        </div>

    </div>
</article>

<?= $this->endSection() ?>