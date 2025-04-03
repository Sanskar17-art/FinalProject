<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --primary-light: rgba(67, 97, 238, 0.1);
            --text-color: #333;
            --light-gray: #f5f7fa;
            --border-color: #e1e5eb;
            --sidebar-width: 250px;
            --header-height: 60px;
            --sidebar-bg: #fff;
            --content-bg: #f5f7fa;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--content-bg);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            z-index: 100;
        }

        .sidebar h2 {
            font-size: 28px;
            color: var(--primary-color);
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar a {
            padding: 18px 20px;
            font-size: 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .sidebar a:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .sidebar a.active {
            background-color: var(--primary-color);
            color: white;
        }

        .sidebar .logout {
            margin-top: auto;
            background-color: rgba(239, 71, 111, 0.1);
            color: #ef476f;
        }

        .sidebar .logout:hover {
            background-color: #ef476f;
            color: white;
        }

        .content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            font-size: 22px; /* Increased text size */
        }

        .content h1 {
            font-size: 40px;
        }

        .content h2 {
            font-size: 35px;
        }

        .content h3 {
            font-size: 30px;
        }

        .content p, .content a, .content td, .content th, .content label, .content input, .content select, .content textarea {
            font-size: 20px;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }

            .sidebar h2 {
                font-size: 0;
            }

            .content {
                margin-left: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="index.php">Dashboard</a>
        <a href="user.php">User</a>
        <a href="worker.php">Worker</a>
        <a href="user_report.php">User Report</a>
        <a href="worker_report.php">Worker Report</a>
        <a href="user_contact.php">Contact Us</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>


</body>
</html>