<?php
require_once 'check_session.php';
require_once 'database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sr_code  = trim($_POST['sr_code'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($sr_code === '' || $password === '') {
        $message = 'Please fill in all fields';
    } else {
        try {
            $db   = new Database();
            $conn = $db->getConnect();

            $stmt = $conn->prepare('CALL LoginUser(:sr_code)');
            $stmt->execute([':sr_code' => $sr_code]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id'      => $user['user_id'],
                    'sr_code' => $user['sr_code'],
                    'name'    => $user['first_name'] . ' ' . $user['last_name'],
                    'role'    => $user['role']
                ];
                header('Location: dashboard.php');
                exit;
            } else {
                $message = 'Invalid SR Code or Password';
            }

        } catch (PDOException $e) {
            $message = 'Database error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body>

<div class="form-box">
  <h2>Login</h2>
  <form action="login.php" method="POST">
    <input type="text" name="sr_code" placeholder="SR Code" required />
    <input type="password" name="password" placeholder="Password" required />
    <input type="submit" value="Log In" />
  </form>

  <?php if (!empty($message)): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>

  <div class="login-link">
    Don't have an account? <a href="Sign-up.php">Sign up here</a>
  </div>
</div>

</body>
</html>