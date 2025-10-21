<?php
// Generates a PDF of the analysis page.
session_start();

// Ensure analysis data exists
if (empty($_SESSION['test']['answers'])) {
    header('Location: analisis.php');
    exit;
}

$host = $_SERVER['HTTP_HOST'];
$base = dirname($_SERVER['SCRIPT_NAME']);

// Get HTML of the analysis page by buffering include
// Render only the analysis body via a lightweight printer to avoid full headers
ob_start();
include __DIR__ . '/analisis_print.php';
$bodyHtml = ob_get_clean();

// Try Dompdf if available
if (class_exists('\Dompdf\Dompdf')) {
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml('<!doctype html><html><head><meta charset="utf-8"/><title>Hasil Analisis</title></head><body>' . $bodyHtml . '</body></html>');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $pdf = $dompdf->output();
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="hasil_analisis.pdf"');
    echo $pdf;
    exit;
}

// Try wkhtmltopdf binary
$wk = trim(shell_exec('where wkhtmltopdf 2>&1')) ?: trim(shell_exec('which wkhtmltopdf 2>&1'));
if ($wk) {
    $tmpHtml = tempnam(sys_get_temp_dir(), 'analisis') . '.html';
    $tmpPdf = tempnam(sys_get_temp_dir(), 'analisis') . '.pdf';
    file_put_contents($tmpHtml, '<!doctype html><html><head><meta charset="utf-8"/><title>Hasil Analisis</title></head><body>' . $bodyHtml . '</body></html>');
    // call wkhtmltopdf
    $cmd = escapeshellarg($wk) . ' ' . escapeshellarg($tmpHtml) . ' ' . escapeshellarg($tmpPdf);
    shell_exec($cmd);
    if (file_exists($tmpPdf)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="hasil_analisis.pdf"');
        readfile($tmpPdf);
        @unlink($tmpHtml);
        @unlink($tmpPdf);
        exit;
    }
}

// Fallback: return Word (.doc) file for download (Word can open HTML-wrapped DOC)
$filename = 'hasil_analisis.doc';
header('Content-Type: application/msword; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: private, must-revalidate');
header('Pragma: public');
// Wrap in minimal HTML with UTF-8 meta so Word renders correctly
echo '<!doctype html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><title>Hasil Analisis</title></head><body>' . $bodyHtml . '</body></html>';
exit;
