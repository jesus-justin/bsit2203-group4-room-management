<?php
// Correct the path to the database connection
require_once 'C:\xampp\htdocs\bsit2203-group4-room-management\Database\database_connection.php';

// Get all buildings with their rooms
$sql = "SELECT b.building_name, r.room_name
        FROM Buildings b
        JOIN Rooms r ON b.building_id = r.building_id
        ORDER BY b.building_name, r.room_name";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group rooms by building
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
