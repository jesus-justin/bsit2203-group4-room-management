<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dash-beta-notsure.css">
</head>
<body>
    <nav class="navbar">
        <div class="dropdown-container">
            <button onclick="toggleDropdown()" class="dropdown-btn">Menu ☰</button>
            <div id="dropdownMenu" class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="rooms.php">Rooms</a>
                <a href="overview.php">Overview</a>
                <a href="about_us.php">About Us</a>
            </div>
        </div>
    </nav>

    <h1>Welcome to Your Dashboard</h1>

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
