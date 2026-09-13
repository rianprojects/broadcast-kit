<?= $this->extend('layouts/frontend') ?>

<?= $this->section('extra_head') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen pt-12 md:pt-32 pb-20 transition-colors duration-500">
    
    <div class="w-full max-w-4xl mx-auto px-4 md:px-6">
        
        <div class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-2 tracking-tighter uppercase font-outfit">
                System Health
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Real-time Service Monitoring</p>
        </div>

        <div class="grid gap-6">
            <?php foreach($monitors as $m): ?>
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[1.5rem] p-5 md:p-6 shadow-sm hover:shadow-md transition-shadow">
                
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6 text-center sm:text-left">
                    
                    <div class="flex flex-col items-center sm:items-start gap-2">
                        <div class="flex flex-wrap justify-center sm:justify-start items-center gap-3">
                            <h3 class="font-bold text-slate-800 dark:text-white text-xl font-outfit">
                                <?= $m['site_name'] ?>
                            </h3>
                            
                            <?php if($m['status'] == 'up'): ?>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20"><i class="fa-solid fa-check"></i> OPERATIONAL</span>
                            <?php elseif($m['status'] == 'slow'): ?>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-600 border border-amber-200"><i class="fa-solid fa-triangle-exclamation"></i> DEGRADED</span>
                            <?php elseif($m['status'] == 'bad'): ?>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600 border border-red-200"><i class="fa-solid fa-circle-exclamation"></i> BAD</span>
                            <?php else: ?>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600 border border-red-200 animate-pulse"><i class="fa-solid fa-bolt"></i> OUTAGE</span>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?= $m['url'] ?>" target="_blank" class="text-xs text-slate-400 font-mono hover:text-indigo-500 transition-colors break-all">
                            <?= $m['url'] ?> <i class="fa-solid fa-external-link-alt ml-1"></i>
                        </a>
                    </div>

                    <?php 
                        $resColor = 'text-indigo-600 dark:text-indigo-400';
                        if($m['last_response'] <= 100) $resColor = 'text-emerald-500';
                        elseif($m['last_response'] > 100 && $m['last_response'] <= 150) $resColor = 'text-amber-500';
                        else $resColor = 'text-red-500';
                    ?>
                    
                    <div class="w-full sm:w-auto flex flex-col items-center sm:items-end bg-slate-50 dark:bg-slate-800/50 sm:bg-transparent rounded-xl p-3 sm:p-0 border border-slate-100 dark:border-slate-800 sm:border-none">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Response</span>
                        <span class="text-2xl sm:text-xl font-black font-outfit <?= $resColor ?>">
                            <?= $m['last_response'] ?>ms
                        </span>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex items-end justify-between gap-0.5 md:gap-1 h-8 w-full">
                        <?php 
                        $historyData = $m['history'] ?? [];
                        $totalSlots = 20;
                        $emptySlots = $totalSlots - count($historyData);
                        for($i=0; $i<$emptySlots; $i++): ?>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-sm h-full"></div>
                        <?php endfor; 
                        
                        foreach($historyData as $h): 
                            $color = ($h['status'] == 'up') ? 'bg-emerald-400' : 'bg-red-500';
                        ?>
                            <div class="relative w-full h-full <?= $color ?> rounded-sm group tooltip-trigger transition-all hover:scale-110 hover:shadow-lg">
                                <div class="hidden group-hover:block absolute bottom-full mb-2 left-1/2 -translate-x-1/2 w-max px-2 py-1 bg-slate-800 text-white text-[10px] rounded shadow-xl z-20 pointer-events-none">
                                    <?= $h['response_time'] ?>ms <br>
                                    <span class="text-slate-400"><?= date('H:i', strtotime($h['created_at'])) ?></span>
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-800"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="flex justify-between mt-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                        <span>20 Checks Ago</span>
                        <span>Now</span>
                    </div>
                </div>

                <div class="h-24 w-full border-t border-slate-100 dark:border-slate-800 pt-4 relative">
                    <?php if(!empty($m['history'])): ?>
                        <div class="relative w-full h-full">
                            <canvas id="chart-<?= $m['id'] ?>"></canvas>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center justify-center h-full text-[10px] text-slate-400 uppercase tracking-widest">
                            No Data Available yet...
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    Chart.defaults.font.family = 'Plus Jakarta Sans';
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.layout.padding = 0; 

    <?php foreach($monitors as $m): ?>
    <?php if(!empty($m['history'])): ?>
        
        const historyData_<?= $m['id'] ?> = <?= json_encode($m['history']) ?>;
        const labels_<?= $m['id'] ?> = historyData_<?= $m['id'] ?>.map(item => ''); 
        const data_<?= $m['id'] ?>    = historyData_<?= $m['id'] ?>.map(item => item.response_time);

        const ctx_<?= $m['id'] ?> = document.getElementById('chart-<?= $m['id'] ?>').getContext('2d');
        
        const gradient_<?= $m['id'] ?> = ctx_<?= $m['id'] ?>.createLinearGradient(0, 0, 0, 100);
        gradient_<?= $m['id'] ?>.addColorStop(0, 'rgba(99, 102, 241, 0.2)'); 
        gradient_<?= $m['id'] ?>.addColorStop(1, 'rgba(99, 102, 241, 0)');

        new Chart(ctx_<?= $m['id'] ?>, {
            type: 'line',
            data: {
                labels: labels_<?= $m['id'] ?>,
                datasets: [{
                    data: data_<?= $m['id'] ?>,
                    borderColor: '#6366f1',
                    borderWidth: 2,
                    backgroundColor: gradient_<?= $m['id'] ?>,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0, 
                    pointHoverRadius: 4,
                    pointHitRadius: 20,
                    pointBackgroundColor: '#6366f1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false }, 
                    tooltip: { 
                        enabled: true,
                        intersect: false, 
                        mode: 'index',
                    } 
                },
                scales: {
                    x: { display: false }, 
                    y: { display: false, beginAtZero: true } 
                }
            }
        });

    <?php endif; ?>
    <?php endforeach; ?>
});
</script>
<?= $this->endSection() ?>