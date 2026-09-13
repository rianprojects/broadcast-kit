<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="min-h-screen pt-32 pb-20 flex items-center justify-center">
    <div class="w-full max-w-md p-8 rounded-[2rem] shadow-2xl border border-slate-200 dark:border-slate-800 text-center">
        
        <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
            <i class="fa-solid fa-key"></i>
        </div>

        <h1 class="text-2xl font-black text-slate-900 dark:text-white font-outfit mb-2">Lupa Password?</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm mb-8">Masukkan email Anda, kami akan mengirimkan link untuk mereset password.</p>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-600 rounded-xl text-sm border border-green-200">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/forgotProcess') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>
            <input type="email" name="email" placeholder="Email Address" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition text-center" required>

            <?php if(isset($site_key) && !empty($site_key)): ?>
                <div class="flex justify-center">
                    <?php if (!empty($recaptcha_enabled)): ?><div class="g-recaptcha" data-sitekey="<?= $site_key ?>"></div><?php endif; ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all">
                Kirim Link Reset
            </button>
        </form>

        <div class="mt-8">
            <a href="<?= base_url('login') ?>" class="text-sm text-slate-500 hover:text-indigo-600 transition">Kembali ke Login</a>
        </div>
    </div>
</div>

<?php if(isset($site_key) && !empty($site_key)): ?>
    <?php if (!empty($recaptcha_enabled)): ?><script src="https://www.google.com/recaptcha/api.js" async defer></script><?php endif; ?>
<?php endif; ?>

<?= $this->endSection() ?>