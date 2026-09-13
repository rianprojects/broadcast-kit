<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="blogGen()" class="max-w-7xl mx-auto py-12 px-4 sm:px-6">
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit">
            SEO Content <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500">Writer</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm">
            Hasilkan draf artikel blog terstruktur, 90% gaya manusia (Humanize), dengan fitur <span class="font-bold text-emerald-500">Deep Research</span> (menyertakan sumber).
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-4 text-amber-500">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3 class="font-bold text-sm uppercase tracking-wider">Privacy Mode</h3>
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

            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gaya Penulisan (Tone)</label>
                    <div class="relative">
                        <select x-model="tone" @change="saveToLocal()" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm font-bold text-slate-700 dark:text-slate-300 outline-none focus:border-emerald-500 appearance-none cursor-pointer transition-all">
                            <option value="Santai, Mengalir, dan Menggunakan Teknik Parafrase 90% Manusia">Santai & Mengalir (Humanize)</option>
                            <option value="Profesional, Formal, Terpercaya, dan Objektif">Profesional & Edukatif</option>
                            <option value="Jurnalistik, Tajam, Lugas, Seperti Portal Berita Top">Berita / Jurnalistik</option>
                            <option value="Bercerita (Storytelling), Emosional, dan Melibatkan Pembaca">Bercerita (Storytelling)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Engine AI</label>
                    <div class="relative">
                        <select x-model="aiModel" @change="saveToLocal()" class="w-full bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl py-3 px-4 text-sm font-bold text-emerald-700 dark:text-emerald-400 outline-none focus:border-emerald-500 appearance-none cursor-pointer transition-all">
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash (Standard)</option>
                            <option value="gemini-2.5-flash-lite">Gemini 2.5 Flash-Lite (Fast)</option>
                            <option value="gemini-3.1-flash-preview">Gemini 3.1 Flash (Advanced Deep Research)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-emerald-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 dark:border-slate-800 pt-5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Topik Utama</label>
                    <textarea x-model="topic" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm text-slate-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all resize-none" placeholder="Cth: Tren teknologi web development terbaru..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Target Kata Kunci (Pisahkan koma)</label>
                    <input type="text" x-model="keywords" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm text-slate-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="ai, web developer 2026, framework">
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white dark:bg-slate-900/80 p-8 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl relative flex flex-col min-h-[500px]">
                
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-8 border-b border-slate-100 dark:border-slate-800 pb-6 relative z-20">
                    <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_#10b981]"></span> Auto-Humanize + Deep Research
                    </div>
                    
                    <div class="flex flex-col items-end w-full sm:w-auto">
                        <button @click="generate()" :disabled="loading || cooldown > 0" 
                            class="w-full sm:w-auto relative group bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-black px-10 py-3.5 rounded-2xl shadow-lg shadow-emerald-500/30 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 overflow-hidden min-w-[200px]">
                        
                            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                        
                            <template x-if="loading">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-notch animate-spin"></i>
                                    <span>Browsing Internet...</span>
                                </div>
                            </template>
                            
                            <template x-if="!loading && cooldown === 0">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-robot"></i>
                                    <span>Generate Artikel</span>
                                </div>
                            </template>
                            
                            <template x-if="!loading && cooldown > 0">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-hourglass-half"></i>
                                    <span x-text="'Tunggu ' + cooldown + 's'"></span>
                                </div>
                            </template>
                        </button>
                    </div>
                </div>

                <div class="flex-1 relative">
                    
                    <div x-show="!result && !loading" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                        <i class="fa-regular fa-file-lines text-6xl mb-4 opacity-50"></i>
                        <p class="font-medium text-sm">Draf artikel Anda akan muncul di sini</p>
                    </div>

                    <div x-show="loading" class="absolute inset-0 flex flex-col items-center justify-center text-emerald-500 bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm z-30 rounded-[2rem]">
                        <i class="fa-solid fa-globe text-6xl mb-6 animate-bounce drop-shadow-[0_0_15px_rgba(16,185,129,0.5)]"></i>
                        <p class="font-bold text-lg animate-pulse text-slate-800 dark:text-white" x-text="loadingStep"></p>
                        <div class="w-48 h-1.5 bg-slate-200 dark:bg-slate-800 rounded-full mt-4 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full animate-[loading_2s_ease-in-out_infinite]"></div>
                        </div>
                    </div>

                    <div x-show="result" x-transition.opacity class="w-full pb-8">
                        
                        <div class="flex justify-between items-center mb-6">
                            <button @click="resetArticle()" class="text-rose-500 hover:text-rose-600 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </button>
                            
                            <button @click="copySpecific(result, 'htmlCopied')" class="bg-slate-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 text-xs font-bold py-2 px-4 rounded-xl transition flex items-center gap-2 border border-slate-200 dark:border-slate-700">
                                <i class="fa-solid" :class="copyStatus.htmlCopied ? 'fa-check text-emerald-500' : 'fa-code'"></i> 
                                <span x-text="copyStatus.htmlCopied ? 'Tersalin!' : 'Copy Pure HTML'"></span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-4 mb-8">
                            <div class="bg-indigo-50/50 dark:bg-indigo-900/10 p-4 rounded-2xl border border-indigo-100 dark:border-indigo-800/30 flex justify-between items-start gap-4 group">
                                <div class="flex-1">
                                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-wider mb-1 block">Meta Title SEO</span>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200" x-text="metaTitle"></p>
                                </div>
                                <button @click="copySpecific(metaTitle, 'titleCopied')" class="text-slate-400 hover:text-indigo-600 p-2 bg-white dark:bg-slate-800 rounded-lg shadow-sm opacity-0 group-hover:opacity-100 transition-all">
                                    <i class="fa-solid" :class="copyStatus.titleCopied ? 'fa-check text-emerald-500' : 'fa-copy'"></i>
                                </button>
                            </div>
                            
                            <div class="bg-indigo-50/50 dark:bg-indigo-900/10 p-4 rounded-2xl border border-indigo-100 dark:border-indigo-800/30 flex justify-between items-start gap-4 group">
                                <div class="flex-1">
                                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-wider mb-1 block">Meta Description SEO</span>
                                    <p class="text-xs font-medium text-slate-600 dark:text-slate-400 leading-relaxed" x-text="metaDesc"></p>
                                </div>
                                <button @click="copySpecific(metaDesc, 'descCopied')" class="text-slate-400 hover:text-indigo-600 p-2 bg-white dark:bg-slate-800 rounded-lg shadow-sm opacity-0 group-hover:opacity-100 transition-all">
                                    <i class="fa-solid" :class="copyStatus.descCopied ? 'fa-check text-emerald-500' : 'fa-copy'"></i>
                                </button>
                            </div>

                            <div class="bg-indigo-50/50 dark:bg-indigo-900/10 p-4 rounded-2xl border border-indigo-100 dark:border-indigo-800/30 flex justify-between items-start gap-4 group">
                                <div class="flex-1">
                                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-wider mb-1 block">Tags / Keywords</span>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <template x-for="tag in metaTags.split(',')" :key="tag">
                                            <span class="px-2 py-1 bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold rounded-md shadow-sm border border-indigo-100 dark:border-indigo-800" x-text="tag.trim()"></span>
                                        </template>
                                    </div>
                                </div>
                                <button @click="copySpecific(metaTags, 'tagsCopied')" class="text-slate-400 hover:text-indigo-600 p-2 bg-white dark:bg-slate-800 rounded-lg shadow-sm opacity-0 group-hover:opacity-100 transition-all">
                                    <i class="fa-solid" :class="copyStatus.tagsCopied ? 'fa-check text-emerald-500' : 'fa-copy'"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="custom-prose dark:prose-invert max-w-none bg-slate-50 dark:bg-slate-800/30 p-6 sm:p-10 rounded-3xl border border-slate-100 dark:border-slate-800">
                            <div x-html="result"></div>

                            <template x-if="sources.length > 0">
                                <div class="mt-10 pt-6 border-t border-slate-200 dark:border-slate-700">
                                    <h4 class="text-sm font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-link text-emerald-500"></i> Sumber Referensi Penulisan:
                                    </h4>
                                    <ul class="space-y-2">
                                        <template x-for="(source, index) in sources" :key="index">
                                            <li class="flex items-start gap-2">
                                                <i class="fa-solid fa-check text-emerald-500 mt-1 text-[10px]"></i>
                                                <a :href="source.url" target="_blank" class="text-xs text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors line-clamp-1" x-text="source.title || source.url"></a>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </template>

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
function blogGen() {
    return {
        apiKey: localStorage.getItem('gemini_api_key') || '',
        aiModel: localStorage.getItem('gemini_blog_model') || 'gemini-2.5-flash',
        tone: localStorage.getItem('gemini_blog_tone') || 'Santai, Mengalir, dan Menggunakan Teknik Parafrase 90% Manusia',
        showKey: false,
        topic: '',
        keywords: '',
        metaTitle: localStorage.getItem('gemini_blog_title') || '',
        metaDesc: localStorage.getItem('gemini_blog_desc') || '',
        metaTags: localStorage.getItem('gemini_blog_tags') || '',
        result: localStorage.getItem('gemini_blog_content') || '',
        sources: JSON.parse(localStorage.getItem('gemini_blog_sources')) || [],
        loading: false,
        loadingStep: '',
        loadingInterval: null,
        cooldown: 0,
        errorModal: false,
        errorMessage: '',
        
        copyStatus: { titleCopied: false, descCopied: false, tagsCopied: false, htmlCopied: false },

        saveKey() {
            localStorage.setItem('gemini_api_key', this.apiKey);
        },

        saveToLocal() {
            localStorage.setItem('gemini_blog_model', this.aiModel);
            localStorage.setItem('gemini_blog_tone', this.tone);
            localStorage.setItem('gemini_blog_title', this.metaTitle);
            localStorage.setItem('gemini_blog_desc', this.metaDesc);
            localStorage.setItem('gemini_blog_tags', this.metaTags);
            localStorage.setItem('gemini_blog_content', this.result);
            localStorage.setItem('gemini_blog_sources', JSON.stringify(this.sources));
        },

        startCooldown() {
            this.cooldown = 15;
            let timer = setInterval(() => {
                this.cooldown--;
                if(this.cooldown <= 0) clearInterval(timer);
            }, 1000);
        },

        showError(msg) {
            this.errorMessage = msg;
            this.errorModal = true;
        },

        async copySpecific(text, statusKey) {
            try {
                await navigator.clipboard.writeText(text);
                this.copyStatus[statusKey] = true;
                setTimeout(() => this.copyStatus[statusKey] = false, 2000);
            } catch (err) {
                this.showError('Gagal menyalin teks!');
            }
        },

        resetArticle() {
            if(confirm("Yakin ingin membuat artikel baru? Artikel saat ini akan dihapus.")){
                this.metaTitle = ''; this.metaDesc = ''; this.metaTags = ''; this.result = '';
                this.topic = ''; this.keywords = ''; this.sources = [];
                localStorage.removeItem('gemini_blog_title');
                localStorage.removeItem('gemini_blog_desc');
                localStorage.removeItem('gemini_blog_tags');
                localStorage.removeItem('gemini_blog_content');
                localStorage.removeItem('gemini_blog_sources');
            }
        },

        runLoadingAnimation() {
            const steps = [
                "Melakukan Web Search untuk data terbaru...",
                "Menganalisis tren dan statistik terkini...",
                "Memparafrase kalimat agar 90% Human-Like...",
                "Menyusun struktur Meta SEO & HTML..."
            ];
            let stepIdx = 0;
            this.loadingStep = steps[0];
            this.loadingInterval = setInterval(() => {
                stepIdx++;
                if(stepIdx < steps.length) {
                    this.loadingStep = steps[stepIdx];
                }
            }, 3500);
        },

        extractTag(text, tag) {
            const regex = new RegExp(`\\[${tag}\\]([\\s\\S]*?)\\[\\/${tag}\\]`, 'i');
            const match = text.match(regex);
            return match ? match[1].trim() : '';
        },

        async generate() {
            if (!this.apiKey) return this.showError('Peringatan: API Key belum dimasukkan!');
            if (!this.topic) return this.showError('Peringatan: Topik utama tidak boleh kosong!');
            if (this.cooldown > 0) return; 
            
            this.loading = true;
            this.runLoadingAnimation();

            let advancedTopic = this.topic + `\n\nINSTRUKSI WAJIB SISTEM: 
1. Keluarkan output dengan format persis seperti di bawah ini.
[META_TITLE]
Isi judul artikel SEO (Maks 60 Karakter)
[/META_TITLE]
[META_DESC]
Isi deskripsi SEO (Maks 155 Karakter)
[/META_DESC]
[META_TAGS]
tag1, tag2, tag3
[/META_TAGS]
[CONTENT]
<h1>Isi Judul H1 Disini</h1>
<p>Isi paragraf pembuka</p>
<h2>Sub Judul H2</h2>
<p>Isi paragraf format HTML murni, gunakan tag <ul>, <li>, <strong>.</p>
[/CONTENT]`;
            
            let formData = new FormData();
            formData.append('apiKey', this.apiKey);
            formData.append('aiModel', this.aiModel);
            formData.append('topic', advancedTopic);
            formData.append('keywords', this.keywords);
            formData.append('tone', this.tone);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            try {
                const response = await fetch('<?= base_url('ailab/generate-content') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.content) {
                    let rawContent = data.content;
                    this.metaTitle = this.extractTag(rawContent, 'META_TITLE');
                    this.metaDesc = this.extractTag(rawContent, 'META_DESC');
                    this.metaTags = this.extractTag(rawContent, 'META_TAGS');
                    
                    let htmlContent = this.extractTag(rawContent, 'CONTENT');
                    if(!htmlContent) htmlContent = rawContent.replace(/\[META_.*\][\s\S]*?\[\/META_.*\]/gi, '');
                    
                    this.result = htmlContent.replace(/```html\n?/g, '').replace(/```\n?/g, '').trim();
                    this.sources = data.sources || [];

                    this.saveToLocal();
                    this.startCooldown(); 
                } else {
                    this.showError(data.error || 'Gagal menyusun artikel. Pastikan API Key valid.');
                }
            } catch (e) {
                this.showError('Terjadi kesalahan jaringan atau server timeout saat melakukan Deep Research.');
            } finally {
                clearInterval(this.loadingInterval);
                this.loading = false;
            }
        }
    }
}
</script>

<style>
@keyframes loading {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(400%); }
}
</style>

<?= $this->endSection() ?>