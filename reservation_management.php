<?php
require_once 'check_session.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action']) && isset($_POST['reservation_id'])) {
        $action = $_POST['action'];
        $id = $_POST['reservation_id'];

        if ($action === 'approve') {
            $stmt = $conn->prepare("CALL ApproveReservation(:id)");
            $stmt->execute([':id' => $id]);
        } elseif ($action === 'deny') {
            $stmt = $conn->prepare("CALL DenyReservation(:id)");
            $stmt->execute([':id' => $id]);
        }
    }
        if ($action === 'approve') {
        $stmt = $conn->prepare("CALL ApproveReservation(:id)");
        $stmt->execute([':id' => $id]);
        header("Location: reservation_management.php?status=approved");
        exit;
    } elseif ($action === 'deny') {
        $stmt = $conn->prepare("CALL DenyReservation(:id)");
        $stmt->execute([':id' => $id]);
        header("Location: reservation_management.php?status=denied");
        exit;
    }

}



$stmt = $conn->prepare("SELECT * FROM reservation");
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservation Management</title>
    <link rel="stylesheet" href="reservations.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <a class="logout-btn" href="logout.php">Logout</a>

    <header class="header">
        <a href="admin_dashboard.php" class="back-button">Dashboard</a>
        <h1 class="center-title">Reservation Management</h1>
    </header>

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
                    <input type="hidden" name="reservation_id" value="<?php echo $res['reservation_id']; ?>">
                    <button type="submit" name="action" value="approve">Approve</button>
                    <button type="submit" name="action" value="deny">Deny</button>  
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        const status = params.get('status');

        if (status === 'approved' || status === 'denied') {
            Swal.fire({
                text: status === 'approved' ? 'Reservation approved.' : 'Reservation denied.',
                icon: 'success',
                backdrop: false,            
                allowOutsideClick: true,
                allowEscapeKey: true,
                position: 'center',
                customClass: {
                    popup: 'swal2-center-popup'
                }
            });
        }
    });
    </script>

</body>
</html>
