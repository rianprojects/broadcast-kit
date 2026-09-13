<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<style>

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
    
    #memeCanvas {
        width: 100% !important;
        height: auto !important;
        object-fit: contain;
        border-radius: 0.5rem;
        background-color: #0f172a;
        background-image: radial-gradient(#1e293b 1px, transparent 1px);
        background-size: 20px 20px;
    }
</style>

<div x-data="memeGenerator()" x-init="init()" class="max-w-7xl mx-auto py-12 sm:py-16 px-4 sm:px-6 min-h-[80vh]">
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center p-3 bg-purple-50 dark:bg-purple-900/30 rounded-2xl mb-4 text-purple-500">
            <i class="fa-solid fa-face-laugh-squint text-3xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit tracking-tight">
            Instant <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-600">Meme Generator</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm md:text-base">
            Buat meme lucu dan viral dalam hitungan detik. Upload gambar, edit teks, lalu download!
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-6 bg-white dark:bg-slate-900/80 p-6 sm:p-8 rounded-[1.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl shadow-purple-500/10 backdrop-blur-xl">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6">
                <i class="fa-solid fa-sliders text-purple-500 mr-2"></i> Pengaturan Meme
            </h2>
            
            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Upload Gambar Base <span class="text-rose-500">*</span></label>
                    <div class="flex items-center justify-center w-full relative">
                        <label @dragover.prevent="isDragging = true" 
                               @dragleave.prevent="isDragging = false" 
                               @drop.prevent="isDragging = false; handleDrop($event)"
                               class="flex flex-col items-center justify-center w-full border-2 border-dashed rounded-xl cursor-pointer transition-all group"
                               :class="isDragging ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20' : (imgObj ? 'border-emerald-300 bg-emerald-50/50 dark:bg-emerald-900/10 dark:border-emerald-800/50' : 'border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 hover:bg-purple-50 dark:hover:border-purple-500')">
                            
                            <div class="flex flex-col items-center justify-center py-8 px-4 text-center">
                                <template x-if="!imgObj">
                                    <div>
                                        <i class="fa-solid fa-images text-4xl text-slate-400 group-hover:text-purple-500 mb-3 transition-colors"></i>
                                        <p class="text-sm text-slate-500"><span class="font-bold text-purple-500">Klik untuk upload</span> atau tarik gambar ke sini</p>
                                    </div>
                                </template>
                                <template x-if="imgObj">
                                    <div>
                                        <i class="fa-solid fa-circle-check text-4xl text-emerald-500 mb-3"></i>
                                        <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">Gambar berhasil dimuat!</p>
                                        <p class="text-xs text-slate-500 mt-1">Klik atau drop lagi untuk mengganti gambar.</p>
                                    </div>
                                </template>
                            </div>
                            <input type="file" class="hidden" accept="image/*" @change="handleUpload">
                        </label>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700/50">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Teks Atas (Top Text)</label>
                        <input type="text" x-model="topText" @input="draw" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all font-bold" placeholder="Tulis teks atas...">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Teks Bawah (Bottom Text)</label>
                        <input type="text" x-model="bottomText" @input="draw" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all font-bold" placeholder="Tulis teks bawah...">
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer w-max">
                        <input type="checkbox" x-model="uppercase" @change="draw" class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500 cursor-pointer">
                        <span class="text-sm font-bold text-slate-600 dark:text-slate-400">Paksa Huruf Kapital (Uppercase)</span>
                    </label>
                </div>

                <hr class="border-slate-200 dark:border-slate-700/50">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Font Family</label>
                        <select x-model="fontFamily" @change="draw" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none cursor-pointer">
                            <option value="Impact, Arial Black, sans-serif">Impact / Arial Black</option>
                            <option value="Arial, Helvetica, sans-serif">Arial</option>
                            <option value="Comic Sans MS, cursive">Comic Sans (Doge style)</option>
                            <option value="sans-serif">Sans-serif</option>
                            <option value="serif">Serif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Ukuran Font (px)</label>
                        <input type="number" x-model="fontSize" @input="draw" min="10" max="300" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Warna Teks</label>
                        <div class="flex items-center gap-3">
                            <input type="color" x-model="fillColor" @input="draw" class="border-2 border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
                            <span class="text-xs font-mono font-bold text-slate-500 uppercase" x-text="fillColor"></span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Garis Tepi & Ketebalan</label>
                        <div class="flex items-center gap-3">
                            <input type="color" x-model="strokeColor" @input="draw" class="border-2 border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
                            <input type="number" x-model="strokeWidth" @input="draw" min="0" max="50" class="w-20 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg py-2 px-3 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 outline-none">
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-slate-700/50 flex justify-end">
                    <button @click="clearMeme" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-sm transition-all shadow-sm active:scale-95 flex items-center gap-2">
                        <i class="fa-solid fa-trash-can text-rose-500"></i> Reset Semua
                    </button>
                </div>

            </div>
        </div>

        <div class="lg:col-span-6">
            <div class="bg-slate-100 dark:bg-slate-800/50 p-4 sm:p-8 rounded-[1.5rem] border border-slate-200 dark:border-slate-800 h-full flex flex-col items-center relative sticky top-24">
                
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 relative z-10 text-center w-full flex justify-center items-center gap-2">
                    <i class="fa-solid fa-eye text-purple-500"></i> Live Preview
                </h3>

                <div class="relative w-full flex justify-center rounded-xl overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-700/50 bg-white dark:bg-slate-900 group">
                    <canvas x-ref="memeCanvas" id="memeCanvas" class="w-full transition-transform duration-300 group-hover:scale-[1.02]"></canvas>
                    
                    <div x-show="!imgObj" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-100/80 dark:bg-slate-900/80 backdrop-blur-sm z-10 pointer-events-none">
                        <i class="fa-regular fa-image text-5xl text-slate-300 dark:text-slate-600 mb-3"></i>
                        <p class="text-sm font-bold text-slate-400 dark:text-slate-500">Preview akan muncul di sini</p>
                    </div>
                </div>

                <div class="mt-8 w-full">
                    <button @click="downloadMeme" :disabled="!imgObj || isDownloading"
                       class="flex items-center justify-center w-full gap-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-purple-500/30 hover:shadow-xl hover:scale-[1.02] transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                        <template x-if="!isDownloading">
                            <span><i class="fa-solid fa-download mr-2"></i> Download Meme JPG</span>
                        </template>
                        <template x-if="isDownloading">
                            <span><i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Memproses...</span>
                        </template>
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
function memeGenerator() {
    return {
        imgObj: null,
        imgNaturalWidth: 0,
        imgNaturalHeight: 0,
        topText: '',
        bottomText: '',
        uppercase: true,
        fontSize: 64,
        fontFamily: 'Impact, Arial Black, sans-serif',
        fillColor: '#ffffff',
        strokeColor: '#000000',
        strokeWidth: 6,
        isDragging: false,
        isDownloading: false,

        init() {

            this.draw();
        },

        handleUpload(event) {
            const file = event.target.files[0];
            if (file) this.loadFile(file);
        },

        handleDrop(event) {
            const file = event.dataTransfer.files[0];
            if (file) this.loadFile(file);
        },

        loadFile(file) {
            if (!file.type.startsWith('image/')) {
                alert("Harap upload file gambar yang valid!");
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                const image = new Image();
                image.onload = () => {
                    this.imgObj = image;
                    this.imgNaturalWidth = image.naturalWidth;
                    this.imgNaturalHeight = image.naturalHeight;
                    this.setCanvasToImage();
                    this.draw();
                };
                image.src = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        setCanvasToImage() {
            if (!this.imgObj) return;
            const canvas = this.$refs.memeCanvas;
            const maxW = 1400;
            const scale = this.imgNaturalWidth > maxW ? maxW / this.imgNaturalWidth : 1;
            canvas.width = Math.round(this.imgNaturalWidth * scale);
            canvas.height = Math.round(this.imgNaturalHeight * scale);
        },

        draw() {
            const canvas = this.$refs.memeCanvas;
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            if (!this.imgObj) {

                canvas.width = 600;
                canvas.height = 600;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                return;
            }

            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(this.imgObj, 0, 0, canvas.width, canvas.height);

            const tText = this.uppercase ? (this.topText || '').toUpperCase() : this.topText;
            const bText = this.uppercase ? (this.bottomText || '').toUpperCase() : this.bottomText;

            const size = parseInt(this.fontSize, 10) || 64;
            const font = `${size}px ${this.fontFamily}`;

            ctx.textAlign = 'center';
            ctx.textBaseline = 'top';
            ctx.lineJoin = 'round';
            ctx.font = font;
            ctx.fillStyle = this.fillColor;
            ctx.strokeStyle = this.strokeColor;
            ctx.lineWidth = parseInt(this.strokeWidth, 10) || 6;

            const padding = size * 0.25;
            const topY = padding;

            if (tText) this.drawTextMultiline(ctx, tText, topY, size, canvas.width, true);
            if (bText) {
                ctx.textBaseline = 'bottom';
                this.drawTextMultiline(ctx, bText, canvas.height - padding, size, canvas.width, false);
            }
        },

        drawTextMultiline(ctx, text, y, size, maxWidth, baselineTop = true) {
            const lines = this.wrapText(ctx, text, maxWidth * 0.95);
            const totalHeight = lines.length * size + (lines.length - 1) * 4;
            let startY = baselineTop ? y : (y - totalHeight);
            
            for (let i = 0; i < lines.length; i++) {
                const lineY = startY + i * (size + 4);
                const textY = baselineTop ? lineY : (lineY + size);
                ctx.strokeText(lines[i], maxWidth / 2, textY);
                ctx.fillText(lines[i], maxWidth / 2, textY);
            }
        },

        wrapText(ctx, text, maxWidth) {
            if (!text) return [];
            const words = text.split(/\s+/);
            const lines = [];
            let line = '';
            for (const w of words) {
                const test = line ? line + ' ' + w : w;
                const { width } = ctx.measureText(test);
                if (width > maxWidth && line) {
                    lines.push(line);
                    line = w;
                } else {
                    line = test;
                }
            }
            if (line) lines.push(line);
            return lines;
        },

        downloadMeme() {
            if (!this.imgObj) return;
            this.isDownloading = true;
            
            setTimeout(() => {
                const canvas = this.$refs.memeCanvas;
                const link = document.createElement('a');
                link.download = `Meme_RianProject_${new Date().toISOString().replace(/[:.]/g,'-')}.jpg`;
                link.href = canvas.toDataURL('image/jpeg', 0.9);
                link.click();
                this.isDownloading = false;
            }, 300);
        },

        clearMeme() {
            this.imgObj = null;
            this.topText = '';
            this.bottomText = '';
            this.draw();
            document.querySelectorAll('input[type="file"]').forEach(el => el.value = '');
        }
    }
}
</script>

<?= $this->endSection() ?>