<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, password_hash($_POST['password'], PASSWORD_DEFAULT));
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $profession = mysqli_real_escape_string($conn, $_POST['Profession']);
    $experience_level = mysqli_real_escape_string($conn, $_POST['experience_level']);
    $languages = mysqli_real_escape_string($conn, $_POST['languages']);

    $profilePhotoPath = '';
    $certificatePath = '';

    if (!empty($_FILES['profile_photo']['name'])) {
        $profilePhotoPath = 'uploads/' . basename($_FILES['profile_photo']['name']);
        move_uploaded_file($_FILES['profile_photo']['tmp_name'], $profilePhotoPath);
    }

    if (!empty($_FILES['certificate']['name'])) {
        $certificatePath = 'uploads/' . basename($_FILES['certificate']['name']);
        move_uploaded_file($_FILES['certificate']['tmp_name'], $certificatePath);
    }

    $sql = "INSERT INTO workers (name, email, password, address, mobile, gender, experience, qualification, profession, experience_level, languages, profile_photo, certificate) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("sssssssssssss", $name, $email, $password, $address, $mobile, $gender, $experience, $qualification, $profession, $experience_level, $languages, $profilePhotoPath, $certificatePath);

    if ($stmt->execute()) {
        header('Location: /FinalProject/Worker_Home.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($conn);
}
?>
