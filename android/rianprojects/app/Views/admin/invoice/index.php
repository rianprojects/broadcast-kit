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
    formData: {}, 

    openModal(type, url, title, desc, icon, themeColor, extraData = {}) {
        this.modalType = type;
        this.targetUrl = url;
        this.title = title;
        this.desc = desc;
        this.iconClass = icon;
        this.theme = themeColor;
        this.formData = extraData;
        this.showModal = true;
    }
}">
    
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </span>
                Manajemen Invoice
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1 ml-14 text-sm">Kelola tagihan pelanggan dan pantau pemasukan.</p>
        </div>
        
        <div class="flex gap-2">
            <a href="<?= base_url('admin/invoices/settings') ?>" class="bg-white/40 dark:bg-slate-800/40 backdrop-blur-sm hover:bg-white dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold py-2.5 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                <i class="fa-solid fa-gear"></i> <span class="hidden sm:inline">Settings</span>
            </a>
            <a href="<?= base_url('admin/invoices/create') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl transition shadow-lg shadow-indigo-500/20 flex items-center gap-2 text-sm">
                <i class="fa-solid fa-plus"></i> <span class="hidden sm:inline">Buat Invoice</span>
            </a>
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
                        <th class="px-6 py-5">Identitas Tagihan</th>
                        <th class="px-6 py-5">Tanggal & Tempo</th>
                        <th class="px-6 py-5">Total Nominal</th>
                        <th class="px-6 py-5 text-right">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php if (empty($invoices)): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-500 font-medium">Belum ada invoice yang dibuat.</td>
                    </tr>
                    <?php else: foreach($invoices as $inv): ?>
                    <tr class="hover:bg-indigo-500/5 transition-colors">
                        
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                <?= $inv['invoice_number'] ?>
                                <?php if($inv['status'] === 'paid'): ?>
                                    <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-500 text-[10px] font-black rounded-full uppercase">Lunas</span>
                                <?php elseif($inv['status'] === 'unpaid'): ?>
                                    <span class="px-2 py-0.5 bg-rose-500/10 text-rose-500 text-[10px] font-black rounded-full uppercase">Belum Bayar</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 bg-slate-500/10 text-slate-500 text-[10px] font-black rounded-full uppercase">Batal</span>
                                <?php endif; ?>
                            </div>
                            <div class="text-xs text-indigo-500 font-semibold mt-1">
                                <i class="fa-solid fa-user-tie mr-1"></i> <?= esc($inv['customer_name']) ?>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-[11px] leading-tight text-slate-500 dark:text-slate-400 font-medium">
                                <p><span class="w-12 inline-block font-bold">Terbit</span>: <?= date('d M Y', strtotime($inv['issue_date'])) ?></p>
                                <?php if($inv['due_date']): ?>
                                <p class="mt-1"><span class="w-12 inline-block font-bold text-rose-400">Tempo</span>: <span class="text-rose-500 font-bold"><?= date('d M Y', strtotime($inv['due_date'])) ?></span></p>
                                <?php endif; ?>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="font-black text-emerald-500 text-base">Rp <?= number_format($inv['total_amount'], 0, ',', '.') ?></span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                
                                <?php if($inv['status'] === 'unpaid'): ?>
                                <button type="button" 
                                    @click="openModal('POST', '<?= base_url('admin/invoices/update-status/' . $inv['id']) ?>', 'Tandai Lunas?', 'Apakah pembayaran untuk tagihan <?= $inv['invoice_number'] ?> sudah diterima?', 'fa-solid fa-check-double', 'success', {status: 'paid'})" 
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 hover:bg-emerald-500 hover:text-white transition shadow-sm" 
                                    title="Tandai Lunas">
                                    <i class="fa-solid fa-check-double text-xs"></i>
                                </button>
                                <?php endif; ?>

                                <a href="<?= base_url('admin/invoices/print/' . $inv['id']) ?>" target="_blank" 
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:bg-indigo-600 hover:text-white transition shadow-sm" 
                                    title="Cetak PDF">
                                    <i class="fa-solid fa-print text-xs"></i>
                                </a>

                                <button type="button" 
                                    @click="openModal('POST', '<?= base_url('admin/invoices/delete/' . $inv['id']) ?>', 'Hapus Invoice?', 'Data invoice <?= $inv['invoice_number'] ?> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.', 'fa-solid fa-trash-can', 'danger')" 
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition shadow-sm" title="Hapus Invoice">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                                
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
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
                            <template x-for="(value, key) in formData" :key="key">
                                <input type="hidden" :name="key" :value="value">
                            </template>
                            
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