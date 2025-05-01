<?php
require_once 'check_session.php';

$name = $_SESSION['user']['name'];
$sr_code = $_SESSION['user']['sr_code'];
$role = $_SESSION['user']['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <h1>User Profile</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>SR Code:</strong> <?php echo htmlspecialchars($sr_code); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>

        <div class="nav-links">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
