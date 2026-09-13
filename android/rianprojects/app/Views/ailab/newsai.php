<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="newsGen()" class="max-w-7xl mx-auto py-12 px-4 sm:px-6">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit">
            AI News <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 to-blue-500">Generator</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm">
            Ubah fakta mentah 5W1H dan kutipan narasumber menjadi artikel berita jurnalistik yang tajam dan profesional.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-4 text-amber-500">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3 class="font-bold text-sm uppercase tracking-wider">Privacy Mode</h3>
                </div>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                    API Key Anda disimpan di <strong>Local Storage</strong> browser. Kami tidak menyimpannya di database kami.
                </p>
                <div class="relative">
                    <input :type="showKey ? 'text' : 'password'" x-model="apiKey" @input="saveKey()" 
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 pr-12 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-cyan-500 outline-none transition-all" 
                           placeholder="Paste Gemini API Key...">
                    <button @click="showKey = !showKey" class="absolute right-4 top-3.5 text-slate-400 hover:text-cyan-500 transition-colors">
                        <i class="fa-solid" :class="showKey ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                    <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-[10px] text-indigo-500 font-bold mt-3 inline-flex items-center gap-1 hover:underline">
                    Dapatkan API Key Gratis <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Engine AI</label>
                        <select x-model="aiModel" class="w-full bg-cyan-50 dark:bg-cyan-900/20 border border-cyan-200 dark:border-cyan-800/50 rounded-xl py-3 px-4 text-sm font-bold text-cyan-700 dark:text-cyan-400 outline-none focus:border-cyan-500 transition-all">
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash</option>
                            <option value="gemini-2.5-flash-lite">Gemini Flash-Lite</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gaya Penulisan</label>
                        <select x-model="tone" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm font-medium text-slate-800 dark:text-white outline-none focus:border-cyan-500 transition-all">
                            <option value="Hard News (Profesional)">Hard News</option>
                            <option value="Soft News (Feature)">Soft News / Feature</option>
                            <option value="Investigatif (Tajam)">Investigatif</option>
                            <option value="Opini / Editorial">Editorial</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Target Panjang Artikel</label>
                        <select x-model="articleLength" @change="saveToLocal()" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm font-medium text-slate-800 dark:text-white outline-none focus:border-cyan-500 transition-all">
                            <option value="Singkat (2-3 Paragraf)">Berita Singkat (2-3 Paragraf / Flash News)</option>
                            <option value="Standar (4-6 Paragraf)">Berita Standar (4-6 Paragraf)</option>
                            <option value="Mendalam (7+ Paragraf)">Berita Mendalam (7+ Paragraf / In-depth)</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-4 border border-slate-200 dark:border-slate-700 rounded-xl p-4 bg-slate-50/50 dark:bg-slate-800/30">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-list-check text-cyan-500"></i>
                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300">Fakta Utama (5W + 1H)</h4>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Apa (What) *</label>
                            <input type="text" x-model="w_what" @input="saveToLocal()" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg py-2 px-3 text-sm text-slate-800 dark:text-white outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all" placeholder="Peristiwa yang terjadi...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Siapa (Who) *</label>
                            <input type="text" x-model="w_who" @input="saveToLocal()" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg py-2 px-3 text-sm text-slate-800 dark:text-white outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all" placeholder="Pihak yang terlibat...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Kapan (When) *</label>
                            <input type="text" x-model="w_when" @input="saveToLocal()" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg py-2 px-3 text-sm text-slate-800 dark:text-white outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all" placeholder="Waktu kejadian...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Di mana (Where) *</label>
                            <input type="text" x-model="w_where" @input="saveToLocal()" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg py-2 px-3 text-sm text-slate-800 dark:text-white outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all" placeholder="Lokasi kejadian...">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Mengapa (Why)</label>
                        <input type="text" x-model="w_why" @input="saveToLocal()" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg py-2 px-3 text-sm text-slate-800 dark:text-white outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all" placeholder="Penyebab peristiwa...">
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Bagaimana (How)</label>
                        <textarea x-model="w_how" @input="saveToLocal()" rows="2" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg py-2 px-3 text-sm text-slate-800 dark:text-white outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all resize-none" placeholder="Kronologi kejadian..."></textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Latar Belakang / Opini Penulis</label>
                    <textarea x-model="deskripsi" @input="saveToLocal()" rows="2" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-sm text-slate-800 dark:text-white outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 transition-all resize-none" placeholder="Catatan tambahan jurnalis..."></textarea>
                </div>

                <div class="border-t border-slate-100 dark:border-slate-800 pt-4">
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider"><i class="fa-solid fa-quote-left text-cyan-500"></i> Kutipan Narasumber</label>
                        <button @click="addQuote()" class="text-[10px] font-bold bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 px-2 py-1 rounded-md hover:bg-cyan-200 transition-colors">+ Tambah Orang</button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(quote, index) in quotes" :key="index">
                            <div class="flex flex-col gap-2 p-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl relative group">
                                <input type="text" x-model="quote.name" @input="saveToLocal()" class="w-full bg-transparent border-b border-slate-300 dark:border-slate-600 py-1 text-sm text-slate-800 dark:text-white font-bold outline-none focus:border-cyan-500" placeholder="Nama & Jabatan Narasumber...">
                                <textarea x-model="quote.text" @input="saveToLocal()" rows="2" class="w-full bg-transparent py-1 text-sm text-slate-600 dark:text-slate-300 outline-none resize-none" placeholder="Isi ucapan / kutipan..."></textarea>
                                
                                <button @click="removeQuote(index)" class="absolute top-2 right-2 w-6 h-6 bg-rose-100 text-rose-500 rounded-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-rose-500 hover:text-white">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                            </div>
                        </template>
                        <p x-show="quotes.length === 0" class="text-xs text-slate-400 italic text-center py-2">Belum ada kutipan narasumber.</p>
                    </div>
                </div>

                <button @click="generate()" :disabled="loading || !w_what || !w_who || !w_when || !w_where" 
                    class="w-full relative group bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-black py-4 rounded-xl shadow-lg shadow-cyan-500/30 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 overflow-hidden mt-4">
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                    
                    <template x-if="loading">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-notch animate-spin"></i> Menyusun Berita...</div>
                    </template>
                    <template x-if="!loading">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-newspaper"></i> Generate Berita</div>
                    </template>
                </button>
            </div>
        </div>

        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white dark:bg-slate-900/80 p-8 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl relative min-h-[600px] flex flex-col overflow-hidden">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4 mb-6 relative z-20">
                    <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700">
                        <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse shadow-[0_0_8px_#06b6d4]"></span> Newsroom AI
                    </div>
                    
                    <div class="flex gap-2" x-show="result && !loading">
                        <button @click="confirmClear()" class="text-rose-500 hover:text-rose-600 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2">
                            <i class="fa-solid fa-trash"></i> Clear
                        </button>
                        <button @click="copyCode()" class="bg-slate-100 dark:bg-slate-800 hover:bg-cyan-50 dark:hover:bg-cyan-900/30 text-slate-600 dark:text-slate-300 hover:text-cyan-600 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2 border border-slate-200 dark:border-slate-700">
                            <i class="fa-regular" :class="copied ? 'fa-circle-check text-emerald-500' : 'fa-copy'"></i> 
                            <span x-text="copied ? 'Tersalin!' : 'Copy Berita'"></span>
                        </button>
                    </div>
                </div>

                <div class="flex-1 relative">
                    <div x-show="!result && !loading" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 transition-opacity duration-300">
                        <i class="fa-regular fa-newspaper text-6xl mb-4 opacity-30"></i>
                        <p class="font-medium text-sm">Draf berita akan muncul di sini</p>
                    </div>

                    <div x-show="loading" class="absolute inset-0 flex flex-col items-center justify-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm z-30 transition-all rounded-xl">
                        <div class="relative w-20 h-20 mb-6 flex items-center justify-center">
                            <div class="absolute inset-0 border-4 border-cyan-100 dark:border-cyan-900/50 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-cyan-500 border-t-transparent rounded-full animate-spin"></div>
                            <i class="fa-solid fa-pen-nib text-2xl text-cyan-500 animate-pulse"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white mb-2 tracking-wide" x-text="loadingText">Mengumpulkan fakta...</h3>
                        <p class="text-xs font-medium text-slate-500 animate-pulse">Mohon tunggu, AI sedang bekerja sebagai jurnalis Anda.</p>
                        
                        <div class="w-48 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full mt-6 overflow-hidden">
                            <div class="h-full bg-cyan-500 w-1/3 animate-[translateX_2s_ease-in-out_infinite] rounded-full" style="animation: bounceSlide 1.5s infinite linear;"></div>
                        </div>
                    </div>

                    <div x-show="result && !loading" x-transition.opacity class="w-full pb-8">
                        <div class="custom-prose dark:prose-invert max-w-none prose-blockquote:border-l-cyan-500 prose-blockquote:bg-cyan-50 dark:prose-blockquote:bg-cyan-900/10 prose-blockquote:px-4 prose-blockquote:py-1 prose-blockquote:rounded-r-lg prose-h1:font-black prose-h1:text-3xl prose-h1:mb-6 prose-p:text-lg prose-p:leading-relaxed">
                            <div x-html="result"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="errorModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" x-cloak>
            <div x-show="errorModal" x-transition.opacity @click="errorModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>
            <div x-show="errorModal" x-transition.scale.95 class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-white/10 overflow-hidden text-center p-8">
                <div class="w-20 h-20 bg-rose-500/10 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3">Terjadi Kesalahan</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-8 text-sm leading-relaxed" x-text="errorMessage"></p>
                <button @click="errorModal = false" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-rose-500/30">
                    Mengerti
                </button>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="clearModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" x-cloak>
            <div x-show="clearModal" x-transition.opacity @click="clearModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>
            <div x-show="clearModal" x-transition.scale.95 class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-white/10 overflow-hidden text-center p-8">
                <div class="w-20 h-20 bg-rose-500/10 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3">Hapus Draf?</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-8 text-sm leading-relaxed">
                    Apakah Anda yakin ingin menghapus semua form dan draf berita yang sudah dibuat? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex gap-3">
                    <button @click="clearModal = false" class="flex-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold py-3.5 rounded-2xl transition">
                        Batal
                    </button>
                    <button @click="executeClearData()" class="flex-1 bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 rounded-2xl transition shadow-lg shadow-rose-500/30">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </template>

    <style>
        @keyframes bounceSlide {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(300%); }
        }
    </style>

</div>

<script>
function newsGen() {
    return {
        apiKey: localStorage.getItem('gemini_api_key') || '',
        showKey: false,
        aiModel: 'gemini-2.5-flash',
        tone: 'Hard News (Profesional)',
        articleLength: localStorage.getItem('gemini_news_length') || 'Standar (4-6 Paragraf)',
        
        w_what: localStorage.getItem('gemini_news_what') || '',
        w_who: localStorage.getItem('gemini_news_who') || '',
        w_when: localStorage.getItem('gemini_news_when') || '',
        w_where: localStorage.getItem('gemini_news_where') || '',
        w_why: localStorage.getItem('gemini_news_why') || '',
        w_how: localStorage.getItem('gemini_news_how') || '',

        deskripsi: localStorage.getItem('gemini_news_desc') || '',
        quotes: JSON.parse(localStorage.getItem('gemini_news_quotes')) || [],
        result: localStorage.getItem('gemini_news_result') || '',
        
        loading: false,
        loadingText: 'Menyiapkan mesin AI...',
        loadingInterval: null,
        copied: false,

        errorModal: false,
        errorMessage: '',
        clearModal: false,

        init() {
            if(this.quotes.length === 0) {
                this.addQuote();
            }
        },

        startLoadingText() {
            const texts = [
                'Menganalisis matriks 5W1H...',
                'Menerapkan struktur Piramida Terbalik...',
                'Memilih diksi jurnalistik yang tepat...',
                'Merajut kutipan narasumber...',
                'Melakukan penyuntingan akhir (Editing)...'
            ];
            let i = 0;
            this.loadingText = texts[0];
            this.loadingInterval = setInterval(() => {
                i = (i + 1) % texts.length;
                this.loadingText = texts[i];
            }, 1800);
        },

        stopLoadingText() {
            if (this.loadingInterval) {
                clearInterval(this.loadingInterval);
                this.loadingInterval = null;
            }
        },

        addQuote() {
            this.quotes.push({ name: '', text: '' });
            this.saveToLocal();
        },

        removeQuote(index) {
            this.quotes.splice(index, 1);
            this.saveToLocal();
        },

        saveKey() {
            localStorage.setItem('gemini_api_key', this.apiKey);
        },

        saveToLocal() {
            localStorage.setItem('gemini_news_length', this.articleLength);
            localStorage.setItem('gemini_news_what', this.w_what);
            localStorage.setItem('gemini_news_who', this.w_who);
            localStorage.setItem('gemini_news_when', this.w_when);
            localStorage.setItem('gemini_news_where', this.w_where);
            localStorage.setItem('gemini_news_why', this.w_why);
            localStorage.setItem('gemini_news_how', this.w_how);
            localStorage.setItem('gemini_news_desc', this.deskripsi);
            localStorage.setItem('gemini_news_quotes', JSON.stringify(this.quotes));
            localStorage.setItem('gemini_news_result', this.result);
        },

        confirmClear() {
            
            this.clearModal = true;
        },

        executeClearData() {

            this.articleLength = 'Standar (4-6 Paragraf)';
            this.w_what = '';
            this.w_who = '';
            this.w_when = '';
            this.w_where = '';
            this.w_why = '';
            this.w_how = '';
            this.deskripsi = '';
            this.quotes = [{ name: '', text: '' }];
            this.result = '';
            
            localStorage.removeItem('gemini_news_length');
            localStorage.removeItem('gemini_news_what');
            localStorage.removeItem('gemini_news_who');
            localStorage.removeItem('gemini_news_when');
            localStorage.removeItem('gemini_news_where');
            localStorage.removeItem('gemini_news_why');
            localStorage.removeItem('gemini_news_how');
            localStorage.removeItem('gemini_news_desc');
            localStorage.removeItem('gemini_news_quotes');
            localStorage.removeItem('gemini_news_result');
            this.clearModal = false;
        },

        showError(msg) {
            this.errorMessage = msg;
            this.errorModal = true;
        },

        async copyCode() {
            try {
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = this.result;
                await navigator.clipboard.writeText(tempDiv.textContent || tempDiv.innerText);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            } catch (err) {
                this.showError('Gagal menyalin!');
            }
        },

        async generate() {
            if (!this.apiKey) return this.showError('Peringatan: Gemini API Key belum dimasukkan!');
            
            if (!this.w_what.trim() || !this.w_who.trim() || !this.w_when.trim() || !this.w_where.trim()) {
                return this.showError('Peringatan: Kolom Apa, Siapa, Kapan, dan Di mana wajib diisi!');
            }
            
            this.loading = true;
            this.startLoadingText();

            let combinedFakta = `
Apa yang terjadi: ${this.w_what}
Siapa yang terlibat: ${this.w_who}
Kapan terjadi: ${this.w_when}
Di mana lokasi: ${this.w_where}
Mengapa terjadi: ${this.w_why || 'Belum diketahui'}
Bagaimana kronologinya: ${this.w_how || 'Belum ada detail'}
            `.trim();
            
            let formData = new FormData();
            formData.append('apiKey', this.apiKey);
            formData.append('aiModel', this.aiModel);
            formData.append('tone', this.tone);
            formData.append('articleLength', this.articleLength); 
            formData.append('fakta', combinedFakta);
            formData.append('deskripsi', this.deskripsi);
            formData.append('quotes', JSON.stringify(this.quotes));
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            try {
                const response = await fetch('<?= base_url('ailab/generate-news') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.content) {
                    let safePattern = data.content.replace(/```html\n?/g, '').replace(/```\n?/g, '').trim();
                    
                    this.result = safePattern;
                    this.saveToLocal();
                } else {
                    this.showError(data.error || 'Ups! Gagal membuat draf berita. Pastikan API Key valid.');
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                this.showError('Terjadi kesalahan jaringan. Pastikan server berjalan dan endpoint tersedia.');
            } finally {
                this.loading = false;
                this.stopLoadingText(); 
            }
        }
    }
}
</script>
<?= $this->endSection() ?>