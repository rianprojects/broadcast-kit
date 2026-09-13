<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="imageGen()" class="max-w-7xl mx-auto py-12 px-4 sm:px-6">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit">
            AI Image <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">Generator</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm">
            Kreasikan imajinasimu menjadi visual nyata. Atur parameter secara presisi untuk hasil maksimal.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-3 space-y-6 flex flex-col h-full">
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
                               class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 pr-12 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all" 
                               placeholder="Paste Gemini API Key...">
                        <button @click="showKey = !showKey" class="absolute right-4 top-3.5 text-slate-400 hover:text-indigo-500 transition-colors">
                            <i class="fa-solid" :class="showKey ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    
                    <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-[10px] text-indigo-500 font-bold mt-3 inline-flex items-center gap-1 hover:underline">
                        Dapatkan API Key <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
            </div>

            <div class="bg-white dark:bg-slate-900/80 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-lg backdrop-blur-xl space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <i class="fa-solid fa-sliders text-indigo-500"></i>
                    <h3 class="font-bold text-slate-800 dark:text-white text-sm uppercase tracking-wider">Parameter</h3>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Model AI</label>
                    <div class="relative">
                        <select x-model="aiModel" class="w-full bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800/50 rounded-xl py-3 px-4 text-sm font-bold text-indigo-700 dark:text-indigo-400 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 appearance-none cursor-pointer transition-all">
                            <option value="gemini-2.5-flash-image">Gemini 2.5 Flash Image (Nano Banana)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-indigo-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Skala (Aspect Ratio)</label>
                    <div class="relative">
                        <select x-model="aspectRatio" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm font-medium text-slate-800 dark:text-white outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 appearance-none cursor-pointer transition-all">
                            <option value="1:1">1:1 (Square / Feed)</option>
                            <option value="16:9">16:9 (Landscape / Desktop)</option>
                            <option value="9:16">9:16 (Portrait / Reels)</option>
                            <option value="3:4">3:4 (Vertical Photo)</option>
                            <option value="4:3">4:3 (Standard Photo)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Jumlah (Batch)</label>
                    <div class="grid grid-cols-4 gap-2">
                        <template x-for="n in [1, 2, 3, 4]">
                            <button @click="batch = n" 
                                    :class="batch === n ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:border-indigo-400'"
                                    class="py-2 rounded-xl border text-xs font-bold transition-all" x-text="n">
                            </button>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1"><i class="fa-solid fa-user"></i> Foto Subjek</label>
                        <div class="relative w-full h-24 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl hover:border-indigo-500 transition-colors flex items-center justify-center bg-slate-50 dark:bg-slate-800/50 overflow-hidden group">
                            <input type="file" @change="handleSubjectUpload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/*">
                            <div x-show="!subjectPreview" class="text-center transition-transform group-hover:scale-105 pointer-events-none">
                                <i class="fa-solid fa-cloud-arrow-up text-xl text-indigo-300 dark:text-indigo-700 mb-1"></i>
                                <p class="text-[9px] font-bold text-slate-500">Upload Wajah</p>
                            </div>
                            <img x-show="subjectPreview" :src="subjectPreview" class="absolute inset-0 w-full h-full object-cover opacity-80 z-10">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1"><i class="fa-solid fa-shirt"></i> Foto Pakaian</label>
                        <div class="relative w-full h-24 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl hover:border-indigo-500 transition-colors flex items-center justify-center bg-slate-50 dark:bg-slate-800/50 overflow-hidden group">
                            <input type="file" @change="handleClothesUpload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/*">
                            <div x-show="!clothesPreview" class="text-center transition-transform group-hover:scale-105 pointer-events-none">
                                <i class="fa-solid fa-cloud-arrow-up text-xl text-indigo-300 dark:text-indigo-700 mb-1"></i>
                                <p class="text-[9px] font-bold text-slate-500">Upload Baju</p>
                            </div>
                            <img x-show="clothesPreview" :src="clothesPreview" class="absolute inset-0 w-full h-full object-cover opacity-80 z-10">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-8 space-y-6">
            
            <div class="bg-white dark:bg-slate-900/80 p-8 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl relative">
                
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fa-regular fa-image"></i> Gambar Referensi Pose / Latar (Opsional)
                    </label>
                    <div class="relative w-full h-32 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors flex items-center justify-center bg-slate-50 dark:bg-slate-800/50 overflow-hidden group">
                        <input type="file" @change="handleFileUpload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/*">
                        <div x-show="!imagePreview" class="text-center transition-transform group-hover:scale-105 pointer-events-none">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-indigo-300 dark:text-indigo-700 mb-2"></i>
                            <p class="text-xs font-bold text-slate-500">Klik atau drop gambar pose di sini</p>
                        </div>
                        <img x-show="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-cover opacity-60 z-10">
                        <div x-show="imagePreview" class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-white text-xs font-bold bg-indigo-600 px-3 py-1 rounded-lg">Ganti Gambar</span>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-emerald-500 uppercase tracking-wider mb-2">Positif Prompt</label>
                    <textarea x-model="prompt" rows="3" 
                              class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 text-lg font-medium text-slate-800 dark:text-white outline-none resize-none transition-all" 
                              placeholder="Deskripsikan detail lingkungan, gaya seni, pencahayaan... (Cth: cinematic lighting, outdoor, 8k resolution)"></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-bold text-rose-500 uppercase tracking-wider mb-2">Negatif Prompt</label>
                    <textarea x-model="negativePrompt" rows="2" 
                              class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl p-3 focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 text-sm text-slate-600 dark:text-slate-300 outline-none resize-none transition-all" 
                              placeholder="Apa yang TIDAK ingin Anda lihat? (Cth: low quality, blurry, bad anatomy, text)"></textarea>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6 border-t border-slate-100 dark:border-slate-800 pt-6">
                    <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_#10b981]"></span> 
                        <span x-text="aiModel === 'gemini-2.5-flash-image' ? 'Nano Banana Engine' : 'Standard Engine'"></span>
                    </div>
                    
                    <div class="flex flex-col items-end w-full sm:w-auto">
                        <button @click="generate()" :disabled="loading || cooldown > 0" 
                            class="w-full sm:w-auto relative group bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black px-10 py-4 rounded-2xl shadow-lg shadow-indigo-500/30 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:active:scale-100 flex items-center justify-center gap-3 overflow-hidden min-w-[200px]">
                        
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                    
                        <template x-if="loading">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-notch animate-spin"></i>
                                <span>Sedang Merender...</span>
                            </div>
                        </template>
                        
                        <template x-if="!loading && cooldown === 0">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                                <span>Hasilkan Gambar</span>
                            </div>
                        </template>
                        
                        <template x-if="!loading && cooldown > 0">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-hourglass-half"></i>
                                <span x-text="'Tunggu ' + cooldown + 's'"></span>
                            </div>
                        </template>
                    </button>
                        
                        <span x-show="cooldown > 0" x-transition.opacity class="text-[10px] text-amber-500 font-bold mt-2 text-right flex items-center gap-1">
                            <i class="fa-solid fa-triangle-exclamation"></i> Menghindari limit penggunaan API Key
                        </span>
                    </div>
                </div>
            </div>

            <div x-show="resultImages.length > 0" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-10" class="mt-8">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-4 border-b border-slate-200 dark:border-slate-800 pb-2">Hasil Render (<span x-text="resultImages.length"></span>)</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <template x-for="(img, index) in resultImages" :key="index">
                        <div class="relative group rounded-3xl overflow-hidden shadow-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 aspect-square cursor-pointer" @click="openPreview(img)">
                            <img :src="img" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-white text-xs font-bold bg-black/50 backdrop-blur-md px-2 py-1 rounded-md"><i class="fa-solid fa-expand mr-1"></i> Preview</span>
                                    <a :href="img" download="RianProjects-AI.png" @click.stop class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-500 transition shadow-lg">
                                        <i class="fa-solid fa-download text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>

    <template x-teleport="body">
        <div x-show="previewModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" x-cloak>
            <div x-show="previewModal" x-transition.opacity @click="previewModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>
            
            <div x-show="previewModal" x-transition.scale.95 class="relative w-full max-w-5xl bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-white/10 overflow-hidden flex flex-col max-h-[90vh]">
                
                <div class="flex justify-between items-center p-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                    <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <i class="fa-regular fa-image text-indigo-500"></i> Image Preview
                    </h3>
                    <button @click="previewModal = false" class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-500 hover:text-rose-500 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-auto bg-slate-100 dark:bg-black/50 p-4 flex items-center justify-center min-h-[50vh]">
                    <img :src="activeImage" class="max-w-full max-h-[70vh] object-contain rounded-xl shadow-lg border border-slate-200 dark:border-slate-800">
                </div>

                <div class="p-4 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center">
                    <div class="text-xs text-slate-500 hidden sm:block">
                        <span class="font-bold text-slate-700 dark:text-slate-300">Prompt:</span> <span class="line-clamp-1 truncate inline-block max-w-md align-bottom" x-text="prompt"></span>
                    </div>
                    <a :href="activeImage" download="RianProjects-AI.png" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold flex items-center gap-2 transition shadow-lg shadow-indigo-500/20">
                        <i class="fa-solid fa-download"></i> Download HD
                    </a>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="upgradeModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" x-cloak>
            <div x-show="upgradeModal" x-transition.opacity @click="upgradeModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>
            
            <div x-show="upgradeModal" x-transition.scale.95 class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-white/10 overflow-hidden text-center p-8">
                <div class="w-20 h-20 bg-amber-500/10 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3">Fitur Premium Google</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-6 text-sm leading-relaxed">
                    API Key Anda saat ini berada di "Free Tier". Google mengkhususkan model pembuat gambar (seperti Nano Banana) <strong>hanya untuk akun dengan penagihan aktif (Pay-as-you-go).</strong>
                </p>
                
                <div class="space-y-3">
                     <a href="https://console.cloud.google.com/billing" target="_blank" class="w-full block bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-amber-500/30">
                        Aktifkan Penagihan Google <i class="fa-solid fa-arrow-up-right-from-square ml-2 text-xs"></i>
                    </a>
                    <button @click="upgradeModal = false" class="w-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-4 rounded-2xl transition">
                        Nanti Saja
                    </button>
                </div>
            </div>
        </div>
    </template>

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
function imageGen() {
    return {
        apiKey: localStorage.getItem('gemini_api_key') || '',
        showKey: false,
        
        aiModel: 'gemini-2.5-flash-image',
        aspectRatio: '1:1',
        batch: 1,
        prompt: '',
        negativePrompt: '',
        
        uploadedFile: null,
        imagePreview: null,
        subjectFile: null,
        subjectPreview: null,
        clothesFile: null,
        clothesPreview: null,
        
        resultImages: [],
        loading: false,
        cooldown: 0,
        
        previewModal: false,
        activeImage: '',
        errorModal: false,
        errorMessage: '',
        upgradeModal: false, 

        saveKey() {
            localStorage.setItem('gemini_api_key', this.apiKey);
        },

        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.uploadedFile = file;
                this.imagePreview = URL.createObjectURL(file);
            }
        },

        handleSubjectUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.subjectFile = file;
                this.subjectPreview = URL.createObjectURL(file);
            }
        },

        handleClothesUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.clothesFile = file;
                this.clothesPreview = URL.createObjectURL(file);
            }
        },

        async compressImage(file) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
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
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        },

        startCooldown() {
            this.cooldown = 30; 
            let timer = setInterval(() => {
                this.cooldown--;
                if(this.cooldown <= 0) clearInterval(timer);
            }, 1000);
        },

        openPreview(imgSrc) {
            this.activeImage = imgSrc;
            this.previewModal = true;
        },

        showError(msg) {
            this.errorMessage = msg;
            this.errorModal = true;
        },

        async generate() {
            if (!this.apiKey) return this.showError('Peringatan: Gemini API Key belum dimasukkan di menu Privacy Mode!');
            if (!this.prompt) return this.showError('Peringatan: Positif Prompt tidak boleh kosong!');
            if (this.cooldown > 0) return; 
            
            this.loading = true;
            this.resultImages = [];
            
            let finalPrompt = `Action/Environment: ${this.prompt}. \n`;
            finalPrompt += `Aspect Ratio: ${this.aspectRatio}. \n`;
            if (this.negativePrompt) {
                finalPrompt += `NEGATIVE PROMPT (DO NOT INCLUDE): ${this.negativePrompt}.`;
            }

            let formData = new FormData();
            formData.append('apiKey', this.apiKey);
            formData.append('aiModel', this.aiModel);
            formData.append('prompt', finalPrompt);
            formData.append('batch', this.batch);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            try {
                if (this.uploadedFile) {
                    const compressed = await this.compressImage(this.uploadedFile);
                    formData.append('reference_image', compressed);
                }
                if (this.subjectFile) {
                    const compressed = await this.compressImage(this.subjectFile);
                    formData.append('subject_image', compressed);
                }
                if (this.clothesFile) {
                    const compressed = await this.compressImage(this.clothesFile);
                    formData.append('clothes_image', compressed);
                }
            } catch (err) {
                this.loading = false;
                return this.showError('Gagal memproses gambar. Pastikan format gambar valid.');
            }
            
            try {
                const response = await fetch('<?= base_url('ailab/generate-image') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.image_url) {
                    if(Array.isArray(data.image_url)) {
                        this.resultImages = data.image_url;
                    } else {
                        this.resultImages = [data.image_url];
                    }
                    this.startCooldown(); 
                } else if (response.status === 429) {
                    this.upgradeModal = true; 
                } else {
                    this.showError(data.error || 'Gagal generate gambar dari server. Pastikan API Key valid.');
                }
            } catch (e) {
                this.showError('Terjadi kesalahan jaringan atau server tidak merespon.');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>

<?= $this->endSection() ?>