<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-green-600 to-green-600 flex items-center justify-center text-white shadow-lg shadow-green-500/30">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </span>
            AI Prompts Library
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 ml-14">Kelola koleksi prompt dan karya seni AI Anda.</p>
    </div>
    <a href="<?= base_url('admin/ai-prompts/new') ?>" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-bold transition shadow-lg shadow-green-500/30 flex items-center gap-2 group">
        <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform"></i> Add New Prompt
    </a>
</div>

<div class="rounded-3xl border border-slate-200/50 dark:border-slate-700/50 overflow-hidden bg-transparent shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
            <thead class="bg-slate-100/50 dark:bg-slate-800/50 text-xs uppercase font-bold text-slate-500 dark:text-slate-300 border-b border-slate-200/50 dark:border-slate-700/50">
                <tr>
                    <th class="px-6 py-5"><i class="fa-regular fa-image mr-2 text-green-500"></i> Artwork</th>
                    <th class="px-6 py-5"><i class="fa-solid fa-user-pen mr-2 text-green-500"></i> Creator</th>
                    <th class="px-6 py-5"><i class="fa-solid fa-quote-left mr-2 text-pink-500"></i> Prompt Text</th>
                    <th class="px-6 py-5"><i class="fa-solid fa-share-nodes mr-2 text-green-500"></i> Socials</th>
                    <th class="px-6 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100/50 dark:divide-slate-700/50">
                <?php foreach($prompts as $p): ?>
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition group">
                    <td class="px-6 py-4">
                        <div class="relative w-20 h-20 rounded-xl overflow-hidden border-2 border-slate-200/50 dark:border-slate-700/50 shadow-sm group-hover:scale-105 transition-transform duration-300">
                            <img src="<?= base_url('uploads/prompts/' . $p['image']) ?>" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-green-500 to-emerald-500 flex items-center justify-center text-white text-xs font-bold shadow-sm ring-2 ring-white dark:ring-slate-800">
                                <?= substr(strtoupper($p['creator_name']), 0, 1) ?>
                            </div>
                            <span class="font-bold text-slate-800 dark:text-white"><?= esc($p['creator_name']) ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="relative group/tooltip">
                            <p class="line-clamp-2 w-64 text-xs font-mono bg-white/50 dark:bg-slate-900/50 border border-slate-200/50 dark:border-slate-700/50 p-3 rounded-lg text-slate-600 dark:text-slate-400">
                                <?= esc(strip_tags($p['prompt'])) ?>
                            </p>
                            <div class="absolute bottom-full left-0 mb-2 w-64 p-3 bg-slate-800 text-white text-xs rounded-lg shadow-xl opacity-0 group-hover/tooltip:opacity-100 transition-opacity pointer-events-none z-10 hidden md:block">
                                <?= esc(strip_tags($p['prompt'])) ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3 text-lg">
                            <span class="<?= $p['social_instagram'] ? 'text-pink-500 hover:scale-110 cursor-pointer' : 'text-slate-300 dark:text-slate-700 opacity-50' ?> transition-transform" title="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </span>
                            <span class="<?= $p['social_tiktok'] ? 'text-black dark:text-white hover:scale-110 cursor-pointer' : 'text-slate-300 dark:text-slate-700 opacity-50' ?> transition-transform" title="TikTok">
                                <i class="fa-brands fa-tiktok"></i>
                            </span>
                            <span class="<?= $p['social_facebook'] ? 'text-blue-600 hover:scale-110 cursor-pointer' : 'text-slate-300 dark:text-slate-700 opacity-50' ?> transition-transform" title="Facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </span>
                            <span class="<?= $p['social_threads'] ? 'text-slate-800 dark:text-slate-200 hover:scale-110 cursor-pointer' : 'text-slate-300 dark:text-slate-700 opacity-50' ?> transition-transform" title="Threads">
                                <i class="fa-brands fa-threads"></i>
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= base_url('admin/ai-prompts/edit/' . $p['id']) ?>" class="p-2 bg-white/50 dark:bg-slate-800/50 border border-slate-200/50 dark:border-slate-700/50 text-amber-500 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/30 transition shadow-sm" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            
                            <form action="<?= base_url('admin/ai-prompts/delete/' . $p['id']) ?>" method="post" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prompt ini secara permanen?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-2 bg-white/50 dark:bg-slate-800/50 border border-slate-200/50 dark:border-slate-700/50 text-rose-500 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 transition shadow-sm" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($prompts)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <div class="w-16 h-16 bg-slate-100/50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mb-4 text-2xl">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <p class="font-medium text-lg text-slate-500 dark:text-slate-300">Belum ada Prompt</p>
                            <p class="text-sm mt-1">Mulai dengan menambahkan prompt baru.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>