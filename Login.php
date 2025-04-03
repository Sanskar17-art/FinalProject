<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal</title>
    <link rel="stylesheet" href="CSS/Login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    <div class="container">
        <div class="card">
            <img src="https://tse1.mm.bing.net/th?id=OIP.rcmXeqCUOiCg54dfU4v9tgHaHa&pid=Api&P=0&h=180" alt="User Icon">
            <h2>USER LOGIN</h2>
            <a href="User_login.php" class="start-button">LOGIN</a>
        </div>
 
        <div class="card">
            <img src="https://tse2.mm.bing.net/th?id=OIP.zM7ArKyeNVAiOeTyujsvWwHaHa&pid=Api&P=0&h=180" alt="Worker Icon">
            <h2>WORKER LOGIN</h2> 
            <a href="Worker_Login.php" class="start-button">LOGIN</a>
        </div>
    </div>

    <script>
        // Add mouse move effect for background elements
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