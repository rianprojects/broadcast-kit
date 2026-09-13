<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="aiDetector()" class="max-w-[90rem] mx-auto py-8 sm:py-12 px-4 sm:px-6 min-h-[80vh]">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-8 sm:mb-12">
        <div class="inline-flex items-center justify-center p-3 bg-fuchsia-50 dark:bg-fuchsia-900/30 rounded-2xl mb-4 text-fuchsia-500 shadow-inner">
            <i class="fa-solid fa-magnifying-glass-chart text-2xl sm:text-3xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-3 sm:mb-4 font-outfit tracking-tight">
            AI Text <span class="<?= esc($breadcrumb_color ?? 'text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-500 to-pink-600') ?>">Detector</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto text-sm md:text-base px-2">
            Deteksi apakah sebuah artikel, esai, atau tugas ditulis oleh Manusia atau dihasilkan oleh AI (ChatGPT, Gemini, Claude).
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
        
        <div class="lg:col-span-3 space-y-6 flex flex-col">
            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-4 text-amber-500">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3 class="font-bold text-sm uppercase tracking-wider">Privacy Mode</h3>
                </div>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                    API Key Anda disimpan di <strong>Local Storage</strong> browser. Kami tidak menyimpannya di database kami demi privasi Anda.
                </p>
                <div class="relative mb-2">
                    <input :type="showKey ? 'text' : 'password'" x-model="apiKey" @input="saveKey()" 
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 pr-12 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" 
                           placeholder="Gemini API Key...">
                    <button @click="showKey = !showKey" class="absolute right-4 top-3.5 text-slate-400 hover:text-fuchsia-500">
                        <i class="fa-solid" :class="showKey ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-[10px] text-fuchsia-500 font-bold inline-flex items-center gap-1 hover:underline">
                    Dapatkan API Key Gratis <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
        </div>

        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden p-2 relative"
                 :class="isDragging ? 'ring-2 ring-fuchsia-500 bg-fuchsia-50/50 dark:bg-fuchsia-900/10' : ''"
                 @dragover.prevent="isDragging = true" 
                 @dragleave.prevent="isDragging = false" 
                 @drop.prevent="handleDrop($event)">
                
                <div class="flex items-center justify-between px-4 pt-3 pb-2 border-b border-slate-100 dark:border-slate-800/50 mb-2">
                    <h3 class="text-sm font-bold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-fuchsia-500"></i> Teks Dokumen
                    </h3>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-bold bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-slate-500" x-show="isDragging">Lepas file disini</span>
                        <span class="text-xs font-bold text-slate-400" x-text="textLength + ' Karakter'"></span>
                    </div>
                </div>

                <textarea x-model="inputText" @input="textLength = inputText.length" rows="14" :disabled="loading"
                    class="w-full bg-transparent border-none p-4 text-sm sm:text-base font-medium text-slate-800 dark:text-white outline-none resize-none placeholder-slate-400 leading-relaxed disabled:opacity-50" 
                    placeholder="Paste teks, atau upload dokumen (Word, Excel, PDF, Gambar) di tombol bawah ini..."></textarea>
                
                <input type="file" x-ref="fileInput" @change="uploadFile($event.target.files[0])" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" class="hidden">

                <div class="p-3 bg-slate-50 dark:bg-slate-800/50 rounded-3xl mt-2 flex flex-wrap sm:flex-nowrap justify-between items-center gap-2">
                    
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button @click="inputText = ''; textLength = 0; result = null" x-show="inputText.length > 0" :disabled="loading" class="px-3 py-2 text-xs font-bold text-slate-500 hover:text-rose-500 transition-colors" title="Bersihkan">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        
                        <button @click="$refs.fileInput.click()" :disabled="loading" class="px-3 sm:px-4 py-2.5 text-xs font-bold text-fuchsia-600 bg-fuchsia-100/50 hover:bg-fuchsia-100 dark:text-fuchsia-400 dark:bg-fuchsia-900/30 dark:hover:bg-fuchsia-900/50 rounded-xl transition-colors flex items-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Upload File
                        </button>
                    </div>

                    <button @click="analyze()" :disabled="loading || inputText.length < 50" 
                        class="w-full sm:w-auto bg-gradient-to-r from-fuchsia-500 to-pink-600 hover:from-fuchsia-600 hover:to-pink-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-fuchsia-500/25 transition-all active:scale-95 disabled:opacity-50 flex justify-center items-center gap-2 text-sm whitespace-nowrap">
                        <template x-if="loading">
                            <span><i class="fa-solid fa-circle-notch animate-spin mr-2"></i> <span x-text="loadingText"></span></span>
                        </template>
                        <template x-if="!loading">
                            <span><i class="fa-solid fa-wand-magic-sparkles mr-2"></i> Deteksi AI</span>
                        </template>
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 h-full">
            
            <div x-show="!result && !loading" class="h-full bg-slate-50/50 dark:bg-slate-900/30 rounded-[2rem] border-2 border-dashed border-slate-200 dark:border-slate-800 flex flex-col items-center justify-center p-8 text-center min-h-[300px]">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center text-slate-300 dark:text-slate-600 text-3xl mb-4">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <h3 class="text-slate-600 dark:text-slate-400 font-bold mb-2 text-sm">Belum ada data</h3>
                <p class="text-[11px] text-slate-400 dark:text-slate-500 leading-relaxed">Masukkan teks lalu klik deteksi untuk melihat skor.</p>
            </div>

            <div x-show="loading" class="h-full bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 flex flex-col items-center justify-center p-8 text-center min-h-[300px] shadow-xl">
                <i class="fa-solid fa-radar fa-spin text-4xl text-fuchsia-500 mb-6"></i>
                <h3 class="text-slate-800 dark:text-white font-black text-base animate-pulse" x-text="loadingText"></h3>
            </div>

            <div x-show="result && !loading" style="display: none;" class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl p-6 flex flex-col h-full">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 dark:border-slate-800 pb-3">Skor Deteksi</h3>
                
                <div class="flex items-center justify-between mb-6 gap-4">
                    <div class="text-center flex-1">
                        <div class="text-4xl font-black font-outfit mb-1" :class="result?.ai_percentage > 50 ? 'text-rose-500' : 'text-slate-800 dark:text-white'" x-text="result?.ai_percentage + '%'"></div>
                        <div class="text-[9px] font-bold text-slate-500 uppercase tracking-wider"><i class="fa-solid fa-robot text-rose-500 mr-1"></i> AI Generated</div>
                    </div>
                    <div class="w-px h-12 bg-slate-200 dark:bg-slate-800"></div>
                    <div class="text-center flex-1">
                        <div class="text-4xl font-black font-outfit mb-1" :class="result?.human_percentage > 50 ? 'text-emerald-500' : 'text-slate-800 dark:text-white'" x-text="result?.human_percentage + '%'"></div>
                        <div class="text-[9px] font-bold text-slate-500 uppercase tracking-wider"><i class="fa-solid fa-user text-emerald-500 mr-1"></i> Human</div>
                    </div>
                </div>

                <div class="w-full h-3 bg-emerald-500 rounded-full overflow-hidden flex mb-6 shadow-inner">
                    <div class="h-full bg-rose-500 transition-all duration-1000 ease-out relative" :style="'width: ' + result?.ai_percentage + '%'">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgc3Ryb2tlPSIjZmZmZmZmIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1vcGFjaXR5PSIwLjIiPjxsaW5lIHgxPSItMTAiIHkxPSIyMCIgeDI9IjIwIiB5MT0iLTEwIiAvPjwvZz48L3N2Zz4=')] opacity-50"></div>
                    </div>
                </div>

                <div class="p-4 rounded-xl border-l-4 bg-slate-50 dark:bg-slate-800/50 text-[13px] leading-relaxed text-slate-700 dark:text-slate-300 font-medium"
                     :class="result?.ai_percentage > 50 ? 'border-rose-500' : 'border-emerald-500'" x-text="result?.summary">
                </div>
            </div>
        </div>

        <div x-show="result && !loading" style="display: none;" class="lg:col-span-9 lg:col-start-4">
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white flex items-center gap-2 uppercase tracking-widest">
                        <i class="fa-solid fa-highlighter text-fuchsia-500"></i> Detail Teks Terdeteksi
                    </h3>
                    <div class="flex items-center gap-4 text-[10px] sm:text-xs font-bold text-slate-500">
                        <span class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-rose-500/50 border border-rose-500"></div> Pola AI</span>
                        <span class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-transparent border border-slate-300 dark:border-slate-600"></div> Pola Manusia</span>
                    </div>
                </div>

                <div class="text-slate-700 dark:text-slate-300 leading-loose text-sm sm:text-base font-medium whitespace-pre-wrap" x-html="result?.highlighted_html"></div>
            </div>
        </div>

    </div>
</div>

<script>
function aiDetector() {
    return {
        // State API Key & UI
        apiKey: localStorage.getItem('gemini_api_key_detector') || '',
        showKey: false,
        
        // State Core
        inputText: '',
        textLength: 0,
        loading: false,
        loadingText: 'Menganalisis...',
        result: null,
        isDragging: false,

        saveKey() {
            localStorage.setItem('gemini_api_key_detector', this.apiKey);
        },

        handleDrop(event) {
            this.isDragging = false;
            let file = event.dataTransfer.files[0];
            if (file) this.uploadFile(file);
        },

        async uploadFile(file) {
            if (!file) return;
            
            if (!this.apiKey) {
                alert('Silakan masukkan API Key Gemini Anda di sidebar terlebih dahulu.');
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 5MB.');
                return;
            }

            this.loading = true;
            this.loadingText = 'Membaca Isi File...';
            this.result = null;

            let formData = new FormData();
            formData.append('file', file);
            formData.append('apiKey', this.apiKey);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            try {
                const response = await fetch('<?= base_url('ailab/extract-file') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    this.inputText = data.text + '\n\n' + this.inputText;
                    this.textLength = this.inputText.length;
                } else {
                    alert(data.error || 'Gagal membaca file.');
                }
            } catch (e) {
                alert('Terjadi kesalahan saat upload file.');
            } finally {
                this.loading = false;
                this.loadingText = 'Menganalisis...';
                this.$refs.fileInput.value = ''; 
            }
        },

        async analyze() {
            if (!this.apiKey) {
                alert('Silakan masukkan API Key Gemini Anda di sidebar terlebih dahulu.');
                return;
            }

            if (this.inputText.length < 50) {
                alert('Teks terlalu pendek. Minimal 50 karakter.');
                return;
            }

            this.loading = true;
            this.loadingText = 'Menganalisis Pola...';
            this.result = null;

            let formData = new FormData();
            formData.append('text', this.inputText);
            formData.append('apiKey', this.apiKey);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            try {
                const response = await fetch('<?= base_url('ailab/analyze-text') ?>', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    this.result = data.data;
                    setTimeout(() => {
                        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                    }, 100);
                } else {
                    alert(data.error || 'Gagal menganalisis teks.');
                }
            } catch (error) {
                alert('Terjadi kesalahan jaringan atau respons server tidak valid.');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>

<?= $this->endSection() ?>