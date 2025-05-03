<?php
require_once 'database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name  = trim($_POST["last_name"]);
    $email    = trim($_POST["email"]);
    $password   = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    $role       = "Student";

    if ($first_name && $last_name && $email && $password) {
        try {
            $db   = new Database();
            $conn = $db->getConnect();

            $stmt = $conn->prepare(
              "CALL SignupUser(:first_name, :last_name, :email, :role, :password)"
            );
            $stmt->execute([
                ':first_name' => $first_name,
                ':last_name'  => $last_name,
                ':email'    => $email,
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
  <title>Sign Up - ReServeU</title>
  <link rel="stylesheet" href="sign-up.css" />
</head>
<body>
<div class="container">
  <!-- LEFT SIDE -->
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
      <h2>Sign Up</h2>
      <p>Create your ReServeU account</p>
      <form method="POST" action="">
        <input type="text" name="first_name" placeholder="First Name" required />
        <input type="text" name="last_name" placeholder="Last Name" required />
        <input type="text" name="email" placeholder="Email" required />
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
  </div>
</div>
</body>
</html>
