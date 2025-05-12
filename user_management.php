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
    
    // Redirect with status 'approved' or 'denied' after role change
    header("Location: user_management.php?status=approved");
    exit; // Make sure the script stops here
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
    <link rel="stylesheet" href="reservations.css">
</head>
<body>
    <a class="logout-btn" href="logout.php">Logout</a>

    <header class="header">
        <a href="admin_dashboard.php" class="back-button">Dashboard</a>
        <h1 class="center-title">User Management</h1>
    </header>

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const params = new URLSearchParams(window.location.search);
            const status = params.get('status');  // Get the 'status' parameter from the URL

            // Display SweetAlert based on status
            if (status === 'approved') {
                Swal.fire({
                    text: 'Role has been successfully updated.',
                    icon: 'success',
                    backdrop: false,
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    position: 'center',
                    customClass: {
                        popup: 'swal2-center-popup'
                    }
                });
            } else if (status === 'denied') {
                Swal.fire({
                    text: '',
                });
            }
        });
    </script>
</body>
</html>
