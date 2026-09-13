<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="lg:translate-x-0 lg:static fixed inset-y-0 left-0 z-30 w-64 sidebar-blur border-r border-slate-200/50 dark:border-slate-700/50 shadow-2xl lg:shadow-none flex flex-col h-full z-50 overflow-hidden transition-transform duration-300">
    
    <div class="h-20 min-h-[5rem] flex items-center px-6 border-b border-slate-200/50 dark:border-slate-700/50 ] backdrop-blur-md">
        <a href="<?= base_url('admin') ?>" class="flex items-center gap-3 overflow-hidden group w-full">
            <div class="relative w-10 h-10 min-w-[2.5rem] bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white  shadow-indigo-500/30 transition-all duration-300 group-hover:scale-105 group-hover:shadow-indigo-500/50">
                <i class="fa-solid fa-layer-group text-lg"></i>
                <div class="absolute inset-0 rounded-xl bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            
            <div class="flex flex-col transition-transform duration-300 group-hover:translate-x-1">
                <span class="block text-lg font-black tracking-tight text-slate-800 dark:text-white leading-tight">
                    RIAN<span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-pink-500">PROJECTS</span>
                </span>
                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold tracking-widest uppercase flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Admin Panel
                </span>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto overflow-x-hidden flex flex-col custom-scrollbar">
        
        <div class="px-2 mb-2 mt-2">
            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Main Menu</p>
        </div>

        <?php $isActive = (uri_string() == 'admin'); ?>
        <a href="<?= base_url('admin') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 shadow-sm ring-1 ring-indigo-200 dark:ring-indigo-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-indigo-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0 relative">
                <i class="fa-solid fa-chart-line text-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6 <?= $isActive ? 'text-indigo-600 dark:text-indigo-400 drop-shadow-[0_0_8px_rgba(99,102,241,0.5)]' : 'group-hover:text-indigo-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Dashboard</span>
        </a>
        
        <?php $isActive = (strpos(uri_string(), 'transactions') !== false); ?>
        <a href="<?= base_url('admin/transactions') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 shadow-sm ring-1 ring-red-200 dark:ring-red-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-red-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0 relative">
                <i class="fa-solid fa-money-bill text-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6 <?= $isActive ? 'text-red-600 dark:text-red-400 drop-shadow-[0_0_8px_rgba(99,102,241,0.5)]' : 'group-hover:text-red-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Transaksi</span>
        </a>
        
        <?php $isActive = (strpos(uri_string(), 'invoices') !== false); ?>
        <a href="<?= base_url('admin/invoices') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 shadow-sm ring-1 ring-yellow-200 dark:ring-yellow-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-yellow-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0 relative">
                <i class="fa-solid fa-file-invoice text-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6 <?= $isActive ? 'text-yellow-600 dark:text-yellow-400 drop-shadow-[0_0_8px_rgba(99,102,241,0.5)]' : 'group-hover:text-yellow-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Invoices</span>
        </a>
        
        <?php $isActive = (strpos(uri_string(), 'users') !== false); ?>
        <a href="<?= base_url('admin/users') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 shadow-sm ring-1 ring-orange-200 dark:ring-orange-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-orange-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0 relative">
                <i class="fa-solid fa-user text-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6 <?= $isActive ? 'text-orange-600 dark:text-orange-400 drop-shadow-[0_0_8px_rgba(99,102,241,0.5)]' : 'group-hover:text-orange-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Users</span>
        </a>

        <?php $isActive = (strpos(uri_string(), 'projects') !== false); ?>
        <a href="<?= base_url('admin/projects') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 shadow-sm ring-1 ring-purple-200 dark:ring-purple-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-purple-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-briefcase text-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6 <?= $isActive ? 'text-purple-600 dark:text-purple-400 drop-shadow-[0_0_8px_rgba(168,85,247,0.5)]' : 'group-hover:text-purple-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Projects</span>
        </a>
        
        <?php $isActive = (strpos(uri_string(), 'admin/porto') !== false); ?>
        <a href="<?= base_url('admin/porto') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-violet-50 dark:bg-violet-900/20 text-violet-600 dark:text-violet-400 shadow-sm ring-1 ring-violet-200 dark:ring-violet-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-violet-500 rounded-r-full"></div>
            <?php endif; ?>
        
            <div class="w-8 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-folder-open text-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6 <?= $isActive ? 'text-violet-600 dark:text-violet-400 drop-shadow-[0_0_8px_rgba(139,92,246,0.5)]' : 'group-hover:text-violet-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Porto</span>
        </a>

        <?php $isActive = (strpos(uri_string(), 'posts') !== false); ?>
        <a href="<?= base_url('admin/posts') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 shadow-sm ring-1 ring-pink-200 dark:ring-pink-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-pink-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-pen-nib text-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6 <?= $isActive ? 'text-pink-600 dark:text-pink-400 drop-shadow-[0_0_8px_rgba(236,72,153,0.5)]' : 'group-hover:text-pink-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Blog Posts</span>
        </a>
        
        <?php $isActive = (strpos(uri_string(), 'ai-prompts') !== false); ?>
        <a href="<?= base_url('admin/ai-prompts') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 shadow-sm ring-1 ring-green-200 dark:ring-green-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-green-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-wand-magic-sparkles text-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6 <?= $isActive ? 'text-green-600 dark:text-green-400 drop-shadow-[0_0_8px_rgba(236,72,153,0.5)]' : 'group-hover:text-green-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Ai Prompts</span>
        </a>
        
        <?php $isActive = (strpos(uri_string(), 'ailab') !== false); ?>
        <a href="<?= base_url('admin/ailab') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 shadow-sm ring-1 ring-orange-200 dark:ring-orange-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-orange-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-wand-magic-sparkles text-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6 <?= $isActive ? 'text-orange-600 dark:text-orange-400 drop-shadow-[0_0_8px_rgba(236,72,153,0.5)]' : 'group-hover:text-orange-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Ai Labs</span>
        </a>
        
        <?php $isActive = (strpos(uri_string(), 'widget') !== false); ?>
        <a href="<?= base_url('admin/widgets') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 shadow-sm ring-1 ring-yellow-200 dark:ring-yellow-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-yellow-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-grip text-lg transition-transform duration-300 group-hover:scale-110 group-hover:rotate-45 <?= $isActive ? 'text-yellow-600 dark:text-yellow-400 drop-shadow-[0_0_8px_rgba(6,182,212,0.5)]' : 'group-hover:text-yellow-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Widget</span>
        </a>

        <?php $isActive = (strpos(uri_string(), 'appversions') !== false); ?>
        <a href="<?= base_url('admin/appversions') ?>"
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 shadow-sm ring-1 ring-emerald-200 dark:ring-emerald-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">

            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-emerald-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-mobile-screen-button text-lg transition-transform duration-300 group-hover:scale-110 <?= $isActive ? 'text-emerald-600 dark:text-emerald-400 drop-shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'group-hover:text-emerald-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">App Versions</span>
        </a>

        <?php $isActive = (strpos(uri_string(), 'paymentmethods') !== false); ?>
        <a href="<?= base_url('admin/paymentmethods') ?>"
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 shadow-sm ring-1 ring-amber-200 dark:ring-amber-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">

            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-amber-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-money-check-dollar text-lg transition-transform duration-300 group-hover:scale-110 <?= $isActive ? 'text-amber-600 dark:text-amber-400 drop-shadow-[0_0_8px_rgba(245,158,11,0.5)]' : 'group-hover:text-amber-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Payment Methods</span>
        </a>

        <?php $isActive = (strpos(uri_string(), 'settings') !== false); ?>
        <a href="<?= base_url('admin/settings') ?>" 
           class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden
           <?= $isActive ? 'bg-cyan-50 dark:bg-cyan-900/20 text-cyan-600 dark:text-cyan-400 shadow-sm ring-1 ring-cyan-200 dark:ring-cyan-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
            
            <?php if($isActive): ?>
                <div class="absolute inset-y-0 left-0 w-1 bg-cyan-500 rounded-r-full"></div>
            <?php endif; ?>

            <div class="w-8 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-gear text-lg transition-transform duration-300 group-hover:scale-110 group-hover:rotate-45 <?= $isActive ? 'text-cyan-600 dark:text-cyan-400 drop-shadow-[0_0_8px_rgba(6,182,212,0.5)]' : 'group-hover:text-cyan-500' ?>"></i>
            </div>
            <span class="ml-3 font-bold text-sm tracking-wide">Settings</span>
        </a>
        
        <?php $isActive = (strpos(uri_string(), 'website') !== false); ?>
            <a href="<?= base_url('/') ?>" target="_blank" class="flex items-center h-12 rounded-xl transition-all duration-300 group relative px-4 overflow-hidden <?= $isActive ? 'bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 shadow-sm ring-1 ring-teal-200 dark:ring-teal-800' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' ?>">
                <?php if($isActive): ?>
                    <div class="absolute inset-y-0 left-0 w-1 bg-teal-500 rounded-r-full"></div>
                <?php endif; ?>
                <div class="w-8 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-up-right-from-square text-lg transition-transform duration-300 group-hover:scale-110 group-hover:rotate-45 <?= $isActive ? 'text-teal-600 dark:text-teal-400 drop-shadow-[0_0_8px_rgba(20,184,166,0.5)]' : 'group-hover:text-teal-500' ?>"></i>
                </div>
                <span class="ml-3 font-bold text-sm tracking-wide">Preview Website</span>
            </a>

    </nav>

    <div class="p-4 border-t border-slate-200/50 dark:border-slate-700/50 bg-white/30 dark:bg-slate-900/30 backdrop-blur-md">
        <a href="<?= base_url('auth/logout') ?>" 
           class="flex items-center justify-center h-12 text-sm font-bold text-red-600 bg-red-50 dark:bg-red-900/20 dark:text-red-400 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/40 transition-all duration-300 shadow-sm hover:shadow-md group relative overflow-hidden">
            
            <div class="absolute inset-0 bg-red-500/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
            
            <i class="fa-solid fa-power-off mr-2 group-hover:scale-110 transition-transform relative z-10"></i>
            <span class="relative z-10">Sign Out</span>
        </a>
    </div>
</aside>

<style>
    .sidebar-blur {
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        background-color: rgba(255, 255, 255, 0.7);
    }
    
    .dark .sidebar-blur {
        background-color: rgba(15, 23, 42, 0.7);
    }

    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.3); border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(71, 85, 105, 0.3); }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(100, 116, 139, 0.5); }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(51, 65, 85, 0.5); }
</style>