<?php
require_once 'check_session.php';
require_once 'Database/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$sr_code  = trim($_POST['sr_code']  ?? '');
$password = trim($_POST['password'] ?? '');

if ($sr_code === '' || $password === '') {
    header('Location: login.php?error=Please+fill+in+all+fields');
    exit;
}

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
        header('Location: login.php?error=Invalid+SR+Code+or+Password');
        exit;
    }

} catch (PDOException $e) {
    header('Location: login.php?error=Database+error');
    exit;
}