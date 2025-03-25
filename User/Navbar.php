<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="Navbar.css">
    <script>
                document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.getElementById("menu-toggle");
            const menu = document.getElementById("menu");
            const overlay = document.getElementById("overlay");

            // Function to toggle menu
            function toggleMenu() {
                menu.classList.toggle("active");
                overlay.classList.toggle("active");
            }

            // Click event to open/close menu
            menuToggle.addEventListener("click", toggleMenu);
            overlay.addEventListener("click", toggleMenu);
        });

    </script> <!-- JavaScript for toggle menu -->
</head>
<body>

    <!-- Overlay when mobile menu is active -->
    <div class="overlay" id="overlay"></div>

    <!-- Navbar -->
    <div class="navbar">
        <!-- Toggle Button for Mobile -->
        <button class="menu-toggle" id="menu-toggle">&#9776;</button>

        <!-- Website Title -->
        <h1 class="title">WHAT YOU WANT</h1>

        <!-- Navigation Links -->
        <ul id="menu">
            <li><a href="User_Home.php">Home</a></li>
            <li><a href="Profile.php">Profile</a></li>
            <li><a href="Workers.php">Find a Worker</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <li><a href="Report.php">Report</a></li>
            <li><a href="About_us.php">About</a></li>
        </ul>

        <!-- Profile Icon -->
        <div class="profile-container">
            <img src="profile-icon.png" alt="Profile" class="profile-icon">
        </div>
    </div>

</body>
</html>
