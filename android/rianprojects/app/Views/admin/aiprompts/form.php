<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    
    <div class="flex items-center gap-4 mb-8">
        <a href="<?= base_url('admin/ai-prompts') ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl  text-slate-500 hover:text-indigo-600 hover:-translate-x-1 shadow-sm border border-slate-200 dark:border-slate-700 transition-all duration-300">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
                <?= isset($prompt_data) ? 'Edit Prompt' : 'Upload New Prompt' ?>
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Bagikan inspirasi AI Art baru ke galeri publik.</p>
        </div>
    </div>
    
    <div class=" rounded-[2rem] shadow-xl border border-slate-200 dark:border-slate-700 p-8 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

        <form action="<?= base_url('admin/ai-prompts/save') ?>" method="post" enctype="multipart/form-data" class="space-y-8 relative z-10">
            <?= csrf_field() ?>
            
            <?php if(isset($prompt_data)): ?>
                <input type="hidden" name="id" value="<?= $prompt_data['id'] ?>">
            <?php endif; ?>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Prompt Title <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fa-solid fa-heading"></i>
                        </div>
                        <input type="text" name="title" value="<?= old('title', $prompt_data['title'] ?? '') ?>" class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition font-bold text-lg text-slate-800 dark:text-white" required placeholder="e.g. Cyberpunk City Neon">
                    </div>
                </div>

                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2 gap-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Short Description / Cara Penggunaan</label>
                        
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="applyTemplate('gemini')" class="px-2.5 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors border border-indigo-200 dark:border-indigo-800/50 flex items-center gap-1.5 shadow-sm active:scale-95">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Template Gemini
                            </button>
                            <button type="button" onclick="applyTemplate('chatgpt')" class="px-2.5 py-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-colors border border-emerald-200 dark:border-emerald-800/50 flex items-center gap-1.5 shadow-sm active:scale-95">
                                <i class="fa-solid fa-robot"></i> Template ChatGPT
                            </button>
                        </div>
                    </div>
                    <textarea id="descField" name="description" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition text-sm text-slate-600 dark:text-slate-300" placeholder="A brief explanation about the model used or the style..."><?= old('description', $prompt_data['description'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="border-t border-slate-100 dark:border-slate-700 my-6"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Creator Name</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fa-solid fa-user-astronaut"></i>
                        </div>
                        <input type="text" name="creator_name" value="<?= old('creator_name', $prompt_data['creator_name'] ?? '') ?>" class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition font-medium" required placeholder="e.g. RianArt">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Artwork Image</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fa-regular fa-image"></i>
                        </div>
                        <input type="file" name="image" class="block w-full text-sm text-slate-500 pl-11 file:mr-4 file:py-3.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-slate-200 dark:file:bg-slate-700 file:text-slate-700 dark:file:text-slate-200 cursor-pointer bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition-all" accept="image/*" <?= isset($prompt_data) ? '' : 'required' ?>>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-tag text-indigo-500"></i> Access & Pricing
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Akses</label>
                        <select name="type" id="accessType" onchange="togglePriceAdmin()" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold outline-none transition">
                            <option value="free" <?= (old('type', $prompt_data['type'] ?? '') == 'free') ? 'selected' : '' ?>>FREE (GRATIS)</option>
                            <option value="premium" <?= (old('type', $prompt_data['type'] ?? '') == 'premium') ? 'selected' : '' ?>>PREMIUM (BERBAYAR)</option>
                        </select>
                    </div>
                    <div id="priceInputAdmin" class="<?= (old('type', $prompt_data['type'] ?? '') == 'premium') ? '' : 'hidden' ?>">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Harga (IDR)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center font-bold text-slate-400">Rp</span>
                            <input type="number" name="price" id="priceFieldAdmin" value="<?= old('price', $prompt_data['price'] ?? '0') ?>" class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition font-bold">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Prompt Text <span class="text-rose-500">*</span></label>
                <textarea name="prompt" class="editor w-full px-4 py-4 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition-all font-mono text-sm leading-relaxed text-slate-700 dark:text-slate-300" placeholder="Paste your AI prompt here..."><?= old('prompt', $prompt_data['prompt'] ?? '') ?></textarea>
            </div>

            <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-link text-indigo-500"></i> Social Links
                </h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Tambahkan link profil agar pengunjung bisa follow creator.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-pink-500 transition-colors">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </div>
                        <input type="url" name="social_instagram" value="<?= old('social_instagram', $prompt_data['social_instagram'] ?? '') ?>" placeholder="Instagram URL" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-pink-500 outline-none transition text-sm">
                    </div>

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors">
                            <i class="fa-brands fa-tiktok text-lg"></i>
                        </div>
                        <input type="url" name="social_tiktok" value="<?= old('social_tiktok', $prompt_data['social_tiktok'] ?? '') ?>" placeholder="TikTok URL" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-slate-800 outline-none transition text-sm">
                    </div>

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-brands fa-facebook text-lg"></i>
                        </div>
                        <input type="url" name="social_facebook" value="<?= old('social_facebook', $prompt_data['social_facebook'] ?? '') ?>" placeholder="Facebook URL" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-blue-600 outline-none transition text-sm">
                    </div>

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-slate-800 dark:group-focus-within:text-white transition-colors">
                            <i class="fa-brands fa-threads text-lg"></i>
                        </div>
                        <input type="url" name="social_threads" value="<?= old('social_threads', $prompt_data['social_threads'] ?? '') ?>" placeholder="Threads URL" class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-slate-800 outline-none transition text-sm">
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="group w-full py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-lg shadow-xl shadow-indigo-500/30 transition-all hover:scale-[1.01] active:scale-[0.98] flex items-center justify-center gap-3">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span><?= isset($prompt_data) ? 'Save Changes' : 'Publish Prompt' ?></span>
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function togglePriceAdmin() {
    const type = document.getElementById('accessType').value;
    const wrapper = document.getElementById('priceInputAdmin');
    const field = document.getElementById('priceFieldAdmin');
    if(type === 'premium') {
        wrapper.classList.remove('hidden');
        field.required = true;
    } else {
        wrapper.classList.add('hidden');
        field.required = false;
        field.value = 0;
    }
}


function applyTemplate(type) {
    const descField = document.getElementById('descField');
    let templateText = "";
    
    if(type === 'gemini') {
        templateText = "1. Buka Google Gemini\n2. Upload fotomu\n3. Pilih Tools > 🍌Create Images\n4. Tulis prompt di bawah ini";
    } else if (type === 'chatgpt') {
        templateText = "1. Buka ChatGPT\n2. Upload fotomu\n3. Tulis prompt di bawah ini";
    }
    
    descField.value = templateText;
    descField.classList.add('ring-4', 'ring-indigo-500/30');
    setTimeout(() => {
        descField.classList.remove('ring-4', 'ring-indigo-500/30');
    }, 300);
}
</script>
<?= $this->endSection() ?>

<?= $this->section('extra_scripts') ?>
<script src="<?= base_url('tinymce/tinymce.min.js') ?>"></script>
<script>
    const theme = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
    
    tinymce.init({
        selector: '.editor',
        license_key: 'gpl', 
        plugins: 'link code lists autolink',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link | code',
        menubar: false,
        height: 450,
        branding: false,
        skin: theme === 'dark' ? "oxide-dark" : "oxide",
        content_css: theme === 'dark' ? "dark" : "default",
        setup: function (editor) {
            editor.on('change', function () {
                editor.save(); 
            });
        }
    });
</script>
<?= $this->endSection() ?>