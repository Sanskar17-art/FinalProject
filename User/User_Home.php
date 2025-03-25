<?php
session_start();  // Start the session to access user data

// Check if the user is logged in by checking session variables
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Retrieve user email from session
$user_email = $_SESSION['user_email'];
$user_id = $_SESSION['user_id'];
include('Navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <link rel="stylesheet" href="CSS/User_Home.css">
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome, <?php echo $user_email; ?>!</h1>
        <p>You have successfully logged in.</p>
        <p>User ID: <?php echo $user_id; ?></p>

        <!-- Optionally add a logout link -->
        <a href="logout.php">Log Out</a>
    </div>
</body>
</html>
