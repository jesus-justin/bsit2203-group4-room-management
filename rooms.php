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

$reservableRooms = [
    '501- Chemistry Laboratory',
    '502- Computer Laboratory',
    '503- Computer Laboratory/SSC and Apex Club Office',
    'Psych Lab',
    'Physics Lab',
    'Multimedia Room',
    'Graciano Lopez Jaena Hall'
];

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

<header class="header">
    <a href="dashboard.php" class="back-button">← Back to Dashboard</a>
    <h1 class="center-title">Buildings/Rooms</h1>
    <div style="width: 130px;"></div>
</header>

<main class="room-container">
    <?php foreach ($groupedRooms as $building => $roomList): ?>
        <section class="building-section">
            <h2><?= htmlspecialchars($building) ?></h2>
            <div class="room-grid">
                <?php foreach ($roomList as $room): ?>
                    <?php
                        $roomName = htmlspecialchars($room['room_name']);
                        $isReservable = preg_match('/^Room \d{3}$/', $roomName) || in_array($roomName, $reservableRooms);
                    ?>
                    <?php if ($isReservable): ?>
                        <div 
                            class="room-card clickable" 
                            data-room-id="<?= htmlspecialchars($room['room_id']) ?>" 
                            data-building-name="<?= htmlspecialchars($building) ?>">
                            <?= $roomName ?>
                        </div>
                    <?php else: ?>
                        <div class="room-card disabled" title="This room cannot be reserved"><?= $roomName ?></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</main>

<script>
    const userRole = <?= json_encode($role) ?>;

    document.querySelectorAll('.room-card.clickable').forEach(card => {
        card.addEventListener('click', function () {
            const roomId = this.dataset.roomId;
            const buildingName = this.dataset.buildingName;

            if (userRole === 'student') {
                Swal.fire({
                    icon: 'info',
                    title: 'Redirecting...',
                    text: 'Students can only view the reservation schedule.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = `schedule_calendar.php?room_id=${encodeURIComponent(roomId)}`;
                });
            } else {
                window.location.href = `insert_reservation.php?room_id=${encodeURIComponent(roomId)}&building_name=${encodeURIComponent(buildingName)}`;
            }
        });
    });
</script>

</body>
</html>
