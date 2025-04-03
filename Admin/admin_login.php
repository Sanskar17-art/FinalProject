<?php
session_start();

$error = "";

// Hardcoded admin credentials
$admin_email = "admin@example.com";
$admin_password = "admin123"; // Plain text password (not recommended for real apps)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_email"] = $email;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --text-color: #333;
            --light-gray: #f5f7fa;
            --border-color: #e1e5eb;
            --error-color: #ef476f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Elements */
        .background-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .circle, .square, .triangle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .circle-1 {
            width: 60px;
            height: 60px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 80px;
            height: 80px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .circle-3 {
            width: 40px;
            height: 40px;
            bottom: 20%;
            left: 30%;
            animation-delay: 4s;
        }

        .square {
            border-radius: 0;
            animation: rotate 8s linear infinite;
        }

        .square-1 {
            width: 70px;
            height: 70px;
            top: 30%;
            right: 25%;
            animation-delay: 1s;
        }

        .square-2 {
            width: 50px;
            height: 50px;
            bottom: 30%;
            right: 35%;
            animation-delay: 3s;
        }

        .triangle {
            width: 0;
            height: 0;
            border-left: 30px solid transparent;
            border-right: 30px solid transparent;
            border-bottom: 52px solid rgba(255, 255, 255, 0.1);
            animation: spin 10s linear infinite;
        }

        .triangle-1 {
            top: 40%;
            left: 20%;
            animation-delay: 2.5s;
        }

        .login-container {
            width: 400px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: containerAppear 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: 0.5s;
        }

        .login-container:hover::before {
            transform: translateX(100%);
        }

        .login-header {
            background: rgba(67, 97, 238, 0.2);
            color: white;
            padding: 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            animation: headerAppear 0.8s ease-out;
        }

        .login-header h2 {
            font-size: 1.8rem;
            margin-bottom: 8px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .login-header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .login-form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            animation: formAppear 0.5s ease-out forwards;
            opacity: 0;
        }

        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.4s; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            color: white;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            font-size: 0.95rem;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4fc3f7;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(79, 195, 247, 0.3);
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 42px;
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
        }

        .form-group input:focus + i {
            color: #4fc3f7;
        }

        .error {
            color: #ff5252;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
            animation: shake 0.5s ease-in-out;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: rgba(79, 195, 247, 0.2);
            color: white;
            border: 1.5px solid rgba(79, 195, 247, 0.4);
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: formAppear 0.5s ease-out 0.6s forwards;
            opacity: 0;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: 0.6s;
        }

        .login-button:hover {
            background: rgba(79, 195, 247, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border-color: rgba(79, 195, 247, 0.6);
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            animation: formAppear 0.5s ease-out 0.8s forwards;
            opacity: 0;
        }

        @keyframes containerAppear {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes headerAppear {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes formAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                margin: 20px;
            }

            .login-header {
                padding: 20px;
            }

            .login-header h2 {
                font-size: 1.5rem;
            }

            .login-form {
                padding: 20px;
            }
        }
    </style>
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

    <div class="login-container">
        <div class="login-header">
            <h2><i class="fas fa-user-shield"></i> Admin Login</h2>
            <p>Enter your credentials to access the panel</p>
        </div>
        
        <div class="login-form">
            <?php if (!empty($error)) echo "<span class='error'>$error</span>"; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <i class="fas fa-lock"></i>
                </div>
                
                <button type="submit" class="login-button">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
            
            <div class="login-footer">
                <p>Secure Admin Portal • <?php echo date('Y'); ?></p>
            </div>
        </div>
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