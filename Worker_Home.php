<?php
session_start();
if (!isset($_SESSION['worker_id'])) {
    header("Location: Worker_Login.php");
    exit();
}

$worker_id = $_SESSION['worker_id'];

// Fetch worker details using API
$url = 'http://localhost/FinalProject/Backend/Worker_Home.php';
$options = [
    'http' => [
        'header'  => "Content-Type: application/x-www-form-urlencoded",
        'method'  => 'POST',
        'content' => http_build_query(['worker_id' => $worker_id]),
    ],
];
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);

$worker = json_decode($response, true);

// Set profile image path
$profileImage = !empty($worker['profile_photo']) ? $worker['profile_photo'] : 'uploads/default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Worker Dashboard</title>
  <link rel="stylesheet" href="CSS/home.css">
</head>
<body>
  <?php include 'header.php' ?>

  <div class="dashboard">
    <div class="welcome">
      <h2>Welcome, <?php echo $worker['name']; ?>!</h2>
      <p>Here's your daily overview of tasks and notifications.</p>
    </div>
    <div class="profile-card">
      <img src="<?php echo $profileImage; ?>" alt="Profile Picture" width="100">
      <h3><?php echo $worker['name']; ?></h3>
      <p>Email: <?php echo $worker['email']; ?></p>
      <p>Profession: <?php echo $worker['profession']; ?></p>
      <button class="btn-edit-profile" onclick="window.location.href='Worker_ProfileUp.php'">Edit Profile</button>
    </div>
  </div>

  <?php include 'footer.php' ?>

</body>
</html>
