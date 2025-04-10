<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            text-align: center;
            padding-top: 50px;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        h1 {
            color: white;
            font-size: 3.5em;
            margin-bottom: 40px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }
        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .button-container a {
            display: inline-block;
            padding: 25px 50px;
            background-color: #0072ff;
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2em;
            border-radius: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .button-container a:hover {
            background-color: #0056c1;
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        .button-container a:active {
            transform: translateY(2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .button-container a:nth-child(1) {
            background-color: #28a745;
        }
        .button-container a:nth-child(1):hover {
            background-color: #218838;
        }
        .button-container a:nth-child(2) {
            background-color: #ffc107;
        }
        .button-container a:nth-child(2):hover {
            background-color: #e0a800;
        }
        .button-container a:nth-child(3) {
            background-color: #dc3545;
        }
        .button-container a:nth-child(3):hover {
            background-color: #c82333;
        }
        @media (max-width: 768px) {
            .button-container a {
                padding: 20px 40px;
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <h1>Welcome to Your Dashboard</h1>
    <div class="button-container">
        <a href="profile.php">Profile</a>
        <a href="room.php">Rooms</a>
        <a href="overview.php">Overview</a>
    </div>
</body>
</html>
