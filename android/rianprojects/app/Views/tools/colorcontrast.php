<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto py-12 sm:py-16 px-4 sm:px-6 lg:px-8">

    <?= $this->include('components/breadcrumb') ?>
 
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center p-3 bg-violet-50 dark:bg-violet-900/30 rounded-2xl mb-4 text-violet-500">
            <i class="fa-solid fa-eye text-2xl sm:text-3xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3 font-outfit tracking-tight">
            Color Contrast <span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-500 to-pink-500">Checker</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base">Cek aksesibilitas warna sesuai standar WCAG 2.1 — AA & AAA</p>
    </div>


    <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6 sm:p-8 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-2">Warna Teks</label>
                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3">
                    <input type="color" id="fgColor" value="#ffffff" class="w-10 h-10 rounded-lg border-0 cursor-pointer bg-transparent p-0 flex-shrink-0">
                    <input type="text" id="fgHex" value="#FFFFFF" maxlength="7" class="flex-1 bg-transparent border-0 outline-none font-mono text-sm font-medium text-slate-700 dark:text-slate-200 uppercase">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-2">Warna Background</label>
                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3">
                    <input type="color" id="bgColor" value="#1a1a2e" class="w-10 h-10 rounded-lg border-0 cursor-pointer bg-transparent p-0 flex-shrink-0">
                    <input type="text" id="bgHex" value="#1A1A2E" maxlength="7" class="flex-1 bg-transparent border-0 outline-none font-mono text-sm font-medium text-slate-700 dark:text-slate-200 uppercase">
                </div>
            </div>
        </div>
    </div>


    <div id="preview" class="rounded-[2rem] p-10 text-center mb-6 border border-slate-200 dark:border-slate-800 transition-all duration-200">
        <span id="preview-text" class="block text-2xl font-bold mb-2">Teks Besar — Heading Contoh</span>
        <span id="preview-small" class="text-sm">Ini adalah contoh teks kecil untuk body copy. Pastikan mudah dibaca oleh semua pengguna.</span>
    </div>


    <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6 sm:p-8 mb-6">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="text-center bg-slate-50 dark:bg-slate-800 rounded-2xl p-4">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 mb-2">Rasio Kontras</p>
                <p class="font-mono text-2xl font-bold text-slate-800 dark:text-white mb-3" id="ratio">—</p>
                <div class="flex gap-1 justify-center flex-wrap" id="overall-badges"></div>
            </div>
            <div class="text-center bg-slate-50 dark:bg-slate-800 rounded-2xl p-4">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 mb-3">Teks Normal</p>
                <div class="flex gap-1 justify-center flex-wrap" id="normal-badges"></div>
            </div>
            <div class="text-center bg-slate-50 dark:bg-slate-800 rounded-2xl p-4">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 mb-3">Teks Besar</p>
                <div class="flex gap-1 justify-center flex-wrap" id="large-badges"></div>
            </div>
            <div class="text-center bg-slate-50 dark:bg-slate-800 rounded-2xl p-4">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 mb-3">UI Components</p>
                <div class="flex gap-1 justify-center flex-wrap" id="ui-badges"></div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-slate-900/80 rounded-2xl border border-slate-200 dark:border-slate-800 p-5">
            <p class="text-xs font-bold tracking-widest uppercase text-indigo-500 mb-2">WCAG AA</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Rasio ≥ 4.5:1 untuk teks normal, ≥ 3:1 untuk teks besar & UI. Standar minimum aksesibilitas web.</p>
        </div>
        <div class="bg-white dark:bg-slate-900/80 rounded-2xl border border-slate-200 dark:border-slate-800 p-5">
            <p class="text-xs font-bold tracking-widest uppercase text-violet-500 mb-2">WCAG AAA</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Rasio ≥ 7:1 untuk teks normal, ≥ 4.5:1 untuk teks besar. Standar aksesibilitas tertinggi.</p>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<style>
    .badge-pass { display:inline-flex;align-items:center;padding:.2rem .6rem;border-radius:9999px;font-size:.65rem;font-weight:700;background:rgba(16,185,129,.1);color:#10b981;border:1px solid rgba(16,185,129,.3); }
    .badge-fail { display:inline-flex;align-items:center;padding:.2rem .6rem;border-radius:9999px;font-size:.65rem;font-weight:700;background:rgba(239,68,68,.1);color:#ef4444;border:1px solid rgba(239,68,68,.3); }
</style>
<script>
    const fgPicker=document.getElementById('fgColor'),bgPicker=document.getElementById('bgColor'),fgHex=document.getElementById('fgHex'),bgHex=document.getElementById('bgHex');
    function hexToRgb(h){h=h.replace('#','');if(h.length===3)h=h.split('').map(c=>c+c).join('');const n=parseInt(h,16);return{r:(n>>16)&255,g:(n>>8)&255,b:n&255};}
    function lin(c){c/=255;return c<=0.03928?c/12.92:Math.pow((c+0.055)/1.055,2.4);}
    function lum({r,g,b}){return 0.2126*lin(r)+0.7152*lin(g)+0.0722*lin(b);}
    function contrast(fg,bg){const l1=lum(hexToRgb(fg)),l2=lum(hexToRgb(bg)),hi=Math.max(l1,l2),lo=Math.min(l1,l2);return(hi+0.05)/(lo+0.05);}
    function badge(text,pass){const b=document.createElement('span');b.className=pass?'badge-pass':'badge-fail';b.textContent=(pass?'✓ ':'✗ ')+text;return b;}
    function update(){
        const fg=fgHex.value,bg=bgHex.value;
        if(!/^#[0-9a-fA-F]{6}$/.test(fg)||!/^#[0-9a-fA-F]{6}$/.test(bg))return;
        document.getElementById('preview').style.background=bg;
        document.getElementById('preview').style.color=fg;
        const r=contrast(fg,bg);
        document.getElementById('ratio').textContent=r.toFixed(2)+':1';
        ['overall-badges','normal-badges','large-badges','ui-badges'].forEach(id=>document.getElementById(id).innerHTML='');
        document.getElementById('overall-badges').append(badge('AA',r>=4.5),badge('AAA',r>=7));
        document.getElementById('normal-badges').append(badge('AA',r>=4.5),badge('AAA',r>=7));
        document.getElementById('large-badges').append(badge('AA',r>=3),badge('AAA',r>=4.5));
        document.getElementById('ui-badges').append(badge('AA',r>=3),badge('AAA',r>=4.5));
    }
    fgPicker.addEventListener('input',e=>{fgHex.value=e.target.value.toUpperCase();update();});
    bgPicker.addEventListener('input',e=>{bgHex.value=e.target.value.toUpperCase();update();});
    fgHex.addEventListener('input',e=>{if(/^#[0-9a-fA-F]{6}$/.test(e.target.value)){fgPicker.value=e.target.value;update();}});
    bgHex.addEventListener('input',e=>{if(/^#[0-9a-fA-F]{6}$/.test(e.target.value)){bgPicker.value=e.target.value;update();}});
    update();
</script>
<?= $this->endSection() ?>