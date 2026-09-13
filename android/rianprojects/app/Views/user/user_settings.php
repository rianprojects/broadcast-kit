<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="pt-24 pb-20 min-h-screen">
    <div class="max-w-3xl mx-auto px-6">
        
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-800 dark:text-white mb-2">Pengaturan Akun</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Lengkapi data diri dan rekening pencairan Anda.</p>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-600 rounded-xl text-sm border border-emerald-200">
                <i class="fa-solid fa-circle-check"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 bg-rose-50 text-rose-600 rounded-xl text-sm border border-rose-200">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="rounded-2xl p-6 md:p-8 shadow-sm border border-slate-200 dark:border-slate-800">
            <form action="<?= base_url('dashboard/settings/update') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Nomor WhatsApp</label>
                    <input type="text" name="phone" value="<?= esc($user['phone'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 outline-none focus:border-indigo-500 text-slate-800 dark:text-white" placeholder="Contoh: 08123456789">
                </div>

                <div class="border-t border-slate-100 dark:border-slate-800 pt-6 mt-6">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2"><i class="fa-solid fa-building-columns text-indigo-500"></i> Rekening Pencairan (Withdrawal)</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Nama Bank / E-Wallet</label>
                            <input type="text" name="bank_name" value="<?= esc($user['bank_name'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 outline-none focus:border-indigo-500 text-slate-800 dark:text-white" placeholder="BCA / Mandiri / DANA / GoPay">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Nomor Rekening / No. HP</label>
                            <input type="text" name="bank_account" value="<?= esc($user['bank_account'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 outline-none focus:border-indigo-500 text-slate-800 dark:text-white" placeholder="1234567890">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide">Nama Lengkap Pemilik Rekening</label>
                        <input type="text" name="bank_account_name" value="<?= esc($user['bank_account_name'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 outline-none focus:border-indigo-500 text-slate-800 dark:text-white" placeholder="Sesuai buku tabungan / aplikasi">
                    </div>
                </div>

                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 sm:gap-4">
                    <a href="<?= base_url('dashboard') ?>" class="w-full sm:w-auto text-center px-6 py-3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl transition-all active:scale-95">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
                
            </form>
        </div>

    </div>
</div>
<?= $this->endSection() ?>