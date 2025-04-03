<?php
// Start the session to check if the user is logged in
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: User_Login.php');
    exit();
}
// comment
// Include database connection file
include('../Admin/db_connect.php'); // Ensure this file has the correct database connection details

$message = ""; // To store success or error message

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate input fields
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Insert into database
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message);
        
        if ($stmt->execute()) {
            $message = "success"; // Store success message
        } else {
            $message = "error"; // Store error message
        }
        
        $stmt->close();
    } else {
        $message = "empty"; // Store empty field message
    }
}

// Include the header
include('Navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="Contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="contact-section">
        <h2><i class="fas fa-envelope"></i> Get in Touch</h2>
        
        <div class="contact-info">
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Our Location</h3>
                <p>123 Business Street, City, Country</p>
            </div>
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <h3>Phone Number</h3>
                <p>+1 234 567 890</p>
            </div>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <h3>Email Address</h3>
                <p>contact@example.com</p>
            </div>
            <div class="info-item">
                <i class="fas fa-clock"></i>
                <h3>Working Hours</h3>
                <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
            </div>
        </div>

        <form action="Contact.php" method="POST">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name">
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email address">
            </div>
            <div class="form-group">
                <label for="message"><i class="fas fa-comment"></i> Message</label>
                <textarea id="message" name="message" rows="5" required placeholder="Enter your message here..."></textarea>
            </div>
            <input type="submit" value="Send Message">
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($message == "success") { ?>
                Swal.fire({
                    title: "Success!",
                    text: "Your message has been sent successfully!",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            <?php } elseif ($message == "error") { ?>
                Swal.fire({
                    title: "Error!",
                    text: "Something went wrong. Please try again.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            <?php } elseif ($message == "empty") { ?>
                Swal.fire({
                    title: "Warning!",
                    text: "Please fill all fields!",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
            <?php } ?>
        });
    </script>
</body>
</html>
