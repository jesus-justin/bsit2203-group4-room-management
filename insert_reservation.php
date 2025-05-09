<?php
require_once 'check_session.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnect();

$message = "";

$room_id = $_GET['room_id'] ?? '';
$building_name = $_GET['building_name'] ?? '';

$user_id = $_SESSION['user']['user_id'] ?? '';
$first_name = $_SESSION['user']['first_name'] ?? '';
$last_name = $_SESSION['user']['last_name'] ?? '';
$room_name = ''; 

if (!empty($room_id)) {
    $roomStmt = $conn->prepare("SELECT room_name FROM rooms WHERE room_id = ?");
    $roomStmt->execute([$room_id]);
    $roomData = $roomStmt->fetch(PDO::FETCH_ASSOC);
    $room_name = $roomData['room_name'] ?? ''; 
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = trim($_POST['room_id'] ?? '');
    $user_id = trim($_POST['user_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $building_name = trim($_POST['building_name'] ?? '');
    $reservation_date = trim($_POST['reservation_date'] ?? '');
    $start_time = trim($_POST['start_time'] ?? '');
    $end_time = trim($_POST['end_time'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($room_id)) {
        $message .= "<p class='error-message'>❌ Room ID is missing.</p>";
    } else {
        $roomStmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
        $roomStmt->execute([$room_id]);
        $roomExists = $roomStmt->fetch(PDO::FETCH_ASSOC);

        $userStmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $userStmt->execute([$user_id]);
        $userExists = $userStmt->fetch(PDO::FETCH_ASSOC);

        if ($roomExists && $userExists) {
            $insertStmt = $conn->prepare("INSERT INTO reservation 
                (room_id, user_id, first_name, last_name, building_name, reservation_date, start_time, end_time, description)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $success = $insertStmt->execute([ 
                $room_id, $user_id, $first_name, $last_name, $building_name, 
                $reservation_date, $start_time, $end_time, $description 
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
    <title>Reservation Form</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>

<?php if (!empty($message)) echo $message; ?>
<a href="rooms.php" style="display: inline-block; margin-left:45%; text-decoration: none; font-size: 16px;">← Back to Rooms</a><br>

<a href="schedule_calendar.php" style="display: inline-block; margin-left:45%; text-decoration: none; font-size: 16px;">← Back to Schedule</a>
<form method="post">
    <h2>Make a Reservation</h2>

    <label>Room ID:</label>
    <input type="text" name="room_id" value="<?= htmlspecialchars($room_id) ?>" readonly><br>

    <label>Room Name:</label>
    <input type="text" name="room_name" value="<?= htmlspecialchars($room_name) ?>" readonly><br>

    <label>User ID:</label>
    <input type="text" name="user_id" value="<?= htmlspecialchars($user_id) ?>" readonly><br>

    <label>First Name:</label>
    <input type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>" readonly><br>

    <label>Last Name:</label>
    <input type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>" readonly><br>

    <label>Building Name:</label>
    <input type="text" name="building_name" value="<?= htmlspecialchars($building_name) ?>" readonly><br>

    <label for="reservation_date">Reservation Date:</label>
    <input type="date" name="reservation_date" required><br>

    <label for="start_time">Start Time:</label>
    <input type="time" name="start_time" required><br>

    <label for="end_time">End Time:</label>
    <input type="time" name="end_time" required><br>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br>

    <input type="submit" value="Submit Reservation">
</form>

</body>
</html>
