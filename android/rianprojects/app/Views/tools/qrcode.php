<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<style>
    #qr-canvas-container canvas, 
    #qr-canvas-container svg {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
        border-radius: 0.5rem;
    }

    .color-swatch {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.15s ease;
        flex-shrink: 0;
    }
    .color-swatch:hover { transform: scale(1.15); }
    .color-swatch.active { border-color: #10b981; box-shadow: 0 0 0 2px white, 0 0 0 4px #10b981; }
    .dark .color-swatch.active { box-shadow: 0 0 0 2px #0f172a, 0 0 0 4px #10b981; }

    .tab-btn { transition: all 0.2s ease; }
    .tab-btn.active {
        background: linear-gradient(135deg, #10b981, #0d9488);
        color: white;
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
        border-color: transparent !important;
    }

    input[type="color"] {
        -webkit-appearance: none;
        appearance: none;
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        padding: 2px;
        background: transparent;
    }
    input[type="color"]::-webkit-color-swatch-wrapper { padding: 0; border-radius: 6px; }
    input[type="color"]::-webkit-color-swatch { border: none; border-radius: 6px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0-rc.1/lib/qr-code-styling.js"></script>

<div x-data="qrGenerator()" x-init="init()" class="max-w-7xl mx-auto py-12 sm:py-16 px-4 sm:px-6 min-h-[80vh]">
    <?= $this->include('components/breadcrumb') ?>
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl mb-4 text-emerald-500">
            <i class="fa-solid fa-qrcode text-3xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit tracking-tight">
            Advanced <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-600">QR Generator</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm md:text-base">
            Buat QR Code premium secara instan. 100% aman & diproses di browser Anda.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-7 bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[1.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl shadow-emerald-500/10 backdrop-blur-xl">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6">
                <i class="fa-solid fa-wand-magic-sparkles text-emerald-500 mr-2"></i> Konfigurasi Desain
            </h2>
            
            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tautan atau Teks <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-link text-slate-400"></i>
                        </div>
                        <input type="text" x-model="text" @input="debounceGenerate"
                               class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 pl-11 pr-4 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all"
                               placeholder="Contoh: https://rianprojects.my.id">
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700/50">

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Warna QR (Foreground)</label>
                    <div class="flex gap-2 mb-4 p-1 bg-slate-100 dark:bg-slate-800 rounded-xl w-fit">
                        <button @click="colorMode = 'solid'; updateQR()"
                                class="tab-btn px-4 py-2 text-xs font-bold rounded-lg text-slate-500 dark:text-slate-400"
                                :class="colorMode === 'solid' ? 'active' : ''">
                            <i class="fa-solid fa-circle mr-1"></i> Solid
                        </button>
                        <button @click="colorMode = 'gradient'; updateQR()"
                                class="tab-btn px-4 py-2 text-xs font-bold rounded-lg text-slate-500 dark:text-slate-400"
                                :class="colorMode === 'gradient' ? 'active' : ''">
                            <i class="fa-solid fa-circle-half-stroke mr-1"></i> Gradient
                        </button>
                    </div>

                    <div x-show="colorMode === 'solid'" x-transition>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <template x-for="clr in colorPresets">
                                <button @click="colorDark = clr; updateQR()"
                                        class="color-swatch"
                                        :class="colorDark === clr && colorMode === 'solid' ? 'active' : ''"
                                        :style="`background-color: ${clr}`"
                                        :title="clr"></button>
                            </template>
                        </div>
                        <div class="flex items-center gap-3 mt-2">
                            <input type="color" x-model="colorDark" @input="updateQR()" class="border-2 border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-mono uppercase" x-text="colorDark"></span>
                            <span class="text-xs text-slate-400">← Custom</span>
                        </div>
                    </div>

                    <div x-show="colorMode === 'gradient'" x-transition style="display: none;">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs font-bold text-slate-500 mb-2">Warna Awal</p>
                                <div class="flex items-center gap-2">
                                    <input type="color" x-model="gradientColor1" @input="updateQR()" class="border-2 border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
                                    <span class="text-xs font-mono text-slate-500 uppercase" x-text="gradientColor1"></span>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 mb-2">Warna Akhir</p>
                                <div class="flex items-center gap-2">
                                    <input type="color" x-model="gradientColor2" @input="updateQR()" class="border-2 border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
                                    <span class="text-xs font-mono text-slate-500 uppercase" x-text="gradientColor2"></span>
                                </div>
                            </div>
                        </div>

                        <p class="text-xs font-bold text-slate-500 mb-2">Preset Gradient</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <template x-for="(grd, idx) in gradientPresets">
                                <button @click="gradientColor1 = grd[0]; gradientColor2 = grd[1]; updateQR()"
                                        class="w-10 h-8 rounded-lg border-2 transition-all hover:scale-110 shadow-sm"
                                        :style="`background: linear-gradient(135deg, ${grd[0]}, ${grd[1]})`"
                                        :class="gradientColor1 === grd[0] && gradientColor2 === grd[1] ? 'border-emerald-500 ring-2 ring-emerald-300' : 'border-transparent dark:border-slate-700'"></button>
                            </template>
                        </div>

                        <div class="flex gap-2">
                            <button @click="gradientType = 'linear'; updateQR()"
                                    class="tab-btn flex-1 py-2 text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700 text-slate-500"
                                    :class="gradientType === 'linear' ? 'active border-transparent' : ''">Linear</button>
                            <button @click="gradientType = 'radial'; updateQR()"
                                    class="tab-btn flex-1 py-2 text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700 text-slate-500"
                                    :class="gradientType === 'radial' ? 'active border-transparent' : ''">Radial</button>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Warna Latar (Background)</label>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <template x-for="clr in bgPresets">
                            <button @click="colorLight = clr; applyLogoShape()"
                                    class="color-swatch border border-slate-200 dark:border-slate-700"
                                    :class="colorLight === clr ? 'active' : ''"
                                    :style="`background-color: ${clr}`"
                                    :title="clr"></button>
                        </template>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="color" x-model="colorLight" @input="applyLogoShape()" class="border-2 border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-mono uppercase" x-text="colorLight"></span>
                        <span class="text-xs text-slate-400">← Custom</span>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700/50">

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Bentuk Titik (Body Shape)</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-6">
                        <template x-for="s in dotStyles">
                            <button @click="dotStyle = s.value; updateQR()" 
                                    class="py-2.5 text-xs font-bold rounded-xl transition-all border"
                                    :class="dotStyle === s.value ? 'bg-emerald-50 border-emerald-500 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-slate-50 border-slate-200 text-slate-500 hover:bg-slate-100 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400'"
                                    x-text="s.label"></button>
                        </template>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Bingkai Mata (Eye Frame)</label>
                            <select x-model="eyeFrameStyle" @change="updateQR" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                                <option value="square">Kotak Standar</option>
                                <option value="dot">Membulat (Dots)</option>
                                <option value="extra-rounded">Extra Rounded</option>
                            </select>
                            <div class="flex items-center gap-3 mt-3">
                                <input type="color" x-model="eyeFrameColor" @input="updateQR()" class="border-2 border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-mono uppercase" x-text="eyeFrameColor"></span>
                                <span class="text-xs text-slate-400">← Warna Frame</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Bola Mata (Eye Ball)</label>
                            <select x-model="eyeBallStyle" @change="updateQR" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                                <option value="square">Kotak Standar</option>
                                <option value="dot">Membulat (Dot)</option>
                            </select>
                            <div class="flex items-center gap-3 mt-3">
                                <input type="color" x-model="eyeBallColor" @input="updateQR()" class="border-2 border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-mono uppercase" x-text="eyeBallColor"></span>
                                <span class="text-xs text-slate-400">← Warna Ball</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700/50">

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Sisipkan Logo (Opsional)</label>

                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-slate-300 dark:border-slate-700 border-dashed rounded-xl cursor-pointer bg-slate-50 dark:bg-slate-800/50 hover:bg-emerald-50 dark:hover:border-emerald-500 transition-all group">
                            <div class="flex flex-col items-center justify-center py-4">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400 group-hover:text-emerald-500 mb-2 transition-colors"></i>
                                <p class="text-sm text-slate-500"><span class="font-bold text-emerald-500">Klik untuk upload</span> atau drag & drop</p>
                                <p class="text-xs text-rose-500 font-medium mt-1">PNG Transparan disarankan (Maks 2MB)</p>
                            </div>
                            <input type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" @change="handleLogoUpload">
                        </label>
                    </div>

                    <div x-show="rawLogoUrl" x-transition class="mt-4 space-y-3" style="display:none;">
                        <div class="flex items-center justify-between p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <img :src="rawLogoUrl" class="w-10 h-10 object-contain rounded-lg bg-white border border-slate-200 p-1">
                                <span class="text-sm font-bold text-emerald-700 dark:text-emerald-400">Logo terpasang</span>
                            </div>
                            <button @click="removeLogo" class="text-rose-500 hover:text-rose-600 bg-white dark:bg-slate-800 p-2 rounded-lg shadow-sm hover:shadow transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">Bentuk Bingkai Logo</p>
                            <div class="flex gap-2">
                                <button @click="logoShape = 'transparent'; applyLogoShape()"
                                        class="tab-btn flex-1 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 text-slate-500"
                                        :class="logoShape === 'transparent' ? 'active border-transparent' : ''">
                                    <i class="fa-solid fa-image mr-1.5"></i>Ori
                                </button>
                                <button @click="logoShape = 'circle'; applyLogoShape()"
                                        class="tab-btn flex-1 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 text-slate-500"
                                        :class="logoShape === 'circle' ? 'active border-transparent' : ''">
                                    <i class="fa-solid fa-circle mr-1.5"></i>Bulat
                                </button>
                                <button @click="logoShape = 'square'; applyLogoShape()"
                                        class="tab-btn flex-1 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 text-slate-500"
                                        :class="logoShape === 'square' ? 'active border-transparent' : ''">
                                    <i class="fa-solid fa-square mr-1.5"></i>Kotak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="error" x-transition class="p-3 bg-rose-50 dark:bg-rose-900/20 border border-rose-300 dark:border-rose-800 rounded-xl text-rose-600 dark:text-rose-400 text-sm font-medium flex items-center gap-2" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span x-text="error"></span>
                </div>

            </div>
        </div>

        <div class="lg:col-span-5">
            <div class="bg-slate-100 dark:bg-slate-800/50 p-6 sm:p-8 rounded-[1.5rem] border border-slate-200 dark:border-slate-800 h-full flex flex-col items-center justify-start sm:justify-center relative overflow-hidden sticky top-24">
                
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent pointer-events-none"></div>

                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-8 relative z-10 text-center w-full flex justify-center items-center gap-2">
                    Live Preview
                </h3>

                <div class="relative z-10 group w-full flex justify-center">
                    <div class="p-3 sm:p-5 bg-white rounded-3xl shadow-2xl shadow-slate-200 dark:shadow-black border border-slate-200 transition-transform duration-500 group-hover:scale-105 flex items-center justify-center">
                        <div id="qr-canvas-container" class="rounded-xl overflow-hidden flex justify-center items-center w-[220px] h-[220px] sm:w-[260px] sm:h-[260px]"></div>
                    </div>
                </div>

                <div class="mt-10 w-full relative z-10 px-4">
                    <button @click="downloadQR" :disabled="isDownloading"
                       class="flex items-center justify-center w-full gap-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold py-4 px-6 rounded-xl hover:shadow-xl hover:scale-105 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                        <template x-if="!isDownloading">
                            <span><i class="fa-solid fa-download mr-1"></i> Download </span>
                        </template>
                        <template x-if="isDownloading">
                            <span><i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Menyiapkan...</span>
                        </template>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function qrGenerator() {
    return {
        text: '',
        rawLogoUrl: null,       
        processedLogoUrl: null, 
        logoShape: 'transparent',
        qrCode: null,
        timeout: null,
        error: null,
        isDownloading: false,
        colorMode: 'solid',
        colorDark: '#0f172a',
        colorLight: '#ffffff',
        gradientColor1: '#059669',
        gradientColor2: '#2563eb',
        gradientType: 'linear',
        dotStyle: 'rounded',
        eyeFrameColor: '#0f172a',
        eyeBallColor: '#0f172a',
        eyeFrameStyle: 'extra-rounded',
        eyeBallStyle: 'dot',
        colorPresets: [
            '#0f172a','#1e293b','#1d4ed8','#2563eb','#0ea5e9',
            '#059669','#10b981','#f59e0b','#ef4444','#e11d48',
            '#7c3aed','#a855f7','#ec4899','#f97316','#6b7280',
        ],
        bgPresets: [
            '#ffffff','#f8fafc','#f1f5f9','#fef2f2','#eff6ff',
            '#f0fdf4','#fefce8','#fdf4ff','#0f172a','#1e293b',
        ],
        gradientPresets: [
            ['#059669','#2563eb'], ['#7c3aed','#ec4899'],
            ['#f59e0b','#ef4444'], ['#0ea5e9','#10b981'],
            ['#1d4ed8','#7c3aed'], ['#f97316','#e11d48'],
            ['#0f172a','#374151'], ['#065f46','#047857'],
        ],
        dotStyles: [
            { value: 'square',        label: 'Kotak'   },
            { value: 'rounded',       label: 'Rounded' },
            { value: 'dots',          label: 'Dots'    },
            { value: 'classy',        label: 'Klasik'  },
            { value: 'classy-rounded',label: 'Semi Bulat' },
            { value: 'extra-rounded', label: 'Smooth'  },
        ],

        init() {
            if (typeof QRCodeStyling === 'undefined') {
                setTimeout(() => this.init(), 200);
                return;
            }
            this.qrCode = new QRCodeStyling(this._buildConfig(300));
            this.$nextTick(() => {
                const container = document.getElementById('qr-canvas-container');
                if (container) this.qrCode.append(container);
            });
        },

        _buildConfig(size) {
            const base = {
                width: size,
                height: size,
                type: 'canvas',
                data: this.text.trim() || 'https://rianprojects.my.id',
                image: this.processedLogoUrl || '',
                margin: 10,
                qrOptions: {
                    typeNumber: 0,
                    mode: 'Byte',
                    errorCorrectionLevel: 'H',
                },
                imageOptions: {

                    hideBackgroundDots: false, 
                    imageSize: this.logoShape === 'transparent' ? 0.25 : 0.35,
                    margin: 0, 
                    crossOrigin: 'anonymous',
                },
                backgroundOptions: { color: this.colorLight },
                cornersSquareOptions: { type: this.eyeFrameStyle },
                cornersDotOptions:    { type: this.eyeBallStyle },
            };

            if (this.colorMode === 'solid') {
                base.dotsOptions = { color: this.colorDark, type: this.dotStyle, gradient: null };
                base.cornersSquareOptions.color = this.eyeFrameColor;
                base.cornersSquareOptions.gradient = null;
                base.cornersDotOptions.color = this.eyeBallColor;
                base.cornersDotOptions.gradient = null;
            } else {
                const grad = {
                    type: this.gradientType,
                    rotation: this.gradientType === 'linear' ? Math.PI / 4 : 0,
                    colorStops: [
                        { offset: 0, color: this.gradientColor1 },
                        { offset: 1, color: this.gradientColor2 },
                    ],
                };
                base.dotsOptions = { type: this.dotStyle, color: null, gradient: grad };
                base.cornersSquareOptions.color = this.eyeFrameColor;
                base.cornersSquareOptions.gradient = null;
                base.cornersDotOptions.color = this.eyeBallColor;
                base.cornersDotOptions.gradient = null;
            }

            return base;
        },

        debounceGenerate() {
            this.error = null;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => this.updateQR(), 400);
        },

        updateQR() {
            if (!this.qrCode) return;
            this.qrCode.update(this._buildConfig(300));
        },

        applyLogoShape() {
            if (!this.rawLogoUrl) {
                this.processedLogoUrl = null;
                this.updateQR();
                return;
            }

            if (this.logoShape === 'transparent') {
                this.processedLogoUrl = this.rawLogoUrl;
                this.updateQR();
                return;
            }

            const img = new Image();
            img.crossOrigin = "anonymous";
            img.onload = () => {
                const canvas = document.createElement('canvas');
                const size = 300; 
                canvas.width = size;
                canvas.height = size;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = this.colorLight; 
                if (this.logoShape === 'circle') {
                    ctx.beginPath();
                    ctx.arc(size/2, size/2, size/2, 0, Math.PI * 2);
                    ctx.fill();
                } else if (this.logoShape === 'square') {
                    ctx.beginPath();
                    ctx.roundRect(0, 0, size, size, 40);
                    ctx.fill();
                }

                const padding = 30;
                const innerSize = size - (padding * 2);
                let drawW = innerSize;
                let drawH = innerSize;

                if (img.width > img.height) {
                    drawH = (img.height / img.width) * drawW;
                } else {
                    drawW = (img.width / img.height) * drawH;
                }

                const x = (size - drawW) / 2;
                const y = (size - drawH) / 2;
                ctx.save();
                ctx.beginPath();
                if (this.logoShape === 'circle') {

                    ctx.arc(size/2, size/2, Math.max(drawW, drawH)/2, 0, Math.PI * 2);
                } else {

                    ctx.roundRect(x, y, drawW, drawH, 15);
                }
                ctx.clip();
                ctx.drawImage(img, x, y, drawW, drawH);
                ctx.restore();
                this.processedLogoUrl = canvas.toDataURL('image/png');
                this.updateQR();
            };
            img.src = this.rawLogoUrl;
        },

        handleLogoUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                this.showError('Format ditolak! Gunakan .PNG atau .JPG');
                event.target.value = ''; return;
            }
            if (file.size > 2 * 1024 * 1024) {
                this.showError('Ukuran terlalu besar! Maksimal 2MB.');
                event.target.value = ''; return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                this.rawLogoUrl = e.target.result;
                this.applyLogoShape();
            };
            reader.onerror = () => this.showError('Gagal membaca file gambar.');
            reader.readAsDataURL(file);
        },

        removeLogo() {
            this.rawLogoUrl = null;
            this.processedLogoUrl = null;
            document.querySelectorAll('input[type="file"]').forEach(el => el.value = '');
            this.updateQR();
        },

        downloadQR() {
            if (!this.qrCode) return;
            this.isDownloading = true;
            this.qrCode.update(this._buildConfig(1000));

            setTimeout(() => {
                const fileName = 'QR_RianProject_' + Date.now();
                this.qrCode.download({ name: fileName, extension: 'png' }).then(() => {
                    this.qrCode.update(this._buildConfig(300));
                    this.isDownloading = false;
                });
            }, 300);
        },

        showError(msg) {
            this.error = msg;
            setTimeout(() => { this.error = null; }, 5000);
        }
    }
}
</script>

<?= $this->endSection() ?>