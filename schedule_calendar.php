<?php
require_once 'check_session.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnect();

$user_id = $_SESSION['user']['user_id'] ?? '';
$first_name = $_SESSION['user']['first_name'] ?? '';
$last_name = $_SESSION['user']['last_name'] ?? '';
$role = $_SESSION['user']['role'] ?? '';

// Fetch all buildings for the dropdown
$buildingStmt = $conn->prepare("SELECT building_id, building_name FROM buildings ORDER BY building_name");
$buildingStmt->execute();
$buildings = $buildingStmt->fetchAll(PDO::FETCH_ASSOC);

// Get selected building and room (if available)
$building_id = $_GET['building_id'] ?? null;
$room_id = $_GET['room_id'] ?? null;
$room_name = '';
$building_name = '';

// Fetch rooms if a building is selected
$rooms = [];
if ($building_id) {
    $roomsStmt = $conn->prepare("SELECT room_id, room_name FROM rooms WHERE building_id = ? ORDER BY room_name");
    $roomsStmt->execute([$building_id]);
    $rooms = $roomsStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get the room details if room_id is set
if ($room_id) {
    $roomStmt = $conn->prepare("SELECT r.room_name, b.building_name FROM rooms r JOIN buildings b ON r.building_id = b.building_id WHERE r.room_id = ?");
    $roomStmt->execute([$room_id]);
    $roomData = $roomStmt->fetch(PDO::FETCH_ASSOC);
    if ($roomData) {
        $room_name = $roomData['room_name'];
        $building_name = $roomData['building_name'];
    }
}

// Fetch reservations for the selected room or building
$reservations = [];
if ($room_id) {
    // Get reservations for a specific room
    $reservationsStmt = $conn->prepare("
        SELECT 
            reservation_id,
            first_name,
            last_name,
            reservation_date,
            start_time,
            end_time,
            description,
            status
        FROM reservation
        WHERE room_id = ?
        ORDER BY reservation_date, start_time
    ");
    $reservationsStmt->execute([$room_id]);
} else if ($building_id) {
    // Get reservations for all rooms in the selected building
    $reservationsStmt = $conn->prepare("
        SELECT 
            r.reservation_id,
            r.first_name,
            r.last_name,
            r.reservation_date,
            r.start_time,
            r.end_time,
            r.description,
            r.status,
            rm.room_name
        FROM reservation r
        JOIN rooms rm ON r.room_id = rm.room_id
        WHERE rm.building_id = ?
        ORDER BY r.reservation_date, r.start_time
    ");
    $reservationsStmt->execute([$building_id]);
} else {
    // If no specific room or building is selected, get all reservations
    $reservationsStmt = $conn->prepare("
        SELECT 
            r.reservation_id,
            r.first_name,
            r.last_name,
            r.reservation_date,
            r.start_time,
            r.end_time,
            r.description,
            r.status,
            rm.room_name,
            b.building_name
        FROM reservation r
        JOIN rooms rm ON r.room_id = rm.room_id
        JOIN buildings b ON rm.building_id = b.building_id
        ORDER BY r.reservation_date, r.start_time
    ");
    $reservationsStmt->execute();
}

$reservations = $reservationsStmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare events for FullCalendar
$events = [];
foreach ($reservations as $res) {
    $date = $res['reservation_date'];
    $start = $date . 'T' . $res['start_time'];
    $end = $date . 'T' . $res['end_time'];
    
    $title = isset($res['room_name']) 
        ? $res['room_name'] . ': ' . $res['first_name'] . ' ' . $res['last_name']
        : $res['first_name'] . ' ' . $res['last_name'];
        
    // Add building name if available
    if (isset($res['building_name'])) {
        $title = $res['building_name'] . ' - ' . $title;
    }
    
    // Set color based on status
    $color = '#3788d8'; // Default blue
    if (isset($res['status'])) {
        switch ($res['status']) {
            case 'Confirmed':
                $color = '#4caf50'; // Green
                break;
            case 'Pending':
                $color = '#ff9800'; // Orange
                break;
            case 'Cancelled':
                $color = '#f44336'; // Red
                break;
        }
    }
    
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

// If no reservations, set a flag to show the popup
$no_reservation_message = empty($events) ? 'There are no reservations for this room.' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Schedule</title>
    <link rel="stylesheet" href="schedule_calendar.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <a class="logout-btn" href="logout.php">Logout</a>

    <header class="header">
        <a href="instructor_dashboard.php" class="back-button">Dashboard</a>
        <h1 class="center-title">Schedule</h1>
        <div style="width: 100px;"></div>
    </header>
        
        <?php if ($room_id && $room_name): ?>
        <div class="room-info">
            <h2>Viewing Schedule for: <?= htmlspecialchars($room_name) ?></h2>
            <p>Building: <?= htmlspecialchars($building_name) ?></p>
        </div>
        <?php endif; ?>
        
        <section class="filter-section">
            <h2>Select Room to View Schedule</h2>
            <div class="filter-row">
                <div class="filter-group">
                    <label for="buildingSelect">Building:</label>
                    <select id="buildingSelect" onchange="window.location.href = '?building_id=' + this.value;">
                        <option value="">-- Select Building --</option>
                        <?php foreach ($buildings as $building): ?>
                        <option value="<?= $building['building_id'] ?>" <?= isset($_GET['building_id']) && $_GET['building_id'] == $building['building_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($building['building_name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="roomSelect">Room:</label>
                    <select id="roomSelect" onchange="window.location.href = '?room_id=' + this.value;">
                        <option value="">-- Select Room --</option>
                        <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room['room_id'] ?>" <?= isset($_GET['room_id']) && $_GET['room_id'] == $room['room_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($room['room_name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </section>
        
        <!-- Calendar container -->
        <div id="calendar-container">
            <div class="calendar-header">
                <h2 class="calendar-title" id="calendar-title">
                    Reservation Schedule for <?= $room_name ?: 'All Rooms in ' . $building_name ?>
                </h2>
            </div>
            <div id="calendar"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
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
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                events: <?= json_encode($events) ?>,
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

            // Show a popup if there are no reservations
            <?php if ($no_reservation_message): ?>
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
