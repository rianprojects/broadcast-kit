<?= $this->extend('layouts/frontend') ?>
<?= $this->section('extra_head') ?>
<style>
  .gradient-text {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .skill-bar-fill { width: 0; transition: width 1.2s cubic-bezier(0.4,0,0.2,1); }
  .section-reveal { opacity:0; transform:translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
  .section-reveal.visible { opacity:1; transform:none; }
  .card-glow:hover { box-shadow: 0 0 30px rgba(99,102,241,0.12); }
  .hero-photo-frame { position:relative; }
  .hero-photo-frame::before {
    content:''; position:absolute; inset:-3px; border-radius:24px;
    background:linear-gradient(135deg,#6366f1,#8b5cf6,#ec4899); z-index:-1;
  }
  .hero-photo-frame::after {
    content:''; position:absolute; inset:-12px; border-radius:32px;
    background:linear-gradient(135deg,rgba(99,102,241,.2),rgba(139,92,246,.2));
    z-index:-2; filter:blur(16px);
  }
  .stat-card { position:relative; overflow:hidden; }
  .stat-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:2px;
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    transform:scaleX(0); transform-origin:left; transition:transform .4s ease;
  }
  .stat-card:hover::before { transform:scaleX(1); }
  .timeline-dot { background:linear-gradient(135deg,#6366f1,#8b5cf6); }
  .section-label { font-size:.7rem; font-weight:900; letter-spacing:.2em; text-transform:uppercase; color:#6366f1; }
  .line-clamp-3 { display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
</style>
<style>
    .typewriter-cursor {
        display: inline-block;
        font-weight: 300;
        color: inherit;
        animation: blink 0.75s step-end infinite;
        margin-left: 1px;
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50%       { opacity: 0; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$orderedSections = !empty($sections) ? $sections : ['hero','about','skills','experience','projects','education','contact'];
?>

<?php foreach ($orderedSections as $section): ?>

<?php if ($section === 'hero'): ?>

<section class="section-reveal relative min-h-[92vh] flex items-center overflow-hidden px-4 sm:px-6 pb-20 lg:pb-0">
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute top-1/4 left-0 w-64 h-64 sm:w-96 sm:h-96 bg-indigo-600/10 dark:bg-indigo-600/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-0 w-56 h-56 sm:w-80 sm:h-80 bg-violet-600/10 dark:bg-violet-600/20 rounded-full blur-3xl"></div>
  </div>
  
  <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-12 items-center py-12 lg:py-16 mt-8 lg:mt-0">

    <div class="order-2 lg:order-1 text-center lg:text-left flex flex-col items-center lg:items-start">
      <p class="section-label mb-3 sm:mb-4 flex items-center justify-center lg:justify-start gap-2 w-full">
        <span class="w-8 h-px bg-indigo-500 inline-block hidden sm:inline-block"></span> Hello, I'm
      </p>
      <h1 class="text-4xl sm:text-5xl md:text-6xl xl:text-7xl font-black tracking-tight text-slate-900 dark:text-white mb-3 sm:mb-4 leading-tight font-outfit">
        <?= esc($profile['hero_name'] ?? 'Nama Kamu') ?>
      </h1>
      <h2 class="text-xl sm:text-2xl md:text-3xl font-bold gradient-text mb-6 min-h-[2.5rem]">
           <span id="typewriter"></span><span class="typewriter-cursor">|</span>
      </h2>

      <?php if (!empty($profile['about_text'])): ?>
      <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed mb-8 max-w-lg line-clamp-3">
        <?= esc($profile['about_text']) ?>
      </p>
      <?php endif; ?>
      
      <div class="flex flex-wrap justify-center lg:justify-start gap-3 mb-8 w-full">
        <?php if (!empty($profile['contact_email'])): ?>
        <a href="mailto:<?= esc($profile['contact_email']) ?>"
          class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 sm:px-6 py-3 rounded-xl text-sm transition shadow-lg shadow-indigo-500/30 hover:-translate-y-0.5 active:scale-95">
          <i class="fa-solid fa-envelope"></i> Hubungi Saya
        </a>
        <?php endif; ?>
        <a href="#projects"
          class="inline-flex items-center gap-2 border border-slate-300 dark:border-slate-700 hover:border-indigo-400 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-bold px-5 sm:px-6 py-3 rounded-xl text-sm transition hover:-translate-y-0.5">
          <i class="fa-solid fa-folder-open"></i> Lihat Projects
        </a>
      </div>

      <div class="flex items-center justify-center lg:justify-start gap-3 w-full">
        <?php foreach (['social_github'=>['fa-brands fa-github','GitHub'],'social_linkedin'=>['fa-brands fa-tiktok ','tiktok'],'social_instagram'=>['fa-brands fa-instagram','Instagram'],'social_website'=>['fa-solid fa-globe','Website']] as $key=>[$icon,$label]): ?>
        <?php if (!empty($profile[$key])): ?>
        <a href="<?= esc($profile[$key]) ?>" target="_blank" title="<?= $label ?>"
          class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-slate-600 dark:text-slate-400 hover:text-white border border-slate-200 dark:border-slate-700 hover:border-indigo-600 transition hover:-translate-y-0.5 shadow-sm">
          <i class="<?= $icon ?>"></i>
        </a>
        <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="order-1 lg:order-2 flex justify-center lg:justify-end mb-6 lg:mb-0 relative z-10">
      <?php if (!empty($profile['hero_photo'])): ?>
      <div class="hero-photo-frame scale-90 sm:scale-100">
        <img src="<?= base_url($profile['hero_photo']) ?>" alt="<?= esc($profile['hero_name']) ?>"
          class="w-64 h-72 sm:w-72 sm:h-80 md:w-80 md:h-96 object-cover rounded-3xl shadow-2xl"/>
      </div>
      <?php else: ?>
      <div class="w-64 h-72 sm:w-72 sm:h-80 md:w-80 md:h-96 rounded-3xl bg-gradient-to-br from-indigo-500/20 to-violet-500/20 border-2 border-dashed border-indigo-300 dark:border-indigo-700 flex items-center justify-center scale-90 sm:scale-100">
        <i class="fa-solid fa-user text-6xl text-indigo-300 dark:text-indigo-700"></i>
      </div>
      <?php endif; ?>
    </div>

  </div>

  <a href="#about" class="absolute bottom-4 sm:bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 text-slate-400 hover:text-indigo-500 transition animate-bounce z-20">
    <span class="text-[10px] sm:text-xs font-bold tracking-widest uppercase bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm px-2 py-0.5 rounded-full">Scroll</span>
    <i class="fa-solid fa-chevron-down"></i>
  </a>
</section>

<?php
$stats = [];
if (!empty($experiences)) $stats[] = [count($experiences), 'Pengalaman Kerja'];
if (!empty($projects))    $stats[] = [count($projects),    'Projects Selesai'];
if (!empty($skills))      $stats[] = [count($skills),      'Skills Dikuasai'];
if (!empty($education))   $stats[] = [count($education),   'Pendidikan'];
?>
<?php if (!empty($stats)): ?>
<div class="section-reveal bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm relative z-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-y md:divide-y-0 divide-slate-200 dark:divide-slate-800">
      <?php foreach ($stats as [$num, $label]): ?>
      <div class="stat-card px-4 sm:px-8 py-6 text-center hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
        <p class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 dark:text-white font-outfit"><?= $num ?><span class="text-indigo-500">+</span></p>
        <p class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mt-1"><?= $label ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<?php elseif ($section === 'about' && !empty($profile['about_text'])): ?>

<section id="about" class="section-reveal py-16 sm:py-24 px-6">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 sm:gap-16 items-center">
    <div class="flex justify-center order-2 lg:order-1">
      <?php if (!empty($profile['hero_photo'])): ?>
      <div class="relative scale-90 sm:scale-100">
        <img src="<?= base_url($profile['hero_photo']) ?>" alt="About" class="w-64 h-72 sm:w-72 sm:h-80 object-cover rounded-3xl shadow-2xl"/>
        <div class="absolute -bottom-4 -right-4 bg-indigo-600 text-white rounded-2xl px-5 py-3 shadow-lg">
          <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider opacity-80">Available for</p>
          <p class="font-black text-xs sm:text-sm">Freelance Work</p>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <div class="order-1 lg:order-2 text-center lg:text-left">
      <p class="section-label mb-3 justify-center lg:justify-start">About Me</p>
      <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-6 font-outfit">
        Sedikit tentang <span class="gradient-text">diri saya</span>
      </h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm sm:text-base mb-6 text-left"><?= nl2br(esc($profile['about_text'])) ?></p>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left">
        <?php if (!empty($profile['contact_location'])): ?>
        <div class="flex items-center justify-center sm:justify-start gap-2 text-sm text-slate-600 dark:text-slate-400">
          <i class="fa-solid fa-location-dot text-indigo-500 w-4 text-center"></i><?= esc($profile['contact_location']) ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($profile['contact_email'])): ?>
        <div class="flex items-center justify-center sm:justify-start gap-2 text-sm text-slate-600 dark:text-slate-400 overflow-hidden">
          <i class="fa-solid fa-envelope text-indigo-500 w-4 flex-shrink-0 text-center"></i>
          <span class="truncate"><?= esc($profile['contact_email']) ?></span>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php elseif ($section === 'skills' && !empty($skills)): ?>

<section id="skills" class="section-reveal py-16 sm:py-24 px-6 bg-slate-50 dark:bg-slate-900/50">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-10 sm:mb-14">
      <p class="section-label mb-3">My Skills</p>
      <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white font-outfit">Keahlian <span class="gradient-text">Saya</span></h2>
      <p class="text-slate-500 dark:text-slate-400 mt-3 max-w-md mx-auto text-sm">Teknologi dan tools yang saya kuasai</p>
    </div>
    
    <?php
    $grouped = [];
    foreach ($skills as $s) { 
        $grouped[$s['category'] ?: 'General'][] = $s; 
    }
    
    $colors = ['indigo','violet','pink','sky','emerald','orange','cyan','rose'];
    $ci = 0;
    $iconMap = [
        'php'           => 'fa-brands fa-php',
        'laravel'       => 'fa-brands fa-laravel',
        'codeigniter'   => 'fa-solid fa-fire', 
        'codeigniter 4' => 'fa-solid fa-fire',
        'node.js'       => 'fa-brands fa-node-js',
        'nodejs'        => 'fa-brands fa-node-js',
        'python'        => 'fa-brands fa-python',
        'java'          => 'fa-brands fa-java',
        'html'          => 'fa-brands fa-html5',
        'css'           => 'fa-brands fa-css3-alt',
        'javascript'    => 'fa-brands fa-js',
        'js'            => 'fa-brands fa-js',
        'react'         => 'fa-brands fa-react',
        'vue'           => 'fa-brands fa-vuejs',
        'vuejs'         => 'fa-brands fa-vuejs',
        'bootstrap'     => 'fa-brands fa-bootstrap',
        'tailwind'      => 'fa-solid fa-wind',
        'tailwind css'  => 'fa-solid fa-wind',
        'figma'         => 'fa-brands fa-figma',
        'wordpress'     => 'fa-brands fa-wordpress',
        'discourse'     => 'fa-brands fa-discourse',
        'flarum'        => 'fa-solid fa-comments',
        'git'           => 'fa-brands fa-git-alt',
        'github'        => 'fa-brands fa-github',
        'docker'        => 'fa-brands fa-docker',
        'aws'           => 'fa-brands fa-aws',
        'linux'         => 'fa-brands fa-linux',
        'mysql'         => 'fa-solid fa-database',
        'sql'           => 'fa-solid fa-database',
        'postgresql'    => 'fa-solid fa-database',
        'api'           => 'fa-solid fa-network-wired',
        'json'          => 'fa-solid fa-file-code',
        'rest api'      => 'fa-solid fa-exchange-alt',
    ];
    ?>

    <div class="space-y-8 sm:space-y-10">
      <?php foreach ($grouped as $cat => $items):
        $color = $colors[$ci++ % count($colors)]; ?>
      <div>
        <div class="flex items-center gap-3 mb-5">
          <span class="text-[10px] sm:text-xs font-black text-<?= $color ?>-500 uppercase tracking-widest"><?= esc($cat) ?></span>
          <div class="flex-1 h-px bg-slate-200 dark:bg-slate-800"></div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
          <?php foreach ($items as $s): 
            $catKey    = strtolower(trim($cat));
            $skillKey  = strtolower(trim($s['name']));
            $iconClass = $iconMap[$catKey] ?? ($iconMap[$skillKey] ?? 'fa-solid fa-laptop-code'); 
          ?>
          
          <div class="card-glow bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 hover:border-<?= $color ?>-300 dark:hover:border-<?= $color ?>-700 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
              
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-<?= $color ?>-50 dark:bg-<?= $color ?>-900/30 flex items-center justify-center text-<?= $color ?>-500">
                    <i class="<?= $iconClass ?> text-sm sm:text-base"></i>
                </div>
                <span class="font-bold text-slate-800 dark:text-slate-200 text-xs sm:text-sm truncate max-w-[100px] sm:max-w-[150px]"><?= esc($s['name']) ?></span>
              </div>
              
              <span class="text-[10px] sm:text-xs font-black text-<?= $color ?>-500 bg-<?= $color ?>-50 dark:bg-<?= $color ?>-900/30 px-2 py-1 rounded-md flex-shrink-0">
                <?= $s['level'] ?>%
              </span>
              
            </div>
            
            <div class="h-1.5 sm:h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
              <div class="skill-bar-fill h-full rounded-full bg-gradient-to-r from-<?= $color ?>-500 to-<?= $color ?>-400" data-width="<?= $s['level'] ?>"></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php elseif ($section === 'experience' && !empty($experiences)): ?>

<section id="experience" class="section-reveal py-16 sm:py-24 px-6">
  <div class="max-w-4xl mx-auto">
    <div class="text-center mb-10 sm:mb-14">
      <p class="section-label mb-3">Work History</p>
      <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white font-outfit">Pengalaman <span class="gradient-text">Kerja</span></h2>
    </div>
    <div class="relative">
      <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gradient-to-b from-indigo-500 via-violet-500 to-transparent hidden md:block"></div>
      <div class="space-y-4 sm:space-y-6">
        <?php foreach ($experiences as $e): ?>
        <div class="card-glow relative bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 sm:p-6 md:ml-16 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300">
          <div class="absolute hidden md:flex -left-[2.85rem] top-6 w-5 h-5 timeline-dot rounded-full border-4 border-white dark:border-slate-950 shadow"></div>
          <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-2 sm:gap-3">
            <div class="flex-1">
              <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white"><?= esc($e['role']) ?></h3>
              <p class="text-indigo-500 font-bold text-xs sm:text-sm mt-0.5"><?= esc($e['company']) ?></p>
              <?php if ($e['description']): ?>
              <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-2 sm:mt-3 leading-relaxed"><?= nl2br(esc($e['description'])) ?></p>
              <?php endif; ?>
            </div>
            <?php if ($e['period']): ?>
            <span class="inline-flex items-center gap-1.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800 text-[10px] sm:text-xs font-bold px-3 py-1.5 rounded-full flex-shrink-0 self-start">
              <i class="fa-regular fa-calendar"></i> <?= esc($e['period']) ?>
            </span>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<?php elseif ($section === 'projects' && !empty($projects)): ?>

<section id="projects" class="section-reveal py-16 sm:py-24 px-6 bg-slate-50 dark:bg-slate-900/50">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-10 sm:mb-14">
      <p class="section-label mb-3">My Work</p>
      <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white font-outfit">Project <span class="gradient-text">Terbaru</span></h2>
      <p class="text-slate-500 dark:text-slate-400 mt-2 sm:mt-3 max-w-md mx-auto text-xs sm:text-sm">Beberapa project yang pernah saya kerjakan</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
      <?php foreach ($projects as $p): ?>
      <div class="card-glow group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden hover:border-indigo-300 dark:hover:border-indigo-700 hover:-translate-y-1 sm:hover:-translate-y-1.5 transition-all duration-300 flex flex-col">
        <?php if ($p['image']): ?>
        <div class="overflow-hidden h-40 sm:h-48">
          <img src="<?= base_url($p['image']) ?>" alt="<?= esc($p['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
        </div>
        <?php else: ?>
        <div class="h-40 sm:h-48 bg-gradient-to-br from-indigo-500/10 to-violet-500/10 flex items-center justify-center text-4xl sm:text-5xl">📁</div>
        <?php endif; ?>
        <div class="p-4 sm:p-5 flex flex-col flex-1">
          <h3 class="font-black text-slate-900 dark:text-white text-sm sm:text-base"><?= esc($p['title']) ?></h3>
          <?php if ($p['description']): ?>
          <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-1 sm:mt-1.5 flex-1 leading-relaxed line-clamp-3"><?= esc($p['description']) ?></p>
          <?php endif; ?>
          <?php if ($p['tech_stack']): ?>
          <div class="flex flex-wrap gap-1.5 mt-3 sm:mt-4">
            <?php foreach (explode(',', $p['tech_stack']) as $t): ?>
            <span class="text-[9px] sm:text-[10px] font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full"><?= trim(esc($t)) ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <?php if ($p['demo_url'] || $p['github_url']): ?>
          <div class="flex gap-2 mt-4 sm:mt-5">
            <?php if ($p['demo_url']): ?>
            <a href="<?= esc($p['demo_url']) ?>" target="_blank" class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] sm:text-xs font-bold py-2 sm:py-2.5 rounded-xl transition shadow-lg shadow-indigo-500/20">
              <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Demo
            </a>
            <?php endif; ?>
            <?php if ($p['github_url']): ?>
            <a href="<?= esc($p['github_url']) ?>" target="_blank" class="flex-1 text-center bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-[10px] sm:text-xs font-bold py-2 sm:py-2.5 rounded-xl transition border border-slate-200 dark:border-slate-700">
              <i class="fa-brands fa-github mr-1"></i> GitHub
            </a>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php elseif ($section === 'education' && !empty($education)): ?>

<section id="education" class="section-reveal py-16 sm:py-24 px-6">
  <div class="max-w-4xl mx-auto">
    <div class="text-center mb-10 sm:mb-14">
      <p class="section-label mb-3">Education</p>
      <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white font-outfit">Riwayat <span class="gradient-text">Pendidikan</span></h2>
    </div>
    <div class="space-y-4 sm:space-y-5">
      <?php foreach ($education as $edu): ?>
      <div class="card-glow bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 sm:p-6 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all duration-300">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 sm:gap-4">
          <div class="flex items-start gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0 border border-emerald-100 dark:border-emerald-800">
              <i class="fa-solid fa-graduation-cap text-emerald-500 text-base sm:text-lg"></i>
            </div>
            <div>
              <h3 class="font-black text-slate-900 dark:text-white text-sm sm:text-base"><?= esc($edu['degree']) ?><?= $edu['field'] ? ' — '.esc($edu['field']) : '' ?></h3>
              <p class="text-emerald-500 font-bold text-xs sm:text-sm mt-0.5"><?= esc($edu['institution']) ?></p>
              <?php if ($edu['description']): ?>
              <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-1.5 sm:mt-2"><?= esc($edu['description']) ?></p>
              <?php endif; ?>
            </div>
          </div>
          <?php if ($edu['period']): ?>
          <span class="inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800 text-[10px] sm:text-xs font-bold px-3 py-1.5 rounded-full flex-shrink-0 self-start md:self-auto">
            <i class="fa-regular fa-calendar"></i> <?= esc($edu['period']) ?>
          </span>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php elseif ($section === 'contact'): ?>

<section id="contact" class="section-reveal py-16 sm:py-24 px-6 bg-slate-50 dark:bg-slate-900/50">
  <div class="max-w-4xl mx-auto">
    <div class="text-center mb-10 sm:mb-14">
      <p class="section-label mb-3">Get In Touch</p>
      <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white font-outfit">Hubungi <span class="gradient-text">Saya</span></h2>
      <p class="text-slate-500 dark:text-slate-400 mt-2 sm:mt-3 max-w-md mx-auto text-xs sm:text-sm">Tertarik untuk berkolaborasi? Jangan ragu untuk menghubungi saya</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5 mb-8 sm:mb-10">
      <?php if (!empty($profile['contact_email'])): ?>
      <a href="mailto:<?= esc($profile['contact_email']) ?>"
        class="card-glow bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 rounded-2xl p-5 sm:p-6 text-center hover:-translate-y-1 transition-all duration-300 group">
        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4 border border-indigo-100 dark:border-indigo-800 group-hover:bg-indigo-600 transition">
          <i class="fa-solid fa-envelope text-indigo-500 group-hover:text-white text-lg sm:text-xl transition"></i>
        </div>
        <p class="text-[10px] sm:text-xs font-black text-slate-400 uppercase tracking-wider mb-1">Email</p>
        <p class="text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 truncate"><?= esc($profile['contact_email']) ?></p>
      </a>
      <?php endif; ?>
      <?php if (!empty($profile['contact_phone'])): ?>
      <a href="tel:<?= esc($profile['contact_phone']) ?>"
        class="card-glow bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-green-300 dark:hover:border-green-700 rounded-2xl p-5 sm:p-6 text-center hover:-translate-y-1 transition-all duration-300 group">
        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-50 dark:bg-green-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4 border border-green-100 dark:border-green-800 group-hover:bg-green-500 transition">
          <i class="fa-solid fa-phone text-green-500 group-hover:text-white text-lg sm:text-xl transition"></i>
        </div>
        <p class="text-[10px] sm:text-xs font-black text-slate-400 uppercase tracking-wider mb-1">Phone</p>
        <p class="text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300"><?= esc($profile['contact_phone']) ?></p>
      </a>
      <?php endif; ?>
      <?php if (!empty($profile['contact_location'])): ?>
      <div class="card-glow bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 sm:p-6 text-center hover:-translate-y-1 transition-all duration-300">
        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-pink-50 dark:bg-pink-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4 border border-pink-100 dark:border-pink-800">
          <i class="fa-solid fa-location-dot text-pink-500 text-lg sm:text-xl"></i>
        </div>
        <p class="text-[10px] sm:text-xs font-black text-slate-400 uppercase tracking-wider mb-1">Lokasi</p>
        <p class="text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300"><?= esc($profile['contact_location']) ?></p>
      </div>
      <?php endif; ?>
    </div>
    <div class="flex justify-center gap-2 sm:gap-3 flex-wrap">
      <?php foreach (['social_github'=>['fa-brands fa-github','GitHub'],'social_linkedin'=>['fa-brands fa-tiktok','tiktok'],'social_instagram'=>['fa-brands fa-instagram','Instagram'],'social_website'=>['fa-solid fa-globe','Website']] as $key=>[$icon,$label]): ?>
      <?php if (!empty($profile[$key])): ?>
      <a href="<?= esc($profile[$key]) ?>" target="_blank"
        class="flex items-center gap-1.5 sm:gap-2 border border-slate-200 dark:border-slate-700 hover:border-indigo-400 text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 font-bold text-xs sm:text-sm px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl transition">
        <i class="<?= $icon ?>"></i> <?= $label ?>
      </a>
      <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php endif; ?>
<?php endforeach; ?>

<script>
const revealObs = new IntersectionObserver(entries => {
  entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
},{threshold:0.1});
document.querySelectorAll('.section-reveal').forEach(el => revealObs.observe(el));

const skillObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if(e.isIntersecting) {
      e.target.querySelectorAll('.skill-bar-fill').forEach(bar => {
        setTimeout(() => bar.style.width = bar.dataset.width+'%', 200);
      });
      skillObs.unobserve(e.target);
    }
  });
},{threshold:0.2});
const skillSec = document.getElementById('skills');
if(skillSec) skillObs.observe(skillSec);
</script>

<script>
(function() {
    const taglines = <?= json_encode(
        array_filter(
            array_map('trim', 
                explode(',', $profile['hero_tagline'] ?? 'Full Stack Developer')
            )
        )
    ) ?>;

    let currentIndex = 0;
    let currentChar  = 0;
    let isDeleting   = false;
    let isPaused     = false;
    const el         = document.getElementById('typewriter');

    const speed = {
        type   : 70,
        delete : 35,
        pause  : 2500,
        next   : 400,
    };

    function type() {
        if (isPaused) return;

        const words = Object.values(taglines);
        const current = words[currentIndex];

        if (!isDeleting) {
            el.textContent = current.substring(0, currentChar + 1);
            currentChar++;

            if (currentChar === current.length) {
                if (words.length === 1) return;
                isPaused = true;
                setTimeout(() => {
                    isPaused  = false;
                    isDeleting = true;
                    type();
                }, speed.pause);
                return;
            }

            setTimeout(type, speed.type);
        } else {
            el.textContent = current.substring(0, currentChar - 1);
            currentChar--;

            if (currentChar === 0) {
                isDeleting   = false;
                currentIndex = (currentIndex + 1) % words.length;
                isPaused     = true;
                setTimeout(() => {
                    isPaused = false;
                    type();
                }, speed.next);
                return;
            }

            setTimeout(type, speed.delete);
        }
    }

    setTimeout(type, 500);
})();
</script>

<?= $this->endSection() ?>