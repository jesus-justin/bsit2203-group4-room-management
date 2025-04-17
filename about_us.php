<?php
// about.php

// Dummy data variables
$companyName = "Your Company Name";
$yearFounded = "2021";
$whatYouDo = "designing user-friendly websites and digital experiences";
$mission = "to empower businesses with clean, modern, and efficient web solutions.";
$teamIntro = "We're a passionate group of developers, designers, and problem-solvers.";
$contactMessage = "Got a project in mind? Let's build something amazing together!";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - <?php echo $companyName; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>About Us</h1>
        <p>Welcome to <strong><?php echo $companyName; ?></strong>!</p>
        <p>Since <?php echo $yearFounded; ?>, we’ve been dedicated to <?php echo $whatYouDo; ?></p>
        
        <h2>Our Mission</h2>
        <p><?php echo $mission; ?></p>

        <h2>Who We Are</h2>
        <p><?php echo $teamIntro; ?></p>

        <h2>Let's Connect</h2>
        <p><?php echo $contactMessage; ?></p>
    </div>
</body>
</html>
