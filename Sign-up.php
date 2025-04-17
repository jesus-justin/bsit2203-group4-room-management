<?php
require_once 'C:\xampp\htdocs\bsit2203-group4-room-management\Database\database_connection.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $sr_code = trim($_POST["sr_code"]);
    $role = $_POST["role"];
    $username = trim($_POST["username"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT); // Encrypt the password

    if (!empty($first_name) && !empty($last_name) && !empty($sr_code) && !empty($role) && !empty($username) && !empty($password)) {
        try {
            $stmt = $conn->prepare("INSERT INTO Users (first_name, last_name, sr_code, role, username, password) 
                                    VALUES (:first_name, :last_name, :sr_code, :role, :username, :password)");

            $stmt->execute([
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':sr_code' => $sr_code,
                ':role' => $role,
                ':username' => $username,
                ':password' => $password
            ]);

            // Redirect to login page after successful signup
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
<html>
<head>
    <title>Signup Form</title>
    <style>
        body {
            background-color: #e0f7fa;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .form-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.2);
            width: 350px;
        }

        .form-box h2 {
            text-align: center;
            color: #0288d1;
            margin-bottom: 20px;
        }

        .form-box input,
        .form-box select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #b3e5fc;
            border-radius: 6px;
        }

        .form-box input[type="submit"] {
            background-color: #4fc3f7;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .form-box input[type="submit"]:hover {
            background-color: #0288d1;
        }

        .message {
            text-align: center;
            color: #d32f2f;
            font-weight: bold;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #0288d1;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Sign Up</h2>
    <form method="POST" action="">
        <input type="text" name="first_name" placeholder="First Name" required />
        <input type="text" name="last_name" placeholder="Last Name" required />
        <input type="text" name="sr_code" placeholder="SR Code" required />
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <select name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="Student">Student</option>
            <option value="Instructor">Instructor</option>
            <option value="Student Leader">Student Leader</option>
        </select>
        <input type="submit" value="Register" />
    </form>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>

</body>
</html>
