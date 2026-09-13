<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="pt-28 pb-20 min-h-screen">
    <div class="max-w-md mx-auto px-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl border border-slate-200 dark:border-slate-800 p-8 text-center">
            <h1 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Scan QRIS</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Buka aplikasi e-wallet / m-banking, lalu scan kode di bawah.</p>

            <div class="p-4 bg-white rounded-2xl border border-slate-200 dark:border-slate-700 inline-block mb-4">
                <img src="<?= esc($trx['qr_url']) ?>" alt="QRIS" class="w-56 h-56 object-contain">
            </div>

            <div class="flex justify-between items-center bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-xl border border-indigo-100 dark:border-indigo-800/50 mb-6">
                <span class="text-sm font-bold text-slate-600 dark:text-slate-400">Total Bayar:</span>
                <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">Rp <?= number_format($p['price'], 0, ',', '.') ?></span>
            </div>

            <p id="status-text" class="text-sm font-bold text-amber-500 mb-4">
                <i class="fa-solid fa-spinner fa-spin"></i> Menunggu pembayaran...
            </p>

            <a href="<?= base_url('prompt/' . $p['slug']) ?>" class="block text-center text-sm font-bold text-slate-400 hover:text-rose-500 transition-colors">Batal & Kembali</a>
        </div>
    </div>
</div>

<script>
const merchantRef = <?= json_encode($trx['merchant_ref']) ?>;
const redirectUrl = <?= json_encode(base_url('prompt/' . $p['slug'])) ?>;

const poll = setInterval(() => {
    fetch('<?= base_url('transaction/status/') ?>' + merchantRef)
        .then(r => r.json())
        .then(d => {
            if (d.status === 'approved') {
                clearInterval(poll);
                document.getElementById('status-text').innerHTML = '<i class="fa-solid fa-circle-check"></i> Pembayaran berhasil! Mengalihkan...';
                document.getElementById('status-text').classList.replace('text-amber-500', 'text-emerald-500');
                setTimeout(() => window.location.href = redirectUrl, 1500);
            } else if (d.status === 'rejected') {
                clearInterval(poll);
                document.getElementById('status-text').innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Pembayaran gagal / kedaluwarsa.';
                document.getElementById('status-text').classList.replace('text-amber-500', 'text-rose-500');
            }
        })
        .catch(() => {});
}, 5000);
</script>

<?= $this->endSection() ?>
