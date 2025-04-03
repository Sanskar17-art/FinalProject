<?php 
session_start(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $username = $_POST['username']; 
    $password = $_POST['password']; 
    $conn = new mysqli('localhost', 'root', '', 'project'); 
    if ($conn->connect_error) { 
        die('Connection failed: ' . $conn->connect_error); 
    } 
    $sql = "SELECT * FROM users WHERE email = ? OR phone = ?"; 
    $stmt = $conn->prepare($sql); 
    if ($stmt === false) { 
        die('Error preparing statement: ' . $conn->error); 
    } 
    $stmt->bind_param('ss', $username, $username); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 
    if ($result->num_rows > 0) { 
        $user = $result->fetch_assoc(); 
        if (password_verify($password, $user['password'])) { 
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['user_email'] = $user['email']; 
            header('Location: /FinalProject/User_Home.php'); 
            exit(); 
        } else { 
            echo "<script>alert('Incorrect password. Please try again.');</script>"; 
        } 
    } else { 
        echo "<script>alert('No account found with this email or phone. Please sign up first.');</script>"; 
    } 
    $stmt->close(); 
    $conn->close(); 
} 
?>
