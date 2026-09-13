<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php

$savedAccounts = json_decode($setting['bank_account'] ?? '[]', true);
if (!is_array($savedAccounts) || empty($savedAccounts)) {
    $savedAccounts = [['bank' => '', 'number' => '', 'owner' => '', 'icon' => '']];
}
?>

<div class="max-w-5xl mx-auto mb-10" x-data="invoiceSettings()">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-building-columns"></i>
                </span>
                Pengaturan Invoice
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 ml-14">Atur profil bisnis dan tambahkan rekening pembayaran tanpa batas.</p>
        </div>
        <a href="<?= base_url('admin/invoices') ?>" class="text-slate-500 hover:text-indigo-600 font-bold text-sm transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-6 p-4 bg-emerald-500/10 text-emerald-500 rounded-2xl border border-emerald-500/20 font-bold text-sm">
            <i class="fa-solid fa-circle-check mr-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/invoices/settings/save') ?>" method="POST" enctype="multipart/form-data" class="bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden p-6 sm:p-10 space-y-8">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="space-y-4">
                <h3 class="text-xs font-black text-indigo-500 uppercase tracking-widest mb-4 border-b border-slate-200/50 dark:border-slate-700/50 pb-3">Profil Bisnis</h3>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Nama Bisnis / Perusahaan</label>
                    <input type="text" name="company_name" value="<?= esc($setting['company_name'] ?? '') ?>" required 
                           class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:border-indigo-500 outline-none transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Slogan / Bidang Usaha</label>
                    <input type="text" name="company_tagline" value="<?= esc($setting['company_tagline'] ?? '') ?>" 
                           class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:border-indigo-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Alamat Lengkap</label>
                    <textarea name="company_address" rows="3" 
                              class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:border-indigo-500 outline-none transition-all resize-none"><?= esc($setting['company_address'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xs font-black text-indigo-500 uppercase tracking-widest mb-4 border-b border-slate-200/50 dark:border-slate-700/50 pb-3 flex justify-between items-center">
                    Metode Pembayaran
                </h3>
                
                <template x-for="(acc, index) in accounts" :key="index">
                    <div class="p-5 bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl relative shadow-sm transition-all hover:border-indigo-300">
                        <button type="button" @click="removeAccount(index)" class="absolute top-4 right-4 text-rose-400 hover:text-rose-600 bg-rose-50 dark:bg-rose-900/30 p-2 rounded-lg transition-colors">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pr-10 mb-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bank / E-Wallet</label>
                                <input type="text" x-model="acc.bank" :name="`bank_name[${index}]`" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-800 dark:text-white outline-none focus:border-indigo-500" placeholder="BCA / GoPay">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">No. Rekening</label>
                                <input type="text" x-model="acc.number" :name="`bank_number[${index}]`" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-800 dark:text-white outline-none focus:border-indigo-500" placeholder="1234567890">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Atas Nama</label>
                                <input type="text" x-model="acc.owner" :name="`bank_owner[${index}]`" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-800 dark:text-white outline-none focus:border-indigo-500" placeholder="Rian ...">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2">Logo Bank (Opsional)</label>
                            <div class="flex items-center gap-4">
                                <img x-show="acc.icon" :src="'<?= base_url() ?>' + acc.icon" class="h-10 object-contain bg-white rounded-md p-1 border shadow-sm">
                                <input type="hidden" :name="`old_icon[${index}]`" :value="acc.icon">
                                <input type="file" :name="`bank_icon[${index}]`" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors cursor-pointer">
                            </div>
                        </div>
                    </div>
                </template>
                
                <button type="button" @click="addAccount()" class="w-full py-3.5 border-2 border-dashed border-indigo-200 dark:border-indigo-800/50 text-indigo-500 font-bold rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Rekening Lain
                </button>
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-slate-200/50 dark:border-slate-700/50">
            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-black text-sm py-4 px-10 rounded-2xl shadow-xl shadow-indigo-500/30 transition-all flex items-center gap-3 active:scale-95">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<script>
function invoiceSettings() {
    return {
        accounts: <?= json_encode($savedAccounts) ?>,
        
        addAccount() {
            this.accounts.push({ bank: '', number: '', owner: '', icon: '' });
        },
        removeAccount(index) {
            this.accounts.splice(index, 1);
            if (this.accounts.length === 0) {
                this.addAccount();
            }
        }
    }
}
</script>

<?= $this->endSection() ?>