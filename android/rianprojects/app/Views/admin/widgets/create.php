<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Tambah Widget</h1>
</div>

<div class=" rounded-[2rem] p-8 shadow-xl border border-slate-200 dark:border-slate-800 max-w-3xl">
    <form action="<?= base_url('admin/widgets/store') ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>
        
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Widget (Opsional)</label>
            <input type="text" name="title" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-white focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Cth: Sponsor Kami">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konten HTML / Iframe / Teks</label>
            <textarea name="content" rows="6" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-white focus:ring-2 focus:ring-indigo-500 outline-none font-mono text-sm" placeholder="Paste link <iframe> youtube, tag <img>, atau teks disini..." required></textarea>
            <p class="text-xs text-slate-500 mt-2">Gunakan tag HTML untuk menyisipkan gambar atau video.</p>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
            <select name="is_active" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-white outline-none">
                <option value="1">Aktif (Tampilkan)</option>
                <option value="0">Nonaktif (Sembunyikan)</option>
            </select>
        </div>

        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition transform active:scale-95">Simpan Widget</button>
    </form>
</div>
<?= $this->endSection() ?>