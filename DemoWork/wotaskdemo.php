<?php
session_start();
include '../Backend/connection.php'; // Include your database connection file

// Check if the worker is logged in
if (!isset($_SESSION['worker_id'])) {
    die("Access Denied. Please log in first.");
}

$worker_id = $_SESSION['worker_id'];

// Fetch tasks assigned to this worker
$sql = "SELECT * FROM tasks WHERE worker_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $worker_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Tasks</title>
    <link rel="stylesheet" href="wodemod.css">
</head>
<body>

<div class="task-container">
    <h2>Your Assigned Tasks</h2>
    <?php if ($result->num_rows > 0): ?>
        <div class="task-list">
            <?php while ($task = $result->fetch_assoc()): ?>
                <div class="task-card">
                    <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>
                    <p><strong>Start:</strong> <?php echo htmlspecialchars($task['start_datetime']); ?></p>
                    <p><strong>End:</strong> <?php echo htmlspecialchars($task['end_datetime']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($task['location']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($task['status']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No tasks assigned yet.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
