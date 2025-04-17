<?php
require_once 'check_session.php';

// Grab any error passed back via ?error=
$message = $_GET['error'] ?? '';
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
  <form action="dbp_login.php" method="POST">
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