<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .dark .glass-card {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .glass-card:hover {
        border-color: rgba(99, 102, 241, 0.3);
        transform: translateY(-2px);
    }
    
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-image: linear-gradient(45deg, #4f46e5, #ec4899);
    }
    .dark .text-gradient {
        background-image: linear-gradient(45deg, #818cf8, #f472b6);
    }
</style>

<div class="mb-10 flex flex-col md:flex-row justify-between items-end md:items-center gap-4 relative z-10">
    <div>
        <h1 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">
            Dashboard <span class="text-gradient">Overview</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 font-medium">
            Welcome back, <span class="text-slate-800 dark:text-white font-bold"><?= session()->get('username') ?></span> 👋
        </p>
    </div>
    
    <form method="get" class="glass-card px-4 py-2 rounded-2xl shadow-sm flex items-center gap-3 transition-all">
        <div class="p-1.5 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
            <i class="fa-solid fa-filter text-xs"></i>
        </div>
        <select name="filter" onchange="this.form.submit()" class="bg-transparent text-sm font-bold text-slate-700 dark:text-slate-300 focus:outline-none cursor-pointer pr-2">
            <option value="daily" <?= ($filter == 'daily') ? 'selected' : '' ?>>Last 30 Days</option>
            <option value="monthly" <?= ($filter == 'monthly') ? 'selected' : '' ?>>Monthly (This Year)</option>
            <option value="yearly" <?= ($filter == 'yearly') ? 'selected' : '' ?>>Yearly View</option>
        </select>
    </form>
</div>

<h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4"><i class="fa-solid fa-wallet text-indigo-500 mr-2"></i> Financial Overview</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    
    <div class="border-slate-700/50 border rounded-[2rem] p-6 relative overflow-hidden group shadow-lg shadow-blue-500/10 transition-all duration-300">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl group-hover:bg-blue-500/20 transition-all"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1">Transaksi Masuk</p>
                <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-2">Rp <?= number_format($total_income, 0, ',', '.') ?></h3>
                <p class="text-xs font-medium text-slate-500">Omzet kotor dari penjualan prompt</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-400 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
        </div>
    </div>

    <div class="border-slate-700/50 border rounded-[2rem] p-6 relative overflow-hidden group shadow-lg shadow-rose-500/10 transition-all duration-300">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-rose-500/10 rounded-full blur-3xl group-hover:bg-rose-500/20 transition-all"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider mb-1">Dana Dicairkan</p>
                <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-2">Rp <?= number_format($total_wd_net, 0, ',', '.') ?></h3>
                <p class="text-xs font-medium text-slate-500">Telah ditransfer bersih ke kreator</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-400 to-red-600 text-white flex items-center justify-center shadow-lg shadow-rose-500/30">
                <i class="fa-solid fa-money-bill-transfer"></i>
            </div>
        </div>
    </div>

    <div class="border-slate-700/50 border rounded-[2rem] p-6 relative overflow-hidden group shadow-lg shadow-emerald-500/10 transition-all duration-300">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Profit Platform</p>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white">Rp <?= number_format($platform_profit, 0, ',', '.') ?></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <i class="fa-solid fa-vault"></i>
                </div>
            </div>
            
            <div class="pt-3 border-t border-slate-200 dark:border-slate-700/50 text-xs font-mono text-slate-500 dark:text-slate-400 space-y-1.5">
                <div class="flex justify-between">
                    <span>Admin Flat (Rp 7.500)</span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">+ Rp <?= number_format($fee_flat, 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Komisi Platform (3%)</span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">+ Rp <?= number_format($fee_percent, 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
    </div>

</div>

<h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4"><i class="fa-solid fa-chart-pie text-indigo-500 mr-2"></i> Content & Traffic</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    
    <div class="border-slate-700/50 border rounded-[2rem] p-6 relative overflow-hidden group shadow-lg shadow-indigo-500/10 transition-all duration-300 flex flex-col justify-between">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all"></div>
        <div class="relative z-10 flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-briefcase text-lg"></i>
            </div>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-1">Projects</p>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-1"><?= number_format($total_project) ?></h3>
            <a href="<?= base_url('admin/projects') ?>" class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-colors uppercase">
                Manage <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="border-slate-700/50 border rounded-[2rem] p-6 relative overflow-hidden group shadow-lg shadow-pink-500/10 transition-all duration-300 flex flex-col justify-between">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-pink-500/10 rounded-full blur-3xl group-hover:bg-pink-500/20 transition-all"></div>
        <div class="relative z-10 flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 text-white flex items-center justify-center shadow-lg shadow-pink-500/30 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-layer-group text-lg"></i>
            </div>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold text-pink-600 dark:text-pink-400 uppercase tracking-wider mb-1">AI Prompts</p>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-1"><?= number_format($total_prompt) ?></h3>
            <a href="<?= base_url('admin/ai-prompts') ?>" class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-500 hover:text-pink-600 dark:text-slate-400 dark:hover:text-pink-400 transition-colors uppercase">
                Manage <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="border-slate-700/50 border rounded-[2rem] p-6 relative overflow-hidden group shadow-lg shadow-emerald-500/10 transition-all duration-300 flex flex-col justify-between">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all"></div>
        <div class="relative z-10 flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-newspaper text-lg"></i>
            </div>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Articles</p>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-1"><?= number_format($total_post) ?></h3>
            <a href="<?= base_url('admin/posts') ?>" class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors uppercase">
                Write New <i class="fa-solid fa-pen-nib"></i>
            </a>
        </div>
    </div>

    <div class="border-slate-700/50 border rounded-[2rem] p-6 relative overflow-hidden group shadow-lg shadow-orange-500/10 transition-all duration-300 flex flex-col justify-between">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl group-hover:bg-orange-500/20 transition-all"></div>
        <div class="relative z-10 flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-400 to-red-500 text-white flex items-center justify-center shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-users text-lg"></i>
            </div>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider mb-1">Total Visits</p>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-1"><?= number_format($total_visit) ?></h3>
            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-400 uppercase">
                <i class="fa-solid fa-chart-line"></i> All Time
            </span>
        </div>
    </div>
    
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
    
    <div class="lg:col-span-2 glass-card rounded-[2rem] p-8 shadow-sm">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Traffic Analytics</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Pengunjung unik berdasarkan waktu</p>
            </div>
            <span class="px-4 py-1.5 text-xs font-bold rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                <?= ucfirst($filter) ?> View
            </span>
        </div>
        <div class="relative h-80 w-full">
            <canvas id="trafficChart"></canvas>
        </div>
    </div>

    <div class="border-slate-700/50 border rounded-[2rem] p-8 shadow-sm flex flex-col justify-between">
        <div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Device OS</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Sistem operasi yang digunakan pengunjung</p>
        </div>
        
        <div class="relative h-56 w-full flex justify-center items-center">
            <canvas id="osChart"></canvas>
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="text-center">
                    <span class="block text-2xl font-black text-slate-800 dark:text-white"><?= count($os_stats) ?></span>
                    <span class="text-[10px] uppercase text-slate-400 font-bold">Types</span>
                </div>
            </div>
        </div>

        <div class="mt-8 space-y-3">
            <?php foreach(array_slice($os_stats, 0, 3) as $index => $os): ?>
            <div class="flex justify-between items-center p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full ring-2 ring-white dark:ring-slate-900" style="background-color: <?= ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'][$index % 5] ?>;"></span>
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-300"><?= $os['os'] ?: 'Unknown' ?></span>
                </div>
                <span class="font-bold text-sm text-slate-800 dark:text-white bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md"><?= $os['count'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="border-slate-700/50 border rounded-[2rem] p-8 shadow-sm mb-8">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Recent Visitors</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">10 data kunjungan terakhir real-time</p>
            </div>
        </div>
        <button class="text-slate-400 hover:text-indigo-500 transition"><i class="fa-solid fa-ellipsis"></i></button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200 dark:border-slate-700">
                    <th class="pb-4 pl-4 whitespace-nowrap">IP Address</th>
                    <th class="pb-4 whitespace-nowrap">System</th>
                    <th class="pb-4 whitespace-nowrap">Browser</th>
                    <th class="pb-4 whitespace-nowrap">Page Visited</th> <th class="pb-4 text-right pr-4 whitespace-nowrap">Time</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700/50">
                <?php foreach($recent_visits as $visit): ?>
                <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition duration-300">
                    <td class="py-4 pl-4 font-mono text-indigo-600 dark:text-indigo-400 font-semibold group-hover:translate-x-1 transition-transform whitespace-nowrap">
                        <?= $visit['ip_address'] ?>
                    </td>
                    <td class="py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300">
                            <?php 
                                $osIcon = 'fa-desktop';
                                $osColor = 'text-slate-400';
                                if (stripos($visit['os'], 'Windows') !== false) { $osIcon = 'fa-windows'; $osColor = 'text-blue-500'; }
                                elseif (stripos($visit['os'], 'Android') !== false) { $osIcon = 'fa-android'; $osColor = 'text-green-500'; }
                                elseif (stripos($visit['os'], 'iOS') !== false || stripos($visit['os'], 'Mac') !== false) { $osIcon = 'fa-apple'; $osColor = 'text-slate-800 dark:text-white'; }
                                elseif (stripos($visit['os'], 'Linux') !== false) { $osIcon = 'fa-linux'; $osColor = 'text-yellow-500'; }
                            ?>
                            <i class="fa-brands <?= $osIcon ?> <?= $osColor ?> w-5 text-center"></i>
                            <span class="font-medium"><?= $visit['os'] ?: 'Unknown' ?></span>
                        </div>
                    </td>
                    <td class="py-4 text-slate-600 dark:text-slate-400 whitespace-nowrap">
                        <?= explode(' ', $visit['browser'])[0] ?: 'Unknown' ?>
                    </td>
                    
                    <td class="py-4 text-slate-500 dark:text-slate-400 max-w-[150px] truncate" title="<?= esc($visit['url_visited']) ?>">
                        <?php 
                            $rawUrl = $visit['url_visited'] ?? '';
                            $urlDisplay = !empty($rawUrl) ? esc($rawUrl) : '/'; 
                            if (strpos($rawUrl, 'http') === 0) {
                                $finalHref = $rawUrl;
                            } else {
                                $finalHref = base_url($rawUrl);
                            }
                        ?>
                        <a href="<?= esc($finalHref) ?>" target="_blank" class="hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline transition-colors flex items-center gap-1.5">
                            <i class="fa-solid fa-link text-[10px] opacity-50"></i>
                            <span class="truncate"><?= $urlDisplay ?></span>
                        </a>
                    </td>

                    <td class="py-4 pr-4 text-right whitespace-nowrap">
                        <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-500">
                            <?= date('H:i', strtotime($visit['created_at'])) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    Chart.defaults.font.family = 'Plus Jakarta Sans';
    Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
    const ctx = document.getElementById('trafficChart').getContext('2d');
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.4)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= $chart_labels ?>,
            datasets: [{
                label: 'Total Kunjungan',
                data: <?= $chart_values ?>,
                backgroundColor: gradient,
                borderColor: '#6366f1',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#6366f1',
                pointBorderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#ffffff',
                    titleColor: isDark ? '#fff' : '#1e293b',
                    bodyColor: isDark ? '#cbd5e1' : '#475569',
                    borderColor: isDark ? '#334155' : '#e2e8f0',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: false,
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor, borderDash: [5, 5] },
                    ticks: { stepSize: 1, font: { size: 11 } }
                }
            },
            interaction: { mode: 'nearest', axis: 'x', intersect: false }
        }
    });

    const ctxOS = document.getElementById('osChart').getContext('2d');
    new Chart(ctxOS, {
        type: 'doughnut',
        data: {
            labels: [<?php foreach($os_stats as $os) echo "'".($os['os']?:'Unknown')."',"; ?>],
            datasets: [{
                data: [<?php foreach($os_stats as $os) echo $os['count'].","; ?>],
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#ffffff',
                    bodyColor: isDark ? '#fff' : '#1e293b',
                    borderColor: isDark ? '#334155' : '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 10,
                    padding: 12
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>