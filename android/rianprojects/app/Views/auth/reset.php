<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="min-h-screen pt-32 pb-20 flex items-center justify-center bg-slate-50 dark:bg-[#0f172a] transition-colors duration-500">
    <div class="w-full max-w-md p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl shadow-indigo-500/10 border border-slate-200 dark:border-slate-800 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

        <div class="text-center mb-8 relative z-10">
            <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                <i class="fa-solid fa-key text-2xl"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white font-outfit tracking-tight">Set New Password</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Gunakan kombinasi karakter yang kuat.</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl text-xs font-bold border border-rose-100 dark:border-rose-800 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/resetProcess') ?>" method="post" class="space-y-5 relative z-10">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= $token ?>">
            
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">New Password</label>
                <div class="relative group">
                    <input type="password" name="password" id="password" class="w-full pl-4 pr-12 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 dark:focus:border-indigo-500 outline-none transition text-slate-900 dark:text-white" required placeholder="••••••••">
                    <button type="button" onclick="togglePass('password', 'eye-1')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-indigo-500 transition-colors">
                        <i id="eye-1" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Confirm Password</label>
                <div class="relative group">
                    <input type="password" name="confpassword" id="confpassword" class="w-full pl-4 pr-12 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 dark:focus:border-indigo-500 outline-none transition text-slate-900 dark:text-white" required placeholder="••••••••">
                    <button type="button" onclick="togglePass('confpassword', 'eye-2')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-indigo-500 transition-colors">
                        <i id="eye-2" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition-all active:scale-[0.98]">
                Update Password
            </button>
            
            <div class="text-center pt-2">
                <a href="<?= base_url('login') ?>" class="text-sm font-bold text-slate-400 hover:text-indigo-500 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back to Login
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePass(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);
    
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>

<?= $this->endSection() ?>