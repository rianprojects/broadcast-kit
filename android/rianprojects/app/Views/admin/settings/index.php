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
        border-color: #06b6d4; /* Cyan-500 */
        box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
    }
    .dark .form-input-glass:focus {
        background: rgba(30, 41, 59, 0.8);
    }
</style>

<div class="flex items-center gap-4 mb-8">
    <div class="w-12 h-12 rounded-2xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600 dark:text-cyan-400">
        <i class="fa-solid fa-gear text-2xl animate-spin-slow" style="animation-duration: 10s;"></i>
    </div>
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
            Pengaturan <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 to-blue-500">Website</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">Kelola identitas global dan konfigurasi SEO.</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-8 p-4 rounded-2xl bg-emerald-50/80 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 backdrop-blur-sm flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-300">
                <i class="fa-solid fa-check"></i>
            </div>
            <span class="font-bold text-emerald-800 dark:text-emerald-200"><?= session()->getFlashdata('success') ?></span>
        </div>
        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-200 transition p-2 hover:bg-emerald-100 dark:hover:bg-emerald-800 rounded-lg">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/settings/update') ?>" method="post" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <?= csrf_field() ?>

    <div class="lg:col-span-2 space-y-6">
        
        <div class="border-slate-700/50 border p-8 rounded-[2rem] shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/5 rounded-full blur-2xl -z-10"></div>

            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-globe text-cyan-500"></i> Informasi Umum
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Website (Brand)</label>
                    <input type="text" name="site_name" value="<?= esc($settings['site_name']) ?>" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none" placeholder="Contoh: Rian Projects">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Halaman Default</label>
                    <input type="text" name="site_title" value="<?= esc($settings['site_title']) ?>" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none" placeholder="Rian Projects | Web Developer">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Footer</label>
                <input type="text" name="footer_text" value="<?= esc($settings['footer_text']) ?>" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none" placeholder="Contoh: &copy; 2024 Rian Projects.">
            </div>
        </div>

        <div class="border-slate-700/50 border p-8 rounded-[2rem] shadow-xl relative overflow-hidden">
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl -z-10"></div>

            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass-chart text-blue-500"></i> SEO Global
            </h3>
            
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Meta Description</label>
                <textarea name="site_description" rows="3" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none" placeholder="Deskripsi singkat website untuk Google..."><?= esc($settings['site_description']) ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Meta Keywords</label>
                <textarea name="site_keywords" rows="2" class="w-full px-4 py-3 rounded-xl form-input-glass text-slate-800 dark:text-white transition-all outline-none" placeholder="web developer, portfolio, jasa website..."><?= esc($settings['site_keywords']) ?></textarea>
                <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info"></i> Pisahkan kata kunci dengan tanda koma (,).</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        
        <div class="border-slate-700/50 border p-6 rounded-[2rem] shadow-xl">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-share-nodes text-indigo-500"></i> Sosial Media
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1 flex items-center gap-1"><i class="fa-brands fa-github text-slate-700 dark:text-white"></i> Github URL</label>
                    <input type="url" name="social_github" value="<?= esc($settings['social_github']) ?>" class="w-full px-3 py-2.5 rounded-xl form-input-glass text-sm text-slate-800 dark:text-white outline-none" placeholder="https://github.com/username">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1 flex items-center gap-1"><i class="fa-brands fa-instagram text-pink-600"></i> Instagram URL</label>
                    <input type="url" name="social_instagram" value="<?= esc($settings['social_instagram']) ?>" class="w-full px-3 py-2.5 rounded-xl form-input-glass text-sm text-slate-800 dark:text-white outline-none" placeholder="https://instagram.com/username">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1 flex items-center gap-1"><i class="fa-brands fa-tiktok text-blue-600"></i> TikTok URL</label>
                    <input type="url" name="social_facebook" value="<?= esc($settings['social_facebook']) ?>" class="w-full px-3 py-2.5 rounded-xl form-input-glass text-sm text-slate-800 dark:text-white outline-none" placeholder="https://facebook.com/username">
                </div>
            </div>
        </div>

        <div class="border-slate-700/50 border p-6 rounded-[2rem] shadow-xl">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-emerald-500"></i> Keamanan
            </h3>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="recaptcha_enabled" value="1" <?= !empty($settings['recaptcha_enabled']) ? 'checked' : '' ?> class="w-5 h-5">
                <span class="text-sm text-slate-600 dark:text-slate-300">Aktifkan reCAPTCHA di form Login/Register/Lupa Password</span>
            </label>
        </div>

        <div class="border-slate-700/50 border p-6 rounded-[2rem] shadow-xl">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-credit-card text-amber-500"></i> Metode Pembayaran (Halaman Buy)
            </h3>
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio" name="payment_mode" value="manual" <?= ($settings['payment_mode'] ?? 'manual') === 'manual' ? 'checked' : '' ?> class="w-5 h-5">
                    <span class="text-sm text-slate-600 dark:text-slate-300">Manual (upload bukti transfer, admin approve via Telegram)</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio" name="payment_mode" value="tripay" <?= ($settings['payment_mode'] ?? '') === 'tripay' ? 'checked' : '' ?> class="w-5 h-5">
                    <span class="text-sm text-slate-600 dark:text-slate-300">Otomatis (TriPay, QRIS/VA, konfirmasi instan)</span>
                </label>
                <p class="text-[10px] text-slate-400 flex items-center gap-1"><i class="fa-solid fa-circle-info"></i> API key TriPay diatur di file <code>.env</code> (belum tersedia via form ini).</p>
            </div>
        </div>

        <button type="submit" class="group w-full py-4 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold shadow-lg shadow-cyan-500/30 transition-all active:scale-95 flex items-center justify-center gap-2 relative overflow-hidden">
            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1s_infinite]"></div>
            <i class="fa-solid fa-floppy-disk transition-transform group-hover:scale-110"></i> Simpan Pengaturan
        </button>
    </div>
</form>

<?= $this->endSection() ?>