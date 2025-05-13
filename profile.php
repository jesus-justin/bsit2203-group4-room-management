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
    $_SESSION['role'] = $role; // ✅ Set role in session

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="profiles.css">
</head>
<body>
    <a class="logout-btn" href="logout.php">Logout</a>

    <div class="profile-container">
        <h1>User Profile</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>

        <?php
        if (isset($_SESSION['role'])) {
            switch ($_SESSION['role']) {
                case 'admin':
                    $dashboard = 'admin_dashboard.php';
                    break;
                case 'student':
                    $dashboard = 'student_dashboard.php';
                    break;
                case 'instructor':
                    $dashboard = 'instructor_dashboard.php';
                    break;
                default:
                    $dashboard = '#'; // fallback if role is unrecognized
            }
            echo '<a href="' . $dashboard . '" class="back-button">Return to Dashboard</a>';
        }
        ?>
    </div>
</body>
</html>
