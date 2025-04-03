<?php
// Start session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: Admin_Login.php');
    exit();
}

// Include database connection
include('db_connect.php');

// Fetch messages from the database
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);

include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Contact Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a56d4;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --text-color: #2c3e50;
            --light-gray: #f5f7fa;
            --border-color: #e1e5eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .page-header {
            margin-bottom: 30px;
            animation: slideDown 0.5s ease-out;
        }

        .page-header h2 {
            color: var(--text-color);
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .messages-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 20px;
            animation: containerAppear 0.6s ease-out;
            overflow-x: auto;
            position: relative;
        }

        .messages-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 15px 15px 0 0;
            animation: gradientMove 3s ease infinite;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: var(--light-gray);
            color: var(--text-color);
            font-weight: 600;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary-color);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        th:hover::after {
            transform: scaleX(1);
        }

        tr:last-child td {
            border-bottom: none;
        }

        td {
            color: var(--text-color);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        tr {
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
            animation: rowAppear 0.5s ease forwards;
        }

        tr:hover {
            background-color: var(--light-gray);
            transform: translateX(5px);
        }

        tr:hover td {
            color: var(--primary-color);
        }

        .message-cell {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
        }

        .message-cell:hover {
            cursor: pointer;
        }

        .message-cell::after {
            content: '...';
            position: absolute;
            right: 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .message-cell:hover::after {
            opacity: 1;
        }

        .date-cell {
            white-space: nowrap;
            position: relative;
        }

        .date-cell::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        tr:hover .date-cell::before {
            opacity: 1;
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

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes rowAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .messages-container {
                padding: 15px;
            }

            th, td {
                padding: 10px;
                font-size: 0.9rem;
            }

            .message-cell {
                max-width: 200px;
            }

            tr:hover {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-envelope"></i> Contact Messages</h2>
        </div>

        <div class="messages-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $delay = 0;
                    while ($row = $result->fetch_assoc()) { 
                    ?>
                        <tr style="animation-delay: <?php echo $delay; ?>s">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="message-cell"><?php echo htmlspecialchars($row['message']); ?></td>
                            <td class="date-cell"><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php 
                    $delay += 0.1;
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add active class to current page link
            const sidebarLinks = document.querySelectorAll('.sidebar a');
            
            sidebarLinks.forEach(link => {
                if (link.getAttribute('href') === 'user_contact.php') {
                    link.classList.add('active');
                }
            });

            // Add hover effect to message cells
            const messageCells = document.querySelectorAll('.message-cell');
            messageCells.forEach(cell => {
                cell.addEventListener('mouseenter', function() {
                    this.style.color = 'var(--primary-color)';
                });
                cell.addEventListener('mouseleave', function() {
                    this.style.color = 'var(--text-color)';
                });
            });
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>
