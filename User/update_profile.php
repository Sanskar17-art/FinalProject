<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    die('Unauthorized access');
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get user input
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$email = $_SESSION['user_email']; // User email from session

// File upload handling
if (!empty($_FILES['profile_photo']['name'])) {
    $imageData = file_get_contents($_FILES['profile_photo']['tmp_name']);
    $sql = "UPDATE users SET name=?, phone=?, address=?, profile_photo=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $phone, $address, $imageData, $email);
} else {
    $sql = "UPDATE users SET name=?, phone=?, address=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $phone, $address, $email);
}

// Execute query
if ($stmt->execute()) {
    echo "Profile updated successfully!";
} else {
    echo "Error updating profile: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
