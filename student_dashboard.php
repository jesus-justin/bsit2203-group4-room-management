<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dash.css">
</head>
<body>
    <nav class="navbar">
        <div class="dropdown-container">
            <button onclick="toggleDropdown()" class="dropdown-btn">Menu</button>
            <div id="dropdownMenu" class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="rooms.php">Rooms</a>
                <a href="about_us.php">About Us</a>
                <a href="feedback.php">Feedback</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="overview">
    <h1>ReServeU: BatStateU - Lipa Campus Room Management System</h1>

    <p>Welcome to the ReServeU, a room management system for Batangas State University Lipa Campus. This advanced platform has been developed to address the everyday challenges of room management on campus. The system is designed to help students, faculty, and staff easily reserve rooms, check availability, and plan their schedules with ease and efficiency. The goal is to provide a seamless and transparent experience in managing room reservations, ensuring that everyone knows the status of rooms at all times.</p>

        <h3>Goal:</h3>
        <p>The ReServeU aims to optimize the way rooms are used on the Batangas State University Lipa Campus. With the system, users can:</p>
        <ul>
            <li><strong>Quickly check room availability:</strong> Students and instructors no longer need to make phone calls or physically check the status of rooms. The system shows real-time updates about whether a room is vacant, occupied, or unavailable.</li>
            <li><strong>Ensure fair access:</strong> By making room availability transparent, the system guarantees that all students and faculty have equal access to reserve rooms based on their needs and availability.</li>
            <li><strong>Save time:</strong> The system eliminates the need for back-and-forth communication or physical visits to the administrative office to confirm room reservations, helping users to book rooms quickly and efficiently.</li>
        </ul>
        <p>Ultimately, the goal of this system is to streamline campus operations and improve the overall experience of managing and using campus rooms for academic and non-academic purposes.</p>
    
        <h3>Key Features and Functions:</h3>
        <p>To enhance user experience, the system includes the following core features:</p>
        <ul>
            <li><strong>Schedule Reservation:</strong> Easily view and reserve available rooms. Users can select a room based on their needs (classroom, meeting room, etc.), check the availability, and book the room for a specific time period. The system ensures that rooms are booked without double-booking conflicts.</li>
            <li><strong>Feedback:</strong> After using a room or completing a reservation, users can submit feedback. This helps the system administrators identify potential issues with rooms (such as maintenance needs), assess room usage patterns, and continuously improve the overall room reservation process. Feedback from users is essential to fine-tuning the system and addressing concerns promptly.</li>
        </ul>
    
        <h3>Benefits of Using the Room Management System:</h3>
        <p>This system brings numerous advantages to the Batangas State University Lipa Campus, both for students and faculty members:</p>
        <ul>
            <li><strong>Increased Efficiency:</strong> The automated system significantly reduces the time required to find and reserve rooms. No more waiting in line or emailing back and forth with administrators. Everything can be done online in real-time.</li>
            <li><strong>Improved Transparency:</strong> Room availability is clearly displayed, so users know exactly when a room is available or already reserved. The system helps eliminate confusion and prevents scheduling conflicts.</li>
            <li><strong>Better Planning:</strong> With the ability to plan ahead, students and instructors can better organize their schedules. No more uncertainty about room availability or last-minute cancellations. Users can book rooms with confidence, knowing the system provides up-to-date information.</li>
            <li><strong>Convenient Access:</strong> The system is available 24/7, providing users the flexibility to check room availability or make reservations at any time, from anywhere. This increases accessibility and ensures that rooms are always accessible when needed.</li>
            <li><strong>Real-Time Updates:</strong> Changes in room status are reflected in real-time, ensuring that users have the most current information. If a room becomes unavailable due to maintenance, this is updated immediately on the system.</li>
            <li><strong>Effective Resource Utilization:</strong> By making room reservations transparent and well-managed, the system ensures that rooms are used efficiently, preventing overcrowding and underutilization of resources.</li>
        </ul>
    </div>

    <script>
        function toggleDropdown() {
            const menu = document.getElementById("dropdownMenu");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-btn')) {
                const dropdowns = document.getElementsByClassName("dropdown-content");
                for (let i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>