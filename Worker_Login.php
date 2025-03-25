<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Worker_Login.css">
    <title>Login Form</title>
</head>
<body>
    <div class="login-container">
        <h2>Login Here</h2>
        <form action="Backend/Wlogin.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Email or Phone" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            
            <button type="submit">Log In</button>
            
        </form>
    </div>
  
</body>
</html>
