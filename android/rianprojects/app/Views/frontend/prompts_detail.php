<?= $this->extend('layouts/frontend') ?>

<?= $this->section('extra_head') ?>
    <meta property="og:title" content="<?= esc($p['title']) ?>">
    <meta property="og:description" content="<?= esc(strip_tags($p['description'] ?? substr($p['prompt'], 0, 100))) ?>">
    <meta property="og:image" content="<?= base_url('uploads/prompts/' . $p['image']) ?>">
    <meta property="og:type" content="article">
    <meta name="twitter:card" content="summary_large_image">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="pt-12 pb-20 min-h-screen transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 mb-12">
            
            <div class="lg:col-span-5">
                <div class="sticky top-28 bg-slate-100 dark:bg-slate-900 rounded-[2.5rem] p-2 shadow-2xl shadow-indigo-500/10 border border-slate-200 dark:border-slate-800 relative overflow-hidden group">
                    <img src="<?= base_url('uploads/prompts/' . $p['image']) ?>" class="w-full h-auto rounded-[2rem] transform group-hover:scale-[1.01] transition duration-700 ease-in-out" alt="<?= esc($p['title']) ?>">
                    <div class="absolute inset-0 pointer-events-none rounded-[2rem] ring-1 ring-inset ring-black/5 dark:ring-white/10"></div>
                </div>
            </div>

            <div class="lg:col-span-7 flex flex-col pt-2 lg:pt-0">
                
                <a href="<?= base_url('prompts') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest hover:underline mb-6 transition-colors w-max">
                    <i class="fa-solid fa-arrow-left"></i> Back to Library
                </a>

                <h1 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit leading-tight">
                    <?= esc($p['title']) ?>
                </h1>
                
                <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400 text-sm font-medium mb-8">
                    <span class="flex items-center gap-1"><i class="fa-solid fa-calendar-days text-xs"></i> <?= date('d M Y', strtotime($p['created_at'])) ?></span>
                    <span>•</span>
                    <span class="flex items-center gap-1"><i class="fa-solid fa-robot text-xs"></i> AI Generated</span>
                    
                    <?php if($p['type'] == 'premium'): ?>
                        <span>•</span>
                        <span class="text-amber-600 dark:text-amber-400 font-bold flex items-center gap-1"><i class="fa-solid fa-crown text-xs"></i> Premium</span>
                    <?php endif; ?>
                </div>

                <?php if($p['description']): ?>
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-book-open text-indigo-500"></i> Cara Penggunaan
                        </h3>
                        <div class="text-slate-600 dark:text-slate-300 leading-relaxed font-medium custom-prose whitespace-pre-line">
                            <?= esc($p['description']) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-terminal text-indigo-500"></i> Prompt Text
                        </h3>

                        <?php if($p['type'] == 'premium'): ?>
                            <span class="px-3 py-1 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-xs font-bold rounded-full border border-amber-200 dark:border-amber-700/50 flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-crown text-[10px]"></i> PREMIUM
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-xs font-bold rounded-full border border-emerald-200 dark:border-emerald-700/50 flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-check text-[10px]"></i> FREE ACCESS
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="relative group bg-slate-900 rounded-2xl overflow-hidden shadow-2xl ring-1 ring-slate-900/5">
                        <div class="flex gap-1.5 px-4 py-3 bg-slate-800/50 border-b border-white/5 items-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-rose-500/80"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-amber-500/80"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500/80"></div>
                            <div class="ml-auto text-[10px] font-mono text-slate-500">AI-Prompt-v1.0</div>
                        </div>

                        <?php if($isOwned): ?>
                            <textarea readonly class="w-full h-56 p-6 bg-transparent font-mono text-sm text-indigo-100 focus:outline-none resize-none leading-loose selection:bg-indigo-500/30 tracking-wide scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent"><?= esc(html_entity_decode(strip_tags($p['prompt']), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?></textarea>
                            
                            <button data-prompt="<?= esc(html_entity_decode(strip_tags($p['prompt']), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?>" onclick="copyDetailPrompt(this)" class="absolute bottom-4 right-4 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition-all flex items-center gap-2 active:scale-95 group/btn">
                                <i class="fa-regular fa-copy group-hover/btn:scale-110 transition-transform"></i> 
                                <span>Copy Prompt</span>
                            </button>
                        <?php else: ?>
                            <div class="relative w-full h-64 bg-slate-900 p-6 overflow-hidden">
                                <div class="font-mono text-sm text-slate-600 dark:text-slate-500 blur-[6px] select-none leading-loose break-words opacity-50">
                                    /imagine prompt: high quality realistic photo of <?= substr($p['slug'], 0, 20) ?>... cinematic lighting, 8k resolution, unreal engine render, detailed texture --v 6.0 --ar 16:9 --style raw... [LOCKED CONTENT] lorem ipsum dolor sit amet prompt hidden secure...
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-slate-900/40 backdrop-blur-[2px] flex flex-col items-center justify-center text-center p-6 z-10">
                                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-4 shadow-xl border border-slate-700 animate-pulse">
                                        <i class="fa-solid fa-lock text-2xl text-slate-400"></i>
                                    </div>
                                    <h3 class="text-white font-black text-xl mb-1">Premium Prompt</h3>
                                    <p class="text-slate-400 text-sm mb-6 max-w-xs">
                                        Buka akses penuh ke prompt original ini hanya dengan <br>
                                        <strong class="text-amber-400 text-lg">Rp <?= number_format($p['price'], 0, ',', '.') ?></strong>
                                    </p>
                                    <button type="button" onclick="openBuyModal()" class="group relative px-8 pb-8 pt-2 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-white font-bold rounded-xl shadow-xl shadow-orange-500/20 transition-all transform hover:scale-105 overflow-hidden">
                                        <div class="absolute inset-0 w-full h-full bg-white/20 -translate-x-full skew-x-12 group-hover:animate-shine"></div>
                                        <span class="relative flex items-center gap-2">
                                            <i class="fa-solid fa-unlock"></i> Beli Sekarang
                                        </span>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="border-t border-slate-200 dark:border-slate-800 my-10"></div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
            
            <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center gap-4 transition hover:border-indigo-200 dark:hover:border-slate-700">
                <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-md ring-2 ring-white dark:ring-slate-800">
                    <?= substr(strtoupper($p['creator_name']), 0, 1) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Created By</p>
                    <p class="font-bold text-slate-900 dark:text-white truncate"><?= esc($p['creator_name']) ?></p>
                </div>
                <div class="flex gap-2">
                    <?php if($p['social_instagram']): ?><a href="<?= $p['social_instagram'] ?>" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 text-slate-400 hover:text-pink-500 hover:bg-pink-50 dark:hover:bg-pink-900/20 transition shadow-sm border border-slate-200 dark:border-slate-700"><i class="fa-brands fa-instagram"></i></a><?php endif; ?>
                    <?php if($p['social_tiktok']): ?><a href="<?= $p['social_tiktok'] ?>" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 text-slate-400 hover:text-black dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-700 transition shadow-sm border border-slate-200 dark:border-slate-700"><i class="fa-brands fa-tiktok"></i></a><?php endif; ?>
                </div>
            </div>

            <div class="flex gap-3 h-full">
                <a href="https://wa.me/?text=<?= urlencode($p['title'] . ' ' . current_url()) ?>" target="_blank" class="flex-1 flex flex-col items-center justify-center bg-emerald-50 dark:bg-emerald-900/10 text-emerald-600 dark:text-emerald-400 rounded-2xl border border-emerald-100 dark:border-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition group">
                    <i class="fa-brands fa-whatsapp text-xl mb-1 group-hover:scale-110 transition-transform"></i>
                    <span class="text-[10px] font-bold uppercase tracking-wide">WhatsApp</span>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>&text=<?= urlencode('Check out this AI Prompt: ' . $p['title']) ?>" target="_blank" class="flex-1 flex flex-col items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700 transition group">
                    <i class="fa-brands fa-x-twitter text-xl mb-1 group-hover:scale-110 transition-transform"></i>
                    <span class="text-[10px] font-bold uppercase tracking-wide">Tweet</span>
                </a>
                <button onclick="navigator.clipboard.writeText(window.location.href); copyLinkFeedback(this)" class="flex-1 flex flex-col items-center justify-center bg-indigo-50 dark:bg-indigo-900/10 text-indigo-600 dark:text-indigo-400 rounded-2xl border border-indigo-100 dark:border-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition group">
                    <i class="fa-solid fa-link text-xl mb-1 group-hover:scale-110 transition-transform"></i>
                    <span class="text-[10px] font-bold uppercase tracking-wide">Copy Link</span>
                </button>
            </div>

        </div>

        <div class="mt-16 pt-10 border-t border-slate-200 dark:border-slate-800 max-w-5xl mx-auto">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-8 flex items-center gap-3">
                <i class="fa-regular fa-comments text-indigo-500"></i> Diskusi & Komentar
            </h3>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="mb-8 p-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-sm border border-emerald-200 dark:border-emerald-800 flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div class="mb-8 p-4 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm border border-rose-200 dark:border-rose-800 flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 mb-10 shadow-sm">
                <form action="<?= base_url('prompt/comment') ?>" method="post" class="space-y-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="prompt_id" value="<?= $p['id'] ?>">
                    
                    <div>
                        <input type="text" name="name" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition text-sm text-slate-800 dark:text-white" placeholder="Nama Kamu" required minlength="3" maxlength="50">
                    </div>
                    
                    <div>
                        <textarea name="comment" rows="3" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition text-sm text-slate-800 dark:text-white whitespace-pre-line" placeholder="Tulis komentar, pertanyaan, atau tanggapan... 🔥🚀✨" required minlength="5" maxlength="1000"></textarea>
                    </div>

                    <?php if(isset($site_key) && !empty($site_key)): ?>
                    <div class="flex">
                        <div class="g-recaptcha" data-sitekey="<?= $site_key ?>"></div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="text-right">
                        <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all active:scale-95 text-sm flex items-center justify-center gap-2 ml-auto">
                            Kirim Komentar <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <?php if(empty($comments)): ?>
                    <div class="text-center py-10 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-2xl">
                        <i class="fa-regular fa-face-smile text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Belum ada komentar. Jadilah yang pertama memberikan tanggapan!</p>
                    </div>
                <?php else: ?>
                    <?php foreach($comments as $c): ?>
                        <div class="flex gap-4 p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm relative group">
                            
                            <?php if(session()->get('role') == 'admin'): ?>
                                <form action="<?= base_url('prompt/deleteComment/' . $c['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus komentar ini?');" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 dark:bg-rose-900/30 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors" title="Hapus Komentar">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-sm shadow-sm ring-2 ring-white dark:ring-slate-800">
                                    <?= strtoupper(substr($c['name'], 0, 1)) ?>
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0 pr-8"> <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-2">
                                    <h4 class="font-bold text-slate-800 dark:text-white text-sm truncate"><?= esc($c['name']) ?></h4>
                                    <span class="text-[10px] font-medium text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md w-max">
                                        <i class="fa-regular fa-clock mr-1"></i><?= date('d M Y, H:i', strtotime($c['created_at'])) ?>
                                    </span>
                                </div>
                                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed whitespace-pre-line"><?= esc($c['comment']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>

function copyDetailPrompt(btn) {
    const textToCopy = btn.getAttribute('data-prompt');

    navigator.clipboard.writeText(textToCopy).then(() => {
        const originalContent = btn.innerHTML;
        const originalClass = btn.className;

        btn.innerHTML = '<i class="fa-solid fa-check"></i> <span>Copied!</span>';
        btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-500');
        btn.classList.add('bg-emerald-500', 'hover:bg-emerald-600');

        setTimeout(() => {
            btn.innerHTML = originalContent;
            btn.className = originalClass;
        }, 2000);
    }).catch(err => {
        console.error('Gagal mencopy teks: ', err);
        alert('Gagal menyalin teks!');
    });
}

function copyLinkFeedback(btn) {
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-check text-xl mb-1"></i><span class="text-[10px] font-bold uppercase tracking-wide">Copied!</span>';
    setTimeout(() => {
        btn.innerHTML = originalContent;
    }, 2000);
}
</script>

<?php if (!$isOwned && $p['type'] == 'premium'): ?>
<div id="buyModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeBuyModal()"></div>

    <div class="relative w-full max-w-md max-h-[90vh] overflow-y-auto bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6">
        <button type="button" onclick="closeBuyModal()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-white transition">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-lg font-black text-slate-900 dark:text-white mb-1">Beli Prompt</h3>
        <p class="text-slate-500 dark:text-slate-400 text-sm mb-5"><?= esc($p['title']) ?> — <strong class="text-amber-500">Rp <?= number_format($p['price'], 0, ',', '.') ?></strong></p>

        <?php if ($paymentMode === 'tripay'): ?>
            <div id="qrisBox" class="text-center py-6">
                <i class="fa-solid fa-spinner fa-spin text-3xl text-indigo-500 mb-3"></i>
                <p class="text-sm text-slate-500 dark:text-slate-400">Membuat kode QRIS...</p>
            </div>
        <?php else: ?>
            <?php if (empty($paymentMethods)): ?>
                <p class="text-sm text-rose-500">Belum ada metode pembayaran aktif. Hubungi admin.</p>
            <?php else: ?>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Pilih Metode Pembayaran</label>
                <select id="methodSelect" onchange="renderMethod(this.value)" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-800 dark:text-white mb-4 outline-none focus:border-indigo-500">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($paymentMethods as $m): ?>
                        <option value="<?= $m['id'] ?>"><?= esc($m['name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <div id="methodDetail" class="hidden mb-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center gap-3">
                    <img id="methodLogo" src="" alt="" class="w-10 h-10 object-contain rounded-lg bg-white p-1 border border-slate-200">
                    <div class="min-w-0">
                        <p id="methodAccName" class="font-bold text-sm text-slate-800 dark:text-white truncate"></p>
                        <p id="methodAccNumber" class="text-sm text-indigo-600 dark:text-indigo-400 font-mono"></p>
                    </div>
                </div>

                <form action="<?= base_url('transaction/process') ?>" method="post" enctype="multipart/form-data" class="space-y-3">
                    <?= csrf_field() ?>
                    <input type="hidden" name="prompt_id" value="<?= $p['id'] ?>">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Upload Bukti Transfer</label>
                        <input type="file" name="proof" accept="image/*" required class="w-full text-sm text-slate-600 dark:text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:text-white file:text-xs file:font-bold hover:file:bg-indigo-700">
                    </div>
                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition active:scale-95">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
const BUY_MODE = <?= json_encode($paymentMode) ?>;
const PROMPT_ID = <?= (int) $p['id'] ?>;
const PAYMENT_METHODS = <?= json_encode($paymentMethods ?? []) ?>;
let qrisPollTimer = null;

function openBuyModal() {
    const modal = document.getElementById('buyModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    if (BUY_MODE === 'tripay') createQris();
}

function closeBuyModal() {
    const modal = document.getElementById('buyModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    if (qrisPollTimer) clearInterval(qrisPollTimer);
}

function renderMethod(id) {
    const m = PAYMENT_METHODS.find(x => String(x.id) === String(id));
    const box = document.getElementById('methodDetail');
    if (!m) { box.classList.add('hidden'); return; }
    document.getElementById('methodLogo').src = m.logo ? '<?= base_url('uploads/payment_methods/') ?>' + m.logo : '';
    document.getElementById('methodAccName').textContent = m.account_name || m.name;
    document.getElementById('methodAccNumber').textContent = m.account_number || '';
    box.classList.remove('hidden');
}

function createQris() {
    const box = document.getElementById('qrisBox');
    const fd = new FormData();
    fd.append('prompt_id', PROMPT_ID);

    fetch('<?= base_url('transaction/qris/create') ?>', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            console.log('createQris response:', d);
            if (d.error || !d.qr_url || !d.merchant_ref) {
                box.innerHTML = '<p class="text-sm text-rose-500">' + (d.error || 'Gagal membuat QRIS: respon tidak lengkap.') + '</p>';
                return;
            }
            const ref = d.merchant_ref;
            box.innerHTML = '<img src="' + d.qr_url + '" class="w-56 h-56 mx-auto rounded-xl border border-slate-200 dark:border-slate-700 mb-3"><p class="text-xs text-slate-400 mb-1">Ref: ' + ref + '</p><p id="qrisStatus" class="text-sm font-bold text-amber-500"><i class="fa-solid fa-hourglass-half"></i> Menunggu pembayaran...</p>';

            qrisPollTimer = setInterval(() => {
                fetch('<?= base_url('transaction/status/') ?>' + ref)
                    .then(r => r.json())
                    .then(s => {
                        const statusEl = document.getElementById('qrisStatus');
                        if (s.status === 'approved') {
                            clearInterval(qrisPollTimer);
                            statusEl.innerHTML = '<span class="text-emerald-500"><i class="fa-solid fa-circle-check"></i> Pembayaran berhasil! Memuat ulang...</span>';
                            setTimeout(() => location.reload(), 1500);
                        } else if (s.status === 'rejected') {
                            clearInterval(qrisPollTimer);
                            statusEl.innerHTML = '<span class="text-rose-500"><i class="fa-solid fa-circle-xmark"></i> Pembayaran gagal/kadaluarsa.</span>';
                        }
                    });
            }, 5000);
        })
        .catch(() => { box.innerHTML = '<p class="text-sm text-rose-500">Gagal membuat QRIS. Coba lagi.</p>'; });
}
</script>
<?php endif; ?>

<?php if(isset($site_key) && !empty($site_key)): ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<style>
    @keyframes shine {
        100% { transform: translateX(200%) skewX(12deg); }
    }
    .group:hover .animate-shine {
        animation: shine 1s;
    }
</style>

<?= $this->endSection() ?>