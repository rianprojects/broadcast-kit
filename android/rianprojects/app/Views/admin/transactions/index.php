<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Transactions</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Verifikasi pembayaran masuk untuk membuka akses prompt premium.</p>
        </div>
        
        <a href="<?= base_url('admin/withdrawals') ?>" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2 group active:scale-95">
            <i class="fa-solid fa-money-bill-transfer group-hover:-translate-y-1 transition-transform"></i> Kelola Withdraw
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="mb-6 p-4 bg-emerald-500/10 text-emerald-500 rounded-2xl border border-emerald-500/20 flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-xl"></i>
            <p class="text-sm font-bold"><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="mb-6 p-4 bg-rose-500/10 text-rose-500 rounded-2xl border border-rose-500/20 flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-xl"></i>
            <p class="text-sm font-bold"><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <div class="rounded-[2.5rem] border border-slate-800 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-500 text-[10px] uppercase tracking-[0.2em] border-b border-slate-800 bg-slate-900/50">
                        <th class="p-6 font-black">Date</th>
                        <th class="p-6 font-black">User Info</th>
                        <th class="p-6 font-black">Prompt Item</th>
                        <th class="p-6 font-black">Amount</th>
                        <th class="p-6 font-black">Proof</th>
                        <th class="p-6 font-black text-center">Status</th>
                        <th class="p-6 font-black text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="7" class="p-20 text-center text-slate-600">
                                <i class="fa-solid fa-receipt text-4xl mb-4 opacity-20"></i>
                                <p>Belum ada transaksi masuk.</p>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach($transactions as $t): ?>
                    <?php 
                        
                        $dbStatus = trim(strtolower($t['status']));
                        $displayStatus = (!empty($dbStatus)) ? $dbStatus : 'pending';
                    ?>
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <td class="p-6">
                            <span class="block text-sm font-bold text-white"><?= date('d M Y', strtotime($t['created_at'])) ?></span>
                            <span class="text-[10px] text-slate-500 uppercase"><?= date('H:i', strtotime($t['created_at'])) ?> WIB</span>
                        </td>
                        <td class="p-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-black text-[10px] border border-indigo-500/30">
                                    <?= substr(strtoupper($t['username']), 0, 1) ?>
                                </div>
                                <span class="text-sm font-bold text-white"><?= esc($t['username']) ?></span>
                            </div>
                        </td>
                        <td class="p-6 text-sm text-slate-400 font-medium">
                            <?= esc($t['prompt_title']) ?>
                        </td>
                        <td class="p-6 text-sm font-black text-emerald-400">
                            Rp <?= number_format($t['amount'], 0, ',', '.') ?>
                        </td>
                        <td class="p-6">
                            <?php if (!empty($t['proof_image'])): ?>
                                <a href="<?= base_url('uploads/proofs/' . $t['proof_image']) ?>" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-800 hover:bg-indigo-600 text-indigo-400 hover:text-white text-[10px] font-black rounded-lg transition-all border border-slate-700">
                                    <i class="fa-solid fa-image"></i> VIEW IMAGE
                                </a>
                            <?php elseif (!empty($t['merchant_ref'])): ?>
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-500/10 text-indigo-400 text-[10px] font-black rounded-lg border border-indigo-500/20">
                                    <i class="fa-solid fa-qrcode"></i> QRIS
                                </span>
                            <?php else: ?>
                                <span class="text-slate-600 text-[10px]">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-6 text-center">
                            <?php 
                                $badgeStyle = "bg-slate-800 text-slate-400 border-slate-700";
                                if($displayStatus == 'pending') $badgeStyle = "bg-amber-500/10 text-amber-500 border-amber-500/20";
                                if($displayStatus == 'approved' || $displayStatus == 'success') $badgeStyle = "bg-emerald-500/10 text-emerald-500 border-emerald-500/20";
                                if($displayStatus == 'rejected') $badgeStyle = "bg-rose-500/10 text-rose-500 border-rose-500/20";
                            ?>
                            <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border <?= $badgeStyle ?>">
                                <?= $displayStatus ?>
                            </span>
                        </td>
                        <td class="p-6">
                            <?php if($displayStatus == 'pending'): ?>
                                <div class="flex justify-center gap-2">
                                    <a href="<?= base_url('admin/transactions/approve/' . $t['id']) ?>" 
                                       onclick="return confirm('Konfirmasi pembayaran ini?')"
                                       class="w-10 h-10 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white shadow-lg shadow-emerald-500/20 flex items-center justify-center transition-all active:scale-90">
                                        <i class="fa-solid fa-check"></i>
                                    </a>

                                    <a href="<?= base_url('admin/transactions/reject/' . $t['id']) ?>" 
                                       onclick="return confirm('Tolak pembayaran ini?')"
                                       class="w-10 h-10 rounded-xl bg-rose-500 hover:bg-rose-600 text-white shadow-lg shadow-rose-500/20 flex items-center justify-center transition-all active:scale-90">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="flex justify-center">
                                    <div class="w-10 h-10 rounded-xl bg-slate-800 text-slate-600 flex items-center justify-center opacity-40 border border-slate-700">
                                        <i class="fa-solid fa-lock-open text-xs"></i>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>