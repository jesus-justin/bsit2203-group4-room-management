<?php
require_once 'check_session.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="top-bar">
        <span></span>
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <h2>Welcome to the Admin Dashboard</h2>
    <ul>
        <li><a href="user_management.php">User Management</a></li>
        <li><a href="reservation_management.php">Reservation Management</a></li>
    </ul>
</body>
</html>
