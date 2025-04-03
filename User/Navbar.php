 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="Navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="navbar">
        <div class="logo-section">
            <i class="fas fa-shopping-bag"></i>
            <h1 class="title">WHAT YOU WANT</h1>
        </div>
        <ul class="nav-links">
            <li><a href="User_Home.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="Profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="Contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            <li><a href="About_us.php"><i class="fas fa-info-circle"></i> About</a></li>
            <li><a href="logout.php" class="logout-btn" onclick="event.preventDefault(); window.location.href='../User/Logout.php';"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>

    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });
    </script>
</body>
</html>
