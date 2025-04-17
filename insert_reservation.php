<?php 
include 'database.php'; 

$db = new Database();
$conn = $db->getConnect();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = trim($_POST['room_id']);
    $user_id = trim($_POST['user_id']);
    $username = trim($_POST['username']);
    $building_name = trim($_POST['building_name']);
    $reservation_date = trim($_POST['reservation_date']);
    $reservation_time = trim($_POST['reservation_time']);
    $status = trim($_POST['status']);
    $description = trim($_POST['description']);

    // Check if room exists
    $roomStmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
    $roomStmt->execute([$room_id]);

    // Check if user exists
    $userStmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $userStmt->execute([$user_id]);

    if ($roomStmt->rowCount() > 0 && $userStmt->rowCount() > 0) {
        $sql = "INSERT INTO reservation 
                    (room_id, user_id, username, building_name, reservation_date, reservation_time, status, description)
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $success = $stmt->execute([
            $room_id, $user_id, $username, $building_name,
            $reservation_date, $reservation_time, $status, $description
        ]);

        if ($success) {
            $message = "<p class='success-message'>✅ Reservation created successfully!</p>";
        } else {
            $message = "<p class='error-message'>❌ Error inserting reservation.</p>";
        }
    } else {
        if ($roomStmt->rowCount() === 0) {
            $message .= "<p class='error-message'>❌ Room ID <strong>$room_id</strong> not found.</p>";
        }
        if ($userStmt->rowCount() === 0) {
            $message .= "<p class='error-message'>❌ User ID <strong>$user_id</strong> not found.</p>";
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

    <form method="post">
        <h2>Make a Reservation</h2>

        <label for="room_id">Room ID:</label>
        <input type="number" name="room_id" id="room_id" required><br>

        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" id="user_id" required><br>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="building_name">Building Name:</label>
        <input type="text" name="building_name" id="building_name" required><br>

        <label for="reservation_date">Reservation Date:</label>
        <input type="date" name="reservation_date" id="reservation_date" required><br>

        <label for="reservation_time">Reservation Time:</label>
        <input type="time" name="reservation_time" id="reservation_time" required><br>

        <label for="status">Status:</label>
        <input type="text" name="status" id="status" required><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>

        <input type="submit" value="Submit Reservation">
    </form>

    <form action="view_reservation.php" method="get" style="margin-top: 10px;">
        <button type="submit">View Reservations</button>
    </form>

</body>
</html>
