<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<div class="min-h-screen pt-28 pb-20 flex items-center justify-center transition-colors duration-500">
    <div class="w-full max-w-md p-8 rounded-[2rem] shadow-2xl shadow-indigo-500/10 border border-slate-200 dark:border-slate-800 relative overflow-hidden">

        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-600"></div>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-900 dark:text-white font-outfit mb-2">Welcome Back!</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Masuk untuk mengelola prompt dan dashboard Anda.</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm border border-rose-200 dark:border-rose-800 flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-sm border border-emerald-200 dark:border-emerald-800 flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/loginProcess') ?>" method="post" class="space-y-5" id="loginForm">
            <?= csrf_field() ?>

            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Email or Username</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <input type="text" name="email" value="<?= old('email') ?>" class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-medium text-slate-900 dark:text-white" placeholder="name@example.com" required>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Password</label>
                    <a href="<?= base_url('auth/forgot') ?>" class="text-xs font-bold text-indigo-600 hover:text-indigo-500 hover:underline">Lupa Password?</a>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" id="password" name="password" class="w-full pl-11 pr-12 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-medium text-slate-900 dark:text-white" placeholder="••••••••" required>
                    
                    <button type="button" onclick="togglePass()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-indigo-500 transition-colors focus:outline-none" title="Tampilkan Password">
                        <i id="eye-icon" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- reCAPTCHA v2 Widget -->
            <?php if(isset($site_key) && !empty($site_key)): ?>
            <div class="flex justify-center">
                <div class="g-recaptcha" data-sitekey="<?= $site_key ?>"></div>
            </div>
            <?php endif; ?>

            <button type="submit" class="group w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2">
                <span>Sign In</span>
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 text-center text-sm text-slate-500">
            Belum punya akun? <a href="<?= base_url('register') ?>" class="text-indigo-600 font-bold hover:underline transition-colors">Daftar Sekarang</a>
        </div>
    </div>
</div>

<script>
function togglePass() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

<!-- reCAPTCHA v2 Script -->
<?php if(isset($site_key) && !empty($site_key)): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<?= $this->endSection() ?>