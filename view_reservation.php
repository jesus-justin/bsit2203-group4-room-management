<?php 
include 'database.php'; 

$db = new Database();
$conn = $db->getConnect();

// Handle search and filter input
$search = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM reservation WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND username LIKE :search";
    $params[':search'] = "%$search%";
}
if (!empty($statusFilter)) {
    $sql .= " AND status = :status";
    $params[':status'] = $statusFilter;
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reservations</title>
    <link rel="stylesheet" href="view_reserve.css">
    <!-- <style>
        /* body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .search-filter-wrapper {

            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: flex-end;
            position: absolute;
            top: 50px;
            right: 20px;
            z-index: 100;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input[type="text"] {
            width: 100%;
            padding: 8px 35px 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-box button {
            position: absolute;
            right: 5px;
            top: 5px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            padding: 0;
        }

        .filter-dropdown {
            position: relative;
        }

        .filter-dropdown select {
            padding: 8px 25px 8px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            appearance: none;
            background-color: white;
            background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSaxmDtsdkYsDaSCyS4rA6XEBpgcrz8zi5Efw&s');
            background-size: 16px;
            background-repeat: no-repeat;
            background-position: right 8px center;
        } */
    </style> -->
</head>
<body>

    <h2>All Reservations</h2>

    <!-- Right-Aligned Search + Filter -->
    <form method="GET" class="search-filter-wrapper">
        <div class="search-box">
            <input type="text" name="search" placeholder="Search for kyutness" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" title="Search" class="search-submit">🔍</button>
        </div>
        <div class="filter-dropdown">
            <select name="status" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="Pending" <?= $statusFilter === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Approved" <?= $statusFilter === 'Approved' ? 'selected' : '' ?>>Approved</option>
                <option value="Rejected" <?= $statusFilter === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>
        </div>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room ID</th>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Building</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($results) {
                    foreach ($results as $row) {
                        echo "<tr>
                                <td>{$row['reservation_id']}</td>
                                <td>{$row['room_id']}</td>
                                <td>{$row['user_id']}</td>
                                <td>{$row['first_name']}</td>
                                <td>{$row['last_name']}</td>
                                <td>{$row['building_name']}</td>
                                <td>{$row['reservation_date']}</td>
                                <td>{$row['reservation_time']}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['description']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No reservations found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <form action="insert_reservation.php" method="get" style="margin-top: 10px;">
        <button type="submit" class="main-action-button">Add Reservation</button>   
    </form>


</body>
</html>
