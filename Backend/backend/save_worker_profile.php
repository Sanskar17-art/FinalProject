<?php
// Start the session if needed
session_start();

include 'connection.php';

// Check if the user is logged in or not
if (!isset($_SESSION['worker_id'])) {
    header("Location: login.php");
    exit();
}

// Get the worker ID from the session (or pass it via a hidden field)
$worker_id = $_SESSION['worker_id'];

// Sanitize and collect form data
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$mobile = $_POST['mobile'];
$gender = $_POST['gender'];
$experience = $_POST['experience'];
$qualification = $_POST['qualification'];
$profession = $_POST['profession'];
$experience_level = $_POST['experience_level'];
$languages = $_POST['languages'];

// Handle profile photo upload
$profile_photo = $_FILES['profile-photo']['name'];
$profile_photo_tmp = $_FILES['profile-photo']['tmp_name'];
$profile_photo_path = "uploads/" . basename($profile_photo);

// Handle certificate upload (optional)
$certificate = $_FILES['certificate']['name'];
$certificate_tmp = $_FILES['certificate']['tmp_name'];
$certificate_path = "uploads/" . basename($certificate);

// Move uploaded files to the 'uploads' directory
if ($profile_photo) {
    move_uploaded_file($profile_photo_tmp, $profile_photo_path);
}

if ($certificate) {
    move_uploaded_file($certificate_tmp, $certificate_path);
}

// Prepare the SQL query for updating the worker's profile
$query = "UPDATE workers SET name = ?, email = ?, address = ?, mobile = ?, gender = ?, experience = ?, qualification = ?, profession = ?, experience_level = ?, languages = ?, profile_photo = ?, certificate = ? WHERE worker_id = ?";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind parameters to the query
$stmt->bind_param("ssssssssssssi", $name, $email, $address, $mobile, $gender, $experience, $qualification, $profession, $experience_level, $languages, $profile_photo, $certificate, $worker_id);

// Execute the query
if ($stmt->execute()) {
    // Redirect back to the profile page or a success page
    header("Location: Worker_Profile.php?success=1");
    exit();
} else {
    // Handle failure
    echo "Error updating profile: " . $stmt->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>