<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="pt-28 pb-20 min-h-screen transition-colors duration-500">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        <div class="flex items-center gap-4 mb-8">
            <a href="<?= base_url('prompts/my') ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-500 hover:text-indigo-600 hover:-translate-x-1 shadow-sm border border-slate-200 dark:border-slate-700 transition-all duration-300">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Upload Karya AI</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Bagikan prompt dan hasil generate gambar terbaik Anda.</p>
            </div>
        </div>

        <div class="rounded-[2rem] shadow-xl border border-slate-200 dark:border-slate-700 p-8 relative overflow-hidden">

            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

            <?php if(session()->getFlashdata('errors')): ?>
                <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/20 text-rose-600 rounded-xl text-sm border border-rose-200 dark:border-rose-800">
                    <ul class="list-disc pl-4">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('prompts/my/save') ?>" method="post" enctype="multipart/form-data" class="space-y-8 relative z-10">
                <?= csrf_field() ?>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Karya <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <i class="fa-solid fa-heading"></i>
                            </div>
                            <input type="text" name="title" value="<?= old('title') ?>" class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition font-bold text-lg text-slate-800 dark:text-white" required placeholder="Contoh: Cyberpunk City Neon">
                        </div>
                    </div>

                    <div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2 gap-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi Singkat / Model AI</label>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="applyTemplate('gemini')" class="px-2.5 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors border border-indigo-200 dark:border-indigo-800/50 flex items-center gap-1.5 shadow-sm active:scale-95">
                                    <i class="fa-solid fa-wand-magic-sparkles"></i> Template Gemini
                                </button>
                                <button type="button" onclick="applyTemplate('chatgpt')" class="px-2.5 py-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-colors border border-emerald-200 dark:border-emerald-800/50 flex items-center gap-1.5 shadow-sm active:scale-95">
                                    <i class="fa-solid fa-robot"></i> Template ChatGPT
                                </button>
                            </div>
                        </div>
                        <textarea id="descField" name="description" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition text-sm text-slate-600 dark:text-slate-300" placeholder="Misal: Dibuat menggunakan Midjourney V6 dengan aspect ratio 16:9..."><?= old('description') ?></textarea>
                    </div>
                </div>

                <div class="border-t border-slate-100 dark:border-slate-700 my-6"></div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Upload Gambar Hasil AI (JPG/PNG) <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <i class="fa-regular fa-image"></i>
                            </div>
                            <input type="file" name="image" class="block w-full text-sm text-slate-500 pl-11 file:mr-4 file:py-3.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-slate-200 dark:file:bg-slate-700 file:text-slate-700 dark:file:text-slate-200 cursor-pointer bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 outline-none transition-all" accept="image/*" required>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-2">*Maksimal ukuran file 5MB. Gambar akan otomatis dioptimasi ke WebP.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Prompt Asli <span class="text-rose-500">*</span></label>
                        <textarea name="prompt" rows="6" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition font-mono text-sm text-slate-700 dark:text-slate-300" placeholder="Paste prompt lengkap Anda di sini..." required><?= old('prompt') ?></textarea>
                    </div>
                </div>

                <div class="border-t border-slate-100 dark:border-slate-700 my-6"></div>

                <div class="space-y-8">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-tag text-indigo-500"></i> Akses & Harga
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Akses</label>
                                <select name="type" id="accessType" onchange="togglePrice()" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold outline-none transition">
                                    <option value="free">FREE (GRATIS)</option>
                                    <option value="premium">PREMIUM (BERBAYAR)</option>
                                </select>
                            </div>
                            <div id="priceWrapper" class="hidden">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Harga Jual (IDR)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-4 flex items-center font-bold text-slate-400">Rp</span>
                                    <input type="number" name="price" id="priceField" class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition font-bold" placeholder="Contoh: 15000">
                                </div>
                                <p class="text-[10px] text-slate-400 mt-2 italic">*Saran: Gunakan harga yang kompetitif.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-link text-indigo-500"></i> Social Links
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Tambahkan link profil agar pengunjung bisa follow Anda.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-pink-500 transition-colors">
                                    <i class="fa-brands fa-instagram text-lg"></i>
                                </div>
                                <input type="url" name="social_instagram" placeholder="Instagram URL" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-pink-500 outline-none transition text-sm">
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors">
                                    <i class="fa-brands fa-tiktok text-lg"></i>
                                </div>
                                <input type="url" name="social_tiktok" placeholder="TikTok URL" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-slate-800 outline-none transition text-sm">
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                    <i class="fa-brands fa-facebook text-lg"></i>
                                </div>
                                <input type="url" name="social_facebook" placeholder="Facebook URL" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-blue-600 outline-none transition text-sm">
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-slate-800 dark:group-focus-within:text-white transition-colors">
                                    <i class="fa-brands fa-threads text-lg"></i>
                                </div>
                                <input type="url" name="social_threads" placeholder="Threads URL" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-slate-800 outline-none transition text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 dark:border-slate-700 my-6"></div>

                <div class="pt-2 flex flex-col-reverse sm:flex-row gap-4">
                    <a href="<?= base_url('prompts/my') ?>" class="w-full sm:w-1/3 py-4 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="group w-full sm:w-2/3 py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-lg shadow-xl shadow-indigo-500/30 transition-all hover:scale-[1.01] active:scale-[0.98] flex items-center justify-center gap-3">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Publikasikan Prompt Sekarang</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function togglePrice() {
    const type = document.getElementById('accessType').value;
    const wrapper = document.getElementById('priceWrapper');
    const field = document.getElementById('priceField');
    if (type === 'premium') {
        wrapper.classList.remove('hidden');
        field.required = true;
    } else {
        wrapper.classList.add('hidden');
        field.required = false;
        field.value = '';
    }
}

function applyTemplate(type) {
    const descField = document.getElementById('descField');
    if (type === 'gemini') {
        descField.value = "1. Buka Google Gemini\n2. Upload fotomu\n3. Pilih Tools > 🍌Create Images\n4. Tulis prompt di bawah ini";
    } else if (type === 'chatgpt') {
        descField.value = "1. Buka ChatGPT\n2. Upload fotomu\n3. Tulis prompt di bawah ini";
    }
    descField.classList.add('ring-4', 'ring-indigo-500/30');
    setTimeout(() => descField.classList.remove('ring-4', 'ring-indigo-500/30'), 300);
}
</script>

<?= $this->endSection() ?>