<?php
require_once 'check_session.php';
require_once 'database.php';



$db = new Database();
$conn = $db->getConnect();

$user = $_SESSION['user'] ?? [];
$user_id = $user['user_id'] ?? '';
$first_name = $user['first_name'] ?? '';
$last_name = $user['last_name'] ?? '';
$role = $user['role'] ?? '';

// Fetch all buildings
$buildingStmt = $conn->prepare("SELECT building_id, building_name FROM buildings ORDER BY building_name");
$buildingStmt->execute();
$buildings = $buildingStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle GET inputs
$building_id = $_GET['building_id'] ?? null;
$room_id = $_GET['room_id'] ?? null;
$room_name = '';
$building_name = '';
$rooms = [];

if ($role === 'student') {
    $dashboardLink = 'student_dashboard.php';
} elseif ($role === 'instructor') {
    $dashboardLink = 'instructor_dashboard.php';
} else {
    $dashboardLink = 'login.php';
}
// Get rooms for selected building
if ($building_id) {
    $roomsStmt = $conn->prepare("SELECT room_id, room_name FROM rooms WHERE building_id = ? ORDER BY room_name");
    $roomsStmt->execute([$building_id]);
    $rooms = $roomsStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get selected room and building name
if ($room_id) {
    $roomStmt = $conn->prepare("
        SELECT r.room_name, b.building_name 
        FROM rooms r 
        JOIN buildings b ON r.building_id = b.building_id 
        WHERE r.room_id = ?
    ");
    $roomStmt->execute([$room_id]);
    $roomData = $roomStmt->fetch(PDO::FETCH_ASSOC);
    if ($roomData) {
        $room_name = $roomData['room_name'];
        $building_name = $roomData['building_name'];
    }
}

// Fetch reservation data based on selection
if ($room_id) {
    $sql = "
        SELECT reservation_id, first_name, last_name, reservation_date, start_time, end_time, description, status 
        FROM reservation 
        WHERE room_id = ? 
        ORDER BY reservation_date, start_time
    ";
    $params = [$room_id];
} elseif ($building_id) {
    $sql = "
        SELECT r.reservation_id, r.first_name, r.last_name, r.reservation_date, r.start_time, r.end_time, r.description, r.status, rm.room_name 
        FROM reservation r 
        JOIN rooms rm ON r.room_id = rm.room_id 
        WHERE rm.building_id = ? 
        ORDER BY r.reservation_date, r.start_time
    ";
    $params = [$building_id];
} else {
    $sql = "
        SELECT r.reservation_id, r.first_name, r.last_name, r.reservation_date, r.start_time, r.end_time, r.description, r.status, rm.room_name, b.building_name 
        FROM reservation r 
        JOIN rooms rm ON r.room_id = rm.room_id 
        JOIN buildings b ON rm.building_id = b.building_id 
        ORDER BY r.reservation_date, r.start_time
    ";
    $params = [];
}

$reservationsStmt = $conn->prepare($sql);
$reservationsStmt->execute($params);
$reservations = $reservationsStmt->fetchAll(PDO::FETCH_ASSOC);

// Format reservations for FullCalendar
$events = [];
foreach ($reservations as $res) {
    $start = $res['reservation_date'] . 'T' . $res['start_time'];
    $end = $res['reservation_date'] . 'T' . $res['end_time'];
    $title = ($res['room_name'] ?? '') . ': ' . $res['first_name'] . ' ' . $res['last_name'];

    if (!empty($res['building_name'])) {
        $title = $res['building_name'] . ' - ' . $title;
    }

    // Set color based on status
    $status_colors = [
        'Confirmed' => '#4caf50',
        'Pending' => '#ff9800',
        'Cancelled' => '#f44336'
    ];
    $color = $status_colors[$res['status']] ?? '#3788d8';

    $events[] = [
        'id' => $res['reservation_id'],
        'title' => $title,
        'start' => $start,
        'end' => $end,
        'description' => $res['description'],
        'backgroundColor' => $color,
        'borderColor' => $color
    ];
}

$no_reservation_message = empty($events) ? 'There are no reservations for this room.' : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Schedule</title>
    <link rel="stylesheet" href="schedule_calendar.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <a class="logout-btn" href="logout.php">Logout</a>

    <header class="header">
        <a href="<?= $dashboardLink ?>" class="back-button">Dashboard</a>
        <h1 class="center-title">Schedule</h1>
    </header>

    
    <section class="filter-section">
        <h2>Select Room to View Schedule</h2>
        <div class="filter-row">
            <div class="filter-group">
                <label for="buildingSelect">Building:</label>
                <select id="buildingSelect" onchange="window.location.href = '?building_id=' + this.value;">
                    <option value="">-- Select Building --</option>
                    <?php foreach ($buildings as $building): ?>
                        <option value="<?= $building['building_id'] ?>" <?= $building_id == $building['building_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($building['building_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="roomSelect">Room:</label>
                <select id="roomSelect" onchange="window.location.href = '?building_id=<?= urlencode($building_id) ?>&room_id=' + this.value;">
                    <option value="">-- Select Room --</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room['room_id'] ?>" <?= $room_id == $room['room_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($room['room_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </section>

    

    <div id="calendar-container">

        <div class="calendar-header">
            <h2 class="calendar-title" id="calendar-title">
                Reservation Schedule for <?= htmlspecialchars($room_name ?: ($building_name ? "All Rooms in $building_name" : 'All Buildings')) ?>
            </h2>
        </div>
        <div class="legend">
            <div><span class="legend-box confirmed"></span> Confirmed</div>
            <div><span class="legend-box pending"></span> Pending</div>
            <div><span class="legend-box cancelled"></span> Cancelled</div>
        </div>
        <div id="calendar"></div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            slotMinTime: '07:00:00',
            slotMaxTime: '22:00:00',
            allDaySlot: false,
            height: 'auto',
            events: <?= json_encode($events) ?>,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            eventClick: function(info) {
                Swal.fire({
                    title: info.event.title,
                    html: `
                        <p><strong>Description:</strong> ${info.event.extendedProps.description}</p>
                        <p><strong>Start:</strong> ${info.event.start.toLocaleString()}</p>
                        <p><strong>End:</strong> ${info.event.end.toLocaleString()}</p>
                    `,
                    icon: 'info'
                });
            }
        });
        calendar.render();

        <?php if ($no_reservation_message && $room_id): ?>
        Swal.fire({
            title: 'No Reservations',
            text: '<?= $no_reservation_message ?>',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        <?php endif; ?>

    });
    </script>
</body>
</html>
