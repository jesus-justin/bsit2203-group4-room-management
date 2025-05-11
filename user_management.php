<?php
require_once 'check_session.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnect();

// Update role if form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("CALL UpdateUserRole(:id, :role)");
    $stmt->execute([
        ':id' => $_POST['user_id'],
        ':role' => $_POST['role']
    ]);
}

// Get all users
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="top-bar">
        <a href="admin_dashboard.php" class="btn">← Back to Dashboard</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <h2>User Management</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <form method="POST">
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <select name="role">
                        <option value="student" <?php if ($user['role'] === 'student') echo 'selected'; ?>>Student</option>
                        <option value="student leader" <?php if ($user['role'] === 'student leader') echo 'selected'; ?>>Student Leader</option>
                        <option value="instructor" <?php if ($user['role'] === 'instructor') echo 'selected'; ?>>Instructor</option>
                        <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <input type="submit" value="Update Role">
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
