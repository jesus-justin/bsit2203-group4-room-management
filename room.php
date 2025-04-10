<?php
function generateRooms($building, $floors, $roomsPerFloor) {
    echo "<h2>$building</h2><ul>";
    for ($floor = 1; $floor <= $floors; $floor++) {
        for ($room = 1; $room <= $roomsPerFloor; $room++) {
            $roomNum = $floor . str_pad($room, 2, '0', STR_PAD_LEFT);
            echo "<li>Room $roomNum (Floor $floor)</li>";
        }
    }
    echo "</ul>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fb;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }
        h1 {
            color: #0072ff;
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #0056c1;
            font-size: 2em;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        li {
            background-color: #fff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        li:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .back-button {
            padding: 12px 30px;
            background-color: #0072ff;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 25px;
            margin-top: 20px;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .back-button:hover {
            background-color: #0056c1;
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .back-button:active {
            transform: translateY(2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <!-- Back Button -->
    <a href="dashboard.php" class="back-button">Back to Dashboard</a>

    <h1>Room Listing by Building</h1>

    <?php
        generateRooms('CICS/TSB', 5, 4);
        generateRooms('HEB/VMB', 5, 4);
        generateRooms('GZB', 4, 4);
        generateRooms('OB', 5, 4);
    ?>

</body>
</html>
