<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Sidebar Widgets</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Atur urutan dengan cara drag and drop (<i class="fa-solid fa-arrows-up-down"></i>).</p>
    </div>
    <a href="<?= base_url('admin/widgets/create') ?>" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">
        + Tambah Widget
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-800 flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        <span class="font-bold text-sm"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="rounded-[2rem] p-6 shadow-xl border border-slate-200 dark:border-slate-800">
    <ul id="widget-list" class="space-y-3">
        <?php if(empty($widgets)): ?>
            <li class="p-8 text-center text-slate-400 border-2 border-dashed border-slate-700 rounded-xl">Belum ada widget.</li>
        <?php endif; ?>

        <?php foreach($widgets as $w): ?>
            <li data-id="<?= $w['id'] ?>" class="flex items-center justify-between p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm cursor-move hover:border-indigo-500 transition-colors group">
                
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-grip-vertical text-slate-400 group-hover:text-indigo-400 text-xl cursor-grab"></i>
                    <div>
                        <h4 class="font-bold text-slate-800 dark:text-white"><?= esc($w['title']) ?: '<span class="italic text-slate-500">Tanpa Judul</span>' ?></h4>
                        <span class="text-[10px] font-bold uppercase tracking-wider <?= $w['is_active'] ? 'text-emerald-500' : 'text-rose-500' ?>">
                            <?= $w['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="<?= base_url('admin/widgets/edit/' . $w['id']) ?>" class="w-10 h-10 flex items-center justify-center text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-xl transition">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form action="<?= base_url('admin/widgets/delete/' . $w['id']) ?>" method="post" onsubmit="return confirm('Hapus widget ini?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="w-10 h-10 flex items-center justify-center text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-xl transition">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div id="toast" class="fixed bottom-5 right-5 transform translate-y-20 opacity-0 transition-all duration-300 bg-slate-800 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 z-50">
    <i class="fa-solid fa-check-circle text-emerald-400"></i>
    <span class="font-bold text-sm">Urutan disimpan!</span>
</div>

<script>
    var el = document.getElementById('widget-list');
    var sortable = Sortable.create(el, {
        animation: 150,
        ghostClass: 'opacity-40', 
        dragClass: 'shadow-2xl',
        onEnd: function () {
            
            var order = [];
            document.querySelectorAll('#widget-list li').forEach(function(li) {
                if(li.getAttribute('data-id')) {
                    order.push(li.getAttribute('data-id'));
                }
            });

            fetch('<?= base_url('admin/widgets/updateOrder') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>' 
                },
                body: JSON.stringify({ order: order })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success'){
                  
                    const toast = document.getElementById('toast');
                    toast.classList.remove('translate-y-20', 'opacity-0');
                    setTimeout(() => {
                        toast.classList.add('translate-y-20', 'opacity-0');
                    }, 2500);
                }
            });
        },
    });
</script>

<?= $this->endSection() ?>