<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div x-data="paletteExplorer()" class="max-w-7xl mx-auto py-12 sm:py-16 px-4 sm:px-6 min-h-[80vh] relative">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-10">
        <div class="flex justify-center mb-4">
            <div class="inline-flex items-center justify-center p-3 bg-pink-50 dark:bg-pink-900/30 rounded-2xl text-pink-500 shadow-sm">
                <i class="fa-solid fa-palette text-3xl"></i>
            </div>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit tracking-tight">
            Color Palette <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-red-500">Explorer</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-sm md:text-base">
            Temukan, buat, dan kustomisasi paduan warna sempurna Anda. Klik warna untuk menyalin kode HEX.
        </p>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-10">
        
        <div class="flex flex-wrap justify-center gap-2">
            <template x-for="cat in categories">
                <button @click="activeCategory = cat" 
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 border"
                        :class="activeCategory === cat ? 'bg-slate-800 border-slate-800 text-white dark:bg-white dark:text-slate-900 shadow-md' : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:border-slate-400'">
                    <span x-text="cat"></span>
                </button>
            </template>
        </div>

        <div class="flex items-center gap-3">
            <button @click="generateRandom()" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800/50 hover:bg-indigo-100 hover:scale-105 transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-dice"></i> Generate Acak
            </button>
            <button @click="customModal = true" class="px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-pink-500 to-red-500 text-white hover:shadow-lg hover:shadow-pink-500/30 hover:scale-105 transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Buat Custom
            </button>
        </div>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <template x-for="(palette, index) in filteredPalettes" :key="palette.id">
            
            <div class="bg-white dark:bg-slate-900/80 p-4 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none hover:-translate-y-2 hover:shadow-2xl hover:shadow-pink-500/10 transition-all duration-300 group">
                
                <div class="rounded-[1.25rem] overflow-hidden flex flex-col h-56 mb-4 shadow-inner">
                    <template x-for="(color, colorIndex) in palette.colors" :key="colorIndex">
                        <div class="w-full flex-1 relative group/color cursor-pointer transition-all hover:flex-[1.5]"
                             :style="`background-color: ${color};`"
                             @click="copyColor(color)">
                            
                            <div class="absolute inset-0 bg-black/0 group-hover/color:bg-black/10 transition-colors flex items-center justify-center opacity-0 group-hover/color:opacity-100">
                                <span class="bg-white/90 text-slate-800 font-mono text-xs font-bold px-3 py-1 rounded-lg shadow-sm backdrop-blur-sm" x-text="color"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex items-center justify-between px-2">
                    <div class="flex gap-1.5 flex-wrap">
                        <template x-for="tag in palette.tags">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-md" x-text="tag"></span>
                        </template>
                    </div>
                    <button @click="likePalette(palette.id)" class="text-slate-400 hover:text-rose-500 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-heart text-sm" :class="palette.liked ? 'text-rose-500' : ''"></i>
                        <span class="text-xs font-bold" x-text="palette.likes"></span>
                    </button>
                </div>
            </div>

        </template>
    </div>

    <div x-show="customModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="customModal" x-transition.opacity @click="customModal = false" class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm"></div>
        
        <div x-show="customModal" x-transition.scale.95 class="relative bg-white dark:bg-slate-900 w-full max-w-md p-8 rounded-[2.5rem] shadow-2xl border border-white/10">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-slate-800 dark:text-white"><i class="fa-solid fa-fill-drip text-pink-500 mr-2"></i> Racik Paletmu</h3>
                <button @click="customModal = false" class="text-slate-400 hover:text-rose-500 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="rounded-2xl overflow-hidden flex flex-col h-32 mb-6 shadow-inner border border-slate-200 dark:border-slate-700">
                <template x-for="(color, idx) in customColors">
                    <div class="w-full flex-1 transition-colors" :style="`background-color: ${color};`"></div>
                </template>
            </div>

            <div class="grid grid-cols-4 gap-3 mb-8">
                <template x-for="(color, idx) in customColors">
                    <div class="relative group">
                        <input type="color" x-model="customColors[idx]" class="w-full h-12 rounded-xl cursor-pointer border-0 p-0 bg-transparent shadow-sm [&::-webkit-color-swatch-wrapper]:p-0 [&::-webkit-color-swatch]:border-none [&::-webkit-color-swatch]:rounded-xl">
                        <div class="text-center mt-2 font-mono text-[10px] text-slate-500 dark:text-slate-400 uppercase" x-text="customColors[idx]"></div>
                    </div>
                </template>
            </div>

            <button @click="saveCustomPalette()" class="w-full py-4 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded-2xl shadow-lg shadow-pink-500/30 transition-all active:scale-95">
                Simpan ke Koleksi
            </button>
        </div>
    </div>

    <div x-show="toast.show" x-transition.opacity.duration.300ms
         class="fixed bottom-10 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-6 py-3 rounded-2xl shadow-2xl">
        <div class="w-6 h-6 rounded-full flex items-center justify-center border border-white/20" :style="`background-color: ${toast.color}`"></div>
        <span class="text-sm font-bold font-mono" x-text="toast.message"></span>
        <span class="text-sm font-medium" x-text="toast.action"></span>
    </div>

</div>

<script>
function paletteExplorer() {
    return {

        categories: ['Semua', 'Pastel', 'Dark', 'Neon', 'Earth', 'Vintage', 'Custom', 'Acak'],
        activeCategory: 'Semua',
        toast: { show: false, message: '', color: '', action: '' },
        timeout: null,
        customModal: false,
        customColors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
        getRandomHex() {
            return '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0').toUpperCase();
        },

        palettes: [
            { id: 1, colors: ['#222831', '#393E46', '#00ADB5', '#EEEEEE'], tags: ['dark', 'neon'], likes: 1240, liked: false },
            { id: 2, colors: ['#FFC0CB', '#FFB6C1', '#FF69B4', '#FF1493'], tags: ['pastel', 'vintage'], likes: 850, liked: false },
            { id: 3, colors: ['#F9F7F7', '#DBE2EF', '#3F72AF', '#112D4E'], tags: ['earth', 'dark'], likes: 2100, liked: false },
            { id: 4, colors: ['#FF2E63', '#08D9D6', '#252A34', '#EAEAEA'], tags: ['neon', 'dark'], likes: 932, liked: false },
            { id: 5, colors: ['#EAE7DC', '#D8C3A5', '#8E8D8A', '#E98074'], tags: ['vintage', 'earth'], likes: 645, liked: false },
            { id: 6, colors: ['#2A363B', '#E84A5F', '#FF847C', '#FECEAB'], tags: ['vintage', 'pastel'], likes: 1120, liked: false },
            { id: 7, colors: ['#A8E6CF', '#DCEDC1', '#FFD3B6', '#FFAAA5'], tags: ['pastel', 'earth'], likes: 1540, liked: false },
            { id: 8, colors: ['#1A1A2E', '#16213E', '#0F3460', '#E94560'], tags: ['dark', 'neon'], likes: 3200, liked: false },
            { id: 9, colors: ['#F0F8FF', '#C4FB6D', '#82E0AA', '#39AEA9'], tags: ['neon', 'pastel'], likes: 450, liked: false },
            { id: 10, colors: ['#2C3E50', '#E74C3C', '#ECF0F1', '#3498DB'], tags: ['dark', 'vintage'], likes: 880, liked: false },
            { id: 11, colors: ['#FFF5E1', '#FFD1D1', '#FF9E9E', '#E46161'], tags: ['pastel', 'vintage'], likes: 760, liked: false },
            { id: 12, colors: ['#5C4B51', '#8CBEB2', '#F2EBBF', '#F3B562'], tags: ['earth', 'vintage'], likes: 590, liked: false }
        ],

        get filteredPalettes() {
            if (this.activeCategory === 'Semua') {
                return this.palettes;
            }
            return this.palettes.filter(p => p.tags.includes(this.activeCategory.toLowerCase()));
        },

        generateRandom() {
            const newId = Date.now();
            const newPalette = {
                id: newId,
                colors: [this.getRandomHex(), this.getRandomHex(), this.getRandomHex(), this.getRandomHex()],
                tags: ['acak'],
                likes: 0,
                liked: false
            };
            
            this.palettes.unshift(newPalette);
            this.activeCategory = 'Semua';
            this.showToast('Palet Acak', newPalette.colors[0], 'ditambahkan!');
        },

        saveCustomPalette() {
            const newId = Date.now();
            const savedColors = [...this.customColors].map(c => c.toUpperCase());
            
            this.palettes.unshift({
                id: newId,
                colors: savedColors,
                tags: ['custom'],
                likes: 0,
                liked: false
            });

            this.customModal = false;
            this.activeCategory = 'Semua';
            this.showToast('Palet Custom', savedColors[0], 'tersimpan!');
        },

        copyColor(hex) {
            navigator.clipboard.writeText(hex).then(() => {
                this.showToast(hex, hex, 'berhasil disalin!');
            });
        },

        likePalette(id) {
            const index = this.palettes.findIndex(p => p.id === id);
            if (index !== -1) {
                if (!this.palettes[index].liked) {
                    this.palettes[index].likes++;
                    this.palettes[index].liked = true;
                } else {
                    this.palettes[index].likes--;
                    this.palettes[index].liked = false;
                }
            }
        },

        showToast(msg, colorHex, actionText) {
            this.toast.message = msg;
            this.toast.color = colorHex;
            this.toast.action = actionText;
            this.toast.show = true;

            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.toast.show = false;
            }, 2500);
        }
    }
}
</script>

<?= $this->endSection() ?>