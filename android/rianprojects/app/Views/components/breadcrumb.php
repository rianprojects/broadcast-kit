<?php if(isset($breadcrumbs) && is_array($breadcrumbs)): ?>
<nav class="flex justify-center mb-8">
    <ol class="flex items-center space-x-2">
        
        <li>
            <a href="<?= base_url() ?>" class="hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-house text-xs"></i> Beranda
            </a>
        </li>

        <?php if (isset($breadcrumbs) && is_array($breadcrumbs)): ?>
            <?php foreach ($breadcrumbs as $label => $link): ?>
                
                <li><i class="fa-solid fa-chevron-right text-[10px] opacity-50 mx-1"></i></li>

                <?php if ($link === '#'): ?>
                    <li>
                        <span class="font-bold <?= $breadcrumb_color ?? 'text-emerald-500' ?>">
                            <?= esc($label) ?>
                        </span>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?= base_url($link) ?>" class="hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors">
                            <?= esc($label) ?>
                        </a>
                    </li>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php endif; ?>
        
    </ol>
</nav>
<?php endif; ?>