<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div x-data="invoiceBuilder()" class="max-w-6xl mx-auto mb-10">
    
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                    <i class="fa-solid fa-file-circle-plus"></i>
                </span>
                Buat Invoice Baru
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1 ml-14 text-sm">Isi data pelanggan dan rincian tagihan secara otomatis.</p>
        </div>
        <a href="<?= base_url('admin/invoices') ?>" class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-slate-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500 text-slate-600 dark:text-slate-300 font-bold text-sm py-2.5 px-5 rounded-xl transition-all shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="<?= base_url('admin/invoices/store') ?>" method="POST" class="bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden p-6 sm:p-10 space-y-10">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            
            <div class="space-y-5">
                <h3 class="text-xs font-black text-indigo-500 uppercase tracking-widest mb-4 border-b border-slate-200/50 dark:border-slate-700/50 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-user-tie"></i> Data Klien
                </h3>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Nama Lengkap / Perusahaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="customer_name" required 
                           class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all placeholder-slate-400" placeholder="PT. Inovasi Bangsa">
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Email Klien</label>
                        <input type="email" name="customer_email" 
                               class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all placeholder-slate-400" placeholder="email@klien.com">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">WhatsApp / Telepon</label>
                        <input type="text" name="customer_phone" 
                               class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all placeholder-slate-400" placeholder="0812...">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Alamat Lengkap</label>
                    <textarea name="customer_address" rows="2" 
                              class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all resize-none placeholder-slate-400" placeholder="Gedung Sudirman..."></textarea>
                </div>
            </div>

            <div class="space-y-5">
                <h3 class="text-xs font-black text-indigo-500 uppercase tracking-widest mb-4 border-b border-slate-200/50 dark:border-slate-700/50 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days"></i> Detail Tagihan
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Tanggal Terbit <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="date" name="issue_date" value="<?= date('Y-m-d') ?>" required 
                                   class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Jatuh Tempo (Opsional)</label>
                        <div class="relative">
                            <input type="date" name="due_date" 
                                   class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-black text-indigo-500 uppercase tracking-widest mb-4 border-b border-slate-200/50 dark:border-slate-700/50 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-list-check"></i> Rincian Layanan / Produk
            </h3>
            
            <input type="hidden" name="items_json" :value="JSON.stringify(items)">

            <div class="bg-white/60 dark:bg-slate-800/40 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-slate-100/50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 font-bold uppercase text-[11px] tracking-wider">
                            <tr>
                                <th class="px-5 py-4 w-1/2">Nama Layanan / Deskripsi</th>
                                <th class="px-5 py-4 w-24 text-center">Qty</th>
                                <th class="px-5 py-4 w-48 text-right">Harga Satuan (Rp)</th>
                                <th class="px-5 py-4 w-48 text-right">Total (Rp)</th>
                                <th class="px-5 py-4 w-16 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition">
                                    <td class="px-5 py-2">
                                        <input type="text" x-model="item.name" placeholder="Cth: Pembuatan Landing Page" 
                                               class="w-full bg-transparent border-0 focus:ring-0 text-sm outline-none px-0 py-2.5 font-semibold text-slate-800 dark:text-white placeholder-slate-400">
                                    </td>
                                    <td class="px-5 py-2">
                                        <input type="number" min="1" x-model.number="item.qty" 
                                               class="w-full bg-transparent border-0 focus:ring-0 text-sm outline-none px-0 py-2.5 text-center font-bold text-indigo-600 dark:text-indigo-400">
                                    </td>
                                    <td class="px-5 py-2">
                                        <input type="number" min="0" x-model.number="item.price" 
                                               class="w-full bg-transparent border-0 focus:ring-0 text-sm outline-none px-0 py-2.5 text-right font-semibold text-slate-800 dark:text-white">
                                    </td>
                                    <td class="px-5 py-2 text-right font-black text-slate-800 dark:text-emerald-400">
                                        <span x-text="formatRupiah(item.qty * item.price)"></span>
                                    </td>
                                    <td class="px-5 py-2 text-center">
                                        <button type="button" @click="removeItem(index)" class="text-rose-400 hover:text-rose-600 dark:hover:text-rose-400 transition p-2.5 bg-rose-50 dark:bg-rose-500/10 rounded-xl hover:bg-rose-100 dark:hover:bg-rose-500/20">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="button" @click="addItem()" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 px-5 py-2.5 rounded-xl transition flex items-center gap-2 border border-indigo-100 dark:border-indigo-500/20 shadow-sm">
                    <i class="fa-solid fa-plus"></i> Tambah Baris
                </button>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between gap-10">
            
            <div class="flex-1">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" rows="5" 
                          class="w-full bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm text-slate-800 dark:text-white focus:border-indigo-500 outline-none transition-all resize-none placeholder-slate-400" 
                          placeholder="Cth: Pembayaran dilakukan via transfer BCA ke rekening 12345678 a/n Rian..."></textarea>
            </div>
            
            <div class="w-full md:w-[40%] bg-indigo-50/50 dark:bg-slate-800/50 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-indigo-100 dark:border-slate-700 shadow-inner space-y-5">
                
                <div class="flex justify-between items-center text-sm">
                    <span class="font-bold text-slate-500 dark:text-slate-400">Subtotal</span>
                    <span class="font-black text-slate-800 dark:text-white text-base" x-text="formatRupiah(calculateSubtotal())"></span>
                    <input type="hidden" name="subtotal" :value="calculateSubtotal()">
                </div>

                <div class="flex justify-between items-center text-sm gap-4">
                    <span class="font-bold text-slate-500 dark:text-slate-400">Diskon (Rp)</span>
                    <div class="relative w-1/2">
                        <span class="absolute left-3 top-2.5 text-xs font-bold text-slate-400">Rp</span>
                        <input type="number" min="0" x-model.number="discount" name="discount" 
                               class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl pl-8 pr-3 py-2 text-right outline-none focus:border-indigo-500 text-sm font-semibold text-rose-500">
                    </div>
                </div>

                <div class="flex justify-between items-center text-sm gap-4">
                    <span class="font-bold text-slate-500 dark:text-slate-400">Pajak PPN (%)</span>
                    <div class="relative w-24">
                        <input type="number" min="0" max="100" x-model.number="taxPercent" 
                               class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl pr-6 pl-3 py-2 text-center outline-none focus:border-indigo-500 text-sm font-semibold text-slate-800 dark:text-white">
                        <span class="absolute right-3 top-2.5 text-xs font-bold text-slate-400">%</span>
                    </div>
                    <input type="hidden" name="tax_amount" :value="calculateTax()">
                </div>

                <div class="pt-5 border-t border-slate-200 dark:border-slate-700 flex justify-between items-center mt-2">
                    <span class="font-black text-slate-800 dark:text-white text-lg uppercase tracking-widest">Total</span>
                    <span class="font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500 text-2xl" x-text="formatRupiah(calculateTotal())"></span>
                    <input type="hidden" name="total_amount" :value="calculateTotal()">
                </div>

            </div>
        </div>

        <div class="flex justify-end pt-8 border-t border-slate-200/50 dark:border-slate-700/50">
            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-black text-sm py-4 px-10 rounded-2xl shadow-xl shadow-indigo-500/30 transition-all flex items-center gap-3 active:scale-95">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Invoice
            </button>
        </div>

    </form>
</div>

<script>

function invoiceBuilder() {
    return {
        items: [
            { name: '', qty: 1, price: 0 }
        ],
        discount: 0,
        taxPercent: 0,

        addItem() {
            this.items.push({ name: '', qty: 1, price: 0 });
        },

        removeItem(index) {
            if(this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },

        calculateSubtotal() {
            return this.items.reduce((total, item) => total + (item.qty * item.price), 0);
        },

        calculateTax() {
            let sub = this.calculateSubtotal() - this.discount;
            if (sub < 0) sub = 0;
            return (sub * this.taxPercent) / 100;
        },

        calculateTotal() {
            let sub = this.calculateSubtotal();
            let net = sub - this.discount;
            if(net < 0) net = 0;
            return net + this.calculateTax();
        },

        formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
        }
    }
}
</script>

<?= $this->endSection() ?>