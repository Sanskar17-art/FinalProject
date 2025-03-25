<?php
// Start the session to check if the user is logged in
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: User_Login.php');
    exit();
}

// Include the header
include('Navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="About_us.css">
</head>
<body>
    <div class="about-section">
        <h2>Welcome to Our Website</h2>
        <p>We are a team dedicated to providing the best products and services for our customers. Our mission is to make your experience with us enjoyable and memorable.</p>
        <h3>Our Mission</h3>
        <p>Our mission is to deliver exceptional quality products and provide outstanding customer service. We believe in innovation, excellence, and customer satisfaction.</p>
        <h3>Our Team</h3>
        <p>We have a passionate team of professionals who are committed to making your experience amazing. Our team is always here to help you with any inquiries you may have.</p>
    </div>
</body>
</html>
