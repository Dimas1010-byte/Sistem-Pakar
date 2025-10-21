<?php
// Initializes test session and redirects to the question page
session_start();

// Reset or initialize test data
$_SESSION['test'] = [
    'started_at' => time(),
    'current_question' => 1,
    'answers' => [],
];

// Optionally capture source
if (!empty($_POST['source'])) {
    $_SESSION['test']['source'] = $_POST['source'];
}

// Redirect to the question page (adjust path if necessary)
header('Location: soal.php');
exit;
