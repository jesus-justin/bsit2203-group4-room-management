<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define publicly accessible pages
$public = ['login.php', 'sign-up.php'];

// Get current page
$currentPage = basename($_SERVER['PHP_SELF']);

// Redirect to login if user is not logged in and the page is not public
if (empty($_SESSION['user']) && !in_array($currentPage, $public)) {
    header('Location: login.php');
    exit;
}

// Redirect admin users away from non-admin pages
if (
    isset($_SESSION['user']) && 
    $_SESSION['user']['role'] === 'admin' &&
    !in_array($currentPage, ['admin_dashboard.php', 'user_management.php', 'reservation_management.php'])
) {
    header('Location: admin_dashboard.php');
    exit;
}
?>
