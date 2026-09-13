<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto py-12 sm:py-16 px-4 sm:px-6 lg:px-8">

     <?= $this->include('components/breadcrumb') ?>

    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center p-3 bg-orange-50 dark:bg-orange-900/30 rounded-2xl mb-4 text-orange-500">
            <i class="fa-solid fa-palette text-2xl sm:text-3xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3 font-outfit tracking-tight">
            CSS Gradient <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-pink-500">Generator</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base">Buat gradient CSS cantik, copy kode-nya langsung pakai</p>
    </div>

    <div id="gradient-preview" class="w-full h-56 sm:h-72 rounded-[2rem] mb-6 border border-slate-200 dark:border-slate-800 transition-all duration-150"></div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-4">

            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-3">Tipe Gradient</p>
                <div class="flex gap-2 mb-5">
                    <button class="tab flex-1 py-2 rounded-xl text-sm font-bold border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:border-indigo-400 transition-all active-tab" data-type="linear">Linear</button>
                    <button class="tab flex-1 py-2 rounded-xl text-sm font-bold border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:border-indigo-400 transition-all" data-type="radial">Radial</button>
                    <button class="tab flex-1 py-2 rounded-xl text-sm font-bold border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:border-indigo-400 transition-all" data-type="conic">Conic</button>
                </div>
                <div id="angle-row" class="flex items-center gap-4">
                    <label class="text-sm font-semibold text-slate-500 dark:text-slate-400 min-w-[52px]">Sudut</label>
                    <input type="range" id="angle" min="0" max="360" value="135" class="flex-1 accent-indigo-500 cursor-pointer">
                    <span class="font-mono text-sm font-semibold text-slate-700 dark:text-slate-200 min-w-[40px] text-right" id="angle-val">135°</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-4">Color Stops</p>
                <div id="stops" class="space-y-3"></div>
                <button id="add-stop" class="mt-3 w-full py-2.5 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-400 hover:border-indigo-400 hover:text-indigo-500 transition-all">
                    + Tambah Warna
                </button>
            </div>

        </div>

        <div class="space-y-4">
            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-3">Preset</p>
                <div id="presets" class="grid grid-cols-4 gap-2"></div>
            </div>
            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-3">CSS Output</p>
                <div class="relative bg-slate-900 dark:bg-slate-950 rounded-2xl p-4">
                    <code id="css-output" class="text-xs font-mono text-slate-300 leading-relaxed break-all"></code>
                    <button id="copy-btn" class="absolute top-3 right-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">Copy</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<style>
    .active-tab { background: #4f46e5 !important; color: #fff !important; border-color: #4f46e5 !important; }
    .stop-item { display:flex;align-items:center;gap:.6rem;background:var(--stop-bg,#f8fafc);border:1.5px solid #e2e8f0;border-radius:14px;padding:.5rem .8rem; }
    .dark .stop-item { background:#1e293b;border-color:#334155; }
    .stop-item input[type=color] { width:32px;height:32px;border:none;border-radius:8px;cursor:pointer;background:none;padding:0;flex-shrink:0; }
    .stop-item input[type=text] { width:80px;background:none;border:none;outline:none;font-family:monospace;font-size:.8rem;text-transform:uppercase; }
    .stop-item .stop-pos { font-family:monospace;font-size:.72rem;color:#94a3b8;min-width:32px;text-align:right; }
    .rm-stop { background:none;border:1.5px solid #e2e8f0;border-radius:50%;width:22px;height:22px;cursor:pointer;font-size:.85rem;color:#94a3b8;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .dark .rm-stop { border-color:#334155; }
    .rm-stop:hover { background:#fee2e2;border-color:#fca5a5;color:#ef4444; }
    .preset-swatch { height:44px;border-radius:12px;cursor:pointer;border:2px solid transparent;transition:transform .1s,border-color .15s; }
    .preset-swatch:hover { transform:scale(1.08);border-color:#1e293b; }
</style>
<script>
    let type='linear',angle=135;
    let stops=[{color:'#f97316',hex:'#F97316',pos:0},{color:'#ec4899',hex:'#EC4899',pos:50},{color:'#6366f1',hex:'#6366F1',pos:100}];
    const presets=[['#f97316','#ec4899','#6366f1'],['#00c9ff','#92fe9d'],['#f7971e','#ffd200'],['#ee0979','#ff6a00'],['#0f3443','#34e89e'],['#c94b4b','#4b134f'],['#667eea','#764ba2'],['#1a1a2e','#e94560']];
    function buildGrad(){const s=stops.map(s=>`${s.color} ${s.pos}%`).join(', ');return type==='linear'?`linear-gradient(${angle}deg, ${s})`:type==='radial'?`radial-gradient(circle, ${s})`:`conic-gradient(from ${angle}deg, ${s})`;}
    function render(){
        const g=buildGrad();
        document.getElementById('gradient-preview').style.background=g;
        document.getElementById('css-output').textContent=`background: ${g};`;
        renderStops();
    }
    function renderStops(){
        const c=document.getElementById('stops');c.innerHTML='';
        stops.forEach((stop,i)=>{
            const d=document.createElement('div');d.className='stop-item';
            d.innerHTML=`<input type="color" value="${stop.color}" data-i="${i}" class="sc"><input type="text" value="${stop.hex}" data-i="${i}" class="sh" maxlength="7"><input type="range" min="0" max="100" value="${stop.pos}" data-i="${i}" class="sp" style="flex:1;accent-color:#6366f1"><span class="stop-pos">${stop.pos}%</span>${stops.length>2?`<button class="rm-stop" data-i="${i}">×</button>`:''}`;
            c.appendChild(d);
        });
        c.querySelectorAll('.sc').forEach(el=>el.addEventListener('input',e=>{const i=+e.target.dataset.i;stops[i].color=e.target.value;stops[i].hex=e.target.value.toUpperCase();render();}));
        c.querySelectorAll('.sh').forEach(el=>el.addEventListener('input',e=>{if(/^#[0-9a-fA-F]{6}$/.test(e.target.value)){stops[+e.target.dataset.i].color=e.target.value;stops[+e.target.dataset.i].hex=e.target.value.toUpperCase();render();}}));
        c.querySelectorAll('.sp').forEach(el=>el.addEventListener('input',e=>{stops[+e.target.dataset.i].pos=+e.target.value;e.target.nextElementSibling.textContent=e.target.value+'%';render();}));
        c.querySelectorAll('.rm-stop').forEach(el=>el.addEventListener('click',e=>{stops.splice(+e.target.dataset.i,1);render();}));
    }
    document.querySelectorAll('.tab').forEach(t=>t.addEventListener('click',e=>{document.querySelectorAll('.tab').forEach(x=>x.classList.remove('active-tab'));e.target.classList.add('active-tab');type=e.target.dataset.type;document.getElementById('angle-row').style.display=type==='radial'?'none':'flex';render();}));
    document.getElementById('angle').addEventListener('input',e=>{angle=+e.target.value;document.getElementById('angle-val').textContent=angle+'°';render();});
    document.getElementById('add-stop').addEventListener('click',()=>{stops.push({color:'#ffffff',hex:'#FFFFFF',pos:75});render();});
    const pc=document.getElementById('presets');
    presets.forEach(colors=>{const b=document.createElement('div');b.className='preset-swatch';b.style.background=`linear-gradient(135deg,${colors.join(',')})`;b.addEventListener('click',()=>{stops=colors.map((c,i)=>({color:c,hex:c.toUpperCase(),pos:Math.round(i/(colors.length-1)*100)}));render();});pc.appendChild(b);});
    document.getElementById('copy-btn').addEventListener('click',()=>{navigator.clipboard.writeText(document.getElementById('css-output').textContent);const b=document.getElementById('copy-btn');b.textContent='✓ Copied!';setTimeout(()=>b.textContent='Copy',1500);});
    render();
</script>
<?= $this->endSection() ?>