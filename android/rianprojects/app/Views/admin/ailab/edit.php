<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-slate-800 dark:text-white">Edit Tool AI</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui informasi fitur AI.</p>
        </div>
        <a href="<?= base_url('admin/ailab') ?>" class="text-slate-500 hover:text-indigo-600 font-bold text-sm bg-white border border-slate-200 px-4 py-2 rounded-xl transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2rem] p-8 shadow-xl">
        <form action="<?= base_url('admin/ailab/update/'.$tool['id']) ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Fitur</label>
                    <input type="text" name="name" value="<?= $tool['name'] ?>" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Slug (ID Unik)</label>
                    <input type="text" name="slug" value="<?= $tool['slug'] ?>" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi</label>
                    <textarea name="description" required rows="2" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all resize-none"><?= $tool['description'] ?></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Icon FontAwesome</label>
                    <input type="text" name="icon" value="<?= $tool['icon'] ?>" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tags (Pisahkan koma)</label>
                    <input type="text" name="tags" value="<?= $tool['tags'] ?>" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Warna Card (Gradient)</label>
                    <input type="text" name="color" value="<?= $tool['color'] ?>" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Warna Teks Icon</label>
                    <input type="text" name="icon_color" value="<?= $tool['icon_color'] ?>" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Warna BG Icon</label>
                    <input type="text" name="bg_color" value="<?= $tool['bg_color'] ?>" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Link Route CI4</label>
                    <input type="text" name="link" value="<?= $tool['link'] ?>" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Status Awal</label>
                    <select name="status" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-indigo-500 transition-all appearance-none">
                        <option value="Active" <?= $tool['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="off" <?= $tool['status'] === 'off' ? 'selected' : '' ?>>Off (Segera Hadir)</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl shadow-lg transition-all mt-4">
                Update Tool AI
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>