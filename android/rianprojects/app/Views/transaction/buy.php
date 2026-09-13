<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="pt-28 pb-20 min-h-screen">
    <div class="max-w-2xl mx-auto px-4">
        
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl border border-slate-200 dark:border-slate-800 p-8">
            <h1 class="text-2xl font-black text-slate-900 dark:text-white mb-6 text-center">Checkout Prompt</h1>
            
            <div class="flex gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl mb-8 border border-slate-100 dark:border-slate-700">
                <img src="<?= base_url('uploads/prompts/' . $p['image']) ?>" class="w-20 h-20 rounded-lg object-cover border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex flex-col justify-center">
                    <h3 class="font-bold text-slate-900 dark:text-white line-clamp-1"><?= esc($p['title']) ?></h3>
                    <p class="text-indigo-600 dark:text-indigo-400 font-black text-xl mt-1">Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
                </div>
            </div>

            <?php if($p['price'] < 10000): ?>
            <div class="mb-6 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50 flex gap-3 text-amber-700 dark:text-amber-400 shadow-sm animate-pulse-slow">
                <i class="fa-solid fa-lightbulb text-xl shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-sm font-bold mb-1">Tips Hemat Pembayaran!</p>
                    <p class="text-xs leading-relaxed opacity-90">Karena nominal transaksi di bawah <strong>Rp 10.000</strong>, kami sangat merekomendasikan Anda menggunakan transfer sesama <strong>E-Wallet (DANA / ShopeePay)</strong> untuk menghindari biaya admin bank.</p>
                </div>
            </div>
            <?php endif; ?>

            <?php if (($site_settings['payment_mode'] ?? 'manual') === 'tripay'): ?>
            <div class="mb-8">
                <h3 class="font-bold text-sm uppercase tracking-wider text-slate-500 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-bolt"></i> Pilih Metode Pembayaran (Otomatis)
                </h3>

                <form action="<?= base_url('transaction/tripay/create') ?>" method="post" class="space-y-3">
                    <?= csrf_field() ?>
                    <input type="hidden" name="prompt_id" value="<?= $p['id'] ?>">

                    <?php if (empty($channels)): ?>
                        <p class="text-sm text-rose-500">Metode pembayaran tidak tersedia saat ini. Hubungi admin.</p>
                    <?php endif; ?>

                    <?php foreach ($channels as $ch): ?>
                        <label class="flex items-center gap-3 p-3 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer hover:border-indigo-500 transition-colors">
                            <input type="radio" name="payment_method" value="<?= esc($ch['code']) ?>" required class="w-5 h-5">
                            <img src="<?= esc($ch['icon_url']) ?>" class="h-6 object-contain">
                            <span class="text-sm font-bold text-slate-700 dark:text-white"><?= esc($ch['name']) ?></span>
                        </label>
                    <?php endforeach; ?>

                    <div class="flex justify-between items-center bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-xl border border-indigo-100 dark:border-indigo-800/50 mt-4">
                        <span class="text-sm font-bold text-slate-600 dark:text-slate-400">Total Bayar:</span>
                        <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">Rp <?= number_format($p['price'], 0, ',', '.') ?></span>
                    </div>

                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-lg rounded-xl shadow-xl shadow-indigo-500/30 transition-all active:scale-95">
                        <i class="fa-solid fa-bolt"></i> Bayar Sekarang
                    </button>
                </form>
                <a href="<?= base_url('prompt/' . $p['slug']) ?>" class="block text-center mt-5 text-sm font-bold text-slate-400 hover:text-rose-500 transition-colors">Batal & Kembali</a>
            </div>
            <?php else: ?>
            <div class="mb-8">
                <h3 class="font-bold text-sm uppercase tracking-wider text-slate-500 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-building-columns"></i> Metode Pembayaran
                </h3>

                <div class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl bg-slate-50/50 dark:bg-slate-800/20 overflow-hidden">

                    <?php if (empty($methods)): ?>
                        <div class="p-6 text-center text-sm text-rose-500">Metode pembayaran belum tersedia. Hubungi admin.</div>
                    <?php else: ?>

                    <div class="flex border-b border-slate-200 dark:border-slate-700 overflow-x-auto scrollbar-hide">
                        <?php foreach ($methods as $i => $m): ?>
                            <button onclick="switchTab('m<?= $m['id'] ?>')" id="btn-m<?= $m['id'] ?>" class="tab-btn flex-1 py-3 px-4 text-sm font-bold whitespace-nowrap transition-colors <?= $i === 0 ? 'text-indigo-600 border-b-2 border-indigo-600 bg-white dark:bg-slate-800' : 'text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 border-b-2 border-transparent' ?>"><?= esc($m['name']) ?></button>
                        <?php endforeach; ?>
                    </div>

                    <div class="p-6">
                        <?php foreach ($methods as $i => $m): ?>
                            <div id="content-m<?= $m['id'] ?>" class="tab-content <?= $i === 0 ? 'block' : 'hidden' ?>">
                                <div class="flex justify-between items-center mb-4">
                                    <?php if ($m['logo']): ?>
                                        <img src="<?= base_url('uploads/payment_methods/' . $m['logo']) ?>" alt="<?= esc($m['name']) ?> Logo" class="h-8 w-auto object-contain">
                                    <?php else: ?>
                                        <span class="font-bold text-slate-700 dark:text-white"><?= esc($m['name']) ?></span>
                                    <?php endif; ?>
                                    <button onclick="copyRekening('norek-m<?= $m['id'] ?>', this)" class="text-indigo-600 text-xs font-bold hover:underline py-1 px-2 rounded hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-colors">Salin</button>
                                </div>
                                <p id="norek-m<?= $m['id'] ?>" class="font-mono text-2xl font-black text-slate-900 dark:text-white tracking-widest mb-1"><?= esc($m['account_number']) ?></p>
                                <p class="text-xs font-bold text-slate-500">A/N: <?= esc($m['account_name']) ?></p>
                            </div>
                        <?php endforeach; ?>

                        <div class="my-5 border-t border-slate-200 dark:border-slate-700"></div>

                        <div class="flex justify-between items-center bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-xl border border-indigo-100 dark:border-indigo-800/50">
                            <span class="text-sm font-bold text-slate-600 dark:text-slate-400">Total Transfer:</span>
                            <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">Rp <?= number_format($p['price'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <form action="<?= base_url('transaction/process') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="prompt_id" value="<?= $p['id'] ?>">
                <input type="hidden" name="amount" value="<?= $p['price'] ?>">

                <div class="mb-8">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        <i class="fa-solid fa-cloud-arrow-up text-indigo-500 mr-1"></i> Upload Bukti Transfer
                    </label>
                    <div class="relative group">
                        <input type="file" name="proof" class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-600 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50 cursor-pointer bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 focus:border-indigo-500 outline-none transition-all" required accept="image/*">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2">*Format: JPG, PNG. Pastikan nominal dan tujuan transfer terlihat jelas.</p>
                </div>

                <button type="submit" class="group w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-lg rounded-xl shadow-xl shadow-indigo-500/30 transition-all transform hover:scale-[1.01] active:scale-95 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Konfirmasi Pembayaran
                </button>
                <a href="<?= base_url('prompt/' . $p['slug']) ?>" class="block text-center mt-5 text-sm font-bold text-slate-400 hover:text-rose-500 transition-colors">Batal & Kembali</a>
            </form>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>

function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.add('hidden');
        el.classList.remove('block');
    });
    
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('text-indigo-600', 'border-indigo-600', 'bg-white', 'dark:bg-slate-800');
        btn.classList.add('text-slate-500', 'border-transparent');
    });

    document.getElementById('content-' + tabId).classList.remove('hidden');
    document.getElementById('content-' + tabId).classList.add('block');
    
    const activeBtn = document.getElementById('btn-' + tabId);
    activeBtn.classList.remove('text-slate-500', 'border-transparent');
    activeBtn.classList.add('text-indigo-600', 'border-indigo-600', 'bg-white', 'dark:bg-slate-800');
}

function copyRekening(elementId, btn) {
    const textToCopy = document.getElementById(elementId).innerText.replace(/\s+/g, ''); 
    
    navigator.clipboard.writeText(textToCopy).then(() => {
        const originalText = btn.innerText;
        btn.innerText = 'Tersalin!';
        btn.classList.add('text-emerald-600', 'bg-emerald-50', 'dark:bg-emerald-900/30');
        btn.classList.remove('text-indigo-600');
        
        setTimeout(() => {
            btn.innerText = originalText;
            btn.classList.remove('text-emerald-600', 'bg-emerald-50', 'dark:bg-emerald-900/30');
            btn.classList.add('text-indigo-600');
        }, 2000);
    });
}
</script>

<style>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
@keyframes pulse-slow {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.85; }
}
.animate-pulse-slow {
    animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<?= $this->endSection() ?>