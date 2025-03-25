<?php
session_start();  // Start the session to store user data if logged in

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $username = $_POST['username'];  // This can be email or phone
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'project');

    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Prepare SQL query to check if the user exists (search by email or phone)
    $sql = "SELECT * FROM users WHERE email = ? OR phone = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param('ss', $username, $username);  // Bind username to both email and phone columns
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch user data from the database
        $user = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($password, $user['password'])) {
            // Password is correct, login successful
            $_SESSION['user_id'] = $user['id'];  // Store user ID in session
            $_SESSION['user_email'] = $user['email'];  // Store user email in session

            // Redirect to home page
            header('Location: /FinalProject/User_Home.php');
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        // User does not exist in the database
        echo "<script>alert('No account found with this email or phone. Please sign up first.');</script>";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
