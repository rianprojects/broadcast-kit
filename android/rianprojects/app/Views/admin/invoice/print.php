<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?= $invoice['invoice_number'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>

        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        @media print {

            @page { size: landscape; margin: 15mm; }
            
            body { 
                background: #fff !important; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
                padding: 0 !important; 
            }

            .no-print { display: none !important; }
            .main-container { 
                width: 100% !important; 
                max-width: none !important; 
                border: none !important; 
                box-shadow: none !important; 
                padding: 15mm !important;
                margin: 0 !important;
                border-radius: 0 !important;

            .header-area { margin-bottom: 5mm !important; }
            .items-table th, .items-table td { padding-top: 2mm !important; padding-bottom: 2mm !important; }
        }
    </style>
</head>
<body class="bg-white p-0 sm:p-5 text-slate-800">

    <div class="max-w-[1120px] mx-auto mb-5 text-right no-print">
        <button onclick="window.print()" class="bg-violet-600 text-white font-bold py-2 px-5 rounded-lg shadow hover:bg-violet-700 transition text-sm">
            Cetak / Download PDF
        </button>
    </div>

    <div class="main-container max-w-[1120px] mx-auto bg-white p-8 rounded-none relative overflow-hidden">
        
        <div class="header-area flex justify-between items-center border-b border-slate-100 pb-5 mb-6 relative z-10">
            <div class="flex items-center gap-4">
                <img src="<?= base_url('assets/rp.png') ?>" class="h-12 w-auto object-contain flex-shrink-0" alt="Logo">
                
                <div>
                    <h1 class="text-2xl font-black text-violet-600 tracking-tight font-outfit leading-none mb-1"><?= esc($setting['company_name'] ?? 'Perusahaan') ?></h1>
                    <p class="text-[11px] font-semibold text-slate-500 tracking-wide leading-tight"><?= esc($setting['company_tagline'] ?? '') ?></p>
                    <p class="text-[11px] text-slate-400 mt-1 leading-normal"><?= nl2br(esc($setting['company_address'] ?? '')) ?></p>
                </div>
            </div>
            <div class="text-right flex flex-col items-end">
                <h2 class="text-2xl font-black text-slate-200 uppercase tracking-widest mb-2 font-outfit">Invoice</h2>
                <p class="text-sm font-bold text-slate-800 mb-1">No: <span class="text-violet-600"><?= $invoice['invoice_number'] ?></span></p>
                <div class="text-[11px] font-medium text-slate-500 space-y-0.5">
                    <p>Tanggal: <?= date('d M Y', strtotime($invoice['issue_date'])) ?></p>
                    <?php if($invoice['due_date']): ?>
                    <p>Jatuh Tempo: <span class="text-rose-500 font-bold"><?= date('d M Y', strtotime($invoice['due_date'])) ?></span></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 mb-8 relative z-10">
            
            <div class="col-span-8 space-y-6">
                <div class="bg-slate-50/50 p-5 rounded-xl border border-slate-100 inline-block min-w-[280px]">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Tagihan Kepada:</p>
                    <h3 class="text-base font-bold text-slate-800 font-outfit leading-none"><?= esc($invoice['name']) ?></h3>
                    <?php if($invoice['phone']): ?><p class="text-xs font-medium text-slate-600 mt-1.5 leading-none"><?= esc($invoice['phone']) ?></p><?php endif; ?>
                    <?php if($invoice['email']): ?><p class="text-xs font-medium text-slate-600 mt-0.5 leading-none"><?= esc($invoice['email']) ?></p><?php endif; ?>
                    <?php if($invoice['address']): ?><p class="text-xs text-slate-500 mt-1.5 max-w-xs leading-relaxed"><?= nl2br(esc($invoice['address'])) ?></p><?php endif; ?>
                </div>

                <div class="items-table overflow-hidden rounded-lg border border-slate-100 shadow-sm bg-white">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-violet-600 text-white font-bold text-[10px] uppercase tracking-wider font-outfit">
                                <th class="py-3 px-4 w-1/2">Deskripsi Jasa / Produk</th>
                                <th class="py-3 px-4 text-center w-20">Qty</th>
                                <th class="py-3 px-4 text-right w-40">Harga</th>
                                <th class="py-3 px-4 text-right w-40">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            <?php foreach($items as $item): ?>
                            <tr>
                                <td class="py-3 px-4 font-semibold"><?= esc($item['item_name']) ?></td>
                                <td class="py-3 px-4 text-center font-medium"><?= $item['quantity'] ?></td>
                                <td class="py-3 px-4 text-right font-medium">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                <td class="py-3 px-4 text-right font-black text-slate-800">Rp <?= number_format($item['total'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-span-4 space-y-6">
                <div class="space-y-2.5">
                    <div class="flex justify-between text-xs px-2">
                        <span class="text-slate-500 font-semibold">Subtotal</span>
                        <span class="text-slate-800 font-bold">Rp <?= number_format($invoice['subtotal'], 0, ',', '.') ?></span>
                    </div>
                    <?php if($invoice['discount'] > 0): ?>
                    <div class="flex justify-between text-xs px-2">
                        <span class="text-slate-500 font-semibold">Diskon</span>
                        <span class="text-rose-500 font-bold">- Rp <?= number_format($invoice['discount'], 0, ',', '.') ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if($invoice['tax'] > 0): ?>
                    <div class="flex justify-between text-xs px-2 border-b border-slate-100 pb-2.5">
                        <span class="text-slate-500 font-semibold">Pajak (PPN)</span>
                        <span class="text-slate-800 font-bold">Rp <?= number_format($invoice['tax'], 0, ',', '.') ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex justify-between items-center bg-violet-50/50 p-4 rounded-xl border border-violet-100">
                        <span class="text-violet-800 font-black uppercase tracking-widest text-[10px]">Total Tagihan</span>
                        <span class="text-violet-600 font-black text-xl font-outfit tracking-tight">Rp <?= number_format($invoice['total_amount'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <?php
                $accounts = json_decode($setting['bank_account'] ?? '[]', true);
                if (!is_array($accounts)) $accounts = [];
                ?>
                <?php if(!empty($accounts)): ?>
                <div class="bg-white p-1 rounded-xl">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 border-b border-slate-100 pb-2">Instruksi Pembayaran:</p>
                    <div class="space-y-3">
                        <?php foreach($accounts as $acc): ?>
                            <?php if(empty($acc['bank']) && empty($acc['number'])) continue; ?>
                            
                            <div class="bg-white border border-slate-100 p-3 rounded-xl flex items-center gap-3 shadow-sm hover:border-violet-100 transition">
                                <?php if(!empty($acc['icon'])): ?>
                                    <img src="<?= base_url($acc['icon']) ?>" class="h-8 w-11 object-contain rounded" alt="<?= esc($acc['bank']) ?>">
                                <?php else: ?>
                                    <div class="h-8 w-11 bg-violet-50 border border-violet-100 rounded-lg flex items-center justify-center font-black text-violet-500 text-base uppercase shadow-inner flex-shrink-0 font-outfit">
                                        <?= esc(substr($acc['bank'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex flex-col justify-center leading-none">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 leading-none"><?= esc($acc['bank']) ?></p>
                                    <p class="text-xs font-black text-slate-800 leading-none mb-1 font-outfit tracking-wider"><?= esc($acc['number']) ?></p>
                                    <p class="text-[9px] font-bold text-slate-500 leading-none">a/n <?= esc($acc['owner']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-auto relative z-10 border-t border-slate-100 pt-5">
            <div class="flex justify-between items-start gap-10">
                <?php if($invoice['notes']): ?>
                <div class="flex-1 max-w-2xl">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Catatan Tambahan:</p>
                    <p class="text-xs font-medium text-slate-600 leading-relaxed"><?= nl2br(esc($invoice['notes'])) ?></p>
                </div>
                <?php else: ?>
                    <div></div>
                <?php endif; ?>
                
                <div class="text-right text-[10px] text-slate-400 flex-shrink-0 pt-3">
                    <p>Terima kasih atas kepercayaan Anda.</p>
                    <p class="font-bold text-violet-500/80 mt-0.5"><?= esc($setting['company_name'] ?? '') ?></p>
                </div>
            </div>
        </div>

        <?php if($invoice['status'] === 'paid'): ?>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -rotate-12 opacity-[0.03] pointer-events-none z-0">
            <h1 class="text-[160px] font-black text-violet-600 uppercase border-[14px] border-violet-600 px-12 py-3 rounded-[3.5rem] font-outfit tracking-tighter">LUNAS</h1>
        </div>
        <?php endif; ?>

    </div>

</body>
</html>