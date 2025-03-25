<?php
session_start();
if (!isset($_SESSION['worker_id'])) {
    header("Location: login.php");
    exit();
}

require_once "Backend/connection.php";

$worker_id = $_SESSION['worker_id'];

// Fetch worker details
$query = "SELECT name, email FROM workers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $worker_id);
$stmt->execute();
$stmt->bind_result($worker_name, $worker_email);
$stmt->fetch();
$stmt->close();

// Fetch users list
$users_query = "SELECT id, name FROM users"; // Assuming there's a users table
$users_result = $conn->query($users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Report</title>
    <link rel="stylesheet" href="CSS/Worker_Report.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Submit a Report</h2>
        <form action="Backend/WReport.php" method="POST">
            <input type="hidden" name="worker_id" value="<?= $worker_id ?>">
            <input type="hidden" name="worker_name" value="<?= htmlspecialchars($worker_name) ?>">
            <input type="hidden" name="email" value="<?= htmlspecialchars($worker_email) ?>">

            <label for="user_id">Select User to Report:</label>
            <select name="user_id" required>
                <option value="">Select a User</option>
                <?php while ($user = $users_result->fetch_assoc()) : ?>
                    <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="evidence">Report Details:</label>
            <textarea name="evidence" required placeholder="Describe the issue..."></textarea>

            <button type="submit">Submit Report</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
