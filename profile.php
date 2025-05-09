<?php
require_once 'check_session.php';
require_once 'database.php';

if (!isset($_SESSION['user']['email'])) {
    die("User session not found. Please log in again.");
}

$email = $_SESSION['user']['email'];

try {
    $db = new Database();
    $conn = $db->getConnect();

    $stmt = $conn->prepare("SELECT CONCAT(first_name, ' ', last_name) AS name, email, role FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }

    $name = $user['name'];
    $role = $user['role'];

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<body>
    
    <style>
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            background-color:rgb(49, 190, 195);
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
            z-index: 9999;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }
    </style>
    <a class="logout-btn" href="logout.php">Logout</a>

    <div class="profile-container">

    <div class="profile-container">
        <h1>User Profile</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>

        <div class="nav-links">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>