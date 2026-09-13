<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<div class="pt-24 pb-20 min-h-screen transition-colors duration-500">
    <div class="max-w-4xl mx-auto px-6">
        
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 font-outfit tracking-tight">
                Syarat & Ketentuan <span class="text-indigo-600">(Terms of Service)</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400">Pembaruan Terakhir: <?= date('d M Y') ?></p>
        </div>

        <div class="rounded-[2rem] p-8 md:p-12 shadow-xl border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 leading-relaxed space-y-10">
            
            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                    <i class="fa-solid fa-scale-balanced text-indigo-500"></i> 1. Penerimaan Syarat
                </h2>
                <p class="text-sm">Dengan mendaftar, mengakses, atau menggunakan layanan platform ini, Anda setuju untuk terikat dengan Syarat dan Ketentuan yang berlaku. Jika Anda tidak setuju, mohon untuk tidak menggunakan layanan kami.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                    <i class="fa-solid fa-copyright text-indigo-500"></i> 2. Keaslian Karya & Hak Cipta
                </h2>
                <ul class="list-disc pl-5 text-sm space-y-2">
                    <li>Kreator <strong>wajib memastikan</strong> bahwa setiap Prompt Premium yang dijual di platform ini adalah <strong>100% karya asli</strong> ciptaan sendiri dan bukan hasil plagiasi.</li>
                    <li><strong>Penolakan Tanggung Jawab (Disclaimer):</strong> Platform ini bertindak murni sebagai perantara (marketplace). Kami <strong>TIDAK BERTANGGUNG JAWAB</strong> atas pelanggaran hak cipta apabila ada pengguna yang menyalin, mencuri, mendistribusikan ulang, atau menjual prompt milik orang lain tanpa izin.</li>
                    <li>Segala sengketa hukum atau klaim hak cipta yang timbul akibat penjualan prompt adalah tanggung jawab penuh dari kreator yang mengunggah prompt tersebut.</li>
                    <li>Kami berhak menghapus prompt secara sepihak dan memblokir akun secara permanen tanpa pengembalian dana jika terbukti melakukan pelanggaran hak cipta.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                    <i class="fa-solid fa-wallet text-indigo-500"></i> 3. Penjualan & Biaya Platform
                </h2>
                <p class="text-sm mb-3">Kreator berhak mendapatkan penghasilan dari setiap penjualan prompt premium yang berhasil dilakukan. Untuk mendukung operasional dan pemeliharaan layanan, platform kami memberlakukan kebijakan potongan komisi sebagai berikut:</p>
                <ul class="list-disc pl-5 text-sm space-y-2">
                    <li>Setiap penghasilan atau penarikan dana akan dikenakan <strong>Biaya Platform sebesar 3%</strong>.</li>
                    <li>Biaya ini akan dipotong secara otomatis pada saat kreator melakukan proses penarikan dana (Withdrawal).</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                    <i class="fa-solid fa-money-bill-transfer text-indigo-500"></i> 4. Kebijakan Penarikan Dana (Withdrawal)
                </h2>
                <p class="text-sm mb-4">Untuk menarik saldo pendapatan ke rekening bank atau e-wallet Anda, berlaku aturan jadwal dan perhitungan berikut:</p>
                
                <div class="bg-slate-50 dark:bg-slate-800/50 p-6 md:p-8 rounded-2xl border border-slate-100 dark:border-slate-700">
                    
                    <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 rounded-xl border border-amber-200 dark:border-amber-800/50 text-sm flex gap-3">
                        <i class="fa-regular fa-clock text-xl mt-0.5"></i>
                        <div>
                            <strong>Jadwal Operasional Penarikan:</strong><br>
                            Permintaan penarikan dana hanya akan diproses pada hari kerja (<strong>Senin s/d Kamis</strong>). Permintaan penarikan yang diajukan pada hari <strong>Jumat, Sabtu, dan Minggu</strong> akan mulai diproses setidaknya pada pukul <strong>10:00 WIB di hari Senin</strong> berikutnya.
                        </div>
                    </div>

                    <ul class="list-disc pl-5 text-sm space-y-3 mb-6">
                        <li>Batas minimal penarikan dana (withdraw) adalah <strong>Rp 50.000</strong>.</li>
                        <li>Setiap transaksi penarikan akan dikenakan biaya transfer antar bank/e-wallet sebesar <strong>Rp 7.500 (Flat)</strong>.</li>
                        <li>Dana yang ditarik akan dipotong <strong>Biaya Platform (3%)</strong>.</li>
                        <li><strong>Bebas Biaya Admin Flat:</strong> Khusus untuk penarikan dana dengan nominal <strong>di atas Rp 1.000.000</strong>, biaya admin Rp 7.500 akan <strong>digratiskan</strong> (namun potongan platform 3% tetap berlaku).</li>
                        <li>Proses pencairan dana membutuhkan waktu 1-3 hari kerja sesuai dengan jadwal operasional.</li>
                    </ul>

                    <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-indigo-100 dark:border-indigo-900/50 relative">
                        <div class="absolute -top-3 left-4 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-calculator"></i> Contoh Simulasi Penarikan
                        </div>
                        <p class="text-sm mt-3 mb-2 font-medium">Jika Anda menarik saldo sebesar <strong>Rp 50.000</strong>, maka rincian potongannya adalah:</p>
                        <ul class="text-sm space-y-1 font-mono text-slate-500 dark:text-slate-400">
                            <li class="flex justify-between"><span>Nominal Penarikan</span> <span>Rp 50.000</span></li>
                            <li class="flex justify-between text-rose-500"><span>Biaya Transfer (Flat)</span> <span>- Rp 7.500</span></li>
                            <li class="flex justify-between text-rose-500 border-b border-dashed border-slate-200 dark:border-slate-700 pb-2 mb-2"><span>Biaya Platform (3%)</span> <span>- Rp 1.500</span></li>
                            <li class="flex justify-between text-emerald-600 dark:text-emerald-400 font-bold text-base"><span>Total Diterima</span> <span>Rp 41.000</span></li>
                        </ul>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                    <i class="fa-solid fa-ban text-rose-500"></i> 5. Penghentian Akun
                </h2>
                <p class="text-sm">Kami berhak untuk menangguhkan atau menghapus akun Anda beserta saldo di dalamnya tanpa pemberitahuan sebelumnya jika Anda melanggar ketentuan layanan ini, melakukan plagiarisme/pencurian karya, melakukan penipuan, atau merugikan pihak lain di platform ini.</p>
            </section>

        </div>
    </div>
</div>
<?= $this->endSection() ?>