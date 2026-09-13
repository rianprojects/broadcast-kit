<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Metode Pembayaran Manual</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Logo & nomor rekening/e-wallet yang tampil di halaman Buy.</p>
    </div>
    <a href="<?= base_url('admin/paymentmethods/create') ?>" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">
        + Tambah Metode
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-800">
        <span class="font-bold text-sm"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="rounded-[2rem] p-6 shadow-xl border border-slate-200 dark:border-slate-800">
    <ul class="space-y-3">
        <?php if (empty($methods)): ?>
            <li class="p-8 text-center text-slate-400 border-2 border-dashed border-slate-700 rounded-xl">Belum ada metode pembayaran.</li>
        <?php endif; ?>

        <?php foreach ($methods as $m): ?>
            <li class="flex items-center justify-between p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center gap-4">
                    <?php if ($m['logo']): ?>
                        <img src="<?= base_url('uploads/payment_methods/' . $m['logo']) ?>" class="h-8 object-contain">
                    <?php endif; ?>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white">
                            <?= esc($m['name']) ?>
                            <span class="ml-2 text-[10px] font-bold uppercase tracking-wider <?= $m['is_active'] ? 'text-emerald-500' : 'text-rose-500' ?>">
                                <?= $m['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400"><?= esc($m['account_number']) ?> a/n <?= esc($m['account_name']) ?></p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="<?= base_url('admin/paymentmethods/edit/' . $m['id']) ?>" class="w-10 h-10 flex items-center justify-center text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-xl transition">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form action="<?= base_url('admin/paymentmethods/delete/' . $m['id']) ?>" method="post" onsubmit="return confirm('Hapus metode ini?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="w-10 h-10 flex items-center justify-center text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-xl transition">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?= $this->endSection() ?>
