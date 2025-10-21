<?php
session_start();

// Ensure test session exists
if (!isset($_SESSION['test'])) {
    // If no test in session, redirect to home to start
    header('Location: index.php');
    exit;
}

$total = 10;
$answer = $_POST['answer'] ?? null;
if ($answer !== null) {
    // Store answer for current question
    $q = $_SESSION['test']['current_question'] ?? 1;
    $_SESSION['test']['answers'][$q] = $answer;
}

// Advance question
$_SESSION['test']['current_question'] = ($_SESSION['test']['current_question'] ?? 1) + 1;

// If finished all questions, go to analysis
if ($_SESSION['test']['current_question'] > $total) {
    header('Location: analisis.php');
    exit;
}

// Otherwise, show next question
header('Location: soal.php');
exit;
