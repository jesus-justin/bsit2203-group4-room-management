<?php
require_once 'check_session.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnect();

$stmt = $conn->prepare("CALL GetAllRoomsWithBuildings()");
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

$groupedRooms = [];
foreach ($rooms as $row) {
    $groupedRooms[$row['building_name']][] = [
        'room_name' => $row['room_name'],
        'room_id' => $row['room_id']
    ];
}

$role = $_SESSION['user']['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms by Building</title>
    <link rel="stylesheet" href="room.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header class="header">
        <a href="dash-beta.php" class="back-button">← Back to Dashboard</a>
        <h1>Rooms</h1>
    </header>

    <main class="room-container">
        <?php foreach ($groupedRooms as $building => $roomList): ?>
            <section class="building-section">
                <h2><?= htmlspecialchars($building) ?></h2>
                <div class="room-grid">
                    <?php foreach ($roomList as $room): ?>
                        <a 
                            class="room-card" 
                            href="insert_reservation.php?room_id=<?= urlencode($room['room_id']) ?>&building_name=<?= urlencode($building) ?>">
                            <?= htmlspecialchars($room['room_name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    </main>

    <script>
        function showStudentAlert() {
            Swal.fire({
                icon: 'info',
                title: 'Access Denied',
                text: 'Students cannot reserve a Room',
                confirmButtonColor: '#3085d6'
            });
        }
    </script>

</body>
</html>
