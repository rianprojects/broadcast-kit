<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<style>
    .glass-panel {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .form-input-glass {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(203, 213, 225, 0.6);
    }
    .dark .form-input-glass {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(51, 65, 85, 0.6);
    }
    .form-input-glass:focus {
        background: rgba(255, 255, 255, 0.8);
        border-color: #ec4899;
        box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
    }
    .dark .form-input-glass:focus {
        background: rgba(30, 41, 59, 0.8);
    }
</style>

<div class="flex items-center gap-4 mb-8">
    <a href="<?= base_url('admin/posts') ?>" class="w-10 h-10 flex items-center justify-center rounded-xl glass-panel text-slate-500 hover:text-pink-600 hover:scale-105 transition-all shadow-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
            Tulis <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-500">Artikel Baru</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">Bagikan ide dan cerita menarik Anda.</p>
    </div>
</div>

<form action="<?= base_url('admin/posts/save') ?>" method="post" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <?= csrf_field() ?>

    <div class="lg:col-span-2 space-y-6">
        
        <div class="glass-panel p-8 rounded-[2rem] shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-pink-500/5 rounded-full blur-2xl -z-10"></div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Artikel</label>
                <input type="text" name="title" class="w-full px-5 py-4 text-xl font-bold rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none placeholder-slate-400" placeholder="Ketik judul yang menarik..." required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konten</label>
                <textarea name="content" class="editor w-full h-96 rounded-xl form-input-glass"></textarea>
            </div>
        </div>
        
        <div class="glass-panel p-8 rounded-[2rem] shadow-xl relative overflow-hidden">
             <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <i class="fa-brands fa-google text-orange-500"></i> Konfigurasi SEO
             </h3>
             <div class="grid gap-5">
                 <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Meta Title</label>
                    <input type="text" name="meta_title" class="w-full px-4 py-3 rounded-xl form-input-glass text-sm text-slate-800 dark:text-white focus:outline-none" placeholder="Judul khusus pencarian Google">
                 </div>
                 <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Meta Description</label>
                    <textarea name="meta_desc" rows="3" class="w-full px-4 py-3 rounded-xl form-input-glass text-sm text-slate-800 dark:text-white focus:outline-none" placeholder="Deskripsi singkat yang muncul di Google..."></textarea>
                 </div>
             </div>
        </div>
    </div>

    <div class="space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label>
                <input list="blog_cats" name="category" class="w-full px-4 py-2.5 rounded-xl form-input-glass text-slate-800 dark:text-white" placeholder="Pilih Kategori" value="<?= isset($post) ? $post['category'] : '' ?>">
                <datalist id="blog_cats">
                    <option value="Teknologi">
                    <option value="Tutorial">
                    <option value="News">
                    <option value="Personal">
                    <option value="Blog">
                </datalist>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tags</label>
                <input type="text" name="tags" class="w-full px-4 py-2.5 rounded-xl form-input-glass text-slate-800 dark:text-white" placeholder="ci4, coding, tips" value="<?= isset($post) ? $post['tags'] : '' ?>">
            </div>
        </div>
        
        <div class="glass-panel p-6 rounded-[2rem] shadow-xl">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-rocket text-indigo-500"></i> Publishing
            </h3>
            
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                <div class="relative">
                    <select name="status" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none appearance-none cursor-pointer font-bold">
                        <option value="draft">Draft (Simpan)</option>
                        <option value="published">Published (Tayangkan)</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-slate-400 pointer-events-none text-xs"></i>
                </div>
            </div>

            <button type="submit" class="group w-full py-4 rounded-xl bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-500 hover:to-rose-500 text-white font-bold shadow-lg shadow-pink-500/30 transition-all active:scale-95 flex items-center justify-center gap-2 relative overflow-hidden">
                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1s_infinite]"></div>
                <i class="fa-solid fa-paper-plane transition-transform group-hover:-translate-y-1 group-hover:translate-x-1"></i> Terbitkan Sekarang
            </button>
        </div>

        <div class="glass-panel p-6 rounded-[2rem] shadow-xl">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-regular fa-image text-emerald-500"></i> Cover Image
            </h3>
            
            <div class="w-full aspect-video bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-pink-400 dark:hover:border-pink-500 transition-colors flex flex-col items-center justify-center overflow-hidden relative group cursor-pointer">
                <img id="imgPreview" src="" class="absolute inset-0 w-full h-full object-cover hidden z-10 transition-transform duration-500 group-hover:scale-105">
                
                <div class="text-center p-4 transition-opacity duration-300 group-hover:scale-110" id="placeholder">
                    <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400">Upload Cover</p>
                </div>
                
                <input type="file" name="featured_image" onchange="previewImage(this)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-20" accept="image/*" required>
            </div>
            <p class="text-[10px] text-slate-400 mt-3 text-center flex justify-center gap-1">
                <i class="fa-solid fa-circle-info"></i> Rekomendasi: 1200x630px (Max 2MB)
            </p>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('extra_scripts') ?>
<script src="<?= base_url('tinymce/tinymce.min.js') ?>"></script>
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreview').src = e.target.result;
                document.getElementById('imgPreview').classList.remove('hidden');
                document.getElementById('placeholder').classList.add('opacity-0');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    const theme = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
    
    tinymce.init({
        selector: '.editor',
        license_key: 'gpl', 
        plugins: 'link image code codesample table lists searchreplace autolink code',
        toolbar: 'undo redo | blocks | bold italic forecolor | fontsize | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code codesample',
        menubar: false,
        height: 500,
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