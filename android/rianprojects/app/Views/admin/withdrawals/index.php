<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                <i class="fa-solid fa-money-bill-transfer"></i>
            </span>
            Permintaan Penarikan
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 ml-14">Kelola dan proses pencairan dana kreator.</p>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="mb-6 p-4 bg-emerald-50 text-emerald-600 rounded-xl text-sm border border-emerald-200"><i class="fa-solid fa-circle-check"></i> <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="mb-6 p-4 bg-rose-50 text-rose-600 rounded-xl text-sm border border-rose-200"><i class="fa-solid fa-triangle-exclamation"></i> <?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="rounded-3xl border border-slate-200/50 dark:border-slate-700/50 overflow-hidden bg-transparent shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
            <thead class="bg-slate-100/50 dark:bg-slate-800/50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200/50 dark:border-slate-700/50">
                <tr>
                    <th class="px-6 py-5">Tanggal</th>
                    <th class="px-6 py-5">User</th>
                    <th class="px-6 py-5">Rekening Tujuan</th>
                    <th class="px-6 py-5">Nominal Bersih</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100/50 dark:divide-slate-700/50">
                <?php foreach($withdrawals as $wd): ?>
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition">
                    <td class="px-6 py-4 text-xs font-mono"><?= date('d M Y, H:i', strtotime($wd['created_at'])) ?></td>
                    <td class="px-6 py-4 font-bold text-slate-800 dark:text-white"><?= esc($wd['username']) ?></td>
                    <td class="px-6 py-4">
                        <div class="text-xs">
                            <span class="font-bold text-indigo-500"><?= esc($wd['bank_name']) ?></span>
                            <p class="font-mono mt-0.5 text-slate-800 dark:text-slate-200"><?= esc($wd['bank_account']) ?></p>
                            <p class="text-slate-400">a.n <?= esc($wd['bank_account_name']) ?></p>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-black text-emerald-600 dark:text-emerald-400 text-lg">
                        Rp <?= number_format($wd['net_amount'], 0, ',', '.') ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php 
                            $badges = [
                                'pending'    => '<span class="px-3 py-1 bg-amber-100/50 text-amber-600 rounded-lg text-xs font-bold border border-amber-200/50">Pending</span>',
                                'completed'  => '<span class="px-3 py-1 bg-emerald-100/50 text-emerald-600 rounded-lg text-xs font-bold border border-emerald-200/50">Selesai</span>',
                                'rejected'   => '<span class="px-3 py-1 bg-rose-100/50 text-rose-600 rounded-lg text-xs font-bold border border-rose-200/50">Ditolak</span>',
                            ];
                            echo $badges[$wd['status']] ?? $wd['status'];
                        ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <?php if($wd['status'] == 'pending'): ?>
                            <div class="flex items-center justify-end gap-2">
                                <form action="<?= base_url('admin/withdrawals/process') ?>" method="post" onsubmit="return confirm('Pastikan Anda SUDAH MEN-TRANSFER uang ke rekening kreator sebelum menekan OK!')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $wd['id'] ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="p-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white rounded-lg transition" title="Tandai Sudah Ditransfer">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                
                                <button onclick="openRejectModal(<?= $wd['id'] ?>)" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white rounded-lg transition" title="Tolak & Refund Saldo">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        <?php else: ?>
                            <span class="text-xs text-slate-400 italic">Sudah diproses</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="rejectModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 w-full max-w-md shadow-2xl border border-slate-200 dark:border-slate-800 transform scale-95 transition-transform" id="modalBox">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Tolak Penarikan</h3>
        <p class="text-sm text-slate-500 mb-4">Uang akan dikembalikan ke saldo user. Silakan tulis alasan penolakan (misal: Nomor Rekening Salah).</p>
        
        <form action="<?= base_url('admin/withdrawals/process') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="rejectWdId" value="">
            <input type="hidden" name="action" value="reject">
            
            <textarea name="notes" rows="3" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 outline-none focus:border-rose-500 text-sm mb-4" required placeholder="Alasan penolakan..."></textarea>
            
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm font-bold transition">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold shadow-lg transition">Tolak & Refund</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(id) {
    document.getElementById('rejectWdId').value = id;
    const modal = document.getElementById('rejectModal');
    const box = document.getElementById('modalBox');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        box.classList.remove('scale-95');
        box.classList.add('scale-100');
    }, 50);
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    const box = document.getElementById('modalBox');
    
    box.classList.remove('scale-100');
    box.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 150);
}
</script>
<?= $this->endSection() ?>