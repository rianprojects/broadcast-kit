<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="flex items-center justify-center space-x-2 my-8">
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getFirst() ?>" class="px-3 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-400 hover:text-white hover:border-indigo-500 transition-all" aria-label="First">
            <i class="fas fa-angles-left text-xs"></i>
        </a>
        <a href="<?= $pager->getPrevious() ?>" class="px-3 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-400 hover:text-white hover:border-indigo-500 transition-all" aria-label="Previous">
            <i class="fas fa-chevron-left text-xs"></i>
        </a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <a href="<?= $link['uri'] ?>" class="px-4 py-2 rounded-lg text-sm font-bold transition-all <?= $link['active'] ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'bg-gray-800 border border-gray-700 text-gray-400 hover:text-white hover:border-indigo-500' ?>">
            <?= $link['title'] ?>
        </a>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getNext() ?>" class="px-3 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-400 hover:text-white hover:border-indigo-500 transition-all" aria-label="Next">
            <i class="fas fa-chevron-right text-xs"></i>
        </a>
        <a href="<?= $pager->getLast() ?>" class="px-3 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-400 hover:text-white hover:border-indigo-500 transition-all" aria-label="Last">
            <i class="fas fa-angles-right text-xs"></i>
        </a>
    <?php endif ?>
</nav>