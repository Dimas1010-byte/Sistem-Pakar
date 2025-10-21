<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>College Compass - Soal Analis</title>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            primary: '#42b6f0',
                            'background-light': '#f6f7f8',
                            'background-dark': '#101c22',
                        },
                        fontFamily: {
                            display: ['Plus Jakarta Sans'],
                        },
                        borderRadius: {
                            DEFAULT: '0.5rem',
                            lg: '1rem',
                            xl: '1.5rem',
                            full: '9999px',
                        },
                    },
                },
            };
        </script>

            <main class="flex-grow">
                <?php
                // Quiz questions (10) mapped to Holland RIASEC categories: R, I, A, S, E, C
                session_start();

                $questions = [
                    [
                        'text' => 'Kegiatan ilmiah mana yang paling menarik bagi Anda?',
                        'options' => [
                            'R' => 'Bekerja dengan alat atau mesin (pekerjaan praktis)',
                            'I' => 'Melakukan percobaan atau penelitian',
                            'A' => 'Membuat karya seni, desain, atau proyek kreatif',
                            'S' => 'Membantu atau mengajar orang lain',
                        ],
                    ],
                    [
                        'text' => 'Pernyataan mana yang paling menggambarkan Anda?',
                        'options' => [
                            'I' => 'Saya suka memecahkan masalah dan teka-teki yang kompleks',
                            'E' => 'Saya suka memimpin kelompok dan mempengaruhi orang lain',
                            'C' => 'Saya lebih suka mengatur data dan menyusun catatan',
                            'R' => 'Saya menikmati pekerjaan di luar ruangan atau pekerjaan fisik',
                        ],
                    ],
                    [
                        'text' => 'Tugas mana yang akan Anda pilih?',
                        'options' => [
                            'A' => 'Mendesain poster atau kampanye visual',
                            'S' => 'Mengorganisir acara komunitas untuk membantu orang',
                            'I' => 'Menganalisis data survei untuk menemukan pola',
                            'C' => 'Membuat rencana dan daftar tugas yang terperinci',
                        ],
                    ],
                    [
                        'text' => 'Aktivitas mana yang terasa paling memuaskan bagi Anda?',
                        'options' => [
                            'R' => 'Membangun atau memperbaiki sesuatu',
                            'I' => 'Melakukan penelitian ilmiah',
                            'E' => 'Memulai usaha kecil atau proyek',
                            'A' => 'Menulis atau mencipta karya orisinal',
                        ],
                    ],
                    [
                        'text' => 'Dalam sebuah tim, peran Anda biasanya adalah:',
                        'options' => [
                            'E' => 'Pemberi semangat / pemimpin',
                            'C' => 'Perencana / pengatur',
                            'S' => 'Pendukung / pelatih',
                            'I' => 'Analis / pemecah masalah',
                        ],
                    ],
                    [
                        'text' => 'Mata pelajaran mana yang Anda sukai?',
                        'options' => [
                            'I' => 'Matematika atau Sains',
                            'A' => 'Seni, Musik, atau Sastra',
                            'S' => 'Psikologi atau Sosiologi',
                            'R' => 'Praktikum Teknologi atau Teknik',
                        ],
                    ],
                    [
                        'text' => 'Bagaimana Anda biasanya menyelesaikan tugas?',
                        'options' => [
                            'C' => 'Mengikuti aturan dan prosedur dengan teliti',
                            'E' => 'Mengambil inisiatif dan berani mencoba hal baru',
                            'R' => 'Lebih suka pendekatan praktis / langsung',
                            'A' => 'Menggunakan kreativitas dan imajinasi',
                        ],
                    ],
                    [
                        'text' => 'Lingkungan kerja mana yang paling cocok untuk Anda?',
                        'options' => [
                            'S' => 'Bekerja dengan orang lain untuk mendukung mereka',
                            'I' => 'Laboratorium tenang atau suasana penelitian',
                            'E' => 'Lingkungan bisnis yang dinamis dan cepat',
                            'A' => 'Studio kreatif yang fleksibel',
                        ],
                    ],
                    [
                        'text' => 'Aktivitas mana yang akan Anda sukarelakan?',
                        'options' => [
                            'C' => 'Mengelola pendaftaran dan administrasi',
                            'R' => 'Menyiapkan peralatan dan logistik',
                            'S' => 'Membimbing atau mengajar siswa',
                            'A' => 'Mendesain materi promosi',
                        ],
                    ],
                    [
                        'text' => 'Hasil mana yang membuat Anda bangga?',
                        'options' => [
                            'I' => 'Menemukan wawasan atau solusi baru',
                            'E' => 'Mengembangkan sebuah proyek hingga sukses',
                            'A' => 'Menciptakan sesuatu yang indah atau bermakna',
                            'S' => 'Mengetahui bahwa Anda telah membantu orang lain',
                        ],
                    ],
                ];

                $total = count($questions);
                // Ensure session test state
                if (!isset($_SESSION['test'])) {
                    $_SESSION['test'] = ['current_question' => 1, 'answers' => []];
                }

                $current = $_SESSION['test']['current_question'] ?? 1;
                if ($current < 1) $current = 1;
                if ($current > $total) $current = $total;

                $qIndex = $current - 1;
                $q = $questions[$qIndex];
                $progressPct = (int)(($current - 1) / $total * 100);
                ?>

                <section class="py-16 md:py-24">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="max-w-4xl mx-auto">
                            <div class="text-center mb-12">
                                <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 dark:text-white">Tes Penilaian Minat</h1>
                                <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">Jawablah pertanyaan berikut untuk membantu kami memahami minat Anda dan menyarankan jurusan kuliah terbaik untuk Anda.</p>
                            </div>

                            <div class="bg-white dark:bg-slate-900/40 rounded-xl shadow-lg p-8 md:p-12">
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Question <?php echo $current; ?> of <?php echo $total; ?></span>
                                        <span class="text-sm font-bold text-primary">Progress</span>
                                    </div>

                                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5">
                                        <div class="bg-primary h-2.5 rounded-full" style="width: <?php echo $progressPct; ?>%"></div>
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <form method="post" action="submit_answer.php">
                                        <h2 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white mb-6"><?php echo htmlspecialchars($q['text']); ?></h2>

                                        <div class="space-y-4">
                                            <?php
                                            $optIndex = 0;
                                            foreach ($q['options'] as $val => $label) {
                                                $optIndex++;
                                                $id = 'q' . $current . '_opt' . $optIndex;
                                                ?>
                                                <label for="<?php echo $id; ?>" class="flex items-center p-4 border border-slate-200 dark:border-slate-700 rounded-lg cursor-pointer hover:bg-primary/10 dark:hover:bg-primary/20 transition-colors">
                                                    <input id="<?php echo $id; ?>" class="h-5 w-5 text-primary focus:ring-primary border-slate-300 dark:border-slate-600 dark:bg-slate-800" name="answer" value="<?php echo $val; ?>" type="radio" required />
                                                    <span class="ml-4 text-slate-700 dark:text-slate-300"><?php echo htmlspecialchars($label); ?></span>
                                                </label>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="flex justify-between items-center mt-12">
                                            <a href="index.php" class="px-6 py-2.5 text-sm font-bold rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors inline-block">Cancel</a>
                                            <button type="submit" class="px-8 py-3 text-base font-bold rounded-full bg-primary text-white hover:opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg shadow-primary/30 inline-block">Next Question <span class="material-symbols-outlined align-middle ml-1">arrow_forward</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <footer class="bg-background-light dark:bg-background-dark border-t border-slate-200 dark:border-slate-800">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 text-primary">
                                <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M42.4379 44C42.4379 44 36.0744 33.9038 41.1692 24C46.8624 12.9336 42.2078 4 42.2078 4L7.01134 4C7.01134 4 11.6577 12.932 5.96912 23.9969C0.876273 33.9029 7.27094 44 7.27094 44L42.4379 44Z" fill="currentColor"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">College Compass</h2>
                        </div>

                        <p class="text-sm text-slate-600 dark:text-slate-400">© 2024 College Compass. All rights reserved.</p>

                        <div class="flex gap-6">
                            <a class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors" href="#">Privacy Policy</a>
                            <a class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors" href="#">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
