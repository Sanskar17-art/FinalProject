<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
    <link rel="stylesheet" href="CSS/User_Signup.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="JAVASCRIPT/User_Signup.js"></script>
</head>
<body>
    <!-- Animated Background Elements -->
    <div class="background-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
        <div class="square square-1"></div>
        <div class="square square-2"></div>
        <div class="triangle triangle-1"></div>
    </div>

    <div class="signup-form">
        <h2><i class="fas fa-user-plus"></i> Create Account</h2>
        <form action="Backend/Usignup.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name">
                <span class="error" id="nameError"></span>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
                <span class="error" id="emailError"></span>
            </div>
            <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                <input type="text" id="phone" name="phone" required placeholder="Enter your phone number">
                <span class="error" id="phoneError"></span>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required placeholder="Create a strong password">
                <span class="error" id="passwordError"></span>
            </div>
            <div class="form-group">
                <label for="profilePhoto"><i class="fas fa-camera"></i> Profile Photo</label>
                <input type="file" id="profilePhoto" name="profilePhoto" accept="image/*">
            </div>
            <div class="form-group">
                <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                <textarea id="address" name="address" rows="3" required placeholder="Enter your complete address"></textarea>
                <span class="error" id="addressError"></span>
            </div>
            <button type="submit">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>
    </div>

    <script>
        // Add mouse move effect for background elements
        document.addEventListener('mousemove', function(e) {
            const elements = document.querySelectorAll('.circle, .square, .triangle');
            const mouseX = e.clientX;
            const mouseY = e.clientY;
            
            elements.forEach(element => {
                const speed = element.getAttribute('data-speed') || 1;
                const x = (window.innerWidth - mouseX * speed) / 100;
                const y = (window.innerHeight - mouseY * speed) / 100;
                element.style.transform = `translateX(${x}px) translateY(${y}px)`;
            });
        });
    </script>
</body>
</html>
