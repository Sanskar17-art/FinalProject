<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';

// Collect form data with validation
$name = isset($_POST['name']) ? trim($_POST['name']) : null;
$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$password = isset($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_BCRYPT) : null;
$address = isset($_POST['address']) ? trim($_POST['address']) : null;
$mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : null;
$gender = isset($_POST['gender']) ? $_POST['gender'] : null;
$experience = isset($_POST['experience']) ? (int)$_POST['experience'] : 0;
$qualification = isset($_POST['qualification']) ? trim($_POST['qualification']) : null;
$profession = isset($_POST['profession']) ? $_POST['profession'] : null;
$experience_level = isset($_POST['experience_level']) ? $_POST['experience_level'] : null;
$languages = isset($_POST['languages']) ? trim($_POST['languages']) : null;

echo isset($_POST['experience_level']) ? $_POST['experience_level'] : null;

// Handle profile photo upload (storing as binary data)
$profile_photo = null;
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {

    $filename = $_FILES['profile_photo']['name'];
    $tempname = $_FILES['profile_photo']['tmp_name'];
    $folder = 'uploads/'.$filename;

    if (!move_uploaded_file($tempname, $folder)) {
        echo "Failed to upload profile photo.";
        exit();
    }


    // // Validate the file size
    // if ($_FILES['profile_photo']['size'] > 64 * 1024 * 1024) {
    //     echo "File size exceeds the maximum allowed size (64MB)";
    //     exit();
    // }

    // $profile_photo_tmp = $_FILES['profile_photo']['tmp_name'];
    // $profile_photo_data = file_get_contents($profile_photo_tmp);  // Read the image as binary data
    // $profile_photo = $profile_photo_data;  // Store the binary data
}

// Handle certificate upload (storing as binary data)
$certificate = null;
if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] == 0) {

    $pdfname = $_FILES['certificate']['name'];
    $tempname = $_FILES['certificate']['tmp_name'];
    $folder = 'uploads/'.$pdfname;

    if (!move_uploaded_file($tempname, $folder)) {
        echo "Failed to upload profile photo.";
        exit();
    }

    // // Validate the file size
    // if ($_FILES['certificate']['size'] > 64 * 1024 * 1024) {
    //     echo "Certificate size exceeds the maximum allowed size (64MB)";
    //     exit();
    // }

    // $certificate_tmp = $_FILES['certificate']['tmp_name'];
    // $certificate_data = file_get_contents($certificate_tmp);  // Read the certificate as binary data
    // $certificate = $certificate_data;  // Store the binary data
}

// SQL query to insert data
$sql = "INSERT INTO workers (name, email, password, address, mobile, gender, profile_photo, experience, qualification, profession, experience_level, certificate, languages)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters to the query (BLOB parameters should be passed as "b" for binary data)
$stmt->bind_param("sssssssssssss", $name, $email, $password, $address, $mobile, $gender, $filename, $experience, $qualification, $profession, $experience_level, $pdfname, $languages);

if ($stmt->execute()) {
    header('Location: /FinalProject/Worker_Login.php');
    echo "<script>alert('Worker Signed Up Successfully , Login Again...!');</script>";
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>