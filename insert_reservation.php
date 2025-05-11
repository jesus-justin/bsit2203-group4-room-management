<?php
require_once 'check_session.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnect();

$message = "";

$room_id = $_GET['room_id'] ?? '';
$building_name = ''; // Initialize building_name

$user_id = $_SESSION['user']['user_id'] ?? '';
$first_name = $_SESSION['user']['first_name'] ?? '';
$last_name = $_SESSION['user']['last_name'] ?? '';
$room_name = ''; 

// Fetch room details including building name from the database
if (!empty($room_id)) {
    $roomStmt = $conn->prepare("
        SELECT r.room_name, b.building_name 
        FROM rooms r
        INNER JOIN buildings b ON r.building_id = b.building_id 
        WHERE r.room_id = ?");
    $roomStmt->execute([$room_id]);
    $roomData = $roomStmt->fetch(PDO::FETCH_ASSOC);

    $room_name = $roomData['room_name'] ?? ''; 
    $building_name = $roomData['building_name'] ?? ''; // Get the building name from the join
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = trim($_POST['room_id'] ?? '');
    $user_id = trim($_POST['user_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $building_name = trim($_POST['building_name'] ?? '');  // Get building_name from POST
    $reservation_date = trim($_POST['reservation_date'] ?? '');
    $start_time = trim($_POST['start_time'] ?? '');
    $end_time = trim($_POST['end_time'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($room_id)) {
        $message .= "<p class='error-message'>❌ Room ID is missing.</p>";
    } else {
        // Check if room and user exist
        $roomStmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
        $roomStmt->execute([$room_id]);
        $roomExists = $roomStmt->fetch(PDO::FETCH_ASSOC);

        $userStmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $userStmt->execute([$user_id]);
        $userExists = $userStmt->fetch(PDO::FETCH_ASSOC);

        if ($roomExists && $userExists) {
            // Insert the reservation into the database
            $insertStmt = $conn->prepare("INSERT INTO reservation 
                (room_id, user_id, first_name, last_name, building_name, reservation_date, start_time, end_time, description)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $success = $insertStmt->execute([ 
                $room_id, $user_id, $first_name, $last_name, $building_name, 
                $reservation_date, $start_time, $end_time, $description 
            ]);

            // Redirect to the same page with success parameter ONLY if the reservation was successful
            if ($success) {
                // Redirect to the same page with success=1 and necessary parameters
                header("Location: " . $_SERVER['PHP_SELF'] . "?success=1&room_id=" . urlencode($room_id) . "&building_name=" . urlencode($building_name));
                exit();
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
    <link rel="stylesheet" href="reservations.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <a class="logout-btn" href="logout.php">Logout</a>

    <header class="header">
        <a href="instructor_dashboard.php" class="back-button">Dashboard</a>
        <h1 class="center-title">Reservation</h1>
        <div style="width: 130px;"></div>
    </header>

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

        <button type="submit">Submit Reservation</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === '1') {
                Swal.fire({
                    icon: 'success',
                    title: 'Reservation Successful!',
                    text: 'Do you want to make another reservation or go back to rooms?',
                    showCancelButton: true,
                    confirmButtonText: 'Make Another Reservation',
                    cancelButtonText: 'Go Back to Rooms'
                }).then((result) => {
                    // Remove success=1 from URL so it doesn't trigger again
                    const newURL = window.location.href.split('?')[0] + '?room_id=' + urlParams.get('room_id') + '&building_name=' + urlParams.get('building_name');
                    window.history.replaceState({}, document.title, newURL);

                    if (result.isConfirmed) {
                        // Stay on this page (do nothing)
                    } else {
                        window.location.href = 'instructor_rooms.php'; // Redirect back to rooms page
                    }
                });
            }
        });
    </script>
</body>
</html>
