<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="dataAnalyst()" class="max-w-7xl mx-auto py-12 px-4 sm:px-6">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit">
            Smart <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500">Data Analyst</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm">
            Unggah file CSV Anda dan biarkan AI menemukan insight, tren, dan merangkum data rumit dalam hitungan detik.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-4 text-emerald-500">
                    <i class="fa-solid fa-key"></i>
                    <h3 class="font-bold text-sm uppercase tracking-wider">Access Key</h3>
                </div>
                <div class="relative">
                    <input :type="showKey ? 'text' : 'password'" x-model="apiKey" @input="saveKey()" 
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 pr-12 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all" 
                           placeholder="Paste Gemini API Key...">
                    <button @click="showKey = !showKey" class="absolute right-4 top-3.5 text-slate-400 hover:text-emerald-500 transition-colors">
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
                        <select x-model="aiModel" class="w-full bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl py-3 px-4 text-sm font-bold text-emerald-700 dark:text-emerald-400 outline-none focus:border-emerald-500 appearance-none cursor-pointer transition-all">
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash (Standard)</option>
                            <option value="gemini-3.1-flash-preview">Gemini 3.1 Flash (Advanced)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-emerald-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Upload Dataset (.CSV)</label>
                    <div class="relative w-full h-32 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl hover:border-emerald-500 dark:hover:border-emerald-500 transition-colors flex items-center justify-center bg-slate-50 dark:bg-slate-800/50 overflow-hidden group cursor-pointer">
                        <input type="file" @change="handleFileUpload" accept=".csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                        
                        <div x-show="!fileName" class="text-center transition-transform group-hover:scale-105 pointer-events-none">
                            <i class="fa-solid fa-file-csv text-3xl text-emerald-300 dark:text-emerald-700 mb-2"></i>
                            <p class="text-xs font-bold text-slate-500">Upload Data CSV</p>
                        </div>

                        <div x-show="fileName" style="display: none;" class="text-center z-10 px-4 w-full">
                            <i class="fa-solid fa-file-circle-check text-3xl text-emerald-500 mb-2"></i>
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300 truncate w-full px-4" x-text="fileName"></p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pertanyaan / Instruksi</label>
                    <textarea x-model="question" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-sm text-slate-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all resize-none" placeholder="Contoh: Tolong buatkan 5 insight utama dari data ini, dan buatkan tabel ringkasannya."></textarea>
                </div>

                <button @click="generate()" :disabled="loading || !csvFile || !question" 
                    class="w-full relative group bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-black py-4 rounded-xl shadow-lg shadow-emerald-500/30 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 overflow-hidden">
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                    
                    <template x-if="loading">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-notch animate-spin"></i> Menganalisis...</div>
                    </template>
                    <template x-if="!loading">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-chart-pie"></i> Temukan Insight</div>
                    </template>
                </button>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white dark:bg-slate-900/80 p-8 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl relative min-h-[600px] flex flex-col">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4 mb-6 relative z-20">
                    <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_#10b981]"></span> Analytics Engine
                    </div>
                    
                    <div class="flex gap-2" x-show="result && !loading">
                        <button @click="confirmClear()" class="text-rose-500 hover:text-rose-600 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2">
                            <i class="fa-solid fa-trash"></i> Reset
                        </button>
                        <button @click="copyResult()" class="bg-slate-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 text-slate-600 dark:text-slate-300 hover:text-emerald-600 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2 border border-slate-200 dark:border-slate-700">
                            <i class="fa-regular" :class="copied ? 'fa-circle-check text-emerald-500' : 'fa-copy'"></i> 
                            <span x-text="copied ? 'Tersalin!' : 'Copy Data'"></span>
                        </button>
                    </div>
                </div>

                <div class="flex-1 relative">
                    <div x-show="!result && !loading" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 transition-opacity duration-300">
                        <i class="fa-solid fa-table-list text-6xl mb-4 opacity-30"></i>
                        <p class="font-medium text-sm">Hasil analisis data akan muncul di sini</p>
                    </div>

                    <div x-show="loading" style="display: none;" class="absolute inset-0 flex flex-col items-center justify-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm z-30 transition-all rounded-xl">
                        <div class="relative w-20 h-20 mb-6 flex items-center justify-center">
                            <div class="absolute inset-0 border-4 border-emerald-100 dark:border-emerald-900/50 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
                            <i class="fa-solid fa-chart-simple text-2xl text-emerald-500 animate-pulse"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white mb-2 tracking-wide" x-text="loadingText">Membaca ribuan baris...</h3>
                        <p class="text-xs font-medium text-slate-500 animate-pulse">Memproses matriks data Anda.</p>
                        <div class="w-48 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full mt-6 overflow-hidden">
                            <div class="h-full bg-emerald-500 w-1/3 rounded-full" style="animation: bounceSlide 1.5s infinite linear;"></div>
                        </div>
                    </div>

                    <div x-show="result && !loading" x-transition.opacity class="w-full pb-8">
                        <div class="custom-prose dark:prose-invert max-w-none prose-table:w-full prose-table:border-collapse prose-th:bg-emerald-50 dark:prose-th:bg-emerald-900/20 prose-th:p-3 prose-th:border prose-th:border-slate-200 dark:prose-th:border-slate-700 prose-td:p-3 prose-td:border prose-td:border-slate-200 dark:prose-td:border-slate-700">
                            <div x-html="result"></div>
                        </div>
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
                <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3">Reset Data?</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-8 text-sm leading-relaxed">
                    Yakin ingin menghapus file dan hasil analisis?
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

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
function dataAnalyst() {
    return {
        apiKey: localStorage.getItem('gemini_api_key') || '',
        showKey: false,
        aiModel: 'gemini-2.5-flash',
        csvFile: null,
        fileName: '',
        question: '',
        result: '',
        
        loading: false,
        loadingText: 'Membaca Dataset...',
        loadingInterval: null,
        copied: false,
        
        errorModal: false,
        errorMessage: '',
        clearModal: false,

        saveKey() {
            localStorage.setItem('gemini_api_key', this.apiKey);
        },

        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                if(file.size > 2048000) {
                    this.showError('Ukuran file maksimal 2MB.');
                    event.target.value = '';
                    return;
                }
                this.csvFile = file;
                this.fileName = file.name;
            }
        },

        confirmClear() {
            this.clearModal = true;
        },

        executeClearData() {
            this.csvFile = null;
            this.fileName = '';
            this.question = '';
            this.result = '';
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput) fileInput.value = '';
            this.clearModal = false;
        },

        showError(msg) {
            this.errorMessage = msg;
            this.errorModal = true;
        },

        async copyResult() {
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

        startLoadingText() {
            const texts = [
                'Mengekstrak struktur tabel...',
                'Mencari pola data...',
                'Menghitung statistik...',
                'Menyusun insight...'
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

        async generate() {
            if (!this.apiKey) return this.showError('Peringatan: Gemini API Key belum dimasukkan!');
            if (!this.csvFile) return this.showError('Peringatan: Silakan upload file CSV terlebih dahulu!');
            if (!this.question.trim()) return this.showError('Peringatan: Pertanyaan analisis wajib diisi!');
            
            this.loading = true;
            this.startLoadingText();
            
            let formData = new FormData();
            formData.append('apiKey', this.apiKey);
            formData.append('aiModel', this.aiModel);
            formData.append('question', this.question);
            formData.append('csv_file', this.csvFile);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            try {
                const response = await fetch('<?= base_url('ailab/analyze-data') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.content) {
                    let safePattern = data.content.replace(/```html\n?/g, '').replace(/```\n?/g, '').trim();
                    this.result = marked.parse(safePattern);
                } else {
                    this.showError(data.error || 'Ups! Gagal menganalisis data. Pastikan API Key valid.');
                }
            } catch (error) {
                this.showError('Terjadi kesalahan jaringan.');
            } finally {
                this.loading = false;
                this.stopLoadingText();
            }
        }
    }
}
</script>
<?= $this->endSection() ?>