<?php
require_once 'check_session.php';
require_once 'database.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnect();

// Fetch confirmed reservations
$stmt = $conn->prepare("
    SELECT r.*, rm.room_name, u.first_name, u.last_name
    FROM reservation r
    JOIN rooms rm ON r.room_id = rm.room_id
    JOIN users u ON r.user_id = u.user_id
    WHERE r.status = 'Confirmed'
");
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$events = [];

foreach ($reservations as $res) {
    $events[] = [
        'id' => $res['reservation_id'],
        'title' => $res['description'],
        'start' => $res['reservation_date'] . 'T' . $res['start_time'],
        'end' => $res['reservation_date'] . 'T' . $res['end_time'],
        'extendedProps' => [
            'room' => $res['room_name'],
            'description' => $res['description'],
            'user' => $res['first_name'] . ' ' . $res['last_name']
        ]
    ];
}

echo json_encode($events);
