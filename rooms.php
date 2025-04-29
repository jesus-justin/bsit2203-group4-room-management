<?php
require_once 'database.php';

$db = new Database();
$conn = $db->getConnect();

$stmt = $conn->prepare("CALL GetAllRoomsWithBuildings()");
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

$groupedRooms = [];
foreach ($rooms as $row) {
    $groupedRooms[$row['building_name']][] = $row['room_name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms by Building</title>
    <link rel="stylesheet" href="rooms.css">

    <style>

        .header {
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .reserve-button {
            display:flex;
            background-color: #4CAF50;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-left: 1200px;
        }

        .reserve-button:hover {
            background-color: #45a049;
        }
    </style>
    
</head>
<body>

    <header class="header">
        <a href="dashboard.php" class="back-button">← Back to Dashboard</a>
        <h1>Rooms by Building</h1>
        <a href="insert_reservation.php" class="reserve-button">Reserve a Room</a>
    </header>

    <main class="room-container">
        <?php foreach ($groupedRooms as $building => $roomList): ?>
            <section class="building-section">
                <h2><?= htmlspecialchars($building) ?></h2>
                <div class="room-grid">
                    <?php foreach ($roomList as $room): ?>
                        <div class="room-card"><?= htmlspecialchars($room) ?></div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    </main>


</body>
</html>
