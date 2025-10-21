<?php
session_start();

$questions = include __DIR__ . '/questions.php';
$answers = $_SESSION['test']['answers'] ?? null;
if (empty($answers) || !is_array($answers)) {
    echo "<div style=\"font-family: Arial, sans-serif;\"><h2>Tidak ada data. Silakan lakukan tes terlebih dahulu.</h2></div>";
    return;
}

$counts = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];
foreach ($answers as $ans) {
    if (isset($counts[$ans])) {
        $counts[$ans]++;
    }
}
arsort($counts);
$top = array_keys($counts);

$recommendations_map = include __DIR__ . '/recommendations_map.php';
$recommendations = [];
foreach ($top as $cat) {
    if (isset($recommendations_map[$cat])) {
        $item = $recommendations_map[$cat];
        $item['key'] = $cat;
        $item['careers'] = $item['majors'] ?? [];
        $recommendations[] = $item;
    }
}

// Minimal printable HTML (keeps styling simple for PDF generators)
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hasil Analisis</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color: #111; margin: 20px; }
        h1 { font-size: 22px; margin-bottom: 6px; }
        h2 { font-size: 18px; margin-top: 18px; }
        h3 { font-size: 16px; margin-top: 12px; }
        ol, ul { margin-left: 20px; }
        .meta { color: #444; font-size: 14px; }
    </style>
</head>
<body>
    <header>
        <h1>Hasil Analisis</h1>
        <p class="meta">Tipe minat teratas: <?php echo htmlspecialchars(implode(', ', array_slice($top, 0, 2))); ?></p>
    </header>

    <section>
        <h2>Rangkuman Jawaban</h2>
        <ol>
            <?php foreach ($answers as $qi => $a):
                $qIndex = max(0, ((int)$qi) - 1);
                $qText = $questions[$qIndex]['text'] ?? '';
                $label = $questions[$qIndex]['options'][$a] ?? $a;
            ?>
                <li>
                    <strong><?php echo htmlspecialchars($qText); ?></strong>
                    <div>Jawaban: <?php echo htmlspecialchars($label); ?> (<?php echo htmlspecialchars($a); ?>)</div>
                </li>
            <?php endforeach; ?>
        </ol>
    </section>

    <section>
        <h2>Rekomendasi Jurusan</h2>
        <?php foreach ($recommendations as $rec): ?>
            <article>
                <h3><?php echo htmlspecialchars($rec['title']); ?> (<?php echo htmlspecialchars($rec['key']); ?>)</h3>
                <p><?php echo htmlspecialchars($rec['desc']); ?></p>
                <?php if (!empty($rec['careers'])): ?>
                    <ul>
                        <?php foreach ($rec['careers'] as $c): ?>
                            <li><?php echo htmlspecialchars($c); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </section>

</body>
</html>

