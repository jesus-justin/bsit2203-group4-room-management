<?php
require_once 'check_session.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("CALL ApproveReservation(:id)");
    $stmt->execute([
        ':id' => $_POST['reservation_id']
    ]);
}

$stmt = $conn->prepare("SELECT * FROM reservation");
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservation Management</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="top-bar">
        <a href="admin_dashboard.php" class="btn">← Back to Dashboard</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <h2>Reservation Management</h2>
    <table>
        <tr>
            <th>Reservation ID</th><th>User ID</th><th>Room ID</th><th>Status</th><th>Action</th>
        </tr>
        <?php foreach ($reservations as $res): ?>
        <tr>
            <form method="POST">
                <td><?php echo $res['reservation_id']; ?></td>
                <td><?php echo $res['user_id']; ?></td>
                <td><?php echo $res['room_id']; ?></td>
                <td><?php echo $res['status']; ?></td>
                <td>
                    <?php if ($res['status'] !== 'approved'): ?>
                        <input type="hidden" name="reservation_id" value="<?php echo $res['reservation_id']; ?>">
                        <input type="submit" value="Approve">
                    <?php else: ?>
                        Approved
                    <?php endif; ?>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
