<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tasks - Worker Dashboard</title>
  <link rel="stylesheet" href="CSS/Worker_Home.css">
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="dashboard">
    <h3>Your Tasks</h3>
    <div class="task-card">
      <h4>Task 1: Report Preparation</h4>
      <p>Status: In Progress</p>
      <p>Complete the report for the client by tomorrow.</p>
    </div>
    <div class="add-task-container">
      <button class="btn-add-task" onclick="alert('Add Task Modal Coming Soon!')">+ Add New Task</button>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
