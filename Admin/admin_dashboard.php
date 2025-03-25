<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { margin: 50px; }
        a { text-decoration: none; padding: 10px; background: red; color: white; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, Admin!</h2>
    <p>You are logged in.</p>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
