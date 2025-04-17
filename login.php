<?php
  session_start();
  $site_title = "ROOM MANAGEMENT SYSTEM";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $site_title; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    :root {
      --primary-color: #0d6efd;
      --secondary-color: #e7f1ff;
      --text-color: #1a3d7c;
    }

    body {
      font-family: 'Arial', sans-serif;
      color: var(--text-color);
      background-color: #f5faff;
    }

    .navbar {
      background-color: var(--secondary-color);
      padding: 1rem 2rem;
    }

    .nav-link {
      color: var(--text-color);
      margin: 0.1rem;
      transition: opacity 0.2s;
    }

    .nav-link:hover {
      opacity: 0.8;
      text-decoration: underline;
    }

    .site-title {
      text-align: center;
      margin-top: 3rem;
      margin-bottom: 2rem;
      font-size: 2.8rem;
      font-weight: bold;
      color: var(--primary-color);
      letter-spacing: 1px;
    }

    .welcome {
      text-align: center;
      margin-bottom: 2rem;
      font-weight: bold;
      color: var(--primary-color);
      font-size: 1.8rem;
    }

    .Login {
      max-width: 350px;
      margin: 2rem auto 4rem auto;
      padding: 4rem;
      border: 1px solid var(--text-color);
      border-radius: 8px;
      background-color: var(--secondary-color);
      text-align: center;
    }

    .Login legend {
      font-size: 1.2rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    .Login label {
      display: block;
      margin: 0.5rem 0;
      color: var(--text-color);
    }

    .Login input[type="text"],
    .Login input[type="password"] {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #bcd4f6;
      border-radius: 4px;
    }

    .submit {
      text-align: center;
      margin-top: 1.5rem;
    }

    .submit button {
      background-color: #003366;
      color: white;
      padding: 0.9rem 1.5rem;
      border-radius: 30px;
      border: none;
      font-weight: bold;
      cursor: pointer;
    }

    .submit button:hover {
      background-color: #0059b3;
    }
  </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <!-- Removed the navbar brand to avoid duplicate site title -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- Centered Title -->
<div class="site-title">
  <?php echo $site_title; ?>
</div>

<!-- Welcome Section -->
<div class="welcome">
  <h1>WELCOME BACK!</h1>
</div>

<!-- Login Section -->
<div class="Login">
  <fieldset>
    <legend>User Login</legend>
    <form action="dbp_login.php" method="POST">
      <label for="sr_code">SR Code:</label>
      <input type="text" id="sr_code" name="sr_code" required />
      <br /><br />
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required />
      <br /><br />
      <div class="submit">
        <button type="submit">Log In</button>
      </div>
    </form>
  </fieldset>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
