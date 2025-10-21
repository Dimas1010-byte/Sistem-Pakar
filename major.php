<?php
// Show detail page for a major identified by slug in query param
require_once __DIR__ . '/header.php';

$slug = $_GET['slug'] ?? null;
$majors = include __DIR__ . '/majors_data.php';
if (!$slug || !isset($majors[$slug])) {
    header('Location: index.php');
    exit;
}

$m = $majors[$slug];
?>
            <main class="flex-grow">
                <section class="py-12">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="max-w-3xl mx-auto bg-white dark:bg-slate-900/40 rounded-lg p-8 shadow-md">
                            <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($m['name']); ?></h1>
                            <p class="text-slate-700 dark:text-slate-300 mb-6"><?php echo htmlspecialchars($m['description']); ?></p>

                            <h3 class="font-semibold mb-2">Contoh Mata Kuliah:</h3>
                            <ul class="list-disc list-inside mb-4">
                                <?php foreach ($m['courses'] as $c): ?>
                                    <li><?php echo htmlspecialchars($c); ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <h3 class="font-semibold mb-2">Prospek Karir:</h3>
                            <ul class="list-disc list-inside">
                                <?php foreach ($m['careers'] as $c): ?>
                                    <li><?php echo htmlspecialchars($c); ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="mt-6">
                                <a href="index.php" class="px-4 py-2 bg-primary text-white rounded">Kembali</a>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

<?php require_once __DIR__ . '/footer.php'; ?>
