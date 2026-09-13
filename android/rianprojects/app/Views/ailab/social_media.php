<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="socialGen()" class="max-w-7xl mx-auto py-12 px-4 sm:px-6">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit">
            Viral Post <span class="text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-500 to-pink-500">Generator</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm">
            Ubah artikel panjang atau poster gambar menjadi 3 variasi konten sosial media yang <em>engaging</em> lengkap dengan Skor Viral!
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
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 pr-12 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" 
                           placeholder="Paste Gemini API Key...">
                    <button @click="showKey = !showKey" class="absolute right-4 top-3.5 text-slate-400 hover:text-fuchsia-500 transition-colors">
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
                        <select x-model="aiModel" class="w-full bg-fuchsia-50 dark:bg-fuchsia-900/20 border border-fuchsia-200 dark:border-fuchsia-800/50 rounded-xl py-3 px-4 text-sm font-bold text-fuchsia-700 dark:text-fuchsia-400 outline-none focus:border-fuchsia-500 appearance-none cursor-pointer transition-all">
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash (Standard - Teks & Gambar)</option>
                            <option value="gemini-2.5-flash-lite">Gemini 2.5 Flash-Lite (Ringan & Cepat)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-fuchsia-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Platform & Gaya Bahasa</label>
                    <div class="grid grid-cols-2 gap-4">
                        <select x-model="platform" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-xs font-medium text-slate-800 dark:text-white outline-none focus:border-fuchsia-500 transition-all">
                            <option value="Instagram (Caption)">Instagram</option>
                            <option value="X / Twitter (Thread)">Twitter / X</option>
                            <option value="TikTok (Hook & Script)">TikTok</option>
                            <option value="LinkedIn (Professional)">LinkedIn</option>
                        </select>
                        <select x-model="tone" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-xs font-medium text-slate-800 dark:text-white outline-none focus:border-fuchsia-500 transition-all">
                            <option value="Storytelling Emosional">Emosional</option>
                            <option value="Anak Jaksel Kekinian">Kekinian / Gaul</option>
                            <option value="Profesional & Tegas">Profesional</option>
                            <option value="Humoris & Nyeleneh">Humoris</option>
                        </select>
                    </div>
                </div>

                <div class="bg-slate-100 dark:bg-slate-800 p-1 rounded-xl flex gap-1">
                    <button @click="inputType = 'text'" :class="inputType === 'text' ? 'bg-white dark:bg-slate-700 text-fuchsia-600 dark:text-fuchsia-400 shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-align-left"></i> Dari Teks
                    </button>
                    <button @click="inputType = 'image'" :class="inputType === 'image' ? 'bg-white dark:bg-slate-700 text-fuchsia-600 dark:text-fuchsia-400 shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-regular fa-image"></i> Dari Poster
                    </button>
                </div>

                <div x-show="inputType === 'text'" x-transition>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Materi / Topik</label>
                    <textarea x-model="topic" rows="5" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm text-slate-800 dark:text-white outline-none focus:border-fuchsia-500 transition-all resize-none" placeholder="Paste ide pokok atau artikel di sini..."></textarea>
                </div>

                <div x-show="inputType === 'image'" x-transition style="display: none;">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Upload Poster</label>
                    <div class="relative w-full h-40 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl hover:border-fuchsia-500 transition-colors flex items-center justify-center bg-slate-50 dark:bg-slate-800/50 overflow-hidden group mb-3">
                        <input type="file" @change="handleImageUpload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/*">
                        <div x-show="!imagePreview" class="text-center pointer-events-none">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-fuchsia-300 dark:text-fuchsia-700 mb-2"></i>
                            <p class="text-xs font-bold text-slate-500">Klik / Drop gambar di sini</p>
                        </div>
                        <img x-show="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-contain opacity-90 z-10 bg-slate-900">
                    </div>
                    <label class="block text-[10px] font-bold text-slate-400 mb-1">Instruksi Tambahan (Opsional)</label>
                    <input type="text" x-model="topic" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-2.5 px-4 text-xs text-slate-800 dark:text-white outline-none focus:border-fuchsia-500 transition-all" placeholder="Buatkan caption promo dari poster ini...">
                </div>

            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl relative flex flex-col min-h-[500px]">
                
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-8 border-b border-slate-100 dark:border-slate-800 pb-6 relative z-20">
                    <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700">
                        <span class="w-2 h-2 rounded-full bg-fuchsia-500 animate-pulse shadow-[0_0_8px_#d946ef]"></span> Multiple Output Engine
                    </div>
                    
                    <button @click="generate()" :disabled="loading" 
                        class="w-full sm:w-auto relative group bg-gradient-to-r from-fuchsia-500 to-pink-500 hover:from-fuchsia-600 hover:to-pink-600 text-white font-black px-10 py-3.5 rounded-2xl shadow-lg shadow-fuchsia-500/30 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 overflow-hidden min-w-[200px]">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                    
                        <template x-if="loading">
                            <div class="flex items-center gap-2"><i class="fa-solid fa-circle-notch animate-spin"></i> Meracik Variasi...</div>
                        </template>
                        <template x-if="!loading">
                            <div class="flex items-center gap-2"><i class="fa-solid fa-fire-flame-curved"></i> Generate Post</div>
                        </template>
                    </button>
                </div>

                <div class="flex-1 relative">
                    <div x-show="result.length === 0 && !loading" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                        <i class="fa-solid fa-mobile-screen-button text-6xl mb-4 opacity-50"></i>
                        <p class="font-medium text-sm text-center">3 Variasi Draf Postingan<br>akan muncul di sini</p>
                    </div>

                    <div x-show="loading" class="absolute inset-0 flex flex-col items-center justify-center text-fuchsia-500 bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm z-30 rounded-[2rem]">
                        <i class="fa-brands fa-usps text-6xl mb-6 animate-bounce drop-shadow-[0_0_15px_rgba(217,70,239,0.5)]"></i>
                        <p class="font-bold text-lg animate-pulse text-slate-800 dark:text-white">Menyusun opsi & Menghitung Skor Viral...</p>
                    </div>

                    <div x-show="result.length > 0 && !loading" x-transition.opacity class="w-full pb-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
                            <template x-for="(post, index) in result" :key="index">
                                <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 flex flex-col hover:shadow-xl hover:border-fuchsia-300 dark:hover:border-fuchsia-700 transition-all duration-300">
                                    
                                    <div class="flex justify-between items-center mb-5 border-b border-slate-200 dark:border-slate-700 pb-4">
                                        <span class="text-xs font-black uppercase tracking-widest text-slate-400">Opsi <span x-text="index + 1"></span></span>
                                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-orange-100 dark:border-orange-900/30">
                                            <i class="fa-solid fa-fire text-orange-500"></i>
                                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Skor: <span x-text="post.score" class="text-orange-500 font-black"></span>/100</span>
                                        </div>
                                    </div>

                                    <div class="custom-prose dark:prose-invert max-w-none text-sm leading-relaxed flex-1 mb-6">
                                        <div x-html="post.content"></div>
                                    </div>

                                    <div class="mt-auto">
                                        <button @click="copyText(post.content, index)" 
                                            class="w-full bg-white dark:bg-slate-900 hover:bg-fuchsia-50 dark:hover:bg-fuchsia-900/30 text-slate-600 dark:text-slate-300 hover:text-fuchsia-600 dark:hover:text-fuchsia-400 text-xs font-bold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2 border border-slate-200 dark:border-slate-700 shadow-sm active:scale-95">
                                            <i class="fa-solid" :class="copiedIndex === index ? 'fa-check text-emerald-500' : 'fa-copy'"></i> 
                                            <span x-text="copiedIndex === index ? 'Tersalin!' : 'Copy Opsi Ini'"></span>
                                        </button>
                                    </div>
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
function socialGen() {
    return {
        apiKey: localStorage.getItem('gemini_api_key') || '',
        showKey: false,
        aiModel: 'gemini-2.5-flash',
        platform: 'Instagram (Caption)',
        tone: 'Storytelling Emosional',
        
        inputType: 'text',
        topic: '',
        imageFile: null,
        imagePreview: null,
        
        result: [], 
        loading: false,
        copiedIndex: null, 
        errorModal: false,
        errorMessage: '',

        saveKey() {
            localStorage.setItem('gemini_api_key', this.apiKey);
        },

        showError(msg) {
            this.errorMessage = msg;
            this.errorModal = true;
        },

        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.imageFile = file;
                this.imagePreview = URL.createObjectURL(file);
            }
        },

        async compressImage(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = (e) => {
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        const MAX_WIDTH = 1024;
                        let width = img.width;
                        let height = img.height;

                        if (width > MAX_WIDTH) {
                            height = Math.round((height * MAX_WIDTH) / width);
                            width = MAX_WIDTH;
                        }

                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        canvas.toBlob((blob) => {
                            resolve(new File([blob], file.name, { type: 'image/jpeg' }));
                        }, 'image/jpeg', 0.8);
                    };
                    img.onerror = (error) => reject(error);
                };
                reader.onerror = (error) => reject(error);
            });
        },

        async copyText(textHtml, index) {
            try {
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = textHtml;
                const textToCopy = tempDiv.innerHTML.replace(/<br\s*[\/]?>/gi, "\n").replace(/<[^>]+>/g, "");

                await navigator.clipboard.writeText(textToCopy.trim());
                this.copiedIndex = index;
                setTimeout(() => this.copiedIndex = null, 2500);
            } catch (err) {
                this.showError('Gagal menyalin teks!');
            }
        },

        async generate() {
            if (!this.apiKey) return this.showError('Gemini API Key belum dimasukkan!');
            
            if (this.inputType === 'text' && !this.topic.trim()) {
                return this.showError('Materi/Artikel sumber tidak boleh kosong!');
            }
            if (this.inputType === 'image' && !this.imageFile) {
                return this.showError('Silakan upload poster/gambar terlebih dahulu!');
            }
            
            this.loading = true;
            this.result = []; 
            
            let formData = new FormData();
            formData.append('apiKey', this.apiKey);
            formData.append('aiModel', this.aiModel);
            formData.append('platform', this.platform);
            formData.append('tone', this.tone);
            formData.append('inputType', this.inputType);
            formData.append('topic', this.topic); 
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            try {
                if (this.inputType === 'image' && this.imageFile) {
                    const compressedImg = await this.compressImage(this.imageFile);
                    formData.append('poster_image', compressedImg);
                }
            } catch (err) {
                this.loading = false;
                console.error("Kompresi Error:", err);
                return this.showError('Gagal memproses dan mengompresi gambar.');
            }
            
            try {
                const response = await fetch('<?= base_url('ailab/generate-social') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const rawText = await response.text();
                let data;
                
                try {
                    data = JSON.parse(rawText);
                } catch(e) {
                    console.error("RAW ERROR PHP:", rawText);
                    return this.showError("PHP CRASH! Buka F12 (Console). Cuplikan: " + rawText.substring(0, 150));
                }
                
                if (response.ok && data.variations) {
                    this.result = data.variations.map(item => {
                        let safePattern = item.content.replace(/```html\n?/g, '').replace(/```\n?/g, '').trim();
                        item.content = safePattern
                            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                            .replace(/\*(.*?)\*/g, '<em>$1</em>');
                        return item;
                    });
                } else {
                    let apiError = data.error || JSON.stringify(data);
                    if (apiError.includes('high demand') || apiError.includes('exhausted')) {
                        this.showError("Server AI Google sedang penuh/sibuk antrean. Silakan coba ganti Engine AI ke 'Flash-Lite'.");
                    } else {
                        this.showError("DETAIL ERROR: " + apiError);
                    }
                }
            } catch (e) {
                this.showError('Terjadi kesalahan jaringan atau fetch gagal. Pastikan API key valid dan koneksi stabil.');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>

<?= $this->endSection() ?>