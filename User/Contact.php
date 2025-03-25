<?php
// Start the session to check if the user is logged in
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: User_Login.php');
    exit();
}

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
    <link rel="stylesheet" href="../CSS/Report.css">
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="contact-section">
        <h2>Get in Touch</h2>
        <center>
        <form action="Contact.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <input type="submit" value="Submit Message">
        </form>
        </center>
    </div>

    <!-- JavaScript for SweetAlert Popups -->
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
