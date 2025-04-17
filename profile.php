<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - Room Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: white;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .container {
            background-color: #fff;
            padding: 30px 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #0072ff;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        p {
            font-size: 1.2em;
            margin: 15px 0;
        }
        .profile-info {
            background: linear-gradient(to right, #28a745, #0072ff);
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-info p {
            font-size: 1.1em;
            margin-bottom: 10px;
        }
        .back-button {
            padding: 12px 30px;
            background-color: #0072ff;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 25px;
            margin-top: 20px;
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
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 80%;
            }
        }
    </style>
</head>
<body>
<div class="logo-header">
        <img src="bsu.png" alt="BSU Logo">
    </div>

    <div class="container">
        <h1>User Profile</h1>

        <div class="profile-info">
            
            <p><strong>Name:</strong> John Doe</p>
            <p><strong>Email:</strong> johndoe@example.com</p>
            <p><strong>Role:</strong> Student</p>
        </div>

        
        <a href="dashboard.php" class="back-button">Back to Dashboard</a>
    </div>

</body>
</html>
