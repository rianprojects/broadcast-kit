<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="pt-24 pb-20 min-h-screen">
    <div class="max-w-5xl mx-auto px-6">
        
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-6 text-white shadow-xl shadow-indigo-500/30 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                    <p class="text-indigo-100 text-sm font-medium mb-1">Total Saldo Aktif</p>
                    <h2 class="text-4xl font-black tracking-tight">Rp <?= number_format($user['balance'] ?? 0, 0, ',', '.') ?></h2>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-4">Tarik Dana (Withdraw)</h3>
                    
                    <?php 
                        $isBalanceEnough = (($user['balance'] ?? 0) >= 50000); 
                        $hasBankAccount = !empty($user['bank_name']) && !empty($user['bank_account']);
                        $isFormDisabled = (!$isBalanceEnough || !$hasBankAccount) ? 'disabled' : '';
                    ?>

                    <form action="<?= base_url('dashboard/wallet/withdraw') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <?php if(!$isBalanceEnough): ?>
                            <div class="mb-4 p-3 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-xl border border-amber-200 dark:border-amber-800/50 text-xs font-medium flex items-center gap-2">
                                <i class="fa-solid fa-circle-info"></i> Saldo Anda belum mencapai batas minimal penarikan (Rp 50.000).
                            </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase">Nominal (Min. Rp 50.000)</label>
                            <input type="number" id="wdAmount" name="amount" min="50000" max="<?= $user['balance'] ?? 0 ?>" 
                            class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 outline-none focus:border-indigo-500 text-slate-800 dark:text-white font-bold disabled:opacity-50 disabled:cursor-not-allowed" 
                            placeholder="50000" required onkeyup="calculateWD()" <?= $isFormDisabled ?>>
                        </div>

                        <div class="mb-6 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 text-xs">
                            <p class="text-slate-500 mb-1">Cair ke rekening:</p>
                            <?php if($hasBankAccount): ?>
                                <p class="font-bold text-slate-800 dark:text-white"><?= esc($user['bank_name']) ?> - <?= esc($user['bank_account']) ?></p>
                                <p class="text-slate-600 dark:text-slate-400">a.n <?= esc($user['bank_account_name']) ?></p>
                            <?php else: ?>
                                <p class="text-rose-500 mb-2 font-bold">Rekening pencairan belum diatur!</p>
                                <a href="<?= base_url('dashboard/settings') ?>" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg font-bold hover:bg-indigo-100 transition-colors">
                                    <i class="fa-solid fa-gear"></i> Atur Rekening Sekarang
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="mb-6 p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl text-sm font-mono text-slate-600 dark:text-slate-400 space-y-2">
                            <div class="flex justify-between"><span>Nominal:</span> <span id="txtNominal">Rp 0</span></div>
                            <div class="flex justify-between text-rose-500"><span>Biaya (Flat):</span> <span id="txtFlat">- Rp 0</span></div>
                            <div class="flex justify-between text-rose-500 border-b border-indigo-200/50 pb-2 mb-2"><span>Biaya (3%):</span> <span id="txtPercent">- Rp 0</span></div>
                            <div class="flex justify-between font-bold text-emerald-600 dark:text-emerald-400"><span>Diterima Bersih:</span> <span id="txtNet">Rp 0</span></div>
                        </div>

                        <button type="submit" 
                            class="w-full py-3 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:active:scale-100 <?= $isFormDisabled ? 'bg-slate-400 dark:bg-slate-700 shadow-none' : 'bg-slate-900 dark:bg-indigo-600 hover:bg-slate-800 dark:hover:bg-indigo-700' ?>" 
                            <?= $isFormDisabled ?>>
                            Ajukan Penarikan
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 h-full">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-6 text-lg">Riwayat Penarikan</h3>
                    
                    <?php if(empty($withdrawals)): ?>
                        <div class="text-center py-10 text-slate-400">
                            <i class="fa-solid fa-receipt text-4xl mb-3"></i>
                            <p>Belum ada riwayat penarikan dana.</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach($withdrawals as $wd): ?>
                                <div class="p-4 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <p class="font-bold text-slate-800 dark:text-white text-lg">Rp <?= number_format($wd['net_amount'], 0, ',', '.') ?></p>
                                        <p class="text-xs text-slate-500 mt-1"><?= date('d M Y, H:i', strtotime($wd['created_at'])) ?> • <?= esc($wd['bank_name']) ?></p>
                                        <?php if($wd['status'] == 'rejected' && $wd['notes']): ?>
                                            <p class="text-xs text-rose-500 mt-1 italic">Alasan tolak: <?= esc($wd['notes']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <?php 
                                            $badges = [
                                                'pending'    => '<span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold"><i class="fa-solid fa-clock"></i> Pending</span>',
                                                'processing' => '<span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-bold"><i class="fa-solid fa-spinner animate-spin"></i> Proses</span>',
                                                'completed'  => '<span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold"><i class="fa-solid fa-check"></i> Sukses</span>',
                                                'rejected'   => '<span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold"><i class="fa-solid fa-xmark"></i> Ditolak</span>',
                                            ];
                                            echo $badges[$wd['status']];
                                        ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function calculateWD() {
    let amount = document.getElementById('wdAmount').value;
    amount = amount ? parseInt(amount) : 0;

    let transferFee = 0;
    let platformFee = 0;
    let netAmount = 0;

    if (amount >= 50000) {
        transferFee = (amount > 1000000) ? 0 : 7500;
        platformFee = Math.round(amount * 0.03);
        netAmount = amount - transferFee - platformFee;
    }

    const formatRp = (angka) => 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    document.getElementById('txtNominal').innerText = formatRp(amount);
    document.getElementById('txtFlat').innerText = '- ' + formatRp(transferFee);
    document.getElementById('txtPercent').innerText = '- ' + formatRp(platformFee);
    document.getElementById('txtNet').innerText = netAmount > 0 ? formatRp(netAmount) : 'Rp 0';
}
</script>
<?= $this->endSection() ?>