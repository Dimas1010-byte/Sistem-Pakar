<?php
// Home page for halaman_utama_(home)_1
require_once __DIR__ . '/header.php';
?>

            <main class="flex-grow">
                <section class="relative py-20 md:py-32">
                    <div class="absolute inset-0 bg-cover bg-center" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBsP2tAFXOzDdiaLjZHeU1KR8OjvmP9yzXCyN6L-J38zcclNgVX7tXRjZTAH2HdCyl_lv35upB6zQx5_nfx6yAUHOJaBNQeONuKwoj27ByReRd361a8lCFlQss5LFYBMkYTwZGH07E39UzKwDH9PEjSq8yIXnCkqf-IZdpe6X0kCJpvfu7YiqxihEzIJnvMAlhGUCicFuH8RxdE0gUQuc_IEMvNofkgFfXf1VMFPCT2O8OslpDTA-DKqLGIKQr79WU5TU-W4hTZN_s");'></div>
                    <div class="absolute inset-0 bg-background-light/80 dark:bg-background-dark/80"></div>
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
                        <div class="max-w-3xl mx-auto text-center">
                            <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 dark:text-white leading-tight tracking-tighter">
                                Analisis Minat Jurusan Kuliah
                            </h1>
                            <p class="mt-6 text-lg text-slate-700 dark:text-slate-300">
                               Temukan jalur akademik ideal yang sesuai dengan minat, keterampilan, dan aspirasi karier Anda. Sistem pakar kami menyediakan rekomendasi personal untuk membantu Anda membuat keputusan yang tepat tentang masa depan.
                            </p>

                            <div class="mt-10">
                                <form id="startForm" method="post" action="start_test.php">
                                    <input type="hidden" name="source" value="home1">
                                    <button id="startBtn" type="submit" class="bg-primary text-white font-bold py-3 px-8 rounded-full text-lg hover:opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg shadow-primary/30">
                                        Mulai Analisis Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="about" class="py-20 md:py-24 bg-background-light dark:bg-background-dark">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center max-w-3xl mx-auto">
                            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white">Mengapa Memilih Kompas Kampus?</h2>
                            <p class="mt-4 text-slate-600 dark:text-slate-400">
                                Sistem pakar kami menawarkan pendekatan komprehensif untuk pemilihan jurusan kuliah, menggabungkan penilaian yang dipersonalisasi dengan panduan ahli.
                            </p>
                        </div>
                        
                        <div class="mt-12 max-w-4xl mx-auto bg-white dark:bg-slate-900/40 p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold mb-3">Tentang Kompas Kampus</h3>
                            <p class="text-slate-600 dark:text-slate-400">College Compass membantu siswa menemukan jurusan kuliah yang sesuai dengan minat dan bakat mereka melalui serangkaian pertanyaan singkat. Sistem ini menggunakan model RIASEC (Realistic, Investigative, Artistic, Social, Enterprising, Conventional) untuk memetakan preferensi Anda dan merekomendasikan jurusan yang relevan.</p>
                            <p class="mt-3 text-slate-600 dark:text-slate-400">Cara kerja singkat: Jawab 10 pertanyaan. Hasil akan menunjukkan tipe minat dominan Anda dan daftar jurusan yang cocok berdasarkan jawaban tersebut.</p>
                            <h4 class="mt-4 font-semibold">Beberapa jurusan yang tersedia di website ini:</h4>
                            <div class="mt-3">
                                <div class="flex gap-2 mb-3 flex-wrap">
                                    <button data-filter="all" class="filterBtn px-3 py-1 rounded bg-primary text-white">All</button>
                                    <?php foreach (['R','I','A','S','E','C'] as $c): ?>
                                        <button data-filter="<?php echo $c; ?>" class="filterBtn px-3 py-1 rounded bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300"><?php echo $c; ?></button>
                                    <?php endforeach; ?>
                                </div>

                                <div id="majorsGrid" class="grid gap-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                <?php
                                $majors = include __DIR__ . '/majors_data.php';
                                // map RIASEC category to material icons
                                $icon_map = [
                                    'R' => 'build',
                                    'I' => 'science',
                                    'A' => 'palette',
                                    'S' => 'groups',
                                    'E' => 'trending_up',
                                    'C' => 'calculate',
                                ];

                                foreach ($majors as $slug => $m) {
                                    $icon = $icon_map[$m['category']] ?? 'school';
                                    echo '<a href="major.php?slug=' . urlencode($slug) . '" data-cat="' . htmlspecialchars($m['category']) . '" class="majorItem block px-3 py-2 rounded border border-slate-100 dark:border-slate-700 text-sm text-slate-700 dark:text-slate-300 hover:bg-primary/10 flex items-center gap-2">';
                                    echo '<span class="material-symbols-outlined text-lg text-primary">' . $icon . '</span>';
                                    echo '<span class="major-name">' . htmlspecialchars($m['name']) . '</span>';
                                    echo '</a>';
                                }
                                ?>
                                </div>
                            </div>
                            <script>
                                (function(){
                                    const buttons = document.querySelectorAll('.filterBtn');
                                    const items = document.querySelectorAll('.majorItem');
                                    function setFilter(f){
                                        items.forEach(it => {
                                            if(f==='all' || it.dataset.cat === f) it.style.display='block'; else it.style.display='none';
                                        });
                                    }
                                    buttons.forEach(b => b.addEventListener('click', ()=>{ setFilter(b.dataset.filter); }));
                                })();
                            </script>
                        </div>
                        <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            <div class="bg-white dark:bg-slate-900/40 p-8 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/20 text-primary">
                                    <span class="material-symbols-outlined text-3xl">bar_chart</span>
                                </div>
                                <h3 class="mt-6 text-xl font-bold text-slate-900 dark:text-white">Rekomendasi yang Dipersonalisasi</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400">
                                    Dapatkan saran jurusan yang disesuaikan berdasarkan profil unik Anda, termasuk minat, keterampilan, dan kekuatan akademis.
                                </p>
                            </div>

                            <div class="bg-white dark:bg-slate-900/40 p-8 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/20 text-primary">
                                    <span class="material-symbols-outlined text-3xl">groups</span>
                                </div>
                                <h3 class="mt-6 text-xl font-bold text-slate-900 dark:text-white">Wawasan Ahli</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400">
                                    Dapatkan manfaat dari wawasan dari konselor karier dan profesional industri yang berpengalaman, yang memberikan perspektif berharga di berbagai bidang.
                                </p>
                            </div>

                            <div class="bg-white dark:bg-slate-900/40 p-8 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/20 text-primary">
                                    <span class="material-symbols-outlined text-3xl">lightbulb</span>
                                </div>
                                <h3 class="mt-6 text-xl font-bold text-slate-900 dark:text-white">Penyelarasan Karier</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400">
                                    Jelajahi bagaimana jurusan yang berbeda terhubung dengan jalur karier potensial, pastikan pilihan akademis Anda selaras dengan tujuan jangka panjang Anda
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

<?php
require_once __DIR__ . '/footer.php';
?>
