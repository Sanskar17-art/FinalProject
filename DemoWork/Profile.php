<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: User_Login.php');
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch user data
$user_email = $_SESSION['user_email'];
$sql = "SELECT name, email, phone, address, profile_photo FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Error preparing SQL statement: ' . $conn->error);
}

$stmt->bind_param('s', $user_email);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

$stmt->close();
$conn->close();

include('Navbar.php'); // Include navbar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="Profile.css">
</head>
<body>

<div class="profile-container">
    <h2>Your Profile</h2>
    <div class="profile-card">
        <div class="profile-photo">
            <?php if (!empty($user_data['profile_photo'])): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($user_data['profile_photo']); ?>" alt="Profile Photo">
            <?php else: ?>
                <img src="user.png" alt="Default Profile Photo">
            <?php endif; ?>
        </div>
        <div class="profile-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_data['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_data['phone']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user_data['address']); ?></p>
        </div>
    </div>
</div>

</body>
</html>
