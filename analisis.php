<?php
// Cleaned-up analysis page: uses shared header/footer and keeps logic intact.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// include shared header (contains <head> and opening <body>)
include __DIR__ . '/header.php';

// Load questions to map answer codes to labels
$questions = include __DIR__ . '/questions.php';

// Load centralized recommendations map
$recommendations_map = include __DIR__ . '/recommendations_map.php';

// Read stored answers
$answers = $_SESSION['test']['answers'] ?? null;
if (empty($answers) || !is_array($answers)) {
    echo '<main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">';
    echo '<div class="max-w-4xl mx-auto text-center py-12">';
    echo '<h2 class="text-2xl font-bold">Tidak ada data soal. Silakan mulai tes terlebih dahulu.</h2>';
    echo '<p class="mt-4"><a href="index.php" class="text-primary">Kembali ke beranda</a></p>';
    echo '</div></main>';
    include __DIR__ . '/footer.php';
    exit;
}

// Initialize counters for R I A S E C
$counts = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];
foreach ($answers as $ans) {
    if (isset($counts[$ans])) {
        $counts[$ans]++;
    }
}

// Sort by count desc
arsort($counts);
$top = array_keys($counts);

// Build recommendations ordered by the result
$recommendations = [];
foreach ($top as $cat) {
    if (isset($recommendations_map[$cat])) {
        $item = $recommendations_map[$cat];
        $item['key'] = $cat;
        // keep backward-compatible 'careers' naming for templates
        $item['careers'] = $item['majors'] ?? [];
        $recommendations[] = $item;
    }
}

// Top two categories for quick summary
$top2 = array_slice($top, 0, 2);
?>

<main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-primary-dark sm:text-5xl">Hasil Analisis</h2>
            <p class="mt-4 text-lg text-gray-600">Berdasarkan jawaban Anda, tipe minat teratas adalah: <strong><?php echo implode(', ', $top2); ?></strong>. Berikut beberapa rekomendasi jurusan berdasarkan preferensi tersebut.</p>
        </div>

        <section class="mb-12 bg-white rounded-xl shadow-soft p-8 text-center">
            <h3 class="text-2xl font-bold text-primary-dark mb-4">Tipe Minat Dominan Anda</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <?php foreach ($top2 as $t): ?>
                    <span class="px-6 py-2 rounded-full bg-secondary text-primary-dark font-semibold"><?php echo htmlspecialchars($t); ?></span>
                <?php endforeach; ?>
            </div>

            <div class="mt-6 text-left max-w-3xl mx-auto">
                <h4 class="font-semibold mb-2">Rangkuman Jawaban Anda:</h4>
                <ol class="list-decimal list-inside space-y-2">
                    <?php foreach ($answers as $qi => $a):
                        $qIndex = max(0, ((int)$qi) - 1);
                        $qText = $questions[$qIndex]['text'] ?? '';
                        $label = $questions[$qIndex]['options'][$a] ?? $a;
                    ?>
                        <li>
                            <strong><?php echo htmlspecialchars($qText); ?></strong>
                            <div class="ml-4 text-sm text-gray-700">Jawaban: <span class="font-medium"><?php echo htmlspecialchars($label); ?></span> (Tipe: <?php echo htmlspecialchars($a); ?>)</div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </section>

        <section>
            <h3 class="text-2xl font-bold text-primary-dark mb-6 text-center">Rekomendasi Jurusan Kuliah</h3>
            <div class="space-y-8">
                <?php foreach ($recommendations as $rec): ?>
                    <article class="bg-white rounded-xl shadow-soft overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="p-8">
                            <div class="flex items-start gap-6">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-primary">school</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-xl font-bold text-gray-900"><?php echo htmlspecialchars($rec['title']); ?></h4>
                                    <p class="mt-2 text-gray-600"><?php echo htmlspecialchars($rec['desc']); ?></p>
                                    <?php if (!empty($rec['careers'])): ?>
                                        <div class="mt-4">
                                            <h5 class="font-semibold text-gray-700 mb-2">Pilihan Jurusan terkait:</h5>
                                            <ul class="list-disc list-inside space-y-1 text-gray-600">
                                                <?php foreach ($rec['careers'] as $c): ?>
                                                    <li><?php echo htmlspecialchars($c); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="mt-16 flex flex-col sm:flex-row justify-center items-center gap-4">
            <a href="index.php#results" class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg h-12 px-8 bg-primary text-white text-base font-bold shadow-lg hover:bg-primary-dark transition-all transform hover:scale-105">
                <span class="material-symbols-outlined mr-2">save</span> Save Results
            </a>
            <a href="download_pdf.php" class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg h-12 px-8 bg-white border border-primary/50 text-primary-dark text-base font-bold shadow-soft hover:bg-primary/10 transition-all transform hover:scale-105">
                <span class="material-symbols-outlined mr-2">download</span> Download PDF
            </a>
        </div>
    </div>
</main>

<?php
include __DIR__ . '/footer.php';

// end of file

