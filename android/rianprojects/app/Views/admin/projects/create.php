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
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
    .dark .form-input-glass:focus {
        background: rgba(30, 41, 59, 0.8);
    }
</style>

<div class="flex items-center gap-4 mb-8">
    <a href="<?= base_url('admin/projects') ?>" class="w-10 h-10 flex items-center justify-center rounded-xl glass-panel text-slate-500 hover:text-indigo-600 hover:scale-105 transition-all shadow-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
            Tambah <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">Proyek Baru</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">Isi detail lengkap portofolio Anda.</p>
    </div>
</div>

<form action="<?= base_url('admin/projects/store') ?>" method="post" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <?= csrf_field() ?>

    <div class="lg:col-span-2 space-y-6">
        
        <div class="glass-panel p-8 rounded-[2rem] shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl -z-10"></div>

            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-indigo-500"></i> Informasi Utama
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Proyek</label>
                    <input type="text" name="title" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none" placeholder="Contoh: Aplikasi Kasir Toko" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori</label>
                    <div class="relative">
                        <select name="category" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none appearance-none cursor-pointer">
                            <option value="Web Development">Web Development</option>
                            <option value="Mobile App">Mobile App</option>
                            <option value="UI/UX Design">UI/UX Design</option>
                            <option value="Bot & Automation">Bot & Automation</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-slate-400 pointer-events-none text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Klien (Opsional)</label>
                    <input type="text" name="client" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none" placeholder="Nama Perusahaan / Personal">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Preview URL</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-slate-400"><i class="fa-solid fa-link"></i></span>
                        <input type="url" name="preview_url" class="w-full pl-10 pr-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none" placeholder="https://...">
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tech Stack</label>
                <input type="text" name="tech_stack" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none" placeholder="Pisahkan dengan koma. Cth: PHP, CodeIgniter 4, Tailwind CSS">
                <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info"></i> Gunakan koma (,) untuk memisahkan teknologi agar menjadi badge otomatis.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Lengkap</label>
                <textarea name="description" class="editor w-full h-64 rounded-xl form-input-glass"></textarea>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        
        <div class="glass-panel p-6 rounded-[2rem] shadow-xl">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-regular fa-image text-emerald-500"></i> Thumbnail
            </h3>
            
            <div class="mb-4">
                <div class="w-full aspect-video bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500 transition-colors flex flex-col items-center justify-center overflow-hidden relative group cursor-pointer">
                    <img id="imgPreview" src="" class="absolute inset-0 w-full h-full object-cover hidden z-10 transition-transform duration-500 group-hover:scale-105">
                    
                    <div class="text-center p-4 transition-opacity duration-300 group-hover:scale-110" id="placeholder">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400">Klik untuk upload</p>
                        <p class="text-[10px] text-slate-400 mt-1">JPG, PNG, WEBP (Max 2MB)</p>
                    </div>
                    
                    <input type="file" name="thumbnail" onchange="previewImage(this)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-20" accept="image/*" required>
                </div>
            </div>
        </div>

        <div class="glass-panel p-6 rounded-[2rem] shadow-xl">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-brands fa-google text-orange-500"></i> SEO Config
            </h3>
            
            <div class="mb-4">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Meta Title</label>
                <input type="text" name="meta_title" class="w-full px-3 py-2 rounded-lg form-input-glass text-sm text-slate-800 dark:text-white focus:outline-none" placeholder="Judul di Google Search">
            </div>

            <div class="mb-2">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Meta Description</label>
                <textarea name="meta_desc" rows="3" class="w-full px-3 py-2 rounded-lg form-input-glass text-sm text-slate-800 dark:text-white focus:outline-none" placeholder="Deskripsi singkat..."></textarea>
            </div>
        </div>

        <button type="submit" class="group w-full py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold shadow-lg shadow-indigo-500/30 transition-all active:scale-95 flex items-center justify-center gap-2 relative overflow-hidden">
            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1s_infinite]"></div>
            <i class="fa-solid fa-save"></i> Simpan Proyek
        </button>
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
        plugins: 'link image code table lists searchreplace autolink',
        toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
        menubar: false,
        height: 700,
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