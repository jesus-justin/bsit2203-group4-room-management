<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Reservation Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('bsuu.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .header {
            background-color: transparent;
            padding: 20px;
        }

        .center-title {
            font-size: 36px;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.4);
            padding: 15px 30px;
            border-radius: 10px;
            margin: 30px auto 10px auto; /* Top, horizontal, and bottom margin */
            display: block;
            width: fit-content;
            text-align: center;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px;
            color: #2c3e50;
        }

        .back-button {
            text-decoration: none;
            color: black;
            font-size: 16px;
            padding: 10px 16px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 8px;
            position: absolute;
            left: 20px;
            top: 20px;
        }

        #calendar {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<header class="header">
    <a href="dashboard.php" class="back-button">Dashboard</a>
    <h1 class="center-title">Room Reservation Calendar</h1>
    <div style="width: 130px;"></div>
</header>
<div id="calendar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            initialView: 'timeGridWeek',
            events: 'load_events.php',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridDay,timeGridWeek'
            },
            slotMinTime: "07:00:00",
            slotMaxTime: "20:00:00",
            nowIndicator: true,
            timeZone: 'local',
            eventClick: function(info) {
                Swal.fire({
                    title: info.event.title,
                    html: `
                        <strong>Room:</strong> ${info.event.extendedProps.room}<br>
                        <strong>Description:</strong> ${info.event.extendedProps.description}<br>
                        <strong>Start:</strong> ${info.event.start.toLocaleString()}<br>
                        <strong>End:</strong> ${info.event.end.toLocaleString()}<br>
                        <strong>User:</strong> ${info.event.extendedProps.user}`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Update Status',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `admin_reservation.php?update=${info.event.id}`;
                    }
                });
            }
        });

        calendar.render();
    });
</script>

</body>
</html>
