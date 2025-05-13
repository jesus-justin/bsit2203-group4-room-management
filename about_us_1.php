<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="about_us.css">
</head>
<body>
    <a class="logout-btn" href="logout.php">Logout</a>

    <header class="header">
        <a href=" student_dashboard.php " class="back-button">Dashboard</a>
        <h1 class="center-title">About Us</h1>
        <div style="width: 130px;"></div>
    </header>

    <section class="about-us">
        <div class="goal-section">
            <h3>Our Goal</h3>
            <p>
                The goal of this project is to create a system that helps students and teachers identify and locate classrooms 
                and manage occupancy status efficiently. By streamlining room assignments, occupancy tracking, and room status 
                updates, we aim to improve the overall campus experience.
            </p>
        </div>

        <div class="team-section">
            <h3>Our Team</h3>
            <div class="profile-container">
                <div class="profile">
                    <img src="angela.jpg" alt="Angela Gizelle Dayo">
                    <h3>Angela Gizelle Dayo</h3>
                </div>
                <div class="profile">
                    <img src="jm.jpg" alt="John Marie Diogracias">
                    <h3>John Marie Diogracias</h3>
                </div>
                <div class="profile">
                    <img src="mikey.jpg" alt="Mike John Marquez">
                    <h3>Mike John Marquez</h3>
                </div>
                <div class="profile">
                    <img src="justin.jpg" alt="Jesus Justin Mercado">
                    <h3>Jesus Justin Mercado</h3>
                </div>
                <div class="profile">
                    <img src="iris.jpg" alt="Iris Minette Napoles">
                    <h3>Iris Minette Napoles</h3>
                </div>
                <div class="profile">
                    <img src="pastor.jpg" alt="Paul Cedric Pastor">
                    <h3>Paul Cedric Pastor</h3>
                </div>
                <div class="profile">
                    <img src="rhendy.jpg" alt="Rhendel Ricohermoso">
                    <h3>Rhendel Ricohermoso</h3>
                </div>
            </div>
        </div>

        <div class="contact-section">
            <h2>Contact Us</h2>
            <p>
                Need to book a room or fix a scheduling issue? We’re here to help—just reach out, and we’ll make it easy for you!
            </p>
            <p class="contact-item">
                <i class="fas fa-envelope"></i>
                <strong>Email us:</strong> reserveu@gmail.com – Reach out for any inquiries, and we'll respond as soon as possible.
            </p>
            <p class="contact-item">
                <i class="fas fa-phone"></i>
                <strong>Call us:</strong> 09123456789 – Our team is available to assist you during office hours.
            </p>
            <p class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <strong>Visit us:</strong> 5th Floor TSB/CECS Building - Stop by the BSU administration office if you prefer in-person support.
            </p>
            <p>
                For quick guides and updates, check our Room Management Portal, where you can find instructions, FAQs, and the latest 
                system enhancements. Making room reservations should be simple, and we’re here to make sure it stays that way.
            </p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 ReServeU. All rights reserved.</p>
    </footer>
</body>
</html>
