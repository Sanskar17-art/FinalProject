<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Login.css">
    <title>Login Form</title>
</head>
<body>
    <div class="login-container">
        <h2>Login Here</h2>
        <form method="POST" action="login.php">
            <label for="username">Email or Phone</label>
            <input type="text" id="username" name="username" placeholder="Email or Phone" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required> 
            <button type="submit">Log In</button>
        </form>
    </div>
</body>
</html>
