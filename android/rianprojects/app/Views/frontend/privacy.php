<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<div class="pt-24 pb-20 min-h-screen transition-colors duration-500">
    <div class="max-w-4xl mx-auto px-6">
        
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit tracking-tight">
                Kebijakan Privasi <span class="text-indigo-600">(Privacy Policy)</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400">Pembaruan Terakhir: <?= date('d M Y') ?></p>
        </div>

        <div class="rounded-[2rem] p-8 md:p-12 shadow-xl border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 leading-relaxed space-y-10">
            
            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 rounded-xl text-sm font-medium">
                Privasi Anda sangat penting bagi kami. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.
            </div>

            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">1. Informasi yang Kami Kumpulkan</h2>
                <p class="text-sm mb-3">Kami mengumpulkan informasi dari Anda saat Anda mendaftar, melakukan transaksi, atau berinteraksi dengan platform kami. Ini termasuk:</p>
                <ul class="list-disc pl-5 text-sm space-y-2">
                    <li><strong>Informasi Pribadi:</strong> Nama, alamat email, dan informasi profil sosial media yang Anda tautkan.</li>
                    <li><strong>Data Transaksi:</strong> Riwayat pembelian prompt, data penarikan (withdraw), dan nomor rekening/e-wallet (hanya disimpan untuk proses transfer).</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">2. Bagaimana Kami Menggunakan Informasi Anda</h2>
                <p class="text-sm mb-3">Informasi yang kami kumpulkan digunakan dalam berbagai cara, termasuk untuk:</p>
                <ul class="list-disc pl-5 text-sm space-y-2">
                    <li>Menyediakan, mengoperasikan, dan memelihara platform kami.</li>
                    <li>Memproses transaksi pembelian prompt premium dan mencatat komisi kreator.</li>
                    <li>Memproses penarikan dana (withdrawal) ke rekening Anda.</li>
                    <li>Mendeteksi dan mencegah aktivitas penipuan atau penyalahgunaan akun.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">3. Keamanan Data</h2>
                <p class="text-sm">Kami menggunakan standar keamanan teknologi terkini (termasuk enkripsi password) untuk melindungi data pribadi Anda dari akses yang tidak sah. Namun, tidak ada metode transmisi di internet yang 100% aman. Kami berusaha sebaik mungkin, tetapi tidak dapat menjamin keamanan absolut.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">4. Berbagi Informasi Pihak Ketiga</h2>
                <p class="text-sm">Kami <strong>tidak pernah menjual, menukar, atau menyewakan</strong> informasi identitas pribadi Anda kepada pihak luar. Kami hanya membagikan data kepada pihak ketiga yang terpercaya (seperti Payment Gateway) semata-mata untuk keperluan memproses pembayaran dan penarikan dana Anda secara aman.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">5. Perubahan Kebijakan</h2>
                <p class="text-sm">Kami berhak memperbarui Kebijakan Privasi ini dari waktu ke waktu. Setiap perubahan akan langsung dipublikasikan di halaman ini. Kami menyarankan Anda untuk meninjau halaman ini secara berkala.</p>
            </section>

        </div>
    </div>
</div>
<?= $this->endSection() ?>