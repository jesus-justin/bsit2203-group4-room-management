<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Overview</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fb;
            padding: 30px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            line-height: 1.8;
        }
        h2 {
            color: #0072ff;
            font-size: 2.8em;
            margin-bottom: 30px;
            text-align: center;
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.1);
            font-weight: bold;
        }
        p {
            font-size: 1.2em;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            max-width: 900px;
        }
        .goal, .functions, .benefits {
            margin-bottom: 30px;
        }
        .goal h3, .functions h3, .benefits h3 {
            color: #0056c1;
            font-size: 2.2em;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .functions ul, .benefits ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            font-size: 1.2em;
        }
        .functions li, .benefits li {
            background-color: #0072ff;
            color: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            text-align: left;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .back-button {
            padding: 15px 40px;
            background-color: #0072ff;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 25px;
            margin-bottom: 30px;
            transition: background-color 0.3s, transform 0.3s;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .back-button:hover {
            background-color: #0056c1;
            transform: translateY(-5px);
        }
        .back-button:active {
            transform: translateY(2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        ul li {
            margin-left: 20px;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <a href="dashboard.php" class="back-button">Back to Dashboard</a>

    <h2>Room Management System Overview</h2>

    <p>Welcome to the **Room Management System** for Batangas State University Lipa Campus. This advanced platform has been developed to address the everyday challenges of room management on campus. The system is designed to help students, faculty, and staff easily reserve rooms, check availability, and plan their schedules with ease and efficiency. The goal is to provide a seamless and transparent experience in managing room reservations, ensuring that everyone knows the status of rooms at all times.</p>

    <div class="goal">
        <h3>Goal of the Room Management System:</h3>
        <p>The **Room Management System** aims to optimize the way rooms are used on the Batangas State University Lipa Campus. With the system, users can:</p>
        <ul>
            <li><strong>Quickly check room availability:</strong> Students and instructors no longer need to make phone calls or physically check the status of rooms. The system shows real-time updates about whether a room is vacant, occupied, or unavailable.</li>
            <li><strong>Ensure fair access:</strong> By making room availability transparent, the system guarantees that all students and faculty have equal access to reserve rooms based on their needs and availability.</li>
            <li><strong>Save time:</strong> The system eliminates the need for back-and-forth communication or physical visits to the administrative office to confirm room reservations, helping users to book rooms quickly and efficiently.</li>
        </ul>
        <p>Ultimately, the goal of this system is to streamline campus operations and improve the overall experience of managing and using campus rooms for academic and non-academic purposes.</p>
    </div>

    <div class="functions">
        <h3>Key Features and Functions:</h3>
        <p>To enhance user experience, the system includes the following core features:</p>
        <ul>
            <li><strong>Schedule Reservation:</strong> Easily view and reserve available rooms. Users can select a room based on their needs (classroom, meeting room, etc.), check the availability, and book the room for a specific time period. The system ensures that rooms are booked without double-booking conflicts.</li>
            <li><strong>University Minimap:</strong> Navigate the campus with ease by using the integrated minimap feature. This interactive map allows users to locate rooms, departments, and other important facilities. New students and staff can use this feature to familiarize themselves with the campus layout, while returning students can quickly find rooms for their next class.</li>
            <li><strong>Feedback:</strong> After using a room or completing a reservation, users can submit feedback. This helps the system administrators identify potential issues with rooms (such as maintenance needs), assess room usage patterns, and continuously improve the overall room reservation process. Feedback from users is essential to fine-tuning the system and addressing concerns promptly.</li>
        </ul>
    </div>

    <div class="benefits">
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

</body>
</html>
