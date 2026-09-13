<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<div class="pt-28 pb-20 min-h-screen transition-colors duration-500" x-data="{ 
    showModal: false, 
    targetUrl: '', 
    title: '', 
    desc: '', 
    iconClass: '', 
    theme: 'primary',

    openModal(url, title, desc, icon, themeColor) {
        this.targetUrl = url;
        this.title = title;
        this.desc = desc;
        this.iconClass = icon;
        this.theme = themeColor;
        this.showModal = true;
    }
}">
    
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="mt-10 p-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-2xl border border-emerald-100 dark:border-emerald-800 flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                <p class="text-sm font-medium"><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4 pt-12">
            <div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white font-outfit">
                    Hello, <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500"><?= esc($user['username']) ?></span> 👋
                </h1>
                <p class="text-slate-500 dark:text-slate-400">Selamat datang kembali di area kreator. Siap berkarya hari ini?</p>
            </div>
            
            <div class="flex gap-3">
                <a href="<?= base_url('prompts/my/new') ?>" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Buat Prompt
                </a>
                <a href="<?= base_url('prompts') ?>" class="px-5 py-2.5 bg-white dark:bg-slate-800 text-slate-900 dark:text-white font-bold rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-sm flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i> Jelajahi
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="p-6 bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="fa-solid fa-layer-group text-6xl text-indigo-500"></i>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">My Prompts</p>
                <h3 class="text-4xl font-black text-slate-900 dark:text-white leading-none">
                    <?= number_format($totalPrompt ?? 0, 0, ',', '.') ?>
                </h3>
                <p class="text-xs text-slate-400 mt-3">Karya yang telah Anda publikasikan.</p>
            </div>

            <div class="p-6 bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="fa-solid fa-shield-halved text-6xl text-emerald-500"></i>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Status Akun</p>
                <h3 class="text-4xl font-black text-emerald-500 leading-none">
                    <?= (session()->get('role') == 'admin') ? 'Admin' : 'Creator' ?>
                </h3>
                <p class="text-xs text-slate-400 mt-3 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i> Akun Terverifikasi
                </p>
            </div>

            <div class="p-6 bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="fa-solid fa-rupiah-sign text-6xl text-amber-500"></i>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Saldo Pendapatan</p>
                <h3 class="text-4xl font-black text-slate-900 dark:text-white leading-none">
                    Rp <?= number_format($user['balance'] ?? 0, 0, ',', '.') ?>
                </h3>
                <p class="text-xs mt-3">
                    <a href="<?= base_url('dashboard/wallet') ?>" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold flex items-center gap-1 w-max">
                        Cairkan Dana <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </p>
            </div>
        </div>

        <?php if (!empty($purchasedPrompts)): ?>
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 font-outfit">Prompt yang Dibeli</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <?php foreach ($purchasedPrompts as $pp): ?>
                <a href="<?= base_url('prompt/' . $pp['slug']) ?>" class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all overflow-hidden">
                    <div class="aspect-video bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        <img src="<?= base_url('uploads/prompts/' . $pp['image']) ?>" alt="<?= esc($pp['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm truncate mb-1"><?= esc($pp['title']) ?></h3>
                        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-wide flex items-center gap-1">
                            <i class="fa-solid fa-circle-check"></i> Sudah Dibeli
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 font-outfit">Menu Pintas</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <a href="<?= base_url('prompts/my') ?>" class="group p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all text-center">
                <div class="w-14 h-14 mx-auto bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm">
                    <i class="fa-solid fa-folder-open text-2xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white">Koleksi Saya</h3>
                <p class="text-xs text-slate-500 mt-1">Kelola dan edit prompt Anda.</p>
            </a>

            <a href="<?= base_url('dashboard/wallet') ?>" class="group p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-emerald-500 dark:hover:border-emerald-500 transition-all text-center">
                <div class="w-14 h-14 mx-auto bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm">
                    <i class="fa-solid fa-wallet text-2xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white">Dompet & Saldo</h3>
                <p class="text-xs text-slate-500 mt-1">Tarik komisi pendapatan Anda.</p>
            </a>

            <a href="<?= base_url('dashboard/settings') ?>" class="group p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-purple-500 dark:hover:border-purple-500 transition-all text-center">
                <div class="w-14 h-14 mx-auto bg-purple-50 dark:bg-purple-900/20 text-purple-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm">
                    <i class="fa-solid fa-user-gear text-2xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white">Pengaturan Akun</h3>
                <p class="text-xs text-slate-500 mt-1">Ubah profil & rekening bank.</p>
            </a>

            <button type="button" @click="openModal('<?= base_url('auth/logout') ?>', 'Konfirmasi Keluar?', 'Anda harus login kembali untuk masuk ke area Dashboard.', 'fa-solid fa-power-off', 'danger')" class="group p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-rose-500 dark:hover:border-rose-500 transition-all text-center">
                <div class="w-14 h-14 mx-auto bg-rose-50 dark:bg-rose-900/20 text-rose-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm">
                    <i class="fa-solid fa-power-off text-2xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white">Keluar</h3>
                <p class="text-xs text-slate-500 mt-1">Selesaikan sesi aktif Anda.</p>
            </button>

        </div>



    </div>

    <template x-teleport="body">
        <div x-show="showModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" x-cloak>
            <div x-show="showModal" x-transition.opacity @click="showModal = false" class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm"></div>
            
            <div x-show="showModal" x-transition.scale.95 class="relative bg-white dark:bg-slate-900 w-full max-w-sm p-8 rounded-[2.5rem] shadow-2xl text-center border border-white/10">
                
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl"
                     :class="{
                        'bg-amber-500/10 text-amber-500': theme === 'warning',
                        'bg-rose-500/10 text-rose-500': theme === 'danger',
                        'bg-indigo-500/10 text-indigo-500': theme === 'primary'
                     }">
                    <i :class="iconClass"></i>
                </div>

                <h3 class="text-xl font-black text-slate-800 dark:text-white mb-2" x-text="title"></h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-8 font-medium leading-relaxed" x-text="desc"></p>

                <div class="flex gap-3">
                    <button @click="showModal = false" class="flex-1 py-3.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold rounded-2xl transition">
                        Batal
                    </button>
                    
                    <a :href="targetUrl" class="flex-1 py-3.5 text-white font-bold rounded-2xl shadow-lg transition flex items-center justify-center"
                       :class="{
                           'bg-amber-500 hover:bg-amber-600 shadow-amber-500/30': theme === 'warning',
                           'bg-rose-600 hover:bg-rose-700 shadow-rose-500/30': theme === 'danger',
                           'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-500/30': theme === 'primary'
                       }">
                        Ya, Lanjutkan
                    </a>
                </div>
            </div>
        </div>
    </template>
</div>

<?= $this->endSection() ?>