<?php
require_once 'check_session.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="reservations.css">
</head>
<body>
     <a class="logout-btn" href="logout.php">Logout</a>

    <header class="header">
        <h1 class="center-title">Admin Dashboard</h1>
    </header>

    <ul>
        <li><a href="user_management.php">User Management</a></li>
        <li><a href="reservation_management.php">Reservation Management</a></li>
    </ul>
</body>
</html>
