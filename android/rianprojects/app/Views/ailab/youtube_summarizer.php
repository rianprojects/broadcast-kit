<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="ytSummarizer()" class="max-w-7xl mx-auto py-12 px-4 sm:px-6">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit">
            YouTube <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-600">Summarizer</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm">
            Dapatkan inti sari video YouTube dalam hitungan detik tanpa harus menonton durasi penuh.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-5 space-y-6 sticky top-24">
            
            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-4 text-amber-500">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3 class="font-bold text-sm uppercase tracking-wider">Privacy Mode</h3>
                </div>
                <div class="relative">
                    <input :type="showKey ? 'text' : 'password'" x-model="apiKey" @input="saveKey()" 
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 pr-12 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-red-500 outline-none transition-all" 
                           placeholder="Paste Gemini API Key...">
                    <button @click="showKey = !showKey" class="absolute right-4 top-3.5 text-slate-400 hover:text-red-500 transition-colors">
                        <i class="fa-solid" :class="showKey ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>

                <div class="mt-3 flex items-start gap-2 text-[10px] sm:text-xs text-amber-600/80 dark:text-amber-500/80 bg-amber-50 dark:bg-amber-900/20 p-2.5 rounded-lg border border-amber-200/50 dark:border-amber-800/50">
                    <i class="fa-solid fa-circle-info mt-0.5"></i>
                    <p class="leading-tight font-medium">API Key Anda hanya disimpan sementara di <span class="font-bold">Local Storage</span> browser. Silakan hapus key dari kolom ini saat menutup browser demi keamanan.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl space-y-6">
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Engine AI</label>
                    <div class="relative">
                        <select x-model="aiModel" class="w-full bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 rounded-xl py-3 px-4 text-sm font-bold text-red-700 dark:text-red-400 outline-none focus:border-red-500 appearance-none cursor-pointer transition-all">
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash (Standard)</option>
                            <option value="gemini-3.1-flash-preview">Gemini 3.1 Flash (Advanced)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-red-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">URL Video YouTube</label>
                    <div class="relative">
                        <input type="text" x-model="videoUrl" @input="saveToLocal()" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 pl-12 text-sm text-slate-800 dark:text-white outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all" placeholder="https://www.youtube.com/watch?v=...">
                        <div class="absolute left-4 top-3.5 text-red-500 text-lg">
                            <i class="fa-brands fa-youtube"></i>
                        </div>
                    </div>
                </div>

                <button @click="generate()" :disabled="loading || !videoUrl" 
                    class="w-full relative group bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-black py-4 rounded-xl shadow-lg shadow-red-500/30 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 overflow-hidden">
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                    
                    <template x-if="loading">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-notch animate-spin"></i> Membaca Video...</div>
                    </template>
                    <template x-if="!loading">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-bolt"></i> Buat Ringkasan</div>
                    </template>
                </button>
            </div>
        </div>

        <div class="lg:col-span-7 space-y-6">
            <div class="bg-slate-50/50 dark:bg-slate-900/30 p-8 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 relative min-h-[600px] flex flex-col">
                
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4 mb-6 relative z-20">
                    <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-white dark:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse shadow-[0_0_8px_#ef4444]"></span> Output Engine
                    </div>
                    
                    <div class="flex gap-2" x-show="resultCards.length > 0 && !loading">
                        <button @click="confirmClear()" class="text-rose-500 hover:text-rose-600 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2">
                            <i class="fa-solid fa-trash"></i> Reset
                        </button>
                        <button @click="copyResult()" class="bg-white dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-900/30 text-slate-600 dark:text-slate-300 hover:text-red-600 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2 border border-slate-200 dark:border-slate-700 shadow-sm">
                            <i class="fa-regular" :class="copied ? 'fa-circle-check text-emerald-500' : 'fa-copy'"></i> 
                            <span x-text="copied ? 'Tersalin!' : 'Copy Semua'"></span>
                        </button>
                    </div>
                </div>

                <div class="flex-1 relative">
                    <div x-show="resultCards.length === 0 && !loading" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 transition-opacity duration-300">
                        <i class="fa-solid fa-film text-6xl mb-4 opacity-30"></i>
                        <p class="font-medium text-sm">Hasil ringkasan video akan muncul di sini</p>
                    </div>

                    <div x-show="loading" style="display: none;" class="absolute inset-0 flex flex-col items-center justify-center z-30 transition-all">
                        <div class="relative w-20 h-20 mb-6 flex items-center justify-center">
                            <div class="absolute inset-0 border-4 border-red-100 dark:border-red-900/50 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-red-500 border-t-transparent rounded-full animate-spin"></div>
                            <i class="fa-brands fa-youtube text-2xl text-red-500 animate-pulse"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white mb-2 tracking-wide" x-text="loadingText">Mengekstrak transkrip...</h3>
                        <p class="text-xs font-medium text-slate-500 animate-pulse">Memproses konteks video Anda.</p>
                        <div class="w-48 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full mt-6 overflow-hidden">
                            <div class="h-full bg-red-500 w-1/3 rounded-full" style="animation: bounceSlide 1.5s infinite linear;"></div>
                        </div>
                    </div>

                    <div x-show="resultCards.length > 0 && !loading" x-transition.opacity class="w-full pb-8 space-y-6">
                        
                        <div x-show="mainIntro" class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                            <div class="prose prose-slate dark:prose-invert max-w-none prose-sm" x-html="mainIntro"></div>
                        </div>

                        <template x-for="(card, index) in resultCards" :key="index">
                            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:border-red-300 dark:hover:border-red-900/50 transition-colors">
                                
                                <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-red-500 to-rose-600 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                                
                                <h3 class="text-lg font-black text-slate-800 dark:text-white mb-4 pl-3" x-html="card.title"></h3>
                                
                                <div class="prose prose-slate dark:prose-invert max-w-none prose-sm prose-ul:marker:text-red-500 pl-3">
                                    <div x-html="card.content"></div>
                                </div>
                                
                            </div>
                        </template>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="errorModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6">
            <div x-show="errorModal" x-transition.opacity @click="errorModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>
            <div x-show="errorModal" x-transition.scale.95 class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-white/10 overflow-hidden text-center p-8">
                <div class="w-20 h-20 bg-rose-500/10 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3">Peringatan</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-8 text-sm leading-relaxed" x-text="errorMessage"></p>
                <button @click="errorModal = false" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-rose-500/30">
                    Mengerti
                </button>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="clearModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6">
            <div x-show="clearModal" x-transition.opacity @click="clearModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>
            <div x-show="clearModal" x-transition.scale.95 class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-white/10 overflow-hidden text-center p-8">
                <div class="w-20 h-20 bg-rose-500/10 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3">Hapus Hasil?</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-8 text-sm leading-relaxed">
                    Yakin ingin menghapus form dan hasil ringkasan ini?
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
function ytSummarizer() {
    return {
        apiKey: localStorage.getItem('gemini_api_key') || '',
        showKey: false,
        aiModel: 'gemini-2.5-flash',
        videoUrl: localStorage.getItem('gemini_yt_url') || '',
        rawHtml: localStorage.getItem('gemini_yt_html') || '',
        mainIntro: '',
        resultCards: [],
        
        loading: false,
        loadingText: 'Menghubungkan ke API...',
        loadingInterval: null,
        copied: false,
        
        errorModal: false,
        errorMessage: '',
        clearModal: false,

        init() {
            if (this.rawHtml) {
                this.parseHtmlToCards(this.rawHtml);
            }
        },

        saveKey() {
            localStorage.setItem('gemini_api_key', this.apiKey);
        },

        saveToLocal() {
            localStorage.setItem('gemini_yt_url', this.videoUrl);
            localStorage.setItem('gemini_yt_html', this.rawHtml);
        },

        confirmClear() {
            this.clearModal = true;
        },

        executeClearData() {
            this.videoUrl = '';
            this.rawHtml = '';
            this.mainIntro = '';
            this.resultCards = [];
            localStorage.removeItem('gemini_yt_url');
            localStorage.removeItem('gemini_yt_html');
            this.clearModal = false;
        },

        showError(msg) {
            this.errorMessage = msg;
            this.errorModal = true;
        },

        async copyResult() {
            try {
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = this.rawHtml; 
                await navigator.clipboard.writeText(tempDiv.textContent || tempDiv.innerText);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            } catch (err) {
                this.showError('Gagal menyalin!');
            }
        },

        startLoadingText() {
            const texts = [
                'Mengambil transkrip video...',
                'Memahami konteks pembicaraan...',
                'Menyusun poin-poin penting...',
                'Merapikan ringkasan akhir...'
            ];
            let i = 0;
            this.loadingText = texts[0];
            this.loadingInterval = setInterval(() => {
                i = (i + 1) % texts.length;
                this.loadingText = texts[i];
            }, 1500);
        },

        stopLoadingText() {
            if (this.loadingInterval) {
                clearInterval(this.loadingInterval);
                this.loadingInterval = null;
            }
        },

        parseHtmlToCards(htmlString) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(htmlString, 'text/html');
            
            let cards = [];
            let currentCard = null;
            let introHtml = '';

            Array.from(doc.body.childNodes).forEach(node => {
                if (node.nodeType === 3 && !node.textContent.trim()) return;

                if (node.nodeName.toLowerCase() === 'h3' || node.nodeName.toLowerCase() === 'h2') {
                    if (currentCard) {
                        cards.push(currentCard);
                    }
                    currentCard = {
                        title: node.innerHTML,
                        content: ''
                    };
                } else {
                    if (currentCard) {
                        currentCard.content += node.outerHTML || node.textContent;
                    } else {
                        introHtml += node.outerHTML || node.textContent;
                    }
                }
            });

            if (currentCard) cards.push(currentCard);

            this.mainIntro = introHtml.trim();
            this.resultCards = cards;
        },

        async generate() {
            if (!this.apiKey) return this.showError('Peringatan: Gemini API Key belum dimasukkan!');
            if (!this.videoUrl.trim()) return this.showError('Peringatan: URL YouTube tidak boleh kosong!');
            
            this.loading = true;
            this.startLoadingText();
            this.resultCards = [];
            this.mainIntro = '';
            
            let formData = new FormData();
            formData.append('apiKey', this.apiKey);
            formData.append('aiModel', this.aiModel);
            formData.append('videoUrl', this.videoUrl);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            try {
                const response = await fetch('<?= base_url('ailab/generate-youtube-summary') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.content) {
                    let safePattern = data.content.replace(/```html\n?/g, '').replace(/```\n?/g, '').trim();
                    this.rawHtml = safePattern;
                    this.parseHtmlToCards(safePattern);
                    this.saveToLocal();
                } else {
                    this.showError(data.error || "Gagal mendapatkan ringkasan dari server AI.");
                }

            } catch (error) {
                console.error("Fetch Error:", error); 
                this.showError('Ups! Terjadi kesalahan saat memproses data. Silakan coba lagi.');
            } finally {
                this.loading = false;
                this.stopLoadingText();
            }
        }
    }
}
</script>
<?= $this->endSection() ?>