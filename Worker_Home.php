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
                    <div class="availability-toggle">
                        <label class="switch">
                            <input type="checkbox" id="availabilityToggle" <?php echo isset($worker['is_available']) && $worker['is_available'] ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="availability-text"><?php echo isset($worker['is_available']) && $worker['is_available'] ? 'Available for Work' : 'Currently Unavailable'; ?></span>
                    </div>
                    <button class="btn-edit-profile" onclick="window.location.href='Worker_ProfileUp.php'">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>
  </div>

  <?php include 'footer.php' ?>

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

        // Handle availability toggle
        document.getElementById('availabilityToggle').addEventListener('change', function() {
            const isAvailable = this.checked;
            const toggle = this;
            const statusText = document.querySelector('.availability-text');
            
            // Show loading state
            toggle.disabled = true;
            
            fetch('Backend/update_availability.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `is_available=${isAvailable ? 1 : 0}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update status text
                    statusText.textContent = isAvailable ? 'Available for Work' : 'Currently Unavailable';
                    // Show success message
                    showNotification(isAvailable ? 'You are now available for work' : 'You are now unavailable for work', 'success');
                } else {
                    // Revert toggle if update failed
                    toggle.checked = !isAvailable;
                    showNotification(data.message || 'Failed to update availability status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toggle.checked = !isAvailable;
                showNotification('An error occurred while updating availability status', 'error');
            })
            .finally(() => {
                // Re-enable toggle
                toggle.disabled = false;
            });
        });

        // Notification function
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

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
