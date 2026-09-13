<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div x-data="{ 
    showModal: false, 
    modalType: 'GET', 
    targetUrl: '', 
    title: '', 
    desc: '', 
    iconClass: '', 
    theme: 'primary',

    openModal(type, url, title, desc, icon, themeColor) {
        this.modalType = type;
        this.targetUrl = url;
        this.title = title;
        this.desc = desc;
        this.iconClass = icon;
        this.theme = themeColor;
        this.showModal = true;
    }
}">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-users"></i>
                </span>
                Kelola Pengguna
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1 ml-14 text-sm">Verifikasi, reset, dan login impersonasi.</p>
        </div>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="mb-6 p-4 bg-emerald-500/10 text-emerald-500 rounded-2xl border border-emerald-500/20 font-bold text-sm">
            <i class="fa-solid fa-circle-check mr-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="mb-6 p-4 bg-rose-500/10 text-rose-500 rounded-2xl border border-rose-500/20 font-bold text-sm">
            <i class="fa-solid fa-circle-exclamation mr-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="rounded-[2rem] border border-slate-200 dark:border-slate-800 overflow-hidden bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-100/50 dark:bg-slate-800/50 text-xs uppercase font-black text-slate-500">
                    <tr>
                        <th class="px-6 py-5">Identitas & Status</th>
                        <th class="px-6 py-5">Rekening & Kontak</th>
                        <th class="px-6 py-5">Saldo</th>
                        <th class="px-6 py-5 text-right">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php foreach($users as $u): ?>
                    <tr class="hover:bg-indigo-500/5 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 dark:text-white"><?= esc($u['username']) ?></div>
                            <div class="text-xs text-slate-400 mb-2"><?= esc($u['email']) ?></div>
                            <?php if($u['is_active'] == 1): ?>
                                <span class="px-2 py-0.5 bg-blue-500/10 text-blue-500 text-[10px] font-black rounded-full uppercase">Verified</span>
                            <?php else: ?>
                                <button type="button" 
                                    @click="openModal('GET', '<?= base_url('admin/users/verify/' . $u['id']) ?>', 'Verifikasi Manual?', 'Ini akan mengaktifkan user tanpa perlu konfirmasi email.', 'fa-solid fa-shield-check', 'primary')" 
                                    class="px-2 py-0.5 bg-amber-500/10 text-amber-500 text-[10px] font-black rounded-full uppercase underline decoration-2">
                                    Unverified / Klik Verifikasi
                                </button>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-[11px] leading-tight text-slate-500 dark:text-slate-400 font-medium">
                                <p><i class="fa-brands fa-whatsapp text-emerald-500 w-4"></i> <?= esc($u['phone'] ?? '-') ?></p>
                                <p class="mt-1"><i class="fa-solid fa-credit-card w-4"></i> <?= esc($u['bank_name'] ?? '-') ?>: <?= esc($u['bank_account'] ?? '-') ?></p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-black text-emerald-500">Rp <?= number_format($u['balance'], 0, ',', '.') ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                
                                <button type="button" @click="openModal('GET', '<?= base_url('admin/users/login-as/' . $u['id']) ?>', 'Login Impersonasi?', 'Sesi Anda saat ini akan di-pause dan diganti sementara menjadi user <?= esc($u['username']) ?>.', 'fa-solid fa-right-to-bracket', 'primary')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:bg-indigo-600 hover:text-white transition shadow-sm" title="Login As User">
                                    <i class="fa-solid fa-right-to-bracket text-xs"></i>
                                </button>

                                <button type="button" @click="openModal('POST', '<?= base_url('admin/users/reset-password/' . $u['id']) ?>', 'Reset Password?', 'Password user <?= esc($u['username']) ?> akan diubah secara paksa menjadi: 12345678.', 'fa-solid fa-key', 'warning')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:bg-amber-500 hover:text-white transition shadow-sm" title="Reset Password">
                                    <i class="fa-solid fa-key text-xs"></i>
                                </button>

                                <?php if($u['status'] == 'active'): ?>
                                    <button type="button" @click="openModal('POST', '<?= base_url('admin/users/toggle-ban/' . $u['id']) ?>', 'Blokir Pengguna?', 'User <?= esc($u['username']) ?> tidak akan bisa login atau melakukan transaksi lagi.', 'fa-solid fa-user-slash', 'danger')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition shadow-sm" title="Blokir User">
                                        <i class="fa-solid fa-user-slash text-xs"></i>
                                    </button>
                                <?php else: ?>
                                    <button type="button" @click="openModal('POST', '<?= base_url('admin/users/toggle-ban/' . $u['id']) ?>', 'Buka Blokir?', 'User <?= esc($u['username']) ?> akan diizinkan untuk login kembali.', 'fa-solid fa-user-check', 'success')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 hover:bg-emerald-500 hover:text-white transition shadow-sm" title="Buka Blokir">
                                        <i class="fa-solid fa-user-check text-xs"></i>
                                    </button>
                                <?php endif; ?>

                                <button type="button" @click="openModal('POST', '<?= base_url('admin/users/delete/' . $u['id']) ?>', 'Hapus Permanen?', 'Data user <?= esc($u['username']) ?> akan dihapus selamanya dari sistem. Tindakan ini tidak bisa dibatalkan!', 'fa-solid fa-trash-can', 'danger')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus Permanen">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>

                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" x-cloak>
            
            <div x-show="showModal" x-transition.opacity @click="showModal = false" class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm"></div>
            
            <div x-show="showModal" x-transition.scale.95 class="relative bg-white dark:bg-slate-900 w-full max-w-sm p-8 rounded-[2.5rem] shadow-2xl text-center border border-white/10">
                
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl"
                     :class="{
                        'bg-indigo-500/10 text-indigo-500': theme === 'primary',
                        'bg-amber-500/10 text-amber-500': theme === 'warning',
                        'bg-rose-500/10 text-rose-500': theme === 'danger',
                        'bg-emerald-500/10 text-emerald-500': theme === 'success'
                     }">
                    <i :class="iconClass"></i>
                </div>

                <h3 class="text-xl font-black text-slate-800 dark:text-white mb-2" x-text="title"></h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-8 font-medium leading-relaxed" x-text="desc"></p>

                <div class="flex gap-3">
                    <button @click="showModal = false" class="flex-1 py-3.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold rounded-2xl transition">
                        Batal
                    </button>
                    
                    <template x-if="modalType === 'GET'">
                        <a :href="targetUrl" class="flex-1 py-3.5 text-white font-bold rounded-2xl shadow-lg transition flex items-center justify-center"
                           :class="{
                               'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-500/30': theme === 'primary',
                               'bg-amber-500 hover:bg-amber-600 shadow-amber-500/30': theme === 'warning',
                               'bg-rose-600 hover:bg-rose-700 shadow-rose-500/30': theme === 'danger',
                               'bg-emerald-500 hover:bg-emerald-600 shadow-emerald-500/30': theme === 'success'
                           }">
                            Ya, Lanjutkan
                        </a>
                    </template>

                    <template x-if="modalType === 'POST'">
                        <form :action="targetUrl" method="POST" class="flex-1 m-0">
                            <?= csrf_field() ?>
                            <button type="submit" class="w-full py-3.5 text-white font-bold rounded-2xl shadow-lg transition"
                               :class="{
                                   'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-500/30': theme === 'primary',
                                   'bg-amber-500 hover:bg-amber-600 shadow-amber-500/30': theme === 'warning',
                                   'bg-rose-600 hover:bg-rose-700 shadow-rose-500/30': theme === 'danger',
                                   'bg-emerald-500 hover:bg-emerald-600 shadow-emerald-500/30': theme === 'success'
                               }">
                                Ya, Eksekusi
                            </button>
                        </form>
                    </template>

                </div>
            </div>
        </div>
    </template>
</div>

<?= $this->endSection() ?>