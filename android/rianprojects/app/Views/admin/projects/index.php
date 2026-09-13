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
        background-color: rgba(99, 102, 241, 0.05);
    }
</style>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
            Project <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">Portfolio</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium mt-1">Kelola showcase karya terbaik Anda.</p>
    </div>
    
    <a href="<?= base_url('admin/projects/new') ?>" class="group relative px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all active:scale-95 flex items-center gap-2 overflow-hidden">
        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1s_infinite]"></div>
        <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i>
        <span>Tambah Proyek</span>
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
    
    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-700/50 text-xs uppercase text-slate-400 dark:text-slate-500 font-bold tracking-widest">
                    <th class="px-8 py-6">Thumbnail</th>
                    <th class="px-6 py-6">Project Info</th>
                    <th class="px-6 py-6">Tech Stack</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                <?php if (empty($projects)) : ?>
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center gap-4">
                                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center text-4xl text-slate-300 dark:text-slate-600 mb-2">
                                    <i class="fa-solid fa-folder-open"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-700 dark:text-slate-200">Belum ada proyek</h3>
                                    <p class="text-slate-400 text-sm">Mulai bangun portofolio Anda sekarang!</p>
                                </div>
                                <a href="<?= base_url('admin/projects/new') ?>" class="mt-2 text-indigo-500 hover:text-indigo-600 font-bold text-sm">
                                    + Tambah Proyek Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($projects as $project) : ?>
                        <tr class="table-row-hover transition-colors duration-200 group">
                            
                            <td class="px-8 py-5 w-32 align-top">
                                <div class="w-24 h-16 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 shadow-sm relative group-hover:scale-105 transition-transform duration-300">
                                    <?php if ($project['thumbnail']) : ?>
                                        <img src="<?= base_url('uploads/projects/' . $project['thumbnail']) ?>" alt="Thumb" class="w-full h-full object-cover">
                                    <?php else : ?>
                                        <div class="flex items-center justify-center h-full text-slate-300 dark:text-slate-600"><i class="fa-solid fa-image"></i></div>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-top">
                                <div class="flex flex-col gap-1.5">
                                    <h3 class="font-bold text-slate-800 dark:text-white text-lg group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        <?= $project['title'] ?>
                                    </h3>
                                    
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800/50">
                                            <?= $project['category'] ?? 'General' ?>
                                        </span>
                                        
                                        <?php if(!empty($project['client'])): ?>
                                            <span class="text-xs text-slate-400">&bull;</span>
                                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                                <i class="fa-regular fa-user text-[10px]"></i> <?= $project['client'] ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-top">
                                <div class="flex flex-wrap gap-1.5 max-w-xs">
                                    <?php 
                                    $stacks = array_filter(explode(',', $project['tech_stack']));
                                    foreach(array_slice($stacks, 0, 3) as $stack): 
                                    ?>
                                        <span class="text-[10px] font-bold px-2.5 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-lg border border-slate-200 dark:border-slate-700">
                                            <?= trim($stack) ?>
                                        </span>
                                    <?php endforeach; ?>
                                    <?php if(count($stacks) > 3): ?>
                                        <span class="text-[10px] font-bold px-2 py-1 text-slate-400 bg-slate-50 dark:bg-slate-800/50 rounded-lg">+<?= count($stacks) - 3 ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="px-8 py-5 text-right align-top">
                                <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <a href="<?= base_url('project/' . $project['slug']) ?>" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-all" title="Lihat Live">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                    
                                    <a href="<?= base_url('admin/projects/edit/' . $project['id']) ?>" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/30 transition-all" title="Edit Data">
                                        <i class="fa-solid fa-pen-nib"></i>
                                    </a>
                                    
                                    <form action="<?= base_url('admin/projects/delete/' . $project['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini secara permanen?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 transition-all" title="Hapus Proyek">
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
            </div> <?php if ($pager->getPageCount('projects') > 1) : ?>
            <div class="p-6 border-t border-slate-200 dark:border-slate-700/50 flex justify-center">
                <?= $pager->links('projects', 'tailwind_full') ?>
            </div>
            <?php endif; ?>
        </div> <?= $this->endSection() ?>