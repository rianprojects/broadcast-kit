<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto py-8 px-4">
    
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white">AI Tools Manager</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola semua fitur kecerdasan buatan di etalase Rian Projects.</p>
        </div>
        <a href="<?= base_url('admin/ailab/create') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-indigo-500/30 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Tool Baru
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-6 py-4 rounded-xl mb-6 font-bold text-sm">
            <i class="fa-solid fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2rem] shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs uppercase tracking-widest border-b border-slate-200 dark:border-slate-800">
                        <th class="p-5 font-bold">Fitur AI</th>
                        <th class="p-5 font-bold">Link / Route</th>
                        <th class="p-5 font-bold text-center">Status</th>
                        <th class="p-5 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-800/50">
                    <?php foreach ($tools as $t): ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-colors group">
                        <td class="p-5 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl <?= $t['bg_color'] ?> <?= $t['icon_color'] ?> flex items-center justify-center text-xl">
                                <i class="<?= $t['icon'] ?>"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 dark:text-white text-base"><?= $t['name'] ?></p>
                                <p class="text-xs text-slate-500 truncate max-w-xs"><?= $t['description'] ?></p>
                            </div>
                        </td>
                        <td class="p-5 text-slate-500 dark:text-slate-400 font-mono text-xs">
                            <?= $t['link'] ?>
                        </td>
                        <td class="p-5 text-center">
                            <?php if ($t['status'] === 'Active'): ?>
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-500 border border-emerald-200">Active</span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500 border border-slate-200">Off / Soon</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="<?= base_url('admin/ailab/toggle/'.$t['id']) ?>" method="POST" class="inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors <?= $t['status'] === 'Active' ? 'bg-amber-50 text-amber-500 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-500 hover:bg-emerald-100' ?>" title="Toggle Status">
                                        <i class="fa-solid <?= $t['status'] === 'Active' ? 'fa-power-off' : 'fa-play' ?>"></i>
                                    </button>
                                </form>
                                <a href="<?= base_url('admin/ailab/edit/'.$t['id']) ?>" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-500 hover:bg-indigo-100 flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="<?= base_url('admin/ailab/delete/'.$t['id']) ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tool ini?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>