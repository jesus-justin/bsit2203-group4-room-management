<?php
require_once 'database.php';
require_once 'check_session.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["Email"]);
    $password = trim($_POST["password"]);

    try {
        $db = new Database();
        $conn = $db->getConnect();

        // Call stored procedure to get user by email
        $stmt = $conn->prepare("CALL GetUserByEmail(:email)");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); // Important for stored procedures

        if ($user && password_verify($password, $user['password'])) {
            // Store all required user info in session for auto-fill
            $_SESSION['user'] = [
                'user_id'    => $user['user_id'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'name'       => $user['first_name'] . ' ' . $user['last_name']
            ];

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header("Location: admin_reservation.php");
                exit;
            } else {
                header("Location: dashboard.php"); // Redirect to dashboard for regular users
                exit;
            }
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
     <div class="left-side">
    <div>
      <h1>ReServeU: BatState-U Lipa Campus Room Management System</h1>
      <div class="divider"></div>
      <p>
        <strong>ReServeU</strong> stands for <em>Red Spartan Serve University</em> – a platform designed to streamline room reservation and scheduling across BatState-U Lipa Campus.
        The system empowers students, faculty, and staff to efficiently access and manage available learning spaces.
      </p>
      <br>
      <p><strong>SDG Alignment:</strong><br>
        ReServeU supports <em>United Nations Sustainable Development Goal 4 – Quality Education</em> by promoting inclusive, accessible, and organized educational environments through efficient space management.
      </p>
      <br><br>
      <p style="font-size: 12px; color: #888;">&copy; 2025 ReServeU | Batangas State University - Lipa Campus. All rights reserved.</p>
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
