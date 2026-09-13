<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<style>
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .table-row-hover:hover td {
        background-color: rgba(99, 102, 241, 0.05); /* Indigo tint */
    }
</style>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
            Blog <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-500">Posts</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium mt-1">Kelola artikel dan berita terbaru.</p>
    </div>
    
    <a href="<?= base_url('admin/posts/new') ?>" class="group relative px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-bold rounded-xl shadow-lg shadow-pink-500/30 transition-all active:scale-95 flex items-center gap-2 overflow-hidden">
        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1s_infinite]"></div>
        <i class="fa-solid fa-pen-nib transition-transform group-hover:rotate-12"></i>
        <span>Tulis Artikel</span>
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-8 p-4 rounded-2xl bg-emerald-50/80 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 backdrop-blur-sm flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-300">
                <i class="fa-solid fa-check"></i>
            </div>
            <span class="font-bold text-emerald-800 dark:text-emerald-200"><?= session()->getFlashdata('success') ?></span>
        </div>
        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-200 transition p-2 hover:bg-emerald-100 dark:hover:bg-emerald-800 rounded-lg">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
<?php endif; ?>

<div class="border-slate-700/50 border rounded-[2rem] shadow-xl overflow-hidden relative">
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-700/50 text-xs uppercase text-slate-400 dark:text-slate-500 font-bold tracking-widest">
                    <th class="px-8 py-6">Cover</th>
                    <th class="px-6 py-6">Article Info</th>
                    <th class="px-6 py-6">Status</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                <?php if (empty($posts)) : ?>
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center gap-4">
                                <div class="w-24 h-24 rounded-3xl flex items-center justify-center text-4xl text-slate-300 dark:text-slate-600 mb-2">
                                    <i class="fa-regular fa-newspaper"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-700 dark:text-slate-200">Belum ada artikel</h3>
                                    <p class="text-slate-400 text-sm">Mulai menulis cerita Anda sekarang!</p>
                                </div>
                                <a href="<?= base_url('admin/posts/new') ?>" class="mt-2 text-pink-500 hover:text-pink-600 font-bold text-sm">
                                    + Tulis Artikel Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($posts as $post) : ?>
                        <tr class="table-row-hover transition-colors duration-200 group">
                            
                            <td class="px-8 py-5 w-32 align-top">
                                <div class="w-24 h-16 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 shadow-sm relative group-hover:scale-105 transition-transform duration-300">
                                    <?php if ($post['featured_image']) : ?>
                                        <img src="<?= base_url('uploads/blog/' . $post['featured_image']) ?>" alt="Cover" class="w-full h-full object-cover">
                                    <?php else : ?>
                                        <div class="flex items-center justify-center h-full text-slate-300 dark:text-slate-600"><i class="fa-solid fa-image"></i></div>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-top max-w-md">
                                <div class="flex flex-col gap-1.5">
                                    <h3 class="font-bold text-slate-800 dark:text-white text-lg group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors line-clamp-1">
                                        <?= $post['title'] ?>
                                    </h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                        <?= strip_tags($post['content']) ?>
                                    </p>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                            <i class="fa-regular fa-clock"></i> <?= date('d M Y', strtotime($post['created_at'])) ?>
                                        </span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                            <i class="fa-regular fa-user"></i> <?= $post['author_name'] ?? 'Admin' ?>
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-top">
                                <?php if ($post['status'] == 'published') : ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Published
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="px-8 py-5 text-right align-top">
                                <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <a href="<?= base_url('blog/' . $post['slug']) ?>" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-all" title="Baca Artikel">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    
                                    <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/30 transition-all" title="Edit Artikel">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="<?= base_url('admin/posts/delete/' . $post['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all" title="Hapus Artikel">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($pager) : ?>
        <div class="px-8 py-6 border-t border-slate-200 dark:border-slate-700/50 flex items-center justify-center sm:justify-end bg-slate-50/50 dark:bg-slate-800/20">
            <?= $pager->links('default', 'tailwind_full') ?>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>