<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">App Versions</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Rilis versi terbaru BroadcastKit Companion.</p>
    </div>
    <a href="<?= base_url('admin/appversions/create') ?>" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">
        + Rilis Versi
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-800">
        <span class="font-bold text-sm"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl border border-rose-200 dark:border-rose-800">
        <span class="font-bold text-sm"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<div class="rounded-[2rem] p-6 shadow-xl border border-slate-200 dark:border-slate-800">
    <ul class="space-y-3">
        <?php if (empty($versions)): ?>
            <li class="p-8 text-center text-slate-400 border-2 border-dashed border-slate-700 rounded-xl">Belum ada versi dirilis.</li>
        <?php endif; ?>

        <?php foreach ($versions as $v): ?>
            <li class="flex items-center justify-between p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <div>
                    <h4 class="font-bold text-slate-800 dark:text-white">
                        v<?= esc($v['version']) ?>
                        <?php if ($v['force_update']): ?>
                            <span class="ml-2 text-[10px] font-bold uppercase tracking-wider text-rose-500">Wajib Update</span>
                        <?php endif; ?>
                    </h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1"><?= esc($v['changelog']) ?></p>
                    <a href="<?= base_url($v['apk_path']) ?>" class="text-xs text-indigo-500 hover:underline"><?= esc($v['apk_path']) ?></a>
                </div>
                <form action="<?= base_url('admin/appversions/delete/' . $v['id']) ?>" method="post" onsubmit="return confirm('Hapus versi ini?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-10 h-10 flex items-center justify-center text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-xl transition">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?= $this->endSection() ?>
