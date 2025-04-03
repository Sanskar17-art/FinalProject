<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Login</title>
    <link rel="stylesheet" href="CSS/Worker_Login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

    <div class="login-box">
        <div class="login-header">
            <i class="fas fa-user-tie"></i>
            <h2>Worker Login</h2>
            <p>Welcome back! Please login to your account.</p>
        </div>
        <form action="Backend/Wlogin.php" method="POST" class="login-form">
            <div class="form-group">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Email or Phone Number" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </div>
            <div class="form-footer">
                <p>Don't have an account? <a href="Worker_Signup.php">Sign up</a></p>
            </div>
        </form>
    </div>

    <script>
        // Add animation to form elements
        document.querySelectorAll('.input-group input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Add loading animation to login button
        document.querySelector('.login-form').addEventListener('submit', function(e) {
            const button = this.querySelector('.login-btn');
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
            button.disabled = true;
        });

        // Animate background elements based on mouse movement
        document.addEventListener('mousemove', function(e) {
            const elements = document.querySelectorAll('.circle, .square, .triangle');
            elements.forEach(element => {
                const speed = element.getAttribute('data-speed') || 0.5;
                const x = (window.innerWidth - e.pageX * speed) / 100;
                const y = (window.innerHeight - e.pageY * speed) / 100;
                element.style.transform = `translateX(${x}px) translateY(${y}px)`;
            });
        });
    </script>
</body>
</html>
