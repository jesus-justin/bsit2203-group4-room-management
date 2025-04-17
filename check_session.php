<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$public = ['login.php','Sign-up.php'];
if (empty($_SESSION['user']) && ! in_array(basename($_SERVER['PHP_SELF']), $public)) {
    header('Location: login.php');
    exit;
}
?>