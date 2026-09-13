<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<section class="relative pt-20 pb-32 overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-5xl mx-auto">

            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-200/50 dark:border-slate-700/50 border-indigo-200/50 dark:border-indigo-800/50 mb-8 animate-slide-down">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
                </span>
                <span class="text-sm font-semibold gradient-text">Tersedia untuk Proyek</span>
            </div>

            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-bold tracking-tight text-slate-900 dark:text-white mb-6 leading-tight animate-slide-up">
                <span>Menciptakan Solusi Digital</span>
                <span class="block mt-3 gradient-text animate-scale-in" style="animation-delay: 0.2s;">
                    <span>Yang Skalable & Menginspirasi</span>
                </span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto mb-10 leading-relaxed animate-fade-in" style="animation-delay: 0.4s;">
                Full-stack developer yang passionate dalam membangun aplikasi web modern dengan kode yang clean, 
                user experience yang exceptional, dan teknologi cutting-edge.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-20 animate-slide-up" style="animation-delay: 0.6s;">
                <a href="#projects" class="group px-8 py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:shadow-2xl hover:shadow-indigo-500/50 transition-all duration-300 inline-flex items-center justify-center gap-2 glow-effect hover:scale-105">
                    <span>Lihat Karya Saya</span>
                    <i class="fa-solid fa-arrow-down group-hover:translate-y-1 transition-transform"></i>
                </a>
                <a href="<?= base_url('blog') ?>" class="px-8 py-4 rounded-xl border border-slate-200/50 dark:border-slate-700/50 border-2 border-slate-300/50 dark:border-slate-600/50 text-slate-700 dark:text-slate-200 font-semibold hover:border-indigo-500 dark:hover:border-indigo-500 transition-all duration-300 inline-flex items-center justify-center gap-2 hover:scale-105">
                    <span>Baca Artikel</span>
                    <i class="fa-solid fa-book-open"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-20 max-w-4xl mx-auto">
                <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/20 group">
                    <div class="text-4xl font-bold gradient-text mb-2 font-outfit">280+</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">Proyek Selesai</div>
                </div>
                <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/20 group">
                    <div class="text-4xl font-bold gradient-text mb-2 font-outfit">150+</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">Klien Puas</div>
                </div>
                <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/20 group">
                    <div class="text-4xl font-bold gradient-text mb-2 font-outfit">5+</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">Tahun Pengalaman</div>
                </div>
                <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/20 group">
                    <div class="text-4xl font-bold gradient-text mb-2 font-outfit">98%</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">Tingkat Kepuasan</div>
                </div>
            </div>

            <div class="text-center mb-8">
                <h3 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-3 font-outfit">Keahlian & Teknologi</h3>
                <p class="text-slate-600 dark:text-slate-400">Tools dan framework yang saya kuasai</p>
            </div>

            <div class="relative mt-8">
                <div class="tech-carousel-container relative overflow-hidden py-8">
                    <div class="tech-carousel flex gap-8 items-center w-max">
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-indigo-500/30 group-hover:border-indigo-500 transition-all duration-300">
                                <i class="fab fa-php text-4xl text-[#777BB4] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">PHP</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-red-500/30 group-hover:border-red-500 transition-all duration-300">
                                <i class="fab fa-laravel text-4xl text-[#FF2D20] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">Laravel</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-orange-500/30 group-hover:border-orange-500 transition-all duration-300">
                                <i class="fa-solid fa-fire text-4xl text-[#EF4223] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">CodeIgniter</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-blue-500/30 group-hover:border-blue-500 transition-all duration-300">
                                <i class="fab fa-wordpress text-4xl text-[#21759B] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">WordPress</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-green-500/30 group-hover:border-green-500 transition-all duration-300">
                                <i class="fab fa-node-js text-4xl text-[#339933] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">Node.js</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-blue-400/30 group-hover:border-blue-400 transition-all duration-300">
                                <i class="fab fa-python text-4xl text-[#3776AB] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">Python</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-orange-600/30 group-hover:border-orange-600 transition-all duration-300">
                                <i class="fab fa-html5 text-4xl text-[#E34F26] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">HTML5</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-blue-600/30 group-hover:border-blue-600 transition-all duration-300">
                                <i class="fab fa-css3-alt text-4xl text-[#1572B6] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">CSS3</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-yellow-400/30 group-hover:border-yellow-400 transition-all duration-300">
                                <i class="fab fa-js text-4xl text-[#F7DF1E] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">JavaScript</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-cyan-400/30 group-hover:border-cyan-400 transition-all duration-300">
                                <i class="fab fa-react text-4xl text-[#61DAFB] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">React</span>
                            </div>
                        </div>
                        
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-indigo-500/30 group-hover:border-indigo-500 transition-all duration-300">
                                <i class="fab fa-php text-4xl text-[#777BB4] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">PHP</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-red-500/30 group-hover:border-red-500 transition-all duration-300">
                                <i class="fab fa-laravel text-4xl text-[#FF2D20] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">Laravel</span>
                            </div>
                        </div>
                        <div class="tech-item flex-shrink-0 group cursor-pointer">
                            <div class="w-20 h-20 flex flex-col items-center justify-center rounded-2xl border border-slate-200/50 dark:border-slate-700/50 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-orange-500/30 group-hover:border-orange-500 transition-all duration-300">
                                <i class="fa-solid fa-fire text-4xl text-[#EF4223] mb-1"></i>
                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">CodeIgniter</span>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4 font-outfit">Dipercaya Oleh</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                Bekerja sama dengan berbagai organisasi dan perusahaan ternama
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:scale-105 hover:shadow-xl hover:shadow-indigo-500/20 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mb-3 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-building text-2xl text-white"></i>
                </div>
                <h4 class="font-bold text-sm text-center text-slate-800 dark:text-white">IAK Setih Setio</h4>
            </div>
            <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:scale-105 hover:shadow-xl hover:shadow-pink-500/20 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center mb-3 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-palette text-2xl text-white"></i>
                </div>
                <h4 class="font-bold text-sm text-center text-slate-800 dark:text-white">Batik Mulia</h4>
            </div>
            <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:scale-105 hover:shadow-xl hover:shadow-green-500/20 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center mb-3 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-landmark text-2xl text-white"></i>
                </div>
                <h4 class="font-bold text-sm text-center text-slate-800 dark:text-white">Dekranasda Bungo</h4>
            </div>
            <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:scale-105 hover:shadow-xl hover:shadow-blue-500/20 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center mb-3 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-digital-tachograph text-2xl text-white"></i>
                </div>
                <h4 class="font-bold text-sm text-center text-slate-800 dark:text-white">Digivite</h4>
            </div>
            <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:scale-105 hover:shadow-xl hover:shadow-orange-500/20 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center mb-3 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-shopping-bag text-2xl text-white"></i>
                </div>
                <h4 class="font-bold text-sm text-center text-slate-800 dark:text-white">Mozystore</h4>
            </div>
            <div class="border border-slate-200/50 dark:border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:scale-105 hover:shadow-xl hover:shadow-red-500/20 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center mb-3 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-film text-2xl text-white"></i>
                </div>
                <h4 class="font-bold text-sm text-center text-slate-800 dark:text-white">Bagfilm</h4>
            </div>
        </div>
    </div>
</section>

<section id="projects" class="py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4 font-outfit">Proyek Unggulan</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                Koleksi kurasi karya terbaru saya, menampilkan web development modern dan problem-solving kreatif.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($projects as $index => $project) : ?>
                <div class="group relative rounded-3xl overflow-hidden hover:shadow-2xl hover:shadow-indigo-500/20 hover:-translate-y-3 transition-all duration-500 border border-slate-200/50 dark:border-slate-700/50" style="animation-delay: <?= $index * 0.1 ?>s;">
                    
                    <div class="aspect-video overflow-hidden relative">
                        <img src="<?= base_url('uploads/projects/' . $project['thumbnail']) ?>" 
                             alt="<?= esc($project['title']) ?>" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 right-4">
                            <span class="text-xs font-bold px-3 py-1.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-full shadow-lg">
                                <?= esc($project['category'] ?? 'Web App') ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <a href="<?= base_url('project/' . $project['slug']) ?>" class="group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 line-clamp-1 font-outfit">
                                <?= esc($project['title']) ?>
                            </h3>
                        </a>

                        <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-2 mb-5 leading-relaxed">
                            <?= strip_tags($project['description']) ?>
                        </p>
                        
                        <a href="<?= base_url('project/' . $project['slug']) ?>" class="w-full py-3 flex items-center justify-center gap-2 border-2 border-slate-300/50 dark:border-slate-600/50 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-600 hover:text-white hover:border-transparent transition-all duration-300 text-sm font-semibold group/btn">
                            <span>Detail Lengkap</span>
                            <i class="fa-solid fa-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div id="projectModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl border border-slate-200/50 dark:border-slate-700/50 text-left shadow-2xl transition-all sm:my-8 w-full max-w-6xl scale-95 opacity-0" id="modalPanel">
                <div class="border border-slate-200/50 dark:border-slate-700/50 px-4 py-3 border-b flex flex-col md:flex-row justify-between items-center gap-4 bg-white dark:bg-slate-900">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white font-outfit" id="modalTitle">Loading...</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-mono" id="modalTech">...</p>
                    </div>

                    <div class="flex items-center border border-slate-200/50 dark:border-slate-700/50 rounded-lg p-1 shadow-sm">
                        <button onclick="switchView('desktop')" id="btnDesktop" class="p-2 rounded text-slate-500 hover:text-indigo-600 hover:bg-slate-100/50 dark:hover:bg-slate-800/50 transition active-view">
                            <i class="fa-solid fa-desktop text-lg"></i>
                        </button>
                        <div class="w-px h-6 bg-slate-200/50 dark:bg-slate-700/50 mx-1"></div>
                        <button onclick="switchView('tablet')" id="btnTablet" class="p-2 rounded text-slate-500 hover:text-indigo-600 hover:bg-slate-100/50 dark:hover:bg-slate-800/50 transition">
                            <i class="fa-solid fa-tablet-screen-button text-lg"></i>
                        </button>
                        <div class="w-px h-6 bg-slate-200/50 dark:bg-slate-700/50 mx-1"></div>
                        <button onclick="switchView('mobile')" id="btnMobile" class="p-2 rounded text-slate-500 hover:text-indigo-600 hover:bg-slate-100/50 dark:hover:bg-slate-800/50 transition">
                            <i class="fa-solid fa-mobile-screen-button text-lg"></i>
                        </button>
                    </div>

                    <button onclick="closeModal()" class="text-slate-400 hover:text-red-500 transition">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>

                <div class="bg-slate-100 dark:bg-black h-[75vh] flex flex-col relative overflow-hidden">
                    <div class="flex-1 overflow-auto flex justify-center py-8 bg-cube-pattern transition-colors duration-500 relative">
                        <div id="iframeLoader" class="absolute inset-0 flex items-center justify-center z-10">
                            <i class="fa-solid fa-circle-notch fa-spin text-4xl text-indigo-500"></i>
                        </div>

                        <div id="iframeContainer" class="w-full h-full bg-white shadow-2xl transition-all duration-500 ease-in-out border-4 border-slate-800 rounded-lg overflow-hidden relative z-20">
                            <iframe id="previewFrame" src="" class="w-full h-full" frameborder="0"></iframe>
                        </div>
                    </div>

                    <div class="border border-slate-200/50 dark:border-slate-700/50 px-6 py-4 border-t bg-white dark:bg-slate-900">
                        <p class="text-sm text-slate-600 dark:text-slate-300" id="modalDesc">Loading description...</p>
                        <a href="#" target="_blank" id="modalExternalLink" class="inline-flex items-center gap-2 mt-2 text-sm font-semibold text-indigo-600 hover:underline">
                            <span>Buka Website Live</span> <i class="fa-solid fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.tech-carousel {
    animation: scroll 40s linear infinite;
    width: max-content;
    will-change: transform;
}

.tech-carousel:hover {
    animation-play-state: paused;
}

.tech-item {
    transition: all 0.3s ease;
}

.tech-item:hover {
    animation: float 2s ease-in-out infinite;
}

.bg-cube-pattern {
    background-image: 
        linear-gradient(30deg, #f1f5f9 12%, transparent 12.5%, transparent 87%, #f1f5f9 87.5%, #f1f5f9),
        linear-gradient(150deg, #f1f5f9 12%, transparent 12.5%, transparent 87%, #f1f5f9 87.5%, #f1f5f9),
        linear-gradient(30deg, #f1f5f9 12%, transparent 12.5%, transparent 87%, #f1f5f9 87.5%, #f1f5f9),
        linear-gradient(150deg, #f1f5f9 12%, transparent 12.5%, transparent 87%, #f1f5f9 87.5%, #f1f5f9);
    background-size: 80px 140px;
    background-position: 0 0, 0 0, 40px 70px, 40px 70px;
}

.dark .bg-cube-pattern {
    background-image: 
        linear-gradient(30deg, #1a1a24 12%, transparent 12.5%, transparent 87%, #1a1a24 87.5%, #1a1a24),
        linear-gradient(150deg, #1a1a24 12%, transparent 12.5%, transparent 87%, #1a1a24 87.5%, #1a1a24),
        linear-gradient(30deg, #1a1a24 12%, transparent 12.5%, transparent 87%, #1a1a24 87.5%, #1a1a24),
        linear-gradient(150deg, #1a1a24 12%, transparent 12.5%, transparent 87%, #1a1a24 87.5%, #1a1a24);
}
</style>

<script>
   
    const modal = document.getElementById('projectModal');
    const backdrop = document.getElementById('modalBackdrop');
    const panel = document.getElementById('modalPanel');
    const iframeContainer = document.getElementById('iframeContainer');
    const iframe = document.getElementById('previewFrame');
    const loader = document.getElementById('iframeLoader');
    let currentUrl = '';

    function openProjectModal(slug) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }, 10);

        iframe.src = 'about:blank';
        loader.classList.remove('hidden');
        
        fetch(`<?= base_url('project/') ?>/${slug}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').innerText = data.title;
            document.getElementById('modalTech').innerText = data.tech_stack;
            document.getElementById('modalDesc').innerHTML = data.description;
            document.getElementById('modalExternalLink').href = data.preview_url;
            currentUrl = data.preview_url;

            if (!currentUrl) {
                iframe.classList.add('hidden');
                loader.innerHTML = '<p class="text-slate-500">No preview available.</p>';
            } else {
                iframe.classList.remove('hidden');
                iframe.src = currentUrl;
                iframe.onload = () => {
                    loader.classList.add('hidden');
                };
                
                setTimeout(() => {
                    if(!loader.classList.contains('hidden')) {
                        loader.innerHTML = `
                            <div class="text-center px-4">
                                <p class="text-slate-500 mb-2">Website blocked preview (Security Policy).</p>
                                <a href="${currentUrl}" target="_blank" class="text-indigo-600 underline">Open in New Tab</a>
                            </div>
                        `;
                    }
                }, 5000);
            }
        })
        .catch(err => {
            console.error(err);
            loader.innerHTML = '<p class="text-red-500">Failed to load data.</p>';
        });
            
        switchView('desktop');
    }

    function closeModal() {
        backdrop.classList.add('opacity-0');
        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            iframe.src = 'about:blank';
            loader.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-4xl text-indigo-500"></i>';
            loader.classList.remove('hidden');
        }, 300);
    }

    function switchView(device) {
        iframeContainer.style.maxWidth = '100%';
        iframeContainer.style.height = '100%';
        
        document.querySelectorAll('#btnDesktop, #btnTablet, #btnMobile').forEach(btn => {
            btn.classList.remove('text-indigo-600', 'bg-indigo-50', 'dark:text-indigo-400', 'dark:bg-slate-800');
            btn.classList.add('text-slate-500');
        });

        if (device === 'mobile') {
            iframeContainer.style.maxWidth = '375px';
            document.getElementById('btnMobile').classList.add('text-indigo-600', 'bg-indigo-50', 'dark:text-indigo-400', 'dark:bg-slate-800');
        } else if (device === 'tablet') {
            iframeContainer.style.maxWidth = '768px';
            document.getElementById('btnTablet').classList.add('text-indigo-600', 'bg-indigo-50', 'dark:text-indigo-400', 'dark:bg-slate-800');
        } else {
            document.getElementById('btnDesktop').classList.add('text-indigo-600', 'bg-indigo-50', 'dark:text-indigo-400', 'dark:bg-slate-800');
        }
    }
</script>

<?= $this->endSection() ?>