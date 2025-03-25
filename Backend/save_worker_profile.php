<?php
// Start the session if needed
session_start();

include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['worker_id'])) {
    header("Location: ../Worker_Login.php");
    exit();
}

// Get the worker ID
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

// Get existing profile photo and certificate from the database
$query = "SELECT profile_photo, certificate FROM workers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $worker_id);
$stmt->execute();
$stmt->bind_result($existingProfilePhoto, $existingCertificate);
$stmt->fetch();
$stmt->close();

// Handle profile photo upload (only update if a new file is uploaded)
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
    $filename = time() . "_" . basename($_FILES['profile_photo']['name']);
    $tempname = $_FILES['profile_photo']['tmp_name'];
    $folder = 'uploads/' . $filename;

    if (move_uploaded_file($tempname, $folder)) {
        $profile_photo = $folder; // Save the file path
    } else {
        echo "Failed to upload profile photo.";
        exit();
    }
} else {
    $profile_photo = $existingProfilePhoto; // Keep existing photo if no new upload
}

// Handle certificate upload (only update if a new file is uploaded)
if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] == 0) {
    $pdfname = time() . "_" . basename($_FILES['certificate']['name']);
    $tempname = $_FILES['certificate']['tmp_name'];
    $folder = 'uploads/' . $pdfname;

    if (move_uploaded_file($tempname, $folder)) {
        $certificate = $folder; // Save the file path
    } else {
        echo "Failed to upload certificate.";
        exit();
    }
} else {
    $certificate = $existingCertificate; // Keep existing certificate if no new upload
}

// Prepare the SQL query for updating the worker's profile
$query = "UPDATE workers SET name = ?, email = ?, address = ?, mobile = ?, gender = ?, experience = ?, qualification = ?, profession = ?, experience_level = ?, languages = ?, profile_photo = ?, certificate = ? WHERE id = ?";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind parameters to the query
$stmt->bind_param("ssssssssssssi", $name, $email, $address, $mobile, $gender, $experience, $qualification, $profession, $experience_level, $languages, $profile_photo, $certificate, $worker_id);

// Execute the query
if ($stmt->execute()) {
    // Redirect back to the profile page or a success page
    header("Location: ../Worker_Home.php");
    exit();
} else {
    // Handle failure
    echo "Error updating profile: " . $stmt->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
