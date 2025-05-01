<?php
require_once 'database.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["Email"]);
    $password = trim($_POST["password"]);

    try {
        $db = new Database();
        $conn = $db->getConnect();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user'] = [
                'name'  => $user['first_name'] . ' ' . $user['last_name'],
                'email' => $user['email'],
                'role'  => $user['role']
            ];

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ReServeU: BatState-U Lipa Campus Room Management System</title>
    <link rel="stylesheet" href="login.css?v=1.0">
</head>
<body>
    <div class="container">
        <!-- LEFT SIDE -->
        <div class="left-side">
            <div>
                <h1>ReServeU: BatState-U Lipa Campus Room Management System</h1>
                <div class="divider"></div>
                <p><strong>ReServeU</strong> stands for <em>Red Spartan Serve University</em> – a platform to streamline room reservation.</p>
                <p><strong>SDG Alignment:</strong> Supports <em>SDG 4 – Quality Education</em>.</p>
                <p style="font-size: 12px; color: #888;">&copy; 2025 ReServeU</p>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="right-side">
            <div class="form-box">
                <h2>Welcome!</h2>
                <p>Please login to your account.</p>
                <form method="post" action="">
                    <input type="text" name="Email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" value="Login">
                </form>

                <?php if (!empty($message)): ?>
                    <p class="message"><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>

                <div class="login-link">
                    Don't have an account? <a href="sign-up.php">Sign up</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
