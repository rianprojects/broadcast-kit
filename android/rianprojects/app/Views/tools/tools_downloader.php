<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<style>[x-cloak] { display: none !important; }</style>

<div x-data="universalDownloader()" x-cloak class="max-w-5xl mx-auto py-8 sm:py-12 px-4 sm:px-6 min-h-[80vh]">
    
    <?= $this->include('components/breadcrumb') ?>
    
    <div class="text-center mb-8 sm:mb-12">
        <div class="inline-flex items-center justify-center p-3 bg-sky-50 dark:bg-sky-900/30 rounded-2xl mb-4 text-sky-500">
            <i class="fa-solid fa-cloud-arrow-down text-2xl sm:text-3xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-3 sm:mb-4 font-outfit tracking-tight">
            Video <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-600">Downloader</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 max-w-xl mx-auto text-xs sm:text-sm md:text-base px-2">
            Unduh video, slide foto, atau story dari TikTok, Instagram, dan X (Twitter) tanpa watermark.
        </p>
    </div>

        <div class="flex justify-center mb-6 sm:mb-8">
        <div class="inline-flex items-center gap-1 p-1.5 bg-slate-100 dark:bg-slate-800/60 rounded-full border border-slate-200 dark:border-slate-700">
            <button @click="switchPlatform('tiktok')" 
                class="flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all"
                :class="platform === 'tiktok' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-md' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'">
                <i class="fa-brands fa-tiktok"></i> <span class="hidden sm:inline">TikTok</span>
            </button>
            <button @click="switchPlatform('instagram')" 
                class="flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all"
                :class="platform === 'instagram' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-md' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'">
                <i class="fa-brands fa-instagram"></i> <span class="hidden sm:inline">Instagram</span>
            </button>
            <button @click="switchPlatform('x')" 
                class="flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all"
                :class="platform === 'x' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-md' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'">
                <i class="fa-brands fa-x-twitter"></i> <span class="hidden sm:inline">X / Twitter</span>
            </button>
        </div>
    </div>

        <div x-show="platform === 'tiktok' || platform === 'instagram'" class="flex flex-col items-center justify-center mb-6 -mt-2">
        <div class="inline-flex items-center gap-1 p-1 bg-transparent rounded-full text-xs sm:text-sm flex-wrap justify-center">
            <button @click="mode = 'link'" 
                class="px-4 py-1.5 rounded-full font-bold transition-all"
                :class="mode === 'link' ? 'text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-900/30' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-300'">
                <span x-text="platform === 'instagram' ? 'Link Media' : 'Link Video / Slide'"></span>
            </button>
            <span class="text-slate-300 dark:text-slate-600">|</span>
            <button @click="mode = 'story'" 
                class="px-4 py-1.5 rounded-full font-bold transition-all"
                :class="mode === 'story' ? 'text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-900/30' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-300'">
                Story (Username)
            </button>
            <template x-if="platform === 'tiktok' || platform === 'instagram'">
                <span class="text-slate-300 dark:text-slate-600">|</span>
            </template>
            <template x-if="platform === 'tiktok' || platform === 'instagram'">
                <button @click="mode = 'profile'" 
                    class="px-4 py-1.5 rounded-full font-bold transition-all"
                    :class="mode === 'profile' ? 'text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-900/30' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-300'">
                    Profile (Username)
                </button>
            </template>
        </div>
        <p class="text-center text-[11px] text-slate-400 mt-2">
            <span x-show="mode === 'link'">Tempel link Untuk download langsung</span>
            <span x-show="mode === 'story'">Lihat dan download story yang sedang aktif dari akun ini</span>
            <span x-show="mode === 'profile'">Ambil video atau post terbaru dari akun ini, bisa di-scroll untuk muat lebih banyak</span>
        </p>
    </div>

        <div class="bg-white dark:bg-slate-900/80 p-2 sm:p-3 md:p-4 rounded-[2rem] sm:rounded-full border border-slate-200 dark:border-slate-800 shadow-2xl shadow-sky-500/10 backdrop-blur-xl relative z-20 transition-all hover:shadow-sky-500/20 max-w-3xl mx-auto">
        <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-3">

                        <template x-if="mode === 'link'">
                <div class="relative w-full flex items-center bg-slate-50 sm:bg-transparent dark:bg-slate-800/50 sm:dark:bg-transparent rounded-full sm:rounded-none">
                    <div class="absolute left-5 sm:left-6 text-lg sm:text-xl transition-colors duration-300" :class="platformIconColor">
                        <i :class="platformIcon" class="transition-all duration-300"></i>
                    </div>
                    <input type="text" x-model="url" @keyup.enter="extract()"
                           class="w-full bg-transparent border-none py-3 sm:py-4 pl-12 sm:pl-16 pr-10 sm:pr-12 text-sm sm:text-base font-medium text-slate-800 dark:text-white outline-none placeholder-slate-400" 
                           :placeholder="linkPlaceholder">
                    
                    <button x-show="url" @click="url = ''" class="absolute right-4 text-slate-400 hover:text-rose-500 transition-colors">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
            </template>

                        <template x-if="mode === 'story' || mode === 'profile'">
                <div class="relative w-full flex items-center bg-slate-50 sm:bg-transparent dark:bg-slate-800/50 sm:dark:bg-transparent rounded-full sm:rounded-none">
                    <div class="absolute left-5 sm:left-6 text-lg sm:text-xl text-slate-800 dark:text-white">
                        <i class="fa-solid fa-at"></i>
                    </div>
                    <input type="text" x-model="username" @keyup.enter="extractAll()"
                           class="w-full bg-transparent border-none py-3 sm:py-4 pl-12 sm:pl-16 pr-10 sm:pr-12 text-sm sm:text-base font-medium text-slate-800 dark:text-white outline-none placeholder-slate-400" 
                           :placeholder="mode === 'profile' ? 'Masukkan username profil (tanpa @)...' : 'Masukkan username (tanpa @)...'">
                    
                    <button x-show="username" @click="username = ''" class="absolute right-4 text-slate-400 hover:text-rose-500 transition-colors">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
            </template>

            <button @click="(mode === 'story' || mode === 'profile') ? extractAll() : extract()" :disabled="loading || ((mode === 'story' || mode === 'profile') ? !username : !url)" 
                class="w-full sm:w-auto bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-bold py-3 sm:py-4 px-6 sm:px-8 rounded-full shadow-lg transition-all active:scale-95 disabled:opacity-50 flex items-center justify-center gap-2 whitespace-nowrap text-sm sm:text-base">
                <template x-if="loading">
                    <span><i class="fa-solid fa-circle-notch animate-spin mr-2"></i> Ekstrak...</span>
                </template>
                <template x-if="!loading">
                    <span><i class="fa-solid fa-bolt mr-2"></i> Ekstrak</span>
                </template>
            </button>
        </div>
    </div>

    <div class="flex flex-wrap justify-center gap-4 sm:gap-6 mt-6 text-slate-400 dark:text-slate-500 px-4">
        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold hover:text-slate-800 dark:hover:text-white transition-colors cursor-default"><i class="fa-brands fa-tiktok text-lg sm:text-xl"></i> TikTok</div>
        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold hover:text-slate-800 dark:hover:text-white transition-colors cursor-default"><i class="fa-brands fa-instagram text-lg sm:text-xl"></i> Instagram</div>
        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold hover:text-slate-800 dark:hover:text-white transition-colors cursor-default"><i class="fa-brands fa-x-twitter text-lg sm:text-xl"></i> Twitter / X</div>
    </div>

        <div x-show="result" x-transition.opacity.duration.500ms class="mt-8 sm:mt-12 bg-white dark:bg-slate-900 rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden" style="display: none;">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
            
            <div class="md:col-span-5 relative bg-slate-100 dark:bg-black min-h-[250px] sm:min-h-[300px] md:min-h-[400px] flex items-center justify-center overflow-hidden p-4 sm:p-6">
                <div class="absolute inset-0 bg-gradient-to-tr from-sky-500/20 to-transparent z-10"></div>
                <img :src="proxyImg(result?.thumbnail)" class="absolute inset-0 w-full h-full object-cover blur-2xl opacity-50 scale-125">
                
                <div class="absolute top-4 left-4 z-30 bg-black/60 backdrop-blur-md text-white text-[10px] sm:text-xs font-bold px-3 py-1.5 rounded-lg flex items-center gap-2 shadow-lg">
                    <i class="fa-brands" :class="result?.platform === 'TikTok' ? 'fa-tiktok' : (result?.platform === 'Instagram' ? 'fa-instagram' : (result?.platform === 'Douyin' ? 'fa-solid fa-music' : 'fa-x-twitter'))"></i> 
                    <span x-text="result?.platform"></span>
                </div>

                <template x-if="!isResultVideo">
                    <div class="relative w-full h-full flex items-center justify-center z-20 group">
                        <img :src="proxyImg(result?.media[activeImageIndex]?.url)" class="max-w-full max-h-[250px] sm:max-h-[350px] object-contain rounded-xl shadow-2xl transition-all duration-300">
                        
                        <div x-show="result?.media.length > 1" class="absolute inset-x-0 flex justify-between px-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                            <button @click="activeImageIndex = (activeImageIndex === 0) ? result.media.length - 1 : activeImageIndex - 1" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white/80 dark:bg-black/50 backdrop-blur-sm text-slate-800 dark:text-white flex items-center justify-center hover:bg-sky-500 hover:text-white transition shadow-lg text-sm sm:text-base">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button @click="activeImageIndex = (activeImageIndex === result.media.length - 1) ? 0 : activeImageIndex + 1" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white/80 dark:bg-black/50 backdrop-blur-sm text-slate-800 dark:text-white flex items-center justify-center hover:bg-sky-500 hover:text-white transition shadow-lg text-sm sm:text-base">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                        
                        <div class="absolute bottom-[-15px] left-1/2 -translate-x-1/2 bg-black/70 text-white text-[10px] font-bold px-3 py-1 rounded-full backdrop-blur-md">
                            <span x-text="activeImageIndex + 1"></span> / <span x-text="result?.media.length"></span>
                        </div>
                    </div>
                </template>

                <template x-if="isResultVideo">
                    <div class="relative z-20 group cursor-pointer inline-block" @click="openPreview((result?.platform === 'TikTok' || result?.platform === 'Douyin') ? (result?.media[0].url_hd || result?.media[0].url_sd) : result?.media[0].url, 'video')">
                        <template x-if="result?.thumbnail">
                            <img :src="proxyImg(result?.thumbnail)" class="w-auto h-auto max-w-full max-h-[250px] sm:max-h-[350px] object-contain drop-shadow-2xl rounded-xl group-hover:opacity-75 transition-opacity duration-300">
                        </template>
                        <template x-if="!result?.thumbnail">
                            <div class="w-[250px] h-[250px] sm:w-[300px] sm:h-[300px] rounded-xl bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center group-hover:opacity-75 transition-opacity duration-300">
                                <i class="fa-solid fa-film text-5xl text-white/30"></i>
                            </div>
                        </template>
                        
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-black/40 backdrop-blur-md rounded-full flex items-center justify-center text-white group-hover:bg-sky-500 group-hover:scale-110 transition-all duration-300 shadow-2xl border border-white/20">
                                <i class="fa-solid fa-play ml-1 text-2xl sm:text-3xl"></i>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="md:col-span-7 p-5 sm:p-8 md:p-10 flex flex-col justify-center">
                
                <div class="flex items-center gap-3 mb-3 sm:mb-4 text-slate-500 dark:text-slate-400">
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center overflow-hidden shrink-0">
                        <i class="fa-solid fa-user text-xs"></i>
                    </div>
                    <span class="text-xs sm:text-sm font-bold truncate w-full" x-text="'@' + result?.author"></span>
                </div>
                
                <h2 class="text-lg sm:text-xl font-medium text-slate-800 dark:text-white mb-6 sm:mb-8 line-clamp-3 leading-relaxed" x-html="result?.title"></h2>

                <template x-if="result?.platform === 'TikTok' || result?.platform === 'Douyin'">
                    <div class="space-y-4">
                        
                        <template x-if="result?.type === 'video'">
                            <div class="space-y-3">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 sm:mb-3">Opsi Unduhan & Preview</h4>
                                
                                <button @click="openPreview(result?.media[0].url_hd || result?.media[0].url_sd, 'video')" class="flex items-center justify-between w-full p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all group active:scale-95">
                                    <div class="flex items-center gap-2 sm:gap-3 text-sm sm:text-base font-bold">
                                        <i class="fa-solid fa-play text-sky-500"></i> Putar Video (Preview)
                                    </div>
                                    <i class="fa-solid fa-expand group-hover:scale-110 transition-transform text-slate-400"></i>
                                </button>
                        
                                <a :href="'<?= base_url('tools/download-media') ?>?url=' + encodeURIComponent(result?.media[0].url_hd || result?.media[0].url_sd) + '&type=video'" target="_blank" rel="noreferrer" class="flex items-center justify-between w-full p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-indigo-100 dark:border-indigo-900/50 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white hover:border-indigo-500 transition-all group active:scale-95">
                                    <div class="flex items-center gap-2 sm:gap-3 text-sm sm:text-base font-bold">
                                        <i class="fa-solid fa-video"></i> Download Video HD
                                    </div>
                                    <i class="fa-solid fa-download group-hover:scale-110 transition-transform"></i>
                                </a>
                                
                                <a x-show="result?.audio" :href="'<?= base_url('tools/download-media') ?>?url=' + encodeURIComponent(result?.audio) + '&type=audio'" target="_blank" rel="noreferrer" class="flex items-center justify-between w-full p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-rose-100 dark:border-rose-900/50 bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 hover:bg-rose-600 hover:text-white hover:border-rose-500 transition-all group active:scale-95">
                                    <div class="flex items-center gap-2 sm:gap-3 text-sm sm:text-base font-bold">
                                        <i class="fa-solid fa-music"></i> Download Audio (MP3)
                                    </div>
                                    <i class="fa-solid fa-download group-hover:scale-110 transition-transform"></i>
                                </a>
                            </div>
                        </template>

                        <template x-if="result?.type === 'image'">
                            <div class="space-y-3">
                                <div class="flex justify-between items-end">
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Opsi Unduhan Foto (<span x-text="result?.media.length"></span> Slide)</h4>
                                </div>

                                <a :href="result?.media[activeImageIndex]?.url" target="_blank" rel="noreferrer" class="flex items-center justify-between w-full p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-emerald-100 dark:border-emerald-900/50 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-600 hover:text-white hover:border-emerald-500 transition-all group active:scale-95">
                                    <div class="flex items-center gap-2 sm:gap-3 text-sm sm:text-base font-bold">
                                        <i class="fa-regular fa-image"></i> Download Slide ke-<span x-text="activeImageIndex + 1"></span>
                                    </div>
                                    <i class="fa-solid fa-download group-hover:scale-110 transition-transform"></i>
                                </a>

                                <button x-show="result?.media.length > 2" @click="downloadAllSequential(result.media)" :disabled="downloadingAll"
                                    class="flex items-center justify-center gap-2 w-full p-3 rounded-xl sm:rounded-2xl border-2 border-dashed border-slate-300 dark:border-slate-600 text-slate-500 dark:text-slate-400 hover:border-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all text-sm font-bold disabled:opacity-60">
                                    <template x-if="downloadingAll"><span><i class="fa-solid fa-circle-notch animate-spin"></i> Mengunduh <span x-text="downloadAllProgress"></span>/<span x-text="downloadAllTotal"></span>...</span></template>
                                    <template x-if="!downloadingAll"><span><i class="fa-solid fa-layer-group"></i> Download Semua (<span x-text="result.media.length"></span> Slide)</span></template>
                                </button>

                                <p class="text-[11px] text-slate-400 text-center pt-1">Geser slide pakai tombol panah di atas, atau download semua sekaligus.</p>
                            </div>
                        </template>

                        <div x-show="result?.platform === 'TikTok'" class="mt-8 p-5 rounded-2xl border border-[#2AABEE]/20 bg-gradient-to-br from-[#2AABEE]/10 to-transparent text-center relative overflow-hidden group">
                            <i class="fa-brands fa-telegram absolute -right-6 -bottom-6 text-8xl text-[#2AABEE]/10 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-500"></i>
                            
                            <p class="text-sm text-slate-700 dark:text-slate-300 font-bold mb-3 relative z-10">Mau lebih mudah?</p>
                            
                            <button @click="sendToTelegramBot('https://t.me/UnduhvideotiktokBot')" class="relative z-10 w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#2AABEE] hover:bg-[#229ED9] text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-[#2AABEE]/30 active:scale-95 text-sm">
                                <i class="fa-brands fa-telegram text-lg"></i> Buka UnduhVideoTiktokBot
                            </button>
                            
                            <div class="mt-4 text-[10px] font-black tracking-[0.2em] text-[#2AABEE]/80 uppercase relative z-10">
                                By : IzumiD3v
                            </div>
                        </div>

                    </div>
                </template>

                <template x-if="result?.platform === 'Instagram'">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-2 sm:mb-3 border-b border-slate-100 dark:border-slate-800 pb-2">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Opsi Unduhan Instagram</h4>
                            <span class="text-[10px] font-bold text-sky-500 bg-sky-50 dark:bg-sky-900/30 px-2 py-1 rounded-md" x-text="result?.media.length + ' Item Terdeteksi'"></span>
                        </div>

                        <template x-if="result?.media.length === 1">
                            <a :href="'<?= base_url('tools/download-media') ?>?url=' + encodeURIComponent(result?.media[0].url) + '&type=' + result?.media[0].type" target="_blank" rel="noreferrer" class="flex items-center justify-between w-full p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-indigo-100 dark:border-indigo-900/50 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white hover:border-indigo-500 transition-all group active:scale-95">
                                <div class="flex items-center gap-2 sm:gap-3 text-sm sm:text-base font-bold">
                                    <i class="fa-solid" :class="result?.media[0].type === 'video' ? 'fa-video' : 'fa-image'"></i>
                                    <span x-text="result?.media[0].type === 'video' ? 'Download Video' : 'Download Foto'"></span>
                                </div>
                                <i class="fa-solid fa-download group-hover:scale-110 transition-transform"></i>
                            </a>
                        </template>

                        <template x-if="result?.media.length > 1">
                            <div class="space-y-3">
                                <div class="flex justify-between items-end">
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Carousel (<span x-text="result?.media.length"></span> Slide)</h4>
                                </div>
                                <a :href="'<?= base_url('tools/download-media') ?>?url=' + encodeURIComponent(result?.media[activeImageIndex]?.url) + '&type=' + result?.media[activeImageIndex]?.type" target="_blank" rel="noreferrer" class="flex items-center justify-between w-full p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-emerald-100 dark:border-emerald-900/50 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-600 hover:text-white hover:border-emerald-500 transition-all group active:scale-95">
                                    <div class="flex items-center gap-2 sm:gap-3 text-sm sm:text-base font-bold">
                                        <i class="fa-solid" :class="result?.media[activeImageIndex]?.type === 'video' ? 'fa-video' : 'fa-image'"></i>
                                        Download Slide ke-<span x-text="activeImageIndex + 1"></span>
                                    </div>
                                    <i class="fa-solid fa-download group-hover:scale-110 transition-transform"></i>
                                </a>

                                <button x-show="result?.media.length > 2" @click="downloadAllSequential(result.media)" :disabled="downloadingAll"
                                    class="flex items-center justify-center gap-2 w-full p-3 rounded-xl sm:rounded-2xl border-2 border-dashed border-slate-300 dark:border-slate-600 text-slate-500 dark:text-slate-400 hover:border-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all text-sm font-bold disabled:opacity-60">
                                    <template x-if="downloadingAll"><span><i class="fa-solid fa-circle-notch animate-spin"></i> Mengunduh <span x-text="downloadAllProgress"></span>/<span x-text="downloadAllTotal"></span>...</span></template>
                                    <template x-if="!downloadingAll"><span><i class="fa-solid fa-layer-group"></i> Download Semua (<span x-text="result.media.length"></span> Slide)</span></template>
                                </button>

                                <p class="text-[11px] text-slate-400 text-center pt-1">Geser slide pakai tombol panah di atas, atau download semua sekaligus.</p>
                            </div>
                        </template>

                        <div class="mt-8 p-5 rounded-2xl border border-pink-500/20 bg-gradient-to-br from-pink-500/10 to-transparent text-center relative overflow-hidden group">
                            <i class="fa-brands fa-instagram absolute -right-6 -bottom-6 text-8xl text-pink-500/10 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-500"></i>

                            <p class="text-sm text-slate-700 dark:text-slate-300 font-bold mb-3 relative z-10">Mau lebih mudah?</p>

                            <button @click="sendToTelegramBot('https://t.me/videosdownloaderfree_bot')" class="relative z-10 w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#2AABEE] hover:bg-[#229ED9] text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-[#2AABEE]/30 active:scale-95 text-sm">
                                <i class="fa-brands fa-telegram text-lg"></i> Buka @videosdownloaderfree_bot
                            </button>

                            <div class="mt-4 text-[10px] font-black tracking-[0.2em] text-pink-500/80 uppercase relative z-10">By : IzumiD3v</div>
                        </div>
                    </div>
                </template>

                <template x-if="result?.platform === 'X / Twitter'">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-2 sm:mb-3 border-b border-slate-100 dark:border-slate-800 pb-2">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Opsi Unduhan Video X</h4>
                            <span class="text-[10px] font-bold text-sky-500 bg-sky-50 dark:bg-sky-900/30 px-2 py-1 rounded-md" x-text="result?.media.length + ' Video Terdeteksi'"></span>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <template x-for="(vid, idx) in result?.media" :key="idx">
                                <div class="bg-slate-50 dark:bg-slate-800/40 p-3 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col h-full">
                                    
                                    <div class="relative w-full aspect-video bg-black rounded-xl overflow-hidden mb-3 group shadow-inner flex-shrink-0">
                                        <img :src="vid.thumbnail" class="w-full h-full object-cover opacity-70 group-hover:opacity-50 transition-opacity duration-300">
                                        
                                        <button @click="openPreview(vid.url, 'video')" class="absolute inset-0 w-full h-full flex flex-col items-center justify-center group/play">
                                            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white group-hover/play:bg-sky-500 group-hover/play:scale-110 transition-all duration-300 shadow-lg border border-white/30">
                                                <i class="fa-solid fa-play ml-1"></i>
                                            </div>
                                            <span class="text-[10px] text-white font-bold tracking-widest uppercase mt-2 opacity-0 group-hover/play:opacity-100 transition-opacity">Preview</span>
                                        </button>
                                    </div>
                                    
                                    <div class="mt-auto">
                                        <a :href="'<?= base_url('tools/download-media') ?>?url=' + encodeURIComponent(vid.url) + '&type=video'" target="_blank" rel="noreferrer" class="w-full flex items-center justify-center gap-2 py-3 bg-sky-50 dark:bg-sky-900/20 hover:bg-sky-500 hover:text-white text-sky-600 dark:text-sky-400 text-sm font-bold rounded-xl border border-sky-100 dark:border-sky-800/50 hover:border-sky-500 transition-colors shadow-sm active:scale-95">
                                            <i class="fa-solid fa-download"></i> Download Video
                                        </a>
                                    </div>

                                </div>
                            </template>
                        </div>

                        <div class="mt-8 p-5 rounded-2xl border border-slate-800/10 dark:border-white/10 bg-gradient-to-br from-slate-100 to-transparent dark:from-slate-800/50 text-center relative overflow-hidden group">
                            <i class="fa-brands fa-x-twitter absolute -left-4 -bottom-4 text-8xl text-slate-900/5 dark:text-white/5 group-hover:scale-110 transition-transform duration-500"></i>
                            <i class="fa-brands fa-telegram absolute -right-6 -bottom-6 text-8xl text-[#2AABEE]/10 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-500"></i>
                            
                            <p class="text-sm text-slate-700 dark:text-slate-300 font-bold mb-3 relative z-10">Mau lebih mudah? Kirim link ke sini:</p>
                            
                            <button @click="sendToTelegramBot('https://t.me/XdownloaderPro_Bot')" class="relative z-10 w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#2AABEE] hover:bg-[#229ED9] text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-[#2AABEE]/30 active:scale-95 text-sm">
                                <i class="fa-solid fa-paper-plane text-lg"></i> Kirim ke XDownloaderPro Bot
                            </button>
                            
                            <div class="mt-4 text-[10px] font-black tracking-[0.2em] text-slate-400 uppercase relative z-10">
                                By : IzumiD3v
                            </div>
                        </div>

                    </div>
                </template>

            </div>
        </div>
    </div>

        <div x-show="allItems.length > 0" x-transition.opacity.duration.500ms class="mt-8 sm:mt-12" style="display: none;">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 px-1">
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid" :class="allPlatformLabel.includes('TikTok') ? 'fa-brands fa-tiktok' : 'fa-brands fa-instagram'"></i>
                    <span x-text="allPlatformLabel"></span>
                </h3>
                <p class="text-xs text-slate-400 mt-1">@<span x-text="allUsername"></span> &middot; <span x-text="allItems.length"></span> <span x-text="isPaginatedMode ? 'item termuat' : 'item ditemukan'"></span></p>
            </div>

            <button x-show="allItems.length > 2" @click="downloadAllSequential(allItems)" :disabled="downloadingAll"
                class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-full border-2 border-dashed border-slate-300 dark:border-slate-600 text-slate-500 dark:text-slate-400 hover:border-sky-400 hover:text-sky-600 dark:hover:text-sky-400 transition-all text-xs sm:text-sm font-bold disabled:opacity-60 whitespace-nowrap">
                <template x-if="downloadingAll"><span><i class="fa-solid fa-circle-notch animate-spin"></i> Mengunduh <span x-text="downloadAllProgress"></span>/<span x-text="downloadAllTotal"></span>...</span></template>
                <template x-if="!downloadingAll"><span><i class="fa-solid fa-layer-group"></i> <span x-text="isPaginatedMode ? 'Download Semua yang Termuat' : 'Download Semua'"></span></span></template>
            </button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
            <template x-for="(item, idx) in visibleItems" :key="idx">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col group">
                    
                    <div class="relative w-full aspect-[9/16] bg-slate-100 dark:bg-black overflow-hidden">
                        <img :src="proxyImg(item.thumbnail || item.url)" loading="lazy" class="w-full h-full object-cover opacity-90 group-hover:opacity-60 transition-opacity duration-300">
                        
                        <div class="absolute top-2 left-2 bg-black/60 text-white text-[9px] font-bold px-2 py-1 rounded-md backdrop-blur-sm">
                            <i :class="item.type === 'video' ? 'fa-solid fa-video' : 'fa-regular fa-image'"></i>
                        </div>

                        <template x-if="item.type === 'video'">
                            <button @click="openPreview(item.url, 'video')" class="absolute inset-0 w-full h-full flex items-center justify-center">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white group-hover:bg-sky-500 group-hover:scale-110 transition-all duration-300 shadow-lg border border-white/30">
                                    <i class="fa-solid fa-play ml-0.5 text-sm"></i>
                                </div>
                            </button>
                        </template>
                        <template x-if="item.type === 'image'">
                            <button @click="openPreview(item.url, 'image')" class="absolute inset-0 w-full h-full flex items-center justify-center">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white group-hover:bg-sky-500 group-hover:scale-110 transition-all duration-300 shadow-lg border border-white/30 opacity-0 group-hover:opacity-100">
                                    <i class="fa-solid fa-expand text-sm"></i>
                                </div>
                            </button>
                        </template>
                    </div>

                    <a :href="'<?= base_url('tools/download-media') ?>?url=' + encodeURIComponent(item.url) + '&type=' + item.type"
                       target="_blank" rel="noreferrer"
                       class="flex items-center justify-center gap-1.5 py-2.5 bg-sky-50 dark:bg-sky-900/20 hover:bg-sky-500 hover:text-white text-sky-600 dark:text-sky-400 text-[11px] sm:text-xs font-bold transition-colors active:scale-95">
                        <i class="fa-solid fa-download"></i> <span x-text="'Item ' + (idx + 1)"></span>
                    </a>
                </div>
            </template>
        </div>

                <div x-show="canAutoLoadMore"
             x-init="$nextTick(() => observeSentinel($el))"
             class="flex items-center justify-center gap-2 py-6 text-slate-400 text-xs font-bold">
            <i class="fa-solid fa-circle-notch animate-spin"></i> Memuat item lainnya...
        </div>

                <div x-show="reachedAutoCap" class="flex flex-col items-center justify-center gap-2 py-6">
            <p class="text-xs text-slate-400 font-medium">Sudah memuat <span x-text="allItems.length"></span> item. Lanjutkan memuat lebih banyak?</p>
            <button @click="pageCount = 0; loadMoreItems()" :disabled="loadingMore"
                class="px-5 py-2 rounded-full text-xs font-bold bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 hover:bg-sky-500 hover:text-white transition-colors disabled:opacity-50">
                <template x-if="loadingMore"><span><i class="fa-solid fa-circle-notch animate-spin mr-1"></i> Memuat...</span></template>
                <template x-if="!loadingMore"><span><i class="fa-solid fa-arrow-down mr-1"></i> Muat Lebih Banyak</span></template>
            </button>
        </div>

        <div class="mt-6 p-5 rounded-2xl border border-[#2AABEE]/20 bg-gradient-to-br from-[#2AABEE]/10 to-transparent text-center relative overflow-hidden group max-w-3xl mx-auto">
            <i class="fa-brands fa-telegram absolute -right-6 -bottom-6 text-8xl text-[#2AABEE]/10 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-500"></i>
            <p class="text-sm text-slate-700 dark:text-slate-300 font-bold mb-3 relative z-10">Mau lebih mudah lewat Telegram?</p>
            <button @click="sendToTelegramBot(allPlatformLabel.includes('TikTok') ? 'https://t.me/UnduhvideotiktokBot' : 'https://t.me/videosdownloaderfree_bot')" class="relative z-10 w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#2AABEE] hover:bg-[#229ED9] text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-[#2AABEE]/30 active:scale-95 text-sm">
                <i class="fa-brands fa-telegram text-lg"></i> Buka Bot Telegram
            </button>
            <div class="mt-4 text-[10px] font-black tracking-[0.2em] text-[#2AABEE]/80 uppercase relative z-10">By : IzumiD3v</div>
        </div>
    </div>
    
    <div class="mt-12 bg-slate-50/50 dark:bg-slate-900/30 p-6 sm:p-8 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm max-w-4xl mx-auto">
        <h3 class="text-base sm:text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2 justify-center sm:justify-start">
            <i class="fa-solid fa-shield-halved text-sky-500"></i> Informasi & Kebijakan Layanan
        </h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            <div class="space-y-2 text-center sm:text-left flex flex-col items-center sm:items-start">
                <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg mb-2">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-white text-sm">Privasi & Keamanan</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">
                    Kami menghargai privasi Anda. Kami <b>tidak menyimpan</b> riwayat unduhan, file media, maupun data pribadi Anda di server kami.
                </p>
            </div>

            <div class="space-y-2 text-center sm:text-left flex flex-col items-center sm:items-start">
                <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg mb-2">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-white text-sm">Hak Tanggung Jawab</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">
                    Hak cipta konten milik pembuat aslinya. Termasuk Story yang bersifat sementara, hanya unduh konten milik sendiri atau yang sudah diberi izin. Anda bertanggung jawab penuh atas media yang diunduh.
                </p>
            </div>

            <div class="space-y-2 text-center sm:text-left flex flex-col items-center sm:items-start">
                <div class="w-10 h-10 rounded-full bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center text-lg mb-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-white text-sm">Bukan Web Resmi</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">
                    Layanan ini ditenagai oleh API Pihak Ketiga dan <b>tidak berafiliasi</b>, didukung, atau disponsori oleh entitas resmi TikTok, Instagram, maupun X.
                </p>
            </div>

            <div class="space-y-2 text-center sm:text-left flex flex-col items-center sm:items-start">
                <div class="w-10 h-10 rounded-full bg-sky-100 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 flex items-center justify-center text-lg mb-2">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-white text-sm">Batas Wajar Pakai</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">
                    Demi kenyamanan semua pengguna, ada batas jumlah permintaan per menit. Jika muncul pesan limit, tunggu sebentar lalu coba lagi.
                </p>
            </div>
        </div>
    </div>

    <template x-teleport="body">
        <div>
            <div x-show="errorModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" x-cloak>
                <div x-show="errorModal" x-transition.opacity @click="errorModal = false" class="absolute inset-0 bg-slate-900/90 backdrop-blur-md"></div>
                <div x-show="errorModal" x-transition.scale.95 class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-white/10 overflow-hidden text-center p-6 sm:p-8">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-rose-500/10 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 text-3xl sm:text-4xl">
                        <i class="fa-solid fa-link-slash"></i>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-white mb-2 sm:mb-3">Gagal Mengekstrak</h3>
                    <p class="text-slate-500 dark:text-slate-400 font-medium mb-6 sm:mb-8 text-xs sm:text-sm leading-relaxed" x-text="errorMessage"></p>
                    <button @click="errorModal = false" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 sm:py-4 rounded-xl sm:rounded-2xl transition shadow-lg shadow-rose-500/30 text-sm sm:text-base">
                        Tutup
                    </button>
                </div>
            </div>

            <div x-show="previewModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" x-cloak>
                <div x-show="previewModal" x-transition.opacity @click="closePreview()" class="absolute inset-0 bg-black/95 backdrop-blur-md"></div>
                
                <div x-show="previewModal" x-transition.scale.95 class="relative w-full max-w-4xl max-h-[95vh] flex flex-col items-center justify-center">
                    
                    <button @click="closePreview()" class="absolute -top-10 right-0 sm:-right-4 text-white/50 hover:text-white transition-colors text-3xl z-50">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    
                    <template x-if="previewType === 'video'">
                        <div class="w-full flex flex-col items-center">
                            <video :src="previewUrl" controls autoplay playsinline crossorigin="anonymous" class="w-full max-w-full max-h-[75vh] rounded-2xl shadow-2xl bg-slate-900 outline-none border border-slate-800"></video>
                            
                            <div class="mt-5 text-center bg-slate-900/50 p-4 rounded-2xl border border-white/10 w-full sm:w-auto">
                                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-widest mb-2">Video Blank / Tidak Berputar?</p>
                                <a :href="previewUrl" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-sky-50 text-slate-900 px-5 py-2.5 rounded-xl text-sm font-black transition-all active:scale-95 shadow-lg">
                                    <i class="fa-solid fa-up-right-from-square"></i> Putar Layar Penuh
                                </a>
                            </div>
                        </div>
                    </template>
                    
                    <template x-if="previewType === 'image'">
                        <img :src="previewUrl" referrerpolicy="no-referrer" class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl border border-slate-800">
                    </template>
                    
                </div>
            </div>
        </div>
    </template>
</div>

<script>
function universalDownloader() {
    return {
        platform: 'tiktok',
        mode: 'link',

        url: '',
        username: '',

        loading: false,
        result: null,
        activeImageIndex: 0,

        allItems: [],
        allPlatformLabel: '',
        allUsername: '',
        visibleCount: 12,
        scrollBatchSize: 12,
        _scrollObserver: null,

        isPaginatedMode: false,
        cursor: 0,
        hasMore: false,
        pageCount: 0,
        maxAutoPages: 5,
        loadingMore: false,

        downloadingAll: false,
        downloadAllProgress: 0,
        downloadAllTotal: 0,

        errorModal: false,
        errorMessage: '',
        previewModal: false,
        previewUrl: '',
        previewType: '',

        proxyImg(url) {
            if (!url) return '';
            return '<?= base_url('tools/image-proxy') ?>?url=' + encodeURIComponent(url);
        },

        get isResultVideo() {
            if (!this.result) return false;
            if (this.result.type === 'video' || this.result.type === 'video_x') return true;
            if (this.result.type === 'single') {
                return this.result.media?.[0]?.type === 'video';
            }
            return false;
        },

        get visibleItems() {
            if (this.isPaginatedMode) return this.allItems;
            return this.allItems.slice(0, this.visibleCount);
        },

        get canAutoLoadMore() {
            if (this.isPaginatedMode) {
                return this.hasMore && this.pageCount < this.maxAutoPages && !this.loadingMore;
            }
            return this.visibleCount < this.allItems.length;
        },

        get reachedAutoCap() {
            return this.isPaginatedMode && this.hasMore && this.pageCount >= this.maxAutoPages;
        },

        loadMoreItems() {
            if (this.isPaginatedMode) {
                this.fetchNextProfilePage();
            } else {
                if (this.visibleCount >= this.allItems.length) return;
                this.visibleCount = Math.min(this.visibleCount + this.scrollBatchSize, this.allItems.length);
            }
        },

        observeSentinel(el) {
            if (this._scrollObserver) {
                this._scrollObserver.disconnect();
            }
            this._scrollObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && this.canAutoLoadMore) {
                        this.loadMoreItems();
                    }
                });
            }, { rootMargin: '300px' });
            this._scrollObserver.observe(el);
        },

        async fetchNextProfilePage() {
            if (this.loadingMore || !this.hasMore) return;
            this.loadingMore = true;

            let formData = new FormData();
            formData.append('platform', 'tiktok_profile');
            formData.append('username', this.allUsername);
            formData.append('cursor', this.cursor);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            try {
                const response = await fetch('<?= base_url('tools/extract-all') ?>', {
                    method: 'POST',
                    body: formData
                });
                const rawText = await response.text();
                let data;
                try {
                    data = JSON.parse(rawText);
                } catch (e) {
                    console.error(rawText);
                    this.hasMore = false;
                    return;
                }

                if (response.ok && data.success) {
                    const newItems = data.data.items || [];
                    this.allItems = this.allItems.concat(newItems);
                    this.hasMore = !!data.data.hasMore;
                    this.cursor = data.data.nextCursor || 0;
                    this.pageCount += 1;
                } else {
                    this.hasMore = false;
                }
            } catch (e) {
                this.hasMore = false;
            } finally {
                this.loadingMore = false;
            }
        },

        switchPlatform(p) {
            this.platform = p;
            this.url = '';
            this.username = '';
            this.result = null;
            this.allItems = [];
            this.visibleCount = this.scrollBatchSize;
            this.isPaginatedMode = false;
            this.cursor = 0;
            this.hasMore = false;
            this.pageCount = 0;
            this.mode = 'link';
        },

        get linkPlaceholder() {
            if (this.platform === 'tiktok') return 'Paste link TikTok di sini...';
            if (this.platform === 'instagram') return 'Paste link Post, Reel, Insight dan Story Instagram di sini...';
            if (this.platform === 'x') return 'Paste link X / Twitter di sini...';
            if (this.platform === 'douyin') return 'Paste link Douyin di sini...';
            return 'Paste link di sini...';
        },

        get platformIcon() {
            if (this.url.includes('tiktok.com') || this.url.includes('tiktok.v')) return 'fa-brands fa-tiktok';
            if (this.url.includes('instagram.com')) return 'fa-brands fa-instagram';
            if (this.url.includes('twitter.com') || this.url.includes('x.com')) return 'fa-brands fa-x-twitter';
            if (this.url.includes('douyin.com')) return 'fa-solid fa-music';
            return 'fa-solid fa-link';
        },

        get platformIconColor() {
            if (this.url) return 'text-slate-800 dark:text-white';
            return 'text-slate-400';
        },

        showError(msg) {
            this.errorMessage = msg;
            this.errorModal = true;
        },

        openPreview(realUrl, type) {
            if (type === 'video') {
                this.previewUrl = '<?= base_url('tools/video-proxy') ?>?url=' + encodeURIComponent(realUrl);
            } else {
                this.previewUrl = this.proxyImg(realUrl);
            }
            
            this.previewType = type;
            this.previewModal = true;
        },

        closePreview() {
            this.previewModal = false;
            setTimeout(() => { 
                this.previewUrl = ''; 
                this.previewType = '';
            }, 300);
        },

        
        async downloadAllSequential(items) {
            if (this.downloadingAll || !items || items.length === 0) return;
            this.downloadingAll = true;
            this.downloadAllTotal = items.length;
            this.downloadAllProgress = 0;

            for (const item of items) {
                const type = item.type || (item.url_hd || item.url_sd ? 'video' : 'image');
                const mediaUrl = item.url || item.url_hd || item.url_sd;
                if (!mediaUrl) continue;

                const link = document.createElement('a');
                link.href = '<?= base_url('tools/download-media') ?>?url=' + encodeURIComponent(mediaUrl) + '&type=' + type;
                link.target = '_blank';
                link.rel = 'noreferrer';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                this.downloadAllProgress += 1;
                await new Promise(resolve => setTimeout(resolve, 700));
            }

            this.downloadingAll = false;
        },

        sendToTelegramBot(botUrl) {
            if (!this.url && !this.username) return;

            const textToCopy = this.url || this.username;
            navigator.clipboard.writeText(textToCopy).then(() => {
                let oldBtnText = event.currentTarget.innerHTML;
                event.currentTarget.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Link Tersalin! Buka Bot...';
                
                setTimeout(() => {
                    window.open(botUrl, '_blank');
                    event.currentTarget.innerHTML = oldBtnText;
                }, 800);
            }).catch(err => {
                window.open(botUrl, '_blank');
            });
        },

        async extract() {
            if (!this.url.trim()) return this.showError('Masukkan link video terlebih dahulu!');
            
            this.loading = true;
            this.result = null;
            this.allItems = [];
            this.activeImageIndex = 0;
            
            let formData = new FormData();
            formData.append('url', this.url);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            try {
                const response = await fetch('<?= base_url('tools/extract-link') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const rawText = await response.text();
                let data;
                
                try {
                    data = JSON.parse(rawText);
                } catch(e) {
                    console.error(rawText);
                    return this.showError("Server PHP Error. Buka Console.");
                }
                
                if (response.ok && data.success) {
                    this.result = data.data;
                } else {
                    this.showError(data.error || 'Gagal mengekstrak link.');
                }
            } catch (e) {
                this.showError('Terjadi kesalahan jaringan.');
            } finally {
                this.loading = false;
            }
        },

        async extractAll() {
            if (!this.username.trim()) return this.showError('Masukkan username terlebih dahulu!');

            this.loading = true;
            this.result = null;
            this.allItems = [];

            this.cursor = 0;
            this.hasMore = false;
            this.pageCount = 0;
            this.isPaginatedMode = (this.platform === 'tiktok' && this.mode === 'profile');

            const platformKey = this.platform === 'tiktok'
                ? (this.mode === 'profile' ? 'tiktok_profile' : 'tiktok_story')
                : (this.mode === 'profile' ? 'ig_profile' : 'ig_story');

            let formData = new FormData();
            formData.append('platform', platformKey);
            formData.append('username', this.username);
            if (this.isPaginatedMode) {
                formData.append('cursor', 0);
            }
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            try {
                const response = await fetch('<?= base_url('tools/extract-all') ?>', {
                    method: 'POST',
                    body: formData
                });

                const rawText = await response.text();
                let data;

                try {
                    data = JSON.parse(rawText);
                } catch (e) {
                    console.error(rawText);
                    return this.showError("Server PHP Error. Buka Console.");
                }

                if (response.ok && data.success) {
                    this.allItems = data.data.items || [];
                    this.allPlatformLabel = data.data.platform || '';
                    this.allUsername = data.data.username || this.username;
                    this.visibleCount = this.scrollBatchSize;

                    if (this.isPaginatedMode) {
                        this.hasMore = !!data.data.hasMore;
                        this.cursor = data.data.nextCursor || 0;
                        this.pageCount = 1;
                    }
                } else {
                    this.showError(data.error || 'Gagal mengambil story.');
                }
            } catch (e) {
                this.showError('Terjadi kesalahan jaringan.');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>

<?= $this->endSection() ?>