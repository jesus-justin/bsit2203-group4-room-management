<?php 
include 'database.php'; 

$db = new Database();
$conn = $db->getConnect();

$message = "";

// Fetch rooms for the dropdown
$stmt = $conn->prepare("CALL GetAllRoomsWithBuildings()");
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor(); // Important to prevent PDO error

// Group rooms properly
$groupedRooms = [];
foreach ($rooms as $row) {
    $groupedRooms[$row['building_name']][] = [
        'room_id' => isset($row['room_id']) ? $row['room_id'] : '',
        'room_name' => $row['room_name']
    ];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = trim($_POST['room_id'] ?? '');
    $user_id = trim($_POST['user_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $building_name = trim($_POST['building_name'] ?? '');
    $reservation_date = trim($_POST['reservation_date'] ?? '');
    $reservation_time = trim($_POST['reservation_time'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validate important fields
    if (empty($room_id)) {
        $message .= "<p class='error-message'>❌ Room ID is missing.</p>";
    } else {
        // Check if room exists
        $roomStmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
        $roomStmt->execute([$room_id]);
        $roomExists = $roomStmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists
        $userStmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $userStmt->execute([$user_id]);
        $userExists = $userStmt->fetch(PDO::FETCH_ASSOC);

        if ($roomExists && $userExists) {
            // Insert into reservation
            $insertStmt = $conn->prepare("INSERT INTO reservation 
                        (room_id, user_id, first_name, last_name, building_name, reservation_date, reservation_time, status, description)
                    VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        
            $success = $insertStmt->execute([
                $room_id, $user_id, $first_name, $last_name, $building_name,
                $reservation_date, $reservation_time, $status, $description
            ]);

            if ($success) {
                $message = "<p class='success-message'>✅ Reservation created successfully!</p>";
            } else {
                $message = "<p class='error-message'>❌ Error inserting reservation.</p>";
            }
        } else {
            if (!$roomExists) {
                $message .= "<p class='error-message'>❌ Room ID <strong>$room_id</strong> not found.</p>";
            }
            if (!$userExists) {
                $message .= "<p class='error-message'>❌ User ID <strong>$user_id</strong> not found.</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>

    <?php if (!empty($message)) echo $message; ?>
    <a href="dashboard.php" style="display: inline-block; margin-left:45%; text-decoration: none; font-size: 16px;">← Back to Dashboard</a>

    <form method="post">
        <h2>Make a Reservation</h2>

        <label for="room_id">Room:</label>
        <select name="room_id" id="room_id" required>
            <option value="" disabled selected>Select a room</option>
            <?php foreach ($groupedRooms as $building => $rooms): ?>
                <optgroup label="<?= htmlspecialchars($building) ?>">
                    <?php foreach ($rooms as $room): ?>
                        <option 
                            value="<?= htmlspecialchars($room['room_id']) ?>"
                            data-building="<?= htmlspecialchars($building) ?>">
                            <?= htmlspecialchars($room['room_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </optgroup>
            <?php endforeach; ?>
        </select><br>

        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" id="user_id" required><br>

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required><br>

        
        <label for="building_name">Building Name:</label>
        <input type="text" name="building_name" id="building_name" required readonly><br>

        <label for="reservation_date">Reservation Date:</label>
        <input type="date" name="reservation_date" id="reservation_date" required><br>

        <label for="reservation_time">Reservation Time:</label>
        <input type="time" name="reservation_time" id="reservation_time" required><br>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="Pending" selected>Pending</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Cancelled">Cancelled</option>
        </select><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>

        <input type="submit" value="Submit Reservation">
    </form>

    <form action="view_reservation.php" method="get" style="margin-top: 10px;">
        <button type="submit">View Reservations</button>
    </form>
                        
    <script>
    document.getElementById('room_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var buildingName = selectedOption.getAttribute('data-building');
        document.getElementById('building_name').value = buildingName || '';
    });
    </script>

</body>
</html>
