<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirect unauthorized users
    header("Location: login.php");
    exit();
}

$db = new Database();
$conn = $db->getConnect();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'], $_POST['status'])) {
    $reservation_id = $_POST['reservation_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE reservation SET status = ? WHERE reservation_id = ?");
    $stmt->execute([$status, $reservation_id]);
}

// Fetch all reservations
$stmt = $conn->query("SELECT * FROM reservation ORDER BY reservation_date DESC");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Reservations</title>
    <link rel="stylesheet" href="admin_reservation.css">
</head>
<body>
    <h2>Manage Reservations</h2>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Reservation ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Room ID</th>
                <th>Building</th>
                <th>Date</th>
                <th>Time</th>
                <th>Description</th>
                <th>Status</th>
                <th>Change Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reservations as $res): ?>
            <tr>
                <td><?= $res['reservation_id'] ?></td>
                <td><?= htmlspecialchars($res['user_id']) ?></td>
                <td><?= htmlspecialchars($res['first_name'] . ' ' . $res['last_name']) ?></td>
                <td><?= htmlspecialchars($res['room_id']) ?></td>
                <td><?= htmlspecialchars($res['building_name']) ?></td>
                <td><?= htmlspecialchars($res['reservation_date']) ?></td>
                <td><?= htmlspecialchars($res['reservation_time']) ?></td>
                <td><?= htmlspecialchars($res['description']) ?></td>
                <td><strong><?= htmlspecialchars($res['status']) ?></strong></td>
                <td>
                    <form method="POST" style="display:inline-block;">
                    <input type="hidden" name="reservation_id" value="<?= $res['reservation_id'] ?>">
                            <select name="status">
                            <option value="Pending" <?= $res['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Confirmed" <?= $res['status'] === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="Cancelled" <?= $res['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="rooms.php" style="display: inline-block; margin-left:45%; text-decoration: none; font-size: 16px;">← Back to Rooms</a>
</body>
</html>
