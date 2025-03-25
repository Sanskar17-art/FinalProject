<?php
session_start();

// Assuming worker_id is in session
$worker_id = $_SESSION['worker_id'] ?? null;

if ($worker_id) {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "project";

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch worker data from the database
    $sql = "SELECT * FROM workers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $worker_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $worker = $row;
    } else {
        // Handle worker not found case
        echo "Worker not found.";
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Worker ID not found in session.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Profile</title>
    <link rel="stylesheet" href="CSS/Worker_Profile_Up.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="view-user-details-container">
        <h2 class="profile-heading">Edit Worker Profile</h2>
        <div class="card">
            <div class="profile-photo-container">
                <img src="Backend/uploads/<?php echo $worker['profile_photo']; ?>" alt="Profile Photo" class="profile-photo">
            </div>
            <div class="file-input-container">
                <input type="file" name="profile-photo" id="profile-photo" class="file-input">
            </div>
            <form action="Backend/save_worker_profile.php" method="POST" class="profile-form">
                <div class="form-group">
                    <label for="worker-name">Name</label>
                    <input type="text" id="worker-name" name="name" value="<?php echo $worker['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-email">Email</label>
                    <input type="email" id="worker-email" name="email" value="<?php echo $worker['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-address">Address</label>
                    <input type="text" id="worker-address" name="address" value="<?php echo $worker['address']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-mobile">Mobile</label>
                    <input type="text" id="worker-mobile" name="mobile" value="<?php echo $worker['mobile']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-gender">Gender</label>
                    <input type="text" id="worker-gender" name="gender" value="<?php echo $worker['gender']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-experience">Experience (in years)</label>
                    <input type="number" id="worker-experience" name="experience" value="<?php echo $worker['experience']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-qualification">Qualification</label>
                    <input type="text" id="worker-qualification" name="qualification" value="<?php echo $worker['qualification']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-profession">Profession</label>
                    <input type="text" id="worker-profession" name="profession" value="<?php echo $worker['profession']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-experience-level">Experience Level</label>
                    <input type="text" id="worker-experience-level" name="experience_level" value="<?php echo $worker['experience_level']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-languages">Languages</label>
                    <input type="text" id="worker-languages" name="languages" value="<?php echo $worker['languages']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="worker-certificate">Certificate</label>
                    <input type="file" id="worker-certificate" name="certificate">
                    <?php if ($worker['certificate']) { ?>
                        <a href="Backend/uploads/<?php echo $worker['certificate']; ?>" target="_blank">View Certificate</a>
                    <?php } ?>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>