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
    <link rel="stylesheet" href="Admin.css">
</head>
<body>
    <div class="admin-panel">
        <h2>Contact Messages</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
