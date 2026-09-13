<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<style>
  [x-cloak] { display: none !important; }
</style>

<div x-data="portoBuilder()">

  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-2xl font-black text-slate-800 dark:text-white">Porto Builder</h1>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Drag section untuk reorder · Edit setiap bagian CV kamu</p>
    </div>
    <a href="<?= base_url('porto') ?>" target="_blank"
      class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm font-bold px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 transition">
      <i class="fa-solid fa-eye"></i> Preview
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
  <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)"
    class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm px-4 py-3 rounded-xl flex items-center justify-between">
    <span><i class="fa-solid fa-circle-check mr-2"></i><?= session()->getFlashdata('success') ?></span>
    <button @click="show=false" class="text-emerald-400 hover:text-emerald-600"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <?php endif; ?>

  <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 shadow-sm mb-6 p-5">
    <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3">
      <i class="fa-solid fa-grip-vertical mr-1"></i> Urutan Section (Drag untuk reorder)
    </p>
    <ul id="section-order-list" class="flex flex-wrap gap-2">
      <?php
      $sectionLabels = [
        'hero'       => ['label' => 'Hero',       'icon' => 'fa-user',           'color' => 'text-indigo-500'],
        'about'      => ['label' => 'About',      'icon' => 'fa-circle-info',    'color' => 'text-sky-500'],
        'skills'     => ['label' => 'Skills',     'icon' => 'fa-code',           'color' => 'text-violet-500'],
        'experience' => ['label' => 'Experience', 'icon' => 'fa-briefcase',      'color' => 'text-orange-500'],
        'projects'   => ['label' => 'Projects',   'icon' => 'fa-folder-open',    'color' => 'text-pink-500'],
        'education'  => ['label' => 'Education',  'icon' => 'fa-graduation-cap', 'color' => 'text-emerald-500'],
        'contact'    => ['label' => 'Contact',    'icon' => 'fa-envelope',       'color' => 'text-cyan-500'],
      ];
      foreach ($sections as $sec):
        $info = $sectionLabels[$sec] ?? ['label' => ucfirst($sec), 'icon' => 'fa-circle', 'color' => 'text-slate-500'];
      ?>
      <li data-section="<?= $sec ?>"
        class="flex items-center gap-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 cursor-grab active:cursor-grabbing text-sm font-bold text-slate-600 dark:text-slate-300 select-none hover:border-indigo-400 dark:hover:border-indigo-500 transition">
        <i class="fa-solid <?= $info['icon'] ?> <?= $info['color'] ?>"></i>
        <?= $info['label'] ?>
        <i class="fa-solid fa-grip-dots text-slate-300 dark:text-slate-600 ml-1"></i>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div id="section-hero" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 shadow-sm mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
      <h2 class="font-black text-slate-700 dark:text-white flex items-center gap-2 text-base">
        <i class="fa-solid fa-user text-indigo-500"></i> Hero · About · Contact
      </h2>
    </div>
    <form action="<?= base_url('admin/porto/profile') ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
      <?= csrf_field() ?>

      <div>
        <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Hero</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Foto Profil</label>
            <div id="hero-drop-zone"
              class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-5 text-center cursor-pointer hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition-all duration-200"
              onclick="document.getElementById('hero-photo-input').click()"
              @dragover.prevent="$el.classList.add('border-indigo-400','dark:border-indigo-500')"
              @dragleave="$el.classList.remove('border-indigo-400','dark:border-indigo-500')"
              @drop.prevent="handleDropImg($event,'hero-photo-preview','hero-photo-input','hero-placeholder')">
              <?php if (!empty($profile['hero_photo'])): ?>
              <img id="hero-photo-preview" src="<?= base_url($profile['hero_photo']) ?>"
                class="w-24 h-24 object-cover rounded-full mx-auto mb-2 border-4 border-white dark:border-slate-700 shadow-lg"/>
              <p class="text-xs text-slate-400 dark:text-slate-500">Klik atau drop untuk ganti</p>
              <?php else: ?>
              <img id="hero-photo-preview" src="" class="w-24 h-24 object-cover rounded-full mx-auto mb-2 border-4 border-slate-200 dark:border-slate-700 shadow-lg hidden"/>
              <div id="hero-placeholder">
                <i class="fa-regular fa-image text-4xl text-slate-300 dark:text-slate-600 mb-2 block"></i>
                <p class="text-sm text-slate-400 dark:text-slate-500">Drop atau <span class="text-indigo-500 font-bold">klik pilih</span></p>
                <p class="text-xs text-slate-400 dark:text-slate-600 mt-1">Otomatis Convert ke WebP</p>
              </div>
              <?php endif; ?>
            </div>
            <input type="file" name="hero_photo" id="hero-photo-input" accept="image/*" class="hidden"
              onchange="previewImg(this,'hero-photo-preview','hero-placeholder')"/>
          </div>
          <div class="md:col-span-2 space-y-4">
            <div>
              <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nama</label>
              <input type="text" name="hero_name" value="<?= esc($profile['hero_name'] ?? '') ?>"
                class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                placeholder="Nama Lengkap Kamu"/>
            </div>
            <div>
              <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tagline</label>
              <input type="text" name="hero_tagline" value="<?= esc($profile['hero_tagline'] ?? '') ?>"
                class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                placeholder="Full Stack Developer · UI Designer"/>
            </div>
          </div>
        </div>
      </div>

      <hr class="border-slate-100 dark:border-slate-800"/>

      <div>
        <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">About</p>
        <textarea name="about_text" rows="5"
          class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"
          placeholder="Ceritakan tentang dirimu..."><?= esc($profile['about_text'] ?? '') ?></textarea>
      </div>

      <hr class="border-slate-100 dark:border-slate-800"/>

      <div>
        <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Contact & Sosmed</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <?php
          $fields = [
            ['email','contact_email',   'Email',    'fa-envelope',   false,'email@kamu.com'],
            ['text', 'contact_phone',   'Phone',    'fa-phone',      false,'+62 812 xxxx xxxx'],
            ['text', 'contact_location','Lokasi',   'fa-location-dot',false,'Jakarta, Indonesia'],
            ['url',  'social_github',   'GitHub',   'fa-github',     true, 'https://github.com/...'],
            ['url',  'social_linkedin', 'LinkedIn', 'fa-linkedin',   true, 'https://linkedin.com/in/...'],
            ['url',  'social_instagram','Instagram','fa-instagram',  true, 'https://instagram.com/...'],
          ];
          foreach ($fields as [$type,$name,$label,$icon,$brand,$ph]):
          ?>
          <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">
              <i class="<?= $brand?'fa-brands':'fa-solid' ?> <?= $icon ?> text-slate-400 mr-1"></i><?= $label ?>
            </label>
            <input type="<?= $type ?>" name="<?= $name ?>" value="<?= esc($profile[$name] ?? '') ?>"
              class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
              placeholder="<?= $ph ?>"/>
          </div>
          <?php endforeach; ?>
          <div class="md:col-span-2">
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">
              <i class="fa-solid fa-globe text-slate-400 mr-1"></i>Website
            </label>
            <input type="url" name="social_website" value="<?= esc($profile['social_website'] ?? '') ?>"
              class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
              placeholder="https://website.com"/>
          </div>
        </div>
      </div>
      <div class="flex justify-end pt-2">
        <button type="submit"
          class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-lg shadow-indigo-500/20">
          <i class="fa-solid fa-floppy-disk"></i> Simpan Profile
        </button>
      </div>
    </form>
  </div>

  <div id="section-skills" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 shadow-sm mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
      <h2 class="font-black text-slate-700 dark:text-white flex items-center gap-2 text-base">
        <i class="fa-solid fa-code text-violet-500"></i> Skills
      </h2>
      <div class="flex items-center gap-2">
        <form x-show="selSkills.length > 0" action="<?= base_url('admin/porto/bulkDelete/skill') ?>" method="POST" onsubmit="return confirm('Hapus item terpilih secara permanen?')">
          <?= csrf_field() ?>
          <template x-for="id in selSkills" :key="id">
            <input type="hidden" name="ids[]" :value="id">
          </template>
          <button type="submit" class="flex items-center gap-1.5 text-xs font-bold bg-rose-100 dark:bg-rose-900/30 hover:bg-rose-200 dark:hover:bg-rose-900/50 text-rose-600 dark:text-rose-400 px-3 py-2 rounded-lg transition">
            <i class="fa-solid fa-trash"></i> Hapus (<span x-text="selSkills.length"></span>)
          </button>
        </form>

        <button @click="openModal('skill')"
          class="flex items-center gap-1.5 text-xs font-bold bg-slate-100 dark:bg-slate-800 hover:bg-violet-50 dark:hover:bg-violet-900/20 text-slate-600 dark:text-slate-300 hover:text-violet-600 dark:hover:text-violet-400 border border-slate-200 dark:border-slate-700 hover:border-violet-300 dark:hover:border-violet-700 px-3 py-2 rounded-lg transition">
          <i class="fa-solid fa-plus"></i> Tambah
        </button>
      </div>
    </div>
    <?php if (empty($skills)): ?>
    <div class="text-center py-12 text-slate-400 dark:text-slate-600">
      <i class="fa-solid fa-code text-4xl mb-3 block opacity-30"></i>
      <p class="font-medium">Belum ada skill</p>
    </div>
    <?php else: ?>
    <ul id="skills-list" class="divide-y divide-slate-100 dark:divide-slate-800">
      <?php foreach ($skills as $s): ?>
      <li class="flex items-center gap-4 px-5 py-3.5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition" data-id="<?= $s['id'] ?>">
        <i class="fa-solid fa-grip-vertical drag-handle text-slate-300 dark:text-slate-600 cursor-grab hover:text-slate-400 dark:hover:text-slate-400 text-base flex-shrink-0"></i>
        
        <input type="checkbox" x-model="selSkills" value="<?= $s['id'] ?>" class="w-4 h-4 rounded border-slate-300 text-violet-600 focus:ring-violet-500 cursor-pointer">

        <div class="flex-1 min-w-0">
          <div class="flex items-center gap-2 mb-1.5">
            <span class="font-bold text-sm text-slate-800 dark:text-slate-200"><?= esc($s['name']) ?></span>
            <?php if ($s['category']): ?>
            <span class="text-[10px] font-bold bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 border border-violet-100 dark:border-violet-800 px-2 py-0.5 rounded-full"><?= esc($s['category']) ?></span>
            <?php endif; ?>
          </div>
          <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-1.5">
            <div class="bg-gradient-to-r from-violet-500 to-indigo-500 h-1.5 rounded-full" style="width:<?= $s['level'] ?>%"></div>
          </div>
        </div>
        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 w-8 text-right flex-shrink-0"><?= $s['level'] ?>%</span>
        <button @click="editItem('skill',<?= $s['id'] ?>)"
          class="text-xs font-bold text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-300 px-3 py-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition flex-shrink-0">
          <i class="fa-solid fa-pen-to-square mr-1"></i>Edit
        </button>
        <form action="<?= base_url('admin/porto/skill/delete/'.$s['id']) ?>" method="POST" onsubmit="return confirm('Hapus skill ini?')">
          <?= csrf_field() ?>
          <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition flex-shrink-0">
            <i class="fa-solid fa-trash mr-1"></i>Hapus
          </button>
        </form>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>

  <div id="section-experience" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 shadow-sm mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
      <h2 class="font-black text-slate-700 dark:text-white flex items-center gap-2 text-base">
        <i class="fa-solid fa-briefcase text-orange-500"></i> Experience
      </h2>
      <div class="flex items-center gap-2">
        <form x-show="selExps.length > 0" action="<?= base_url('admin/porto/bulkDelete/experience') ?>" method="POST" onsubmit="return confirm('Hapus item terpilih secara permanen?')">
          <?= csrf_field() ?>
          <template x-for="id in selExps" :key="id">
            <input type="hidden" name="ids[]" :value="id">
          </template>
          <button type="submit" class="flex items-center gap-1.5 text-xs font-bold bg-rose-100 dark:bg-rose-900/30 hover:bg-rose-200 dark:hover:bg-rose-900/50 text-rose-600 dark:text-rose-400 px-3 py-2 rounded-lg transition">
            <i class="fa-solid fa-trash"></i> Hapus (<span x-text="selExps.length"></span>)
          </button>
        </form>

        <button @click="openModal('experience')"
          class="flex items-center gap-1.5 text-xs font-bold bg-slate-100 dark:bg-slate-800 hover:bg-orange-50 dark:hover:bg-orange-900/20 text-slate-600 dark:text-slate-300 hover:text-orange-600 dark:hover:text-orange-400 border border-slate-200 dark:border-slate-700 hover:border-orange-300 dark:hover:border-orange-700 px-3 py-2 rounded-lg transition">
          <i class="fa-solid fa-plus"></i> Tambah
        </button>
      </div>
    </div>
    <?php if (empty($experiences)): ?>
    <div class="text-center py-12 text-slate-400 dark:text-slate-600">
      <i class="fa-solid fa-briefcase text-4xl mb-3 block opacity-30"></i>
      <p class="font-medium">Belum ada experience</p>
    </div>
    <?php else: ?>
    <ul id="experiences-list" class="divide-y divide-slate-100 dark:divide-slate-800">
      <?php foreach ($experiences as $e): ?>
      <li class="flex items-start gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition" data-id="<?= $e['id'] ?>">
        <i class="fa-solid fa-grip-vertical drag-handle text-slate-300 dark:text-slate-600 cursor-grab hover:text-slate-400 mt-1 text-base flex-shrink-0"></i>
        
        <input type="checkbox" x-model="selExps" value="<?= $e['id'] ?>" class="mt-1 w-4 h-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500 cursor-pointer">

        <div class="flex-1 min-w-0">
          <p class="font-bold text-slate-800 dark:text-slate-200"><?= esc($e['role']) ?></p>
          <p class="text-sm text-orange-500 font-semibold mt-0.5"><?= esc($e['company']) ?></p>
          <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5"><?= esc($e['period']) ?></p>
          <?php if ($e['description']): ?>
          <p class="text-sm text-slate-500 dark:text-slate-400 mt-1.5 line-clamp-2"><?= esc($e['description']) ?></p>
          <?php endif; ?>
        </div>
        <button @click="editItem('experience',<?= $e['id'] ?>)"
          class="text-xs font-bold text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-300 px-3 py-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition flex-shrink-0">
          <i class="fa-solid fa-pen-to-square mr-1"></i>Edit
        </button>
        <form action="<?= base_url('admin/porto/experience/delete/'.$e['id']) ?>" method="POST" onsubmit="return confirm('Hapus?')">
          <?= csrf_field() ?>
          <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition flex-shrink-0">
            <i class="fa-solid fa-trash mr-1"></i>Hapus
          </button>
        </form>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>

  <div id="section-projects" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 shadow-sm mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
      <h2 class="font-black text-slate-700 dark:text-white flex items-center gap-2 text-base">
        <i class="fa-solid fa-folder-open text-pink-500"></i> Projects
      </h2>
      <div class="flex items-center gap-2">
        <form x-show="selProjs.length > 0" action="<?= base_url('admin/porto/bulkDelete/project') ?>" method="POST" onsubmit="return confirm('Hapus item terpilih beserta gambarnya secara permanen?')">
          <?= csrf_field() ?>
          <template x-for="id in selProjs" :key="id">
            <input type="hidden" name="ids[]" :value="id">
          </template>
          <button type="submit" class="flex items-center gap-1.5 text-xs font-bold bg-rose-100 dark:bg-rose-900/30 hover:bg-rose-200 dark:hover:bg-rose-900/50 text-rose-600 dark:text-rose-400 px-3 py-2 rounded-lg transition">
            <i class="fa-solid fa-trash"></i> Hapus (<span x-text="selProjs.length"></span>)
          </button>
        </form>

        <button @click="openModal('project')"
          class="flex items-center gap-1.5 text-xs font-bold bg-slate-100 dark:bg-slate-800 hover:bg-pink-50 dark:hover:bg-pink-900/20 text-slate-600 dark:text-slate-300 hover:text-pink-600 dark:hover:text-pink-400 border border-slate-200 dark:border-slate-700 hover:border-pink-300 dark:hover:border-pink-700 px-3 py-2 rounded-lg transition">
          <i class="fa-solid fa-plus"></i> Tambah
        </button>
      </div>
    </div>
    <?php if (empty($projects)): ?>
    <div class="text-center py-12 text-slate-400 dark:text-slate-600">
      <i class="fa-solid fa-folder-open text-4xl mb-3 block opacity-30"></i>
      <p class="font-medium">Belum ada project</p>
    </div>
    <?php else: ?>
    <ul id="projects-list" class="divide-y divide-slate-100 dark:divide-slate-800">
      <?php foreach ($projects as $p): ?>
      <li class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition" data-id="<?= $p['id'] ?>">
        <i class="fa-solid fa-grip-vertical drag-handle text-slate-300 dark:text-slate-600 cursor-grab hover:text-slate-400 text-base flex-shrink-0"></i>
        
        <input type="checkbox" x-model="selProjs" value="<?= $p['id'] ?>" class="w-4 h-4 rounded border-slate-300 text-pink-600 focus:ring-pink-500 cursor-pointer">

        <?php if ($p['image']): ?>
        <img src="<?= base_url($p['image']) ?>" class="w-14 h-14 object-cover rounded-xl border border-slate-200 dark:border-slate-700 flex-shrink-0"/>
        <?php else: ?>
        <div class="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-2xl flex-shrink-0 border border-slate-200 dark:border-slate-700">📁</div>
        <?php endif; ?>
        <div class="flex-1 min-w-0">
          <p class="font-bold text-slate-800 dark:text-slate-200 truncate"><?= esc($p['title']) ?></p>
          <p class="text-sm text-slate-400 dark:text-slate-500 truncate mt-0.5"><?= esc($p['description']) ?></p>
          <?php if ($p['tech_stack']): ?>
          <div class="flex gap-1 flex-wrap mt-1.5">
            <?php foreach (explode(',', $p['tech_stack']) as $t): ?>
            <span class="text-[10px] font-bold bg-pink-50 dark:bg-pink-900/20 text-pink-500 dark:text-pink-400 border border-pink-100 dark:border-pink-800 px-2 py-0.5 rounded-full"><?= trim(esc($t)) ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <button @click="editItem('project',<?= $p['id'] ?>)"
          class="text-xs font-bold text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-300 px-3 py-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition flex-shrink-0">
          <i class="fa-solid fa-pen-to-square mr-1"></i>Edit
        </button>
        <form action="<?= base_url('admin/porto/project/delete/'.$p['id']) ?>" method="POST" onsubmit="return confirm('Hapus?')">
          <?= csrf_field() ?>
          <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition flex-shrink-0">
            <i class="fa-solid fa-trash mr-1"></i>Hapus
          </button>
        </form>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>

  <div id="section-education" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 shadow-sm mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
      <h2 class="font-black text-slate-700 dark:text-white flex items-center gap-2 text-base">
        <i class="fa-solid fa-graduation-cap text-emerald-500"></i> Education
      </h2>
      <div class="flex items-center gap-2">
        <form x-show="selEdus.length > 0" action="<?= base_url('admin/porto/bulkDelete/education') ?>" method="POST" onsubmit="return confirm('Hapus item terpilih secara permanen?')">
          <?= csrf_field() ?>
          <template x-for="id in selEdus" :key="id">
            <input type="hidden" name="ids[]" :value="id">
          </template>
          <button type="submit" class="flex items-center gap-1.5 text-xs font-bold bg-rose-100 dark:bg-rose-900/30 hover:bg-rose-200 dark:hover:bg-rose-900/50 text-rose-600 dark:text-rose-400 px-3 py-2 rounded-lg transition">
            <i class="fa-solid fa-trash"></i> Hapus (<span x-text="selEdus.length"></span>)
          </button>
        </form>

        <button @click="openModal('education')"
          class="flex items-center gap-1.5 text-xs font-bold bg-slate-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 border border-slate-200 dark:border-slate-700 hover:border-emerald-300 dark:hover:border-emerald-700 px-3 py-2 rounded-lg transition">
          <i class="fa-solid fa-plus"></i> Tambah
        </button>
      </div>
    </div>
    <?php if (empty($education)): ?>
    <div class="text-center py-12 text-slate-400 dark:text-slate-600">
      <i class="fa-solid fa-graduation-cap text-4xl mb-3 block opacity-30"></i>
      <p class="font-medium">Belum ada education</p>
    </div>
    <?php else: ?>
    <ul id="education-list" class="divide-y divide-slate-100 dark:divide-slate-800">
      <?php foreach ($education as $edu): ?>
      <li class="flex items-start gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition" data-id="<?= $edu['id'] ?>">
        <i class="fa-solid fa-grip-vertical drag-handle text-slate-300 dark:text-slate-600 cursor-grab hover:text-slate-400 mt-1 text-base flex-shrink-0"></i>
        
        <input type="checkbox" x-model="selEdus" value="<?= $edu['id'] ?>" class="mt-1 w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">

        <div class="flex-1 min-w-0">
          <p class="font-bold text-slate-800 dark:text-slate-200"><?= esc($edu['degree']) ?><?= $edu['field'] ? ' — '.esc($edu['field']) : '' ?></p>
          <p class="text-sm text-emerald-500 font-semibold mt-0.5"><?= esc($edu['institution']) ?></p>
          <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5"><?= esc($edu['period']) ?></p>
        </div>
        <button @click="editItem('education',<?= $edu['id'] ?>)"
          class="text-xs font-bold text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-300 px-3 py-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition flex-shrink-0">
          <i class="fa-solid fa-pen-to-square mr-1"></i>Edit
        </button>
        <form action="<?= base_url('admin/porto/education/delete/'.$edu['id']) ?>" method="POST" onsubmit="return confirm('Hapus?')">
          <?= csrf_field() ?>
          <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition flex-shrink-0">
            <i class="fa-solid fa-trash mr-1"></i>Hapus
          </button>
        </form>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>

  <div x-show="showModal"
    x-cloak
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/60 dark:bg-black/75 z-50 flex items-center justify-center p-4 backdrop-blur-sm"
    @click.self="showModal=false">
    <div x-show="showModal"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
      class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border border-slate-200 dark:border-slate-700">

      <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between sticky top-0 bg-white dark:bg-slate-900 rounded-t-2xl z-10">
        <h3 class="font-black text-slate-800 dark:text-white text-base" x-text="modalTitle"></h3>
        <button @click="showModal=false"
          class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form x-show="modalType==='skill'" action="<?= base_url('admin/porto/skill/save') ?>" method="POST" class="px-6 py-5 space-y-4">
        <?= csrf_field() ?>
        <input type="hidden" name="id" x-model="form.id"/>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nama Skill <span class="text-red-400">*</span></label>
          <input type="text" name="name" x-model="form.name" required
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="Contoh: Laravel"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Kategori</label>
          <input type="text" name="category" x-model="form.category"
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="Backend, Frontend, Tools..."/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
            Level — <span class="text-indigo-500 font-black" x-text="(form.level ?? 80) + '%'"></span>
          </label>
          <input type="range" name="level" x-model="form.level" min="0" max="100"
            class="w-full h-2 rounded-full appearance-none bg-slate-200 dark:bg-slate-700 accent-indigo-500 cursor-pointer"/>
          <div class="flex justify-between text-xs text-slate-400 dark:text-slate-500 mt-1"><span>0%</span><span>50%</span><span>100%</span></div>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold py-2.5 rounded-xl text-sm transition shadow-lg shadow-indigo-500/20">
            <i class="fa-solid fa-floppy-disk"></i> Simpan
          </button>
          <button type="button" @click="showModal=false"
            class="px-5 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Batal</button>
        </div>
      </form>

      <form x-show="modalType==='experience'" action="<?= base_url('admin/porto/experience/save') ?>" method="POST" class="px-6 py-5 space-y-4">
        <?= csrf_field() ?>
        <input type="hidden" name="id" x-model="form.id"/>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Role / Posisi <span class="text-red-400">*</span></label>
          <input type="text" name="role" x-model="form.role" required
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="Full Stack Developer"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Perusahaan <span class="text-red-400">*</span></label>
          <input type="text" name="company" x-model="form.company" required
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="PT. Contoh Indonesia"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Periode</label>
          <input type="text" name="period" x-model="form.period"
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="Jan 2022 – Des 2023"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi</label>
          <textarea name="description" x-model="form.description" rows="3"
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"
            placeholder="Tugas & pencapaian..."></textarea>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold py-2.5 rounded-xl text-sm transition shadow-lg shadow-indigo-500/20">
            <i class="fa-solid fa-floppy-disk"></i> Simpan
          </button>
          <button type="button" @click="showModal=false"
            class="px-5 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Batal</button>
        </div>
      </form>

      <form x-show="modalType==='project'" action="<?= base_url('admin/porto/project/save') ?>" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
        <?= csrf_field() ?>
        <input type="hidden" name="id" x-model="form.id"/>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nama Project <span class="text-red-400">*</span></label>
          <input type="text" name="title" x-model="form.title" required
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="E-Commerce App"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi</label>
          <textarea name="description" x-model="form.description" rows="2"
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"
            placeholder="Deskripsi singkat project..."></textarea>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Gambar Project</label>
          <div x-show="form.currentImage" class="mb-3 flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
            <img :src="'<?= base_url() ?>' + (form.currentImage ?? '')" class="w-14 h-14 object-cover rounded-lg border border-slate-200 dark:border-slate-700"/>
            <div>
              <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Gambar saat ini</p>
              <p class="text-xs text-slate-400 dark:text-slate-500">Upload baru untuk ganti</p>
            </div>
          </div>
          <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-5 text-center cursor-pointer hover:border-pink-400 dark:hover:border-pink-500 hover:bg-pink-50 dark:hover:bg-pink-900/10 transition"
            onclick="document.getElementById('project-img-input').click()"
            @dragover.prevent @drop.prevent="handleDropImg($event,'project-img-preview','project-img-input','project-placeholder')">
            <img id="project-img-preview" class="w-full max-h-36 object-cover rounded-xl mx-auto mb-2 hidden"/>
            <div id="project-placeholder">
              <i class="fa-regular fa-image text-3xl text-slate-300 dark:text-slate-600 mb-1 block"></i>
              <p class="text-sm text-slate-400 dark:text-slate-500">Drop atau <span class="text-pink-500 font-bold">klik pilih</span></p>
              <p class="text-xs text-slate-400 dark:text-slate-600 mt-1">Otomatis Convert ke WebP</p>
            </div>
          </div>
          <input type="file" name="image" id="project-img-input" accept="image/*" class="hidden"
            onchange="previewImg(this,'project-img-preview','project-placeholder')"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tech Stack</label>
          <input type="text" name="tech_stack" x-model="form.tech_stack"
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="Laravel, Vue.js, MySQL"/>
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Demo URL</label>
            <input type="url" name="demo_url" x-model="form.demo_url"
              class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
              placeholder="https://..."/>
          </div>
          <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">GitHub URL</label>
            <input type="url" name="github_url" x-model="form.github_url"
              class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
              placeholder="https://github.com/..."/>
          </div>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold py-2.5 rounded-xl text-sm transition shadow-lg shadow-indigo-500/20">
            <i class="fa-solid fa-floppy-disk"></i> Simpan
          </button>
          <button type="button" @click="showModal=false"
            class="px-5 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Batal</button>
        </div>
      </form>

      <form x-show="modalType==='education'" action="<?= base_url('admin/porto/education/save') ?>" method="POST" class="px-6 py-5 space-y-4">
        <?= csrf_field() ?>
        <input type="hidden" name="id" x-model="form.id"/>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Institusi <span class="text-red-400">*</span></label>
          <input type="text" name="institution" x-model="form.institution" required
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="Universitas Indonesia"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Gelar <span class="text-red-400">*</span></label>
          <input type="text" name="degree" x-model="form.degree" required
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="S1 / D3 / SMA"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Jurusan / Bidang</label>
          <input type="text" name="field" x-model="form.field"
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="Teknik Informatika"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Periode</label>
          <input type="text" name="period" x-model="form.period"
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="2018 – 2022"/>
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi (opsional)</label>
          <textarea name="description" x-model="form.description" rows="2"
            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"></textarea>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-bold py-2.5 rounded-xl text-sm transition shadow-lg shadow-indigo-500/20">
            <i class="fa-solid fa-floppy-disk"></i> Simpan
          </button>
          <button type="button" @click="showModal=false"
            class="px-5 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Batal</button>
        </div>
      </form>

    </div>
  </div>

</div>

<style>
  .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
  .sortable-ghost { opacity:0.4; }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
function portoBuilder() {
  return {
    showModal: false,
    modalType: '',
    modalTitle: '',
    form: {},
    
    // Arrays untuk menampung ID item yang dipilih dari Checkbox
    selSkills: [],
    selExps: [],
    selProjs: [],
    selEdus: [],

    openModal(type) {
      this.modalType  = type;
      this.modalTitle = { skill:'Tambah Skill', experience:'Tambah Experience', project:'Tambah Project', education:'Tambah Education' }[type];
      this.form = { id:'', level:80 };
      resetImgPreview('project-img-preview','project-placeholder','project-img-input');
      this.showModal = true;
    },

    editItem(type, id) {
      fetch(`<?= base_url('admin/porto/item/') ?>${type}/${id}`)
        .then(r => r.json())
        .then(data => {
          this.form = { ...data, currentImage: data.image ?? '' };
          this.modalType  = type;
          this.modalTitle = { skill:'Edit Skill', experience:'Edit Experience', project:'Edit Project', education:'Edit Education' }[type];
          resetImgPreview('project-img-preview','project-placeholder','project-img-input');
          this.showModal = true;
        });
    },

    handleDropImg(e, previewId, inputId, placeholderId) {
      const file = e.dataTransfer.files[0];
      if (file && file.type.startsWith('image/')) {
        const input = document.getElementById(inputId);
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        showImgPreview(file, previewId, placeholderId);
      }
    }
  }
}

function previewImg(input, previewId, placeholderId) {
  if (input.files[0]) showImgPreview(input.files[0], previewId, placeholderId);
}

function showImgPreview(file, previewId, placeholderId) {
  const reader = new FileReader();
  reader.onload = e => {
    const img = document.getElementById(previewId);
    if (img) { img.src = e.target.result; img.classList.remove('hidden'); }
    const ph = document.getElementById(placeholderId);
    if (ph) ph.classList.add('hidden');
  };
  reader.readAsDataURL(file);
}

function resetImgPreview(previewId, placeholderId, inputId) {
  const img = document.getElementById(previewId);
  if (img) { img.src=''; img.classList.add('hidden'); }
  const ph = document.getElementById(placeholderId);
  if (ph) ph.classList.remove('hidden');
  const input = document.getElementById(inputId);
  if (input) input.value = '';
}

Sortable.create(document.getElementById('section-order-list'), {
  animation: 200,
  ghostClass: 'sortable-ghost',
  onEnd() {
    const order = Array.from(document.querySelectorAll('#section-order-list li[data-section]')).map(el => el.dataset.section);
    fetch('<?= base_url('admin/porto/sections/reorder') ?>', {
      method:'POST', headers:{'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest'}, body:JSON.stringify(order)
    });
  }
});

function makeItemSortable(listId, url) {
  const el = document.getElementById(listId);
  if (!el) return;
  Sortable.create(el, {
    handle: '.drag-handle', animation: 200, ghostClass: 'sortable-ghost',
    onEnd() {
      const orders = Array.from(el.querySelectorAll('li[data-id]')).map((li,i) => ({ id:li.dataset.id, position:i+1 }));
      fetch(url, { method:'POST', headers:{'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest'}, body:JSON.stringify(orders) });
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  makeItemSortable('skills-list',      '<?= base_url('admin/porto/skill/reorder') ?>');
  makeItemSortable('experiences-list', '<?= base_url('admin/porto/experience/reorder') ?>');
  makeItemSortable('projects-list',    '<?= base_url('admin/porto/project/reorder') ?>');
  makeItemSortable('education-list',   '<?= base_url('admin/porto/education/reorder') ?>');
});
</script>
<?= $this->endSection() ?>