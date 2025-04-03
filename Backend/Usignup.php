<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['password']) || !isset($_POST['address'])) {
        die('All fields are required');
    }
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $address = $_POST['address'];

    // Validate phone number format
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        die('Invalid phone number format. Please enter a 10-digit number.');
    }
    
    $photo = null;
    if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] == 0) {
        $photo = file_get_contents($_FILES['profilePhoto']['tmp_name']);
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'project');
    
    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $sql = "INSERT INTO users (name, email, phone, password, address, profile_photo) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("sssssb", $name, $email, $phone, $password, $address, $photo);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to user home page after successful signup
        header('Location:/FinalProject/User_Login.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
