
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $address = $_POST['address'];

    // Profile photo handling (check if a photo is uploaded)
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

    // Prepare SQL query to insert data into the database
    $sql = "INSERT INTO users (name, email, phone, password, address, profile_photo) VALUES (?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Bind the parameters
    // 'sssssb' means:
    // - s for string (for name, email, phone, password, and address)
    // - b for blob (binary data for the profile photo)
    $stmt->bind_param("sssssb", $name, $email, $phone, $password, $address, $photo);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to user home page after successful signup
        header('Location: /FinalProject/User_Login.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
 

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
