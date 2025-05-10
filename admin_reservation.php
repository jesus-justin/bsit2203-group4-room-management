<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$db = new Database();
$conn = $db->getConnect();

// Handle status update from dropdown form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'], $_POST['status'])) {
    $reservation_id = $_POST['reservation_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE reservation SET status = ? WHERE reservation_id = ? LIMIT 1");
    $stmt->execute([$status, $reservation_id]);
}

// Handle status update from GET (e.g. ?update=5)
if (isset($_GET['update'])) {
    $reservation_id = $_GET['update'];
    $stmt = $conn->prepare("UPDATE reservation SET status = 'Confirmed' WHERE reservation_id = ? LIMIT 1");
    $stmt->execute([$reservation_id]);
    header("Location: admin_reservation.php");
    exit();
}

// Fetch all reservations with user and room info
$stmt = $conn->query("
    SELECT r.*, u.first_name, u.last_name, rm.room_name
    FROM reservation r
    JOIN users u ON r.user_id = u.user_id
    JOIN rooms rm ON r.room_id = rm.room_id
    ORDER BY r.reservation_date DESC
");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Reservations</title>
    <link rel="stylesheet" href="admin_reservation.css">
    <style>
    .logout-btn {
        position: absolute;
        top: 20px;
        right: 30px;
        background-color:rgb(49, 190, 195);
        color: white;
        padding: 8px 14px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease;
        z-index: 9999;
    }
    .logout-btn:hover {
        background-color: #c0392b;
    }
</style>

<a class="logout-btn" href="logout.php">Logout</a>
</head>
<body>
    <h2>Manage Reservations</h2>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Reservation ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Room</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
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
                <td><?= htmlspecialchars($res['room_name']) ?></td>
                <td><?= htmlspecialchars($res['reservation_date']) ?></td>
                <td><?= htmlspecialchars($res['start_time']) ?></td>
                <td><?= htmlspecialchars($res['end_time']) ?></td>
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
    <a href="schedule_calendar.php" style="display: inline-block; margin-left:45%; text-decoration: none; font-size: 16px;">← Back to Schedule</a>
</body>
</html>
