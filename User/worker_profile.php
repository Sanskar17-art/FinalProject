<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if worker_id is set in POST
if (isset($_POST['worker_id'])) {
    $worker_id = intval($_POST['worker_id']);
    // Store worker_id in session for persistence
    $_SESSION['worker_id'] = $worker_id;
} elseif (isset($_SESSION['worker_id'])) {
    // If not in POST but exists in session, use session value
    $worker_id = $_SESSION['worker_id'];
} else {
    // If neither exists, redirect to workers list
    header("Location: Workers.php");
    exit();
}

// Check if worker exists and is available
$query = $conn->prepare("SELECT * FROM workers WHERE id = ? AND is_available = 1");
if (!$query) {
    die("Error preparing query: " . $conn->error);
}

$query->bind_param("i", $worker_id);
$query->execute();
$result = $query->get_result();

if($result->num_rows === 0) {
    // Clear invalid worker_id from session
    unset($_SESSION['worker_id']);
    // Show error message and redirect
    echo "<script>
        alert('This worker is currently unavailable.');
        window.location.href = 'Workers.php';
    </script>";
    exit();
}

$worker = $result->fetch_assoc();

// Define upload path
$upload_path = dirname(__DIR__) . '/Backend/uploads/';
$default_image = 'default-profile.jpg';
$profile_image = !empty($worker['profile_photo']) && file_exists($upload_path . $worker['profile_photo']) 
    ? $worker['profile_photo'] 
    : $default_image;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($worker['name']); ?> - Profile</title>
    <link rel="stylesheet" href="worker_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'Navbar.php'; ?>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-image-container">
                    <img src="<?php echo htmlspecialchars($profile_image_path); ?>" 
                         alt="<?php echo htmlspecialchars($worker['name']); ?>'s Profile Photo" 
                         class="profile-image"
                         onerror="this.src='<?php echo htmlspecialchars($upload_path . $default_image); ?>'">
                    <div class="profile-status">
                        <i class="fas fa-circle"></i>
                        <span>Available for Work</span>
                    </div>
                </div>
                <div class="profile-title">
                    <h2 class="animate-text"><?php echo htmlspecialchars($worker['name']); ?></h2>
                    <p class="profession animate-text"><?php echo htmlspecialchars($worker['profession']); ?></p>
                </div>
            </div>

            <div class="profile-content">
                <div class="info-section">
                    <div class="info-item">
                        <i class="fas fa-briefcase"></i>
                        <div class="info-details">
                            <h3>Experience</h3>
                            <p><?php echo htmlspecialchars($worker['experience']); ?> years</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-graduation-cap"></i>
                        <div class="info-details">
                            <h3>Qualification</h3>
                            <p><?php echo htmlspecialchars($worker['qualification']); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-venus-mars"></i>
                        <div class="info-details">
                            <h3>Gender</h3>
                            <p><?php echo ucfirst(htmlspecialchars($worker['gender'])); ?></p>
                        </div>
                    </div>
                </div>

                <div class="contact-section">
                    <h3>Contact Information</h3>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <p><?php echo htmlspecialchars($worker['email']); ?></p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <p><?php echo htmlspecialchars($worker['mobile']); ?></p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p><?php echo htmlspecialchars($worker['address']); ?></p>
                    </div>
                </div>

                <?php if (!empty($worker['certificate']) && file_exists($upload_path . $worker['certificate'])): ?>
                <div class="certificate-section">
                    <h3>Certificate</h3>
                    <a href="<?php echo htmlspecialchars($upload_path . $worker['certificate']); ?>" target="_blank" class="certificate-link">
                        <i class="fas fa-certificate"></i>
                        View Certificate
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <div class="profile-actions">
                <form action="Hire_Worker.php" method="POST" class="action-form">
                    <input type="hidden" name="worker_id" value="<?php echo htmlspecialchars($worker['id']); ?>">
                    <button type="submit" class="hire-btn">
                        <i class="fas fa-handshake"></i>
                        Hire Worker
                    </button>
                </form>

                <form action="report_worker.php" method="POST" class="action-form">
                    <input type="hidden" name="worker_id" value="<?php echo htmlspecialchars($worker['id']); ?>">
                    <button type="submit" class="report-btn">
                        <i class="fas fa-flag"></i>
                        Report Worker
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                    }
                });
            });

            document.querySelectorAll('.info-item, .contact-item, .certificate-section').forEach((el) => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html> 