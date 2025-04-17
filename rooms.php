<?php

require_once 'Database/database.php';

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
    <title>Rooms</title>
    <link rel="stylesheet" href="rooms.css">
</head>
<body>
    <a href="dashboard.php" class="back-button">Back to Dashboard</a>

    <h1>Room Listing by Building</h1>

    <?php foreach ($groupedRooms as $building => $roomList): ?>
        <h2><?= htmlspecialchars($building) ?></h2>
        <ul>
            <?php foreach ($roomList as $room): ?>
                <li><?= htmlspecialchars($room) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</body>
</html>