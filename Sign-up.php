<?php
require_once 'Database/database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name  = trim($_POST["last_name"]);
    $sr_code    = trim($_POST["sr_code"]);
    $password   = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    $role       = "Student";

    if ($first_name && $last_name && $sr_code && $password) {
        try {
            $db   = new Database();
            $conn = $db->getConnect();

            $stmt = $conn->prepare(
              "CALL SignupUser(:first_name, :last_name, :sr_code, :role, :password)"
            );
            $stmt->execute([
                ':first_name' => $first_name,
                ':last_name'  => $last_name,
                ':sr_code'    => $sr_code,
                ':role'       => $role,
                ':password'   => $password
            ]);

            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up</title>
  <link rel="stylesheet" href="Sign-up.css" />
</head>
<body>

<div class="form-box">
  <h2>Sign Up</h2>
  <form method="POST" action="">
    <input type="text" name="first_name" placeholder="First Name" required />
    <input type="text" name="last_name" placeholder="Last Name" required />
    <input type="text" name="sr_code" placeholder="SR Code" required />
    <input type="password" name="password" placeholder="Password" required />
    <input type="submit" value="Register" />
  </form>

  <?php if (!empty($message)): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>

  <div class="login-link">
    Already have an account? <a href="login.php">Login here</a>
  </div>
</div>

</body>
</html>