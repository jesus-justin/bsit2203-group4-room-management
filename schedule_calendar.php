<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Room Reservation Calendar</title>
    <a href="dashboard.php" style="display: inline-block; margin-left:45%; text-decoration: none; font-size: 16px;">        ← Back to Dashboard</a>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            margin: 30px;
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        #calendar {
            max-width: 1200px;
            margin: auto;
        }
    </style>
</head>
<body>

<h1>Room Reservation Calendar</h1>
<div id="calendar"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        initialView: 'timeGridWeek',
        events: 'load_events.php', // Load dynamically via AJAX
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
