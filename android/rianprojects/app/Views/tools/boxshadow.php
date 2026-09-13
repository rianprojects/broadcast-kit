<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto py-12 sm:py-16 px-4 sm:px-6 lg:px-8">

    <?= $this->include('components/breadcrumb') ?>

    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center p-3 bg-purple-50 dark:bg-purple-900/30 rounded-2xl mb-4 text-purple-500">
            <i class="fa-solid fa-layer-group text-2xl sm:text-3xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3 font-outfit tracking-tight">
            Box Shadow <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-blue-500">Generator</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base">Generate CSS box-shadow visual & interaktif — multi-layer, inset, blur & spread</p>
    </div>

    <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-8 mb-6 flex items-center justify-center min-h-[220px] relative overflow-hidden" id="preview-area">
        <div class="absolute inset-0 opacity-30" style="background-image:radial-gradient(#c7d2fe 1px,transparent 1px);background-size:22px 22px;"></div>
        <div id="preview-box" class="w-40 h-28 bg-white dark:bg-slate-700 rounded-2xl relative z-10 transition-shadow duration-150"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500">Shadow Layers</p>
                    <span class="text-xs font-bold text-slate-400" id="layer-count">1 layer</span>
                </div>
                <div id="layers" class="space-y-4"></div>
                <button id="add-layer" class="mt-4 w-full py-2.5 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-400 hover:border-purple-400 hover:text-purple-500 transition-all">
                    + Tambah Shadow Layer
                </button>
            </div>
        </div>

        <div class="space-y-4">

            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-3">Background Preview</p>
                <div id="bg-swatches" class="flex gap-2 flex-wrap"></div>
            </div>

            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-3">CSS Output</p>
                <div class="relative bg-slate-900 dark:bg-slate-950 rounded-2xl p-4">
                    <code id="css-out" class="text-xs font-mono text-slate-300 leading-relaxed break-all whitespace-pre-wrap"></code>
                    <button id="copy-btn" class="absolute top-3 right-3 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">Copy</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<style>
    .layer-card { background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:16px;padding:1rem; }
    .dark .layer-card { background:#1e293b;border-color:#334155; }
    .slider-grid { display:grid;grid-template-columns:80px 1fr 48px;align-items:center;gap:.5rem;margin-bottom:.5rem; }
    .slider-grid label { font-size:.75rem;color:#94a3b8;font-weight:500; }
    .slider-grid .num { font-family:monospace;font-size:.75rem;text-align:right;color:#64748b; }
    .dark .slider-grid .num { color:#94a3b8; }
    .inset-btn { font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:8px;border:1.5px solid #e2e8f0;background:none;cursor:pointer;color:#94a3b8;transition:all .15s; }
    .dark .inset-btn { border-color:#334155; }
    .inset-btn.on { background:#7c3aed;color:#fff;border-color:#7c3aed; }
    .rm-layer { background:none;border:none;cursor:pointer;color:#94a3b8;font-size:1rem;padding:.2rem; }
    .rm-layer:hover { color:#ef4444; }
    .bg-swatch { width:28px;height:28px;border-radius:8px;cursor:pointer;border:2px solid transparent;transition:transform .1s; }
    .bg-swatch:hover { transform:scale(1.1); }
    .bg-swatch.active { border-color:#6366f1; }
    .color-pick-row { display:flex;align-items:center;gap:.5rem;margin-top:.5rem; }
    .color-pick-row label { font-size:.75rem;color:#94a3b8;font-weight:500;min-width:80px; }
    .color-pick-inner { display:flex;align-items:center;gap:.5rem;background:#f1f5f9;border:1.5px solid #e2e8f0;border-radius:10px;padding:.3rem .6rem;flex:1; }
    .dark .color-pick-inner { background:#0f172a;border-color:#334155; }
    .color-pick-inner input[type=color] { width:26px;height:26px;border:none;border-radius:6px;cursor:pointer;background:none;padding:0; }
    .color-pick-inner input[type=text] { background:none;border:none;outline:none;font-family:monospace;font-size:.78rem;width:70px; }
</style>
<script>
    const lColors=['#a78bfa','#f472b6','#38bdf8','#4ade80','#fb923c'];
    const bgOptions=['#ffffff','#f8fafc','#0f172a','#1e293b','#f0fdf4','#fdf4ff'];
    let layers=[{x:0,y:8,blur:24,spread:-4,color:'#a78bfa',opacity:35,inset:false}];
    let bgColor='#ffffff';

    function hexToRgba(hex,op){hex=hex.replace('#','');const n=parseInt(hex,16),r=(n>>16)&255,g=(n>>8)&255,b=n&255;return`rgba(${r},${g},${b},${op/100})`;}
    function buildShadow(){return layers.map(l=>`${l.inset?'inset ':''}${l.x}px ${l.y}px ${l.blur}px ${l.spread}px ${hexToRgba(l.color,l.opacity)}`).join(',\n     ');}

    function render(){
        const s=buildShadow();
        document.getElementById('preview-box').style.boxShadow=s;
        document.getElementById('css-out').textContent=`box-shadow: ${s};`;
        document.getElementById('layer-count').textContent=layers.length+' layer'+(layers.length>1?'s':'');
        renderLayers();
    }

    function renderLayers(){
        const c=document.getElementById('layers');c.innerHTML='';
        layers.forEach((l,i)=>{
            const col=lColors[i%lColors.length];
            const d=document.createElement('div');d.className='layer-card';
            d.innerHTML=`
                <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.8rem;">
                    <div style="width:12px;height:12px;border-radius:50%;background:${col};flex-shrink:0;"></div>
                    <span style="font-size:.85rem;font-weight:700;flex:1;">Shadow ${i+1}</span>
                    <button class="inset-btn${l.inset?' on':''}" data-i="${i}">Inset</button>
                    ${layers.length>1?`<button class="rm-layer" data-i="${i}">🗑</button>`:''}
                </div>
                <div class="slider-grid"><label>X Offset</label><input type="range" min="-100" max="100" value="${l.x}" data-i="${i}" data-k="x" style="accent-color:${col}"><span class="num">${l.x}px</span></div>
                <div class="slider-grid"><label>Y Offset</label><input type="range" min="-100" max="100" value="${l.y}" data-i="${i}" data-k="y" style="accent-color:${col}"><span class="num">${l.y}px</span></div>
                <div class="slider-grid"><label>Blur</label><input type="range" min="0" max="150" value="${l.blur}" data-i="${i}" data-k="blur" style="accent-color:${col}"><span class="num">${l.blur}px</span></div>
                <div class="slider-grid"><label>Spread</label><input type="range" min="-50" max="50" value="${l.spread}" data-i="${i}" data-k="spread" style="accent-color:${col}"><span class="num">${l.spread}px</span></div>
                <div class="color-pick-row"><label>Warna</label><div class="color-pick-inner"><input type="color" value="${l.color}" data-i="${i}" class="lc"><input type="text" value="${l.color.toUpperCase()}" data-i="${i}" class="lh" maxlength="7"></div></div>
                <div class="slider-grid" style="margin-top:.5rem;"><label>Opacity</label><input type="range" min="0" max="100" value="${l.opacity}" data-i="${i}" data-k="opacity" style="accent-color:${col}"><span class="num">${l.opacity}%</span></div>`;
            c.appendChild(d);
        });
        c.querySelectorAll('input[type=range]').forEach(el=>el.addEventListener('input',e=>{
            layers[+e.target.dataset.i][e.target.dataset.k]=+e.target.value;
            e.target.nextElementSibling.textContent=e.target.value+(e.target.dataset.k==='opacity'?'%':'px');
            render();
        }));
        c.querySelectorAll('.lc').forEach(el=>el.addEventListener('input',e=>{layers[+e.target.dataset.i].color=e.target.value;render();}));
        c.querySelectorAll('.lh').forEach(el=>el.addEventListener('input',e=>{if(/^#[0-9a-fA-F]{6}$/.test(e.target.value)){layers[+e.target.dataset.i].color=e.target.value;render();}}));
        c.querySelectorAll('.inset-btn').forEach(el=>el.addEventListener('click',e=>{layers[+e.target.dataset.i].inset=!layers[+e.target.dataset.i].inset;render();}));
        c.querySelectorAll('.rm-layer').forEach(el=>el.addEventListener('click',e=>{layers.splice(+e.target.dataset.i,1);render();}));
    }

    document.getElementById('add-layer').addEventListener('click',()=>{
        layers.push({x:0,y:4,blur:16,spread:-2,color:lColors[layers.length%lColors.length],opacity:25,inset:false});render();
    });

    const sw=document.getElementById('bg-swatches');
    bgOptions.forEach(c=>{
        const s=document.createElement('div');s.className='bg-swatch'+(c===bgColor?' active':'');
        s.style.background=c;s.style.border=c==='#ffffff'?'1.5px solid #e2e8f0':'2px solid transparent';
        s.addEventListener('click',()=>{
            bgColor=c;
            document.getElementById('preview-area').style.background=c;
            document.getElementById('preview-box').style.background=c==='#0f172a'||c==='#1e293b'?'#334155':'#ffffff';
            sw.querySelectorAll('.bg-swatch').forEach(x=>x.classList.remove('active'));
            s.classList.add('active');
        });
        sw.appendChild(s);
    });

    document.getElementById('copy-btn').addEventListener('click',()=>{
        navigator.clipboard.writeText(document.getElementById('css-out').textContent);
        const b=document.getElementById('copy-btn');b.textContent='✓ Copied!';setTimeout(()=>b.textContent='Copy',1500);
    });

    render();
</script>
<?= $this->endSection() ?>