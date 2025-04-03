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
    <title>Worker Dashboard</title>
    <link rel="stylesheet" href="CSS/Worker_Home.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay">
        <div class="loader"></div>
    </div>

    <?php include 'header.php' ?>

    <div class="home-section">
        <div class="welcome-container">
            <div class="welcome-content">
                <h2>Welcome, <?php echo $worker['name']; ?>!</h2>
                <p>Manage your profile and view your work opportunities here.</p>
            </div>
            <div class="profile-card">
                <div class="profile-image">
                    <img src="<?php echo $profileImage; ?>" alt="Profile Picture">
                </div>
                <div class="profile-info">
                    <h3><?php echo $worker['name']; ?></h3>
                    <p><i class="fas fa-envelope"></i> <?php echo $worker['email']; ?></p>
                    <p><i class="fas fa-briefcase"></i> <?php echo $worker['profession']; ?></p>
                    <button class="btn-edit-profile" onclick="window.location.href='Worker_ProfileUp.php'">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-stats">
            <div class="stat-card">
                <i class="fas fa-tasks"></i>
                <h3>Active Jobs</h3>
                <p>5</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-star"></i>
                <h3>Rating</h3>
                <p>4.8/5</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar-check"></i>
                <h3>Completed Jobs</h3>
                <p>12</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Earnings</h3>
                <p>$2,500</p>
            </div>
        </div>

        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <div class="activity-list">
                <div class="activity-item">
                    <i class="fas fa-check-circle"></i>
                    <div class="activity-content">
                        <h4>Job Completed</h4>
                        <p>Completed plumbing work for John Doe</p>
                    </div>
                    <span class="activity-time">2 hours ago</span>
                </div>
                <div class="activity-item">
                    <i class="fas fa-calendar-plus"></i>
                    <div class="activity-content">
                        <h4>New Job Request</h4>
                        <p>Received new electrical work request</p>
                    </div>
                    <span class="activity-time">5 hours ago</span>
                </div>
                <div class="activity-item">
                    <i class="fas fa-star"></i>
                    <div class="activity-content">
                        <h4>New Review</h4>
                        <p>Received 5-star rating from Sarah Smith</p>
                    </div>
                    <span class="activity-time">1 day ago</span>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>

    <script>
        // Remove loading overlay when page is loaded
        window.addEventListener('load', function() {
            const loader = document.querySelector('.loading-overlay');
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
