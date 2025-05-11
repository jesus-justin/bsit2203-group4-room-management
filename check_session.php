<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define publicly accessible pages (no redirection needed here)
$publicPages = ['login', 'sign-up'];

// Get current page name without .php or query strings
$currentPage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '.php');

// Redirect to login if not logged in and accessing a non-public page
if (empty($_SESSION['user']) && !in_array($currentPage, $publicPages)) {
    header('Location: login.php');
    exit;
}

// Role-based redirection logic
if (isset($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];

    if (
        $role === 'admin' &&
        !in_array($currentPage, ['admin_dashboard', 'user_management', 'reservation_management'])
    ) {
        header('Location: admin_dashboard.php');
        exit;
    }

    if (
        in_array($role, ['instructor', 'student leader']) &&
        $currentPage !== 'instructor_dashboard'
    ) {
        header('Location: instructor_dashboard.php');
        exit;
    }

    if (
        $role === 'student' &&
        $currentPage !== 'student_dashboard'
    ) {
        header('Location: student_dashboard.php');
        exit;
    }
}
?>
