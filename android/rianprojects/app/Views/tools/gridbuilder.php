<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center p-3 bg-blue-50 dark:bg-blue-900/30 rounded-2xl mb-4 text-blue-500">
            <i class="fa-solid fa-table-cells-large text-2xl sm:text-3xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3 font-outfit tracking-tight">
            CSS Grid <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-cyan-500">Builder</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base">Bangun layout grid secara visual, dapatkan CSS & HTML siap pakai</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="space-y-4">
            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                
                <div class="flex bg-slate-100 dark:bg-slate-800 p-1 rounded-xl mb-6">
                    <button id="btn-mode-auto" class="flex-1 py-2.5 text-xs font-bold rounded-lg bg-white dark:bg-slate-700 shadow text-blue-600 dark:text-blue-400 transition-all">Otomatis</button>
                    <button id="btn-mode-custom" class="flex-1 py-2.5 text-xs font-bold rounded-lg text-slate-500 hover:text-slate-700 dark:text-slate-400 transition-all">Kustom Bebas</button>
                </div>

                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-4">Struktur Grid</p>
                
                <div id="wrap-auto-counts" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-500 dark:text-slate-400 mb-2">Jumlah Kolom</label>
                        <div class="flex items-center gap-2">
                            <button id="col-minus" class="w-9 h-9 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 font-bold text-lg hover:bg-blue-50 hover:text-blue-500 transition-all flex items-center justify-center">−</button>
                            <input type="number" id="cols" value="3" min="1" max="12" class="flex-1 text-center border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl py-2 font-mono text-sm outline-none focus:border-blue-400 pointer-events-none" readonly>
                            <button id="col-plus" class="w-9 h-9 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 font-bold text-lg hover:bg-blue-50 hover:text-blue-500 transition-all flex items-center justify-center">+</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-500 dark:text-slate-400 mb-2">Jumlah Baris</label>
                        <div class="flex items-center gap-2">
                            <button id="row-minus" class="w-9 h-9 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 font-bold text-lg hover:bg-blue-50 hover:text-blue-500 transition-all flex items-center justify-center">−</button>
                            <input type="number" id="rows" value="2" min="1" max="8" class="flex-1 text-center border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl py-2 font-mono text-sm outline-none focus:border-blue-400 pointer-events-none" readonly>
                            <button id="row-plus" class="w-9 h-9 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 font-bold text-lg hover:bg-blue-50 hover:text-blue-500 transition-all flex items-center justify-center">+</button>
                        </div>
                    </div>
                </div>

                <div id="wrap-custom-inputs" class="space-y-4 hidden">
                    <div>
                        <label class="block text-sm font-semibold text-slate-500 dark:text-slate-400 mb-1">Template Columns</label>
                        <p class="text-[10px] text-slate-400 mb-2">Bebas ketik nilai CSS (misal: <code class="text-blue-500 bg-blue-50 dark:bg-blue-900/30 px-1 rounded">1fr 200px 1fr</code>)</p>
                        <input type="text" id="custom-col-str" value="1fr 2fr 1fr" class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl py-3 px-3 font-mono text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-500 dark:text-slate-400 mb-1">Template Rows</label>
                        <p class="text-[10px] text-slate-400 mb-2">Bebas ketik nilai CSS (misal: <code class="text-blue-500 bg-blue-50 dark:bg-blue-900/30 px-1 rounded">100px auto</code>)</p>
                        <input type="text" id="custom-row-str" value="auto 150px" class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl py-3 px-3 font-mono text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>
                </div>

            </div>

            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mb-4">Layout & Spacing</p>
                <div class="space-y-4">
                    
                    <div id="wrap-auto-templates" class="space-y-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Perilaku Kolom</label>
                            <select id="col-template" class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl py-2 px-3 text-sm outline-none focus:border-blue-400 cursor-pointer">
                                <option value="repeat">Membagi rata (1fr)</option>
                                <option value="auto">Menyesuaikan konten (auto)</option>
                                <option value="minmax">Responsif min 100px</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Perilaku Baris</label>
                            <select id="row-template" class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl py-2 px-3 text-sm outline-none focus:border-blue-400 cursor-pointer">
                                <option value="auto">Menyesuaikan konten (auto)</option>
                                <option value="equal">Membagi rata (1fr)</option>
                                <option value="minmax">Responsif min 80px</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1 flex justify-between">
                            <span>Jarak Antar Kolom (Gap)</span> <span id="col-gap-val" class="text-blue-500 font-bold">16px</span>
                        </label>
                        <input type="range" id="col-gap" min="0" max="64" value="16" class="w-full accent-blue-500 cursor-pointer mt-1">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1 flex justify-between">
                            <span>Jarak Antar Baris (Gap)</span> <span id="row-gap-val" class="text-blue-500 font-bold">16px</span>
                        </label>
                        <input type="range" id="row-gap" min="0" max="64" value="16" class="w-full accent-blue-500 cursor-pointer mt-1">
                    </div>
                    <div class="grid grid-cols-2 gap-3 mt-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Justify Items</label>
                            <select id="justify" class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl py-2 px-2 text-xs outline-none focus:border-blue-400 cursor-pointer">
                                <option>stretch</option><option>start</option><option>center</option><option>end</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Align Items</label>
                            <select id="align" class="w-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl py-2 px-2 text-xs outline-none focus:border-blue-400 cursor-pointer">
                                <option>stretch</option><option>start</option><option>center</option><option>end</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500">Preview Layout</p>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-400 font-semibold" id="item-count">6 Anak Elemen</span>
                        <div class="flex bg-slate-100 dark:bg-slate-800 p-0.5 rounded-lg border border-slate-200 dark:border-slate-700">
                            <button id="item-minus" class="w-7 h-7 rounded-md text-slate-500 text-sm font-bold hover:bg-white hover:text-blue-500 hover:shadow transition-all">−</button>
                            <button id="item-plus" class="w-7 h-7 rounded-md text-slate-500 text-sm font-bold hover:bg-white hover:text-blue-500 hover:shadow transition-all">+</button>
                        </div>
                    </div>
                </div>
                <div id="grid-preview" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 border-dashed rounded-2xl p-4 min-h-[300px]"></div>
            </div>

            <div class="bg-white dark:bg-slate-900/80 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-6">
                <div class="flex gap-2 mb-4">
                    <button class="code-tab flex-1 py-2 rounded-xl text-sm font-bold border border-slate-200 dark:border-slate-700 text-slate-500 hover:border-blue-400 transition-all active-code-tab" data-tab="css">Kode CSS</button>
                    <button class="code-tab flex-1 py-2 rounded-xl text-sm font-bold border border-slate-200 dark:border-slate-700 text-slate-500 hover:border-blue-400 transition-all" data-tab="html">Kode HTML</button>
                </div>
                <div class="relative bg-slate-900 dark:bg-slate-950 rounded-2xl p-5 border border-slate-800">
                    <pre id="code-output" class="text-[13px] font-mono text-emerald-400 leading-relaxed whitespace-pre-wrap break-words"></pre>
                    <button id="copy-btn" class="absolute top-4 right-4 bg-white/10 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors backdrop-blur-sm">Copy</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<style>
    .active-code-tab { background:#2563eb!important;color:#fff!important;border-color:#2563eb!important; }
    .grid-cell { 
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.8), rgba(99, 102, 241, 0.8));
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1rem;
        font-weight: 800;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .grid-cell:hover { 
        transform: translateY(-2px) scale(1.02);
        background: linear-gradient(135deg, rgba(59, 130, 246, 1), rgba(99, 102, 241, 1));
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
</style>
<script>

    let st = {
        mode: 'auto', 
        cols: 3, 
        rows: 2,
        colGap: 16, 
        rowGap: 16,
        justify: 'stretch', 
        align: 'stretch',
        colTemplate: 'repeat', 
        rowTemplate: 'auto',
        customColStr: '1fr 2fr 1fr',
        customRowStr: 'auto 150px',
        items: 6, 
        tab: 'css'
    };

    function switchMode(newMode) {
        st.mode = newMode;
        const btnAuto = document.getElementById('btn-mode-auto');
        const btnCustom = document.getElementById('btn-mode-custom');
        const wrapCounts = document.getElementById('wrap-auto-counts');
        const wrapInputs = document.getElementById('wrap-custom-inputs');
        const wrapTemplates = document.getElementById('wrap-auto-templates');

        const activeClass = "flex-1 py-2.5 text-xs font-bold rounded-lg bg-white dark:bg-slate-700 shadow text-blue-600 dark:text-blue-400 transition-all";
        const inactiveClass = "flex-1 py-2.5 text-xs font-bold rounded-lg text-slate-500 hover:text-slate-700 dark:text-slate-400 transition-all";

        if(newMode === 'auto') {
            btnAuto.className = activeClass;
            btnCustom.className = inactiveClass;
            wrapCounts.classList.remove('hidden');
            wrapInputs.classList.add('hidden');
            wrapTemplates.classList.remove('hidden');
        } else {
            btnAuto.className = inactiveClass;
            btnCustom.className = activeClass;
            wrapCounts.classList.add('hidden');
            wrapInputs.classList.remove('hidden');
            wrapTemplates.classList.add('hidden');
        }
        render();
    }

    document.getElementById('btn-mode-auto').addEventListener('click', () => switchMode('auto'));
    document.getElementById('btn-mode-custom').addEventListener('click', () => switchMode('custom'));
    function getColTpl() {
        if(st.mode === 'custom') return st.customColStr || '1fr';
        
        const c = st.cols;
        if(st.colTemplate === 'repeat') return `repeat(${c}, 1fr)`;
        if(st.colTemplate === 'auto') return `repeat(${c}, auto)`;
        if(st.colTemplate === 'minmax') return `repeat(${c}, minmax(100px, 1fr))`;
        return `repeat(${c}, 1fr)`;
    }

    function getRowTpl() {
        if(st.mode === 'custom') return st.customRowStr || 'auto';

        const r = st.rows;
        if(st.rowTemplate === 'auto') return `repeat(${r}, auto)`;
        if(st.rowTemplate === 'equal') return `repeat(${r}, 1fr)`;
        return `repeat(${r}, minmax(80px, auto))`;
    }

    function buildCSS(){
        return `.grid-container {\n  display: grid;\n  grid-template-columns: ${getColTpl()};\n  grid-template-rows: ${getRowTpl()};\n  column-gap: ${st.colGap}px;\n  row-gap: ${st.rowGap}px;\n  justify-items: ${st.justify};\n  align-items: ${st.align};\n}`;
    }

    function buildHTML(){
        let h=`<div class="grid-container">\n`;
        for(let i=1;i<=st.items;i++) h+=`  <div class="grid-item">${i}</div>\n`;
        return h+'</div>';
    }

    function renderPreview(){
        const g = document.getElementById('grid-preview');
        g.style.display = 'grid';
        g.style.gridTemplateColumns = getColTpl();
        g.style.gridTemplateRows = getRowTpl();
        g.style.columnGap = st.colGap + 'px';
        g.style.rowGap = st.rowGap + 'px';
        g.style.justifyItems = st.justify;
        g.style.alignItems = st.align;
        g.innerHTML = '';
        
        for(let i=1;i<=st.items;i++){
            const c = document.createElement('div');
            c.className = 'grid-cell';
            c.textContent = i;
            g.appendChild(c);
        }
        document.getElementById('item-count').textContent = st.items + ' Elemen';
    }

    function renderCode(){ 
        document.getElementById('code-output').textContent = st.tab === 'css' ? buildCSS() : buildHTML(); 
    }
    
    function render(){ 
        renderPreview(); 
        renderCode(); 
    }

    ['col','row'].forEach(t => {
        const key = t === 'col' ? 'cols' : 'rows';
        document.getElementById(t+'-plus').addEventListener('click', () => {
            if(st[key] < (t==='col'?12:8)){ st[key]++; document.getElementById(t+'s').value=st[key]; render(); }
        });
        document.getElementById(t+'-minus').addEventListener('click', () => {
            if(st[key] > 1){ st[key]--; document.getElementById(t+'s').value=st[key]; render(); }
        });
    });

    document.getElementById('custom-col-str').addEventListener('input', e => { st.customColStr = e.target.value; render(); });
    document.getElementById('custom-row-str').addEventListener('input', e => { st.customRowStr = e.target.value; render(); });

    document.getElementById('col-template').addEventListener('change', e => { st.colTemplate = e.target.value; render(); });
    document.getElementById('row-template').addEventListener('change', e => { st.rowTemplate = e.target.value; render(); });
    document.getElementById('justify').addEventListener('change', e => { st.justify = e.target.value; render(); });
    document.getElementById('align').addEventListener('change', e => { st.align = e.target.value; render(); });
    
    document.getElementById('col-gap').addEventListener('input', e => { st.colGap = +e.target.value; document.getElementById('col-gap-val').textContent = e.target.value+'px'; render(); });
    document.getElementById('row-gap').addEventListener('input', e => { st.rowGap = +e.target.value; document.getElementById('row-gap-val').textContent = e.target.value+'px'; render(); });
    
    document.getElementById('item-plus').addEventListener('click', () => { if(st.items < 30) { st.items++; render(); }});
    document.getElementById('item-minus').addEventListener('click', () => { if(st.items > 1) { st.items--; render(); }});
    
    document.querySelectorAll('.code-tab').forEach(t => t.addEventListener('click', e => {
        document.querySelectorAll('.code-tab').forEach(x => x.classList.remove('active-code-tab'));
        e.target.classList.add('active-code-tab');
        st.tab = e.target.dataset.tab;
        renderCode();
    }));
    
    document.getElementById('copy-btn').addEventListener('click', () => {
        navigator.clipboard.writeText(document.getElementById('code-output').textContent);
        const b = document.getElementById('copy-btn');
        b.textContent = '✓ Tersalin!';
        b.classList.replace('bg-white/10', 'bg-emerald-500');
        setTimeout(() => { 
            b.textContent = 'Copy'; 
            b.classList.replace('bg-emerald-500', 'bg-white/10');
        }, 1500);
    });

    render();
</script>
<?= $this->endSection() ?>