<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="loading"></div>
    
    <!-- Animated Background Elements -->
    <div class="background-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
        <div class="square square-1"></div>
        <div class="square square-2"></div>
        <div class="triangle triangle-1"></div>
    </div>
    
    <div class="container">
        <div class="logo-container">
            <i class="fas fa-rocket logo-icon"></i>
        </div>
        <h1 class="animated-text">Welcome to Our Platform</h1>
        <p class="subtitle">Start your journey with us today</p>
        
        <div class="button-group">
            <a href="Signup.php" class="start-button">
                <i class="fas fa-user-plus"></i>
                <span>Sign Up</span>
            </a>
            <a href="Login.php" class="start-button">
                <i class="fas fa-sign-in-alt"></i>
                <span>Login</span>
            </a>
        </div>
    </div>

    <script>
        // Remove loading screen after page loads
        window.addEventListener('load', function() {
            const loading = document.querySelector('.loading');
            setTimeout(() => {
                loading.style.display = 'none';
            }, 500);
        });

        // Add mouse move effect
        document.addEventListener('mousemove', function(e) {
            const circles = document.querySelectorAll('.circle');
            const squares = document.querySelectorAll('.square');
            const triangles = document.querySelectorAll('.triangle');
            
            const mouseX = e.clientX;
            const mouseY = e.clientY;
            
            circles.forEach(circle => {
                const speed = circle.getAttribute('data-speed');
                const x = (window.innerWidth - mouseX * speed) / 100;
                const y = (window.innerHeight - mouseY * speed) / 100;
                circle.style.transform = `translateX(${x}px) translateY(${y}px)`;
            });

            squares.forEach(square => {
                const speed = square.getAttribute('data-speed');
                const x = (window.innerWidth - mouseX * speed) / 100;
                const y = (window.innerHeight - mouseY * speed) / 100;
                square.style.transform = `translateX(${x}px) translateY(${y}px) rotate(${x}deg)`;
            });

            triangles.forEach(triangle => {
                const speed = triangle.getAttribute('data-speed');
                const x = (window.innerWidth - mouseX * speed) / 100;
                const y = (window.innerHeight - mouseY * speed) / 100;
                triangle.style.transform = `translateX(${x}px) translateY(${y}px) rotate(${y}deg)`;
            });
        });
    </script>
</body>
</html>
