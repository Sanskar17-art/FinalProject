<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Signup</title>
<link rel="stylesheet" href="CSS/User_Signup.css">
<script src="JAVASCRIPT/User_Signup.js"></script>
</head>
<body>
<div class="signup-form">
    <h2>Signup Form</h2>
    <form action="Backend/Usignup.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
            <span class="error" id="nameError"></span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <span class="error" id="emailError"></span>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" required>
            <span class="error" id="phoneError"></span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <span class="error" id="passwordError"></span>
        </div>
        <div class="form-group">
            <label for="profilePhoto">Profile Photo</label>
            <input type="file" id="profilePhoto" name="profilePhoto" accept="image/*">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" required></textarea>
            <span class="error" id="addressError"></span>
        </div>
        <button type="submit">Sign Up</button>
    </form>
</div>
</body>
</html>
