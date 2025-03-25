<?php
session_start();  // Start the session to store worker data if logged in

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $username = $_POST['username'];  // This can be email or phone
    $password = $_POST['password'];

    // Prepare SQL query to check if the worker exists (search by email or phone)
    $sql = "SELECT * FROM workers WHERE email = ? OR mobile = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param('ss', $username, $username);  // Bind username to both email and mobile columns
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if worker exists
    if ($result->num_rows > 0) {
        // Fetch worker data from the database
        $worker = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($password, $worker['password'])) {
            // Password is correct, login successful
            $_SESSION['worker_id'] = $worker['id'];  // Store worker ID in session
            $_SESSION['worker_email'] = $worker['email'];  // Store worker email in session

            // Redirect to backend worker home page
            header('Location: /FinalProject/Worker_Home.php');
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        // Worker does not exist in the database
        header('Location: /FinalProject/Worker_Signup.php');
        echo "<script>alert('No account found with this email or phone. Please sign up first.');</script>";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
