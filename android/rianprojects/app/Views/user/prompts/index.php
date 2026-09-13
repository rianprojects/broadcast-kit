<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>

<div class="pt-28 pb-20 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div class="text-center md:text-left">
                <h1 class="text-3xl font-black text-slate-900 dark:text-white">Galeri Saya</h1>
                <p class="text-slate-500 dark:text-slate-400">Kelola prompt yang sudah Anda upload.</p>
            </div>
            
            <?php if(!empty($prompts)): ?>
            <a href="<?= base_url('prompts/my/new') ?>" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all flex items-center gap-2 active:scale-95">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload Baru
            </a>
            <?php endif; ?>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-800 flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check"></i>
                <p class="text-sm font-bold"><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl border border-rose-200 dark:border-rose-800 flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <p class="text-sm font-bold"><?= session()->getFlashdata('error') ?></p>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach($prompts as $p): ?>
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                <div class="relative h-48 overflow-hidden flex-shrink-0">
                    <img src="<?= base_url('uploads/prompts/' . $p['image']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="absolute top-3 right-3 flex gap-2">
                        <button type="button" onclick="openDeleteModal(<?= $p['id'] ?>, '<?= esc(addslashes($p['title'])) ?>')" class="w-9 h-9 bg-white/90 dark:bg-slate-800/90 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-colors shadow-lg backdrop-blur-sm" title="Hapus Karya">
                            <i class="fa-solid fa-trash text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-grow justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white truncate text-lg"><?= esc($p['title']) ?></h3>
                        
                        <p class="text-xs text-slate-500 mt-2 mb-4 line-clamp-2 font-mono bg-slate-50 dark:bg-slate-800/50 p-2 rounded-lg border border-slate-100 dark:border-slate-800">
                            <?= esc(html_entity_decode(strip_tags($p['prompt']))) ?>
                        </p>
                    </div>
                    
                    <a href="<?= base_url('prompt/' . $p['slug']) ?>" target="_blank" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 flex items-center gap-1.5 transition-colors w-max mt-auto">
                        Lihat Halaman Publik <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if(empty($prompts)): ?>
            <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/10 rounded-3xl">
                <div class="w-20 h-20 bg-white dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 dark:text-slate-600 shadow-sm border border-slate-100 dark:border-slate-700">
                    <i class="fa-solid fa-image text-3xl"></i>
                </div>
                <h3 class="text-slate-800 dark:text-white font-black text-xl mb-2">Belum ada karya.</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-8 max-w-sm mx-auto leading-relaxed">Anda belum mengunggah karya apapun. Mulai bagikan prompt AI terbaikmu dan dapatkan penghasilan!</p>
                <a href="<?= base_url('prompts/my/new') ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all active:scale-95 hover:scale-105">
                    <i class="fa-solid fa-plus"></i> Upload Karya Pertama
                </a>
            </div>
            <?php endif; ?>
        </div>
        
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[9999] hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-8 w-full max-w-sm shadow-2xl border border-slate-200 dark:border-slate-800 transform scale-95 opacity-0 transition-all duration-300" id="deleteModalBox">
        
        <div class="w-20 h-20 bg-rose-50 dark:bg-rose-900/20 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl shadow-inner">
            <i class="fa-solid fa-triangle-exclamation animate-bounce"></i>
        </div>
        
        <h3 class="text-2xl font-black text-center text-slate-900 dark:text-white mb-2">Hapus Karya?</h3>
        <p class="text-sm text-center text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">
            Anda yakin ingin menghapus <br>
            <strong id="deletePromptTitle" class="text-slate-800 dark:text-slate-200"></strong>?<br>
            Tindakan ini permanen dan tidak bisa dibatalkan.
        </p>
        
        <form id="deleteForm" action="" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            
            <div class="flex gap-3 justify-center">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-3.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 text-sm font-bold transition-all active:scale-95">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-3.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold shadow-lg shadow-rose-500/30 transition-all active:scale-95 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-trash-can"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openDeleteModal(id, title) {
    const form = document.getElementById('deleteForm');
    const titleSpan = document.getElementById('deletePromptTitle');
    const modal = document.getElementById('deleteModal');
    const box = document.getElementById('deleteModalBox');
    form.action = "<?= base_url('prompts/my/delete') ?>/" + id;
    titleSpan.innerText = '"' + title + '"';
    modal.classList.remove('hidden');
    setTimeout(() => {
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const box = document.getElementById('deleteModalBox');
    box.classList.remove('scale-100', 'opacity-100');
    box.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if(e.target === this) {
        closeDeleteModal();
    }
});
</script>
<?= $this->endSection() ?>