<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto">
    <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight mb-8">Edit Metode Pembayaran</h1>

    <div class="rounded-[2rem] p-8 shadow-xl border border-slate-200 dark:border-slate-800">
        <form action="<?= base_url('admin/paymentmethods/update/' . $method['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-5">
            <?= csrf_field() ?>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nama (mis: BCA, DANA)</label>
                <input type="text" name="name" value="<?= esc($method['name']) ?>" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-indigo-500 outline-none transition-all text-slate-800 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Logo</label>
                <?php if ($method['logo']): ?>
                    <img src="<?= base_url('uploads/payment_methods/' . $method['logo']) ?>" class="h-10 object-contain mb-3">
                <?php endif; ?>
                <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-600 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50 cursor-pointer bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition-all">
                <p class="text-[10px] text-slate-400 mt-2">*Kosongkan jika tidak ingin mengganti logo.</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nomor Rekening / E-Wallet</label>
                <input type="text" name="account_number" value="<?= esc($method['account_number']) ?>" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-indigo-500 outline-none transition-all text-slate-800 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Atas Nama</label>
                <input type="text" name="account_name" value="<?= esc($method['account_name']) ?>" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-indigo-500 outline-none transition-all text-slate-800 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Urutan Tampil</label>
                <input type="number" name="sort_order" value="<?= esc($method['sort_order']) ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-indigo-500 outline-none transition-all text-slate-800 dark:text-white">
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" <?= $method['is_active'] ? 'checked' : '' ?> class="w-5 h-5 rounded text-indigo-600">
                <span class="text-sm font-bold text-slate-700 dark:text-slate-300">Aktif (tampil di halaman Buy)</span>
            </label>

            <div class="flex gap-3 pt-4">
                <a href="<?= base_url('admin/paymentmethods') ?>" class="flex-1 py-3 text-center font-bold rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Batal</a>
                <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
