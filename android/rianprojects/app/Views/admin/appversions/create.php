<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Rilis Versi Baru</h1>
</div>

<div class="rounded-[2rem] p-8 shadow-xl border border-slate-200 dark:border-slate-800 max-w-3xl mx-auto">
    <form action="<?= base_url('admin/appversions/store') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Versi (harus sama dengan versionName di build.gradle.kts)</label>
            <input type="text" name="version" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-white focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Cth: 0.2" required>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Changelog</label>
            <textarea name="changelog" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-white focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Fix bug kamera, tambah fitur X"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">File APK</label>
            <input type="file" name="apk" accept=".apk" class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 file:cursor-pointer cursor-pointer bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 outline-none transition-all" required>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="force_update" id="force_update" value="1" class="w-5 h-5">
            <label for="force_update" class="text-sm text-slate-600 dark:text-slate-300">Wajib update (user tidak bisa lanjut pakai app tanpa update)</label>
        </div>

        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition transform active:scale-95">Rilis Versi</button>
    </form>
</div>
<?= $this->endSection() ?>
