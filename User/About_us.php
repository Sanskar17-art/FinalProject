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
    <link rel="stylesheet" type="text/css" href="About_us.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="about-section">
        <div class="about-header">
            <h2><i class="fas fa-info-circle"></i> About Us</h2>
            <p class="subtitle">Your Trusted Partner in Quality Products</p>
        </div>
        
        <div class="about-content">
            <div class="about-card">
                <div class="icon-wrapper">
                    <i class="fas fa-star"></i>
                </div>
                <h3>Our Mission</h3>
                <p>Our mission is to deliver exceptional quality products and provide outstanding customer service. We believe in innovation, excellence, and customer satisfaction.</p>
            </div>

            <div class="about-card">
                <div class="icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Our Team</h3>
                <p>We have a passionate team of professionals who are committed to making your experience amazing. Our team is always here to help you with any inquiries you may have.</p>
            </div>

            <div class="about-card">
                <div class="icon-wrapper">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Our Values</h3>
                <p>We believe in building lasting relationships with our customers through trust, transparency, and dedication to quality. Your satisfaction is our top priority.</p>
            </div>

            <div class="about-card">
                <div class="icon-wrapper">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Our Vision</h3>
                <p>To be the leading provider of quality products and services, setting new standards in customer satisfaction and industry innovation.</p>
            </div>
        </div>

        <div class="contact-section">
            <h3><i class="fas fa-envelope"></i> Get in Touch</h3>
            <p>Have questions? We'd love to hear from you!</p>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+1 234 567 890</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>contact@example.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>123 Business Street, City, Country</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
