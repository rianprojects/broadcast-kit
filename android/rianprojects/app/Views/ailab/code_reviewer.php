<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="codeReview()" class="max-w-7xl mx-auto py-12 px-4 sm:px-6">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit">
            AI Code <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-orange-500">Reviewer</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm">
            Temukan bug, celah keamanan, dan optimalkan kodingan Anda secara instan layaknya di-review oleh Senior Engineer.
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
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 pr-12 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-rose-500 outline-none transition-all" 
                           placeholder="Paste Gemini API Key...">
                    <button @click="showKey = !showKey" class="absolute right-4 top-3.5 text-slate-400 hover:text-rose-500 transition-colors">
                        <i class="fa-solid" :class="showKey ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                    <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-[10px] text-indigo-500 font-bold mt-3 inline-flex items-center gap-1 hover:underline">
                    Dapatkan API Key Gratis <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl space-y-6">
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Engine AI</label>
                    <div class="relative">
                        <select x-model="aiModel" class="w-full bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800/50 rounded-xl py-3 px-4 text-sm font-bold text-rose-700 dark:text-rose-400 outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 appearance-none cursor-pointer transition-all">
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash (Standard)</option>
                            <option value="gemini-2.5-flash-lite">Gemini 2.5 Flash-Lite (Ringan & Cepat)</option>
                            <option value="gemini-3-flash-preview">Gemini 3 Flash Preview (Next-Gen)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-rose-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Framework / Bahasa</label>
                    <div class="relative">
                        <select x-model="framework" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm font-medium text-slate-800 dark:text-white outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 appearance-none cursor-pointer">
                            <option value="PHP / CodeIgniter 4">PHP (CodeIgniter 4)</option>
                            <option value="Python">Python</option>
                            <option value="Node.js">Node.js</option>
                            <option value="Tailwind CSS / HTML">HTML & Tailwind CSS</option>
                            <option value="General JavaScript">JavaScript (Vanilla/Alpine)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-rose-500">
                            <i class="fa-solid fa-code"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Paste Kodingan</label>
                    </div>
                    <textarea x-model="code" @input="saveToLocal()" rows="12" class="w-full bg-[#1e1e1e] border border-slate-700 rounded-xl p-4 text-sm text-[#d4d4d4] font-mono outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/50 transition-all resize-none shadow-inner" placeholder="<?php echo "public function index() {\n    // Paste kode kamu di sini...\n    echo 'Hello World';\n}"; ?>"></textarea>
                </div>

                <button @click="generate()" :disabled="loading || !code" 
                    class="w-full relative group bg-gradient-to-r from-rose-500 to-orange-500 hover:from-rose-600 hover:to-orange-600 text-white font-black py-4 rounded-xl shadow-lg shadow-rose-500/30 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 overflow-hidden">
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                    
                    <template x-if="loading">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-notch animate-spin"></i> Menganalisis Kode...</div>
                    </template>
                    <template x-if="!loading">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-bug-slash"></i> Audit & Optimasi</div>
                    </template>
                </button>
            </div>
        </div>

        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white dark:bg-slate-900/80 p-8 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl relative min-h-[600px] flex flex-col">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4 mb-6 relative z-20">
                    <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700">
                        <span class="w-2 h-2 rounded-full bg-rose-50 animate-pulse shadow-[0_0_8px_#f43f5e]"></span> Senior AI Engineer
                    </div>
                    
                    <div class="flex gap-2" x-show="result && !loading">
                        <button @click="clearData()" class="text-rose-500 hover:text-rose-600 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2">
                            <i class="fa-solid fa-trash"></i> Clear
                        </button>
                        <button @click="copyCode()" class="bg-slate-100 dark:bg-slate-800 hover:bg-rose-50 dark:hover:bg-rose-900/30 text-slate-600 dark:text-slate-300 hover:text-rose-600 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2 border border-slate-200 dark:border-slate-700">
                            <i class="fa-regular" :class="copied ? 'fa-circle-check text-emerald-500' : 'fa-copy'"></i> 
                            <span x-text="copied ? 'Tersalin!' : 'Copy Hasil'"></span>
                        </button>
                    </div>
                </div>

                <div class="flex-1 relative">
                    <div x-show="!result" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 transition-opacity duration-300" :class="loading ? 'opacity-20' : 'opacity-100'">
                        <i class="fa-solid fa-laptop-code text-6xl mb-4 opacity-30"></i>
                        <p class="font-medium text-sm">Hasil audit akan muncul di sini</p>
                    </div>

                    <div x-show="result && !loading" x-transition.opacity class="w-full pb-8">
                        <div class="custom-prose dark:prose-invert max-w-none prose-pre:bg-[#1e1e1e] prose-pre:text-[#d4d4d4] prose-pre:border prose-pre:border-slate-700 prose-pre:shadow-xl">
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

</div>

<script>
function codeReview() {
    return {
        apiKey: localStorage.getItem('gemini_api_key') || '',
        showKey: false,
        aiModel: 'gemini-2.5-flash',
        framework: 'PHP / CodeIgniter 4',
        
        code: localStorage.getItem('gemini_code_input') || '',
        result: localStorage.getItem('gemini_code_result') || '',
        
        loading: false,
        copied: false,
        errorModal: false,
        errorMessage: '',

        saveKey() {
            localStorage.setItem('gemini_api_key', this.apiKey);
        },

        saveToLocal() {
            localStorage.setItem('gemini_code_input', this.code);
            localStorage.setItem('gemini_code_result', this.result);
        },

        clearData() {
            if(confirm("Yakin ingin menghapus kodingan dan hasil review?")) {
                this.code = ''; 
                this.result = '';
                localStorage.removeItem('gemini_code_input');
                localStorage.removeItem('gemini_code_result');
            }
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
            if (!this.code.trim()) return this.showError('Peringatan: Kolom kodingan masih kosong!');
            
            this.loading = true;
            
            let formData = new FormData();
            formData.append('apiKey', this.apiKey);
            formData.append('aiModel', this.aiModel);
            formData.append('framework', this.framework);
            formData.append('code', this.code);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            try {
                const response = await fetch('<?= base_url('ailab/analyze-code') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.content) {
                    let formatted = data.content;
                    
                    this.result = formatted;
                    this.saveToLocal(); 
                } else {
                    this.showError(data.message || 'Ups! Gagal menganalisis kode. Pastikan API Key valid atau coba lagi nanti.');
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                this.showError('Terjadi kesalahan jaringan. Pastikan server kamu berjalan dengan baik dan endpoint tersedia.');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
<?= $this->endSection() ?>