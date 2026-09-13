<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<div class="min-h-screen pt-28 pb-20 flex items-center justify-center transition-colors duration-500">
    <div class="w-full max-w-md p-8 rounded-[2rem] shadow-2xl shadow-indigo-500/10 border border-slate-200 dark:border-slate-800 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-600 to-pink-500"></div>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-900 dark:text-white font-outfit mb-2">Join Creator</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Buat akun untuk mulai berkarya & jualan prompt.</p>
        </div>

        <?php if(session()->getFlashdata('errors')): ?>
            <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm border border-rose-200 dark:border-rose-800">
                <ul class="list-disc pl-4 space-y-1">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm border border-rose-200 dark:border-rose-800 flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/registerProcess') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>

            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Username</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-purple-500 transition-colors">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <input type="text" name="username" value="<?= old('username') ?>" class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium text-slate-900 dark:text-white" placeholder="username_keren" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-purple-500 transition-colors">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <input type="email" name="email" value="<?= old('email') ?>" class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium text-slate-900 dark:text-white" placeholder="name@example.com" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-purple-500 transition-colors">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" id="password" name="password" class="w-full pl-11 pr-12 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium text-slate-900 dark:text-white" placeholder="••••••••" required>
                    
                    <button type="button" onclick="togglePassword('password', 'eye-icon-password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-purple-500 transition-colors focus:outline-none" title="Tampilkan Password">
                        <i id="eye-icon-password" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Confirm Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-purple-500 transition-colors">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" id="confpassword" name="confpassword" class="w-full pl-11 pr-12 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition font-medium text-slate-900 dark:text-white" placeholder="••••••••" required>
                    
                    <button type="button" onclick="togglePassword('confpassword', 'eye-icon-confpass')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-purple-500 transition-colors focus:outline-none" title="Tampilkan Password">
                        <i id="eye-icon-confpass" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <?php if(isset($site_key) && !empty($site_key)): ?>
            <div class="flex justify-center">
                <?php if (!empty($recaptcha_enabled)): ?><div class="g-recaptcha" data-sitekey="<?= $site_key ?>"></div><?php endif; ?>
            </div>
            <?php endif; ?>

            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold rounded-xl shadow-lg shadow-purple-500/30 transition-all transform hover:scale-[1.02]">
                Create Account
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 text-center text-sm text-slate-500">
            Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-purple-600 font-bold hover:underline transition-colors">Login disini</a>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
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

<?php if(isset($site_key) && !empty($site_key)): ?>
<?php if (!empty($recaptcha_enabled)): ?><script src="https://www.google.com/recaptcha/api.js" async defer></script><?php endif; ?>
<?php endif; ?>

<?= $this->endSection() ?>