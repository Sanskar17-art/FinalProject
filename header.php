<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="CSS/header.css">
</head>
<body>

<header class="header">
  <div class="logo">Worker UI</div>
  <nav class="nav">
    <a href="Worker_Home.php">Home</a>
    <a href="Worker_Tasks.php">Tasks</a>
    <a href="Worker_Ratings.php">Ratings</a>
    <a href="Worker_Report.php">Report</a>
    <a href="Backend/logout.php" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    
    <!-- Hidden logout form -->
    <form id="logout-form" action="Backend/logout.php" method="POST" style="display: none;">
      <input type="hidden" name="logout" value="1">
    </form>
  </nav>
  <div class="profile">
    <a href="Worker_ProfileUp.php">
      <img src="https://tse2.mm.bing.net/th?id=OIP.zM7ArKyeNVAiOeTyujsvWwHaHa&pid=Api&P=0&h=180" alt="User">
    </a>
  </div>
</header>

</body>
</html>