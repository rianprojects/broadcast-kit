<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Edit Widget</h1>
</div>

<div class="rounded-[2rem] p-8 shadow-xl border border-slate-200 dark:border-slate-800 max-w-3xl">
    <form action="<?= base_url('admin/widgets/update/' . $widget['id']) ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>
        
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Widget</label>
            <input type="text" name="title" value="<?= esc($widget['title']) ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konten HTML</label>
            <textarea name="content" rows="6" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-white focus:ring-2 focus:ring-indigo-500 outline-none font-mono text-sm" required><?= $widget['content'] ?></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
            <select name="is_active" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-white outline-none">
                <option value="1" <?= $widget['is_active'] == 1 ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?= $widget['is_active'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition transform active:scale-95">Update Widget</button>
    </form>
</div>
<?= $this->endSection() ?>