<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $worker['name']; ?> - Profile</title>
    <link rel="stylesheet" href="CSS/workers_info.css">
</head>
<body>

    <?php include 'Navbar.php'; ?>

    <div class="profile-container">
        <div class="profile-card">
            <!-- Profile Image -->
            <img src="../Backend/uploads/<?php echo $worker['profile_photo']; ?>" alt="Profile Photo">
            
            <!-- Name -->
            <h2><?php echo $worker['name']; ?></h2>
            
            <!-- Worker Details -->
            <p><strong>Profession:</strong> <?php echo $worker['profession']; ?></p>
            <p><strong>Experience:</strong> <?php echo $worker['experience']; ?> years</p>
            <p><strong>Qualification:</strong> <?php echo $worker['qualification']; ?></p>
            <p><strong>Gender:</strong> <?php echo ucfirst($worker['gender']); ?></p>
            <p><strong>Email:</strong> <?php echo $worker['email']; ?></p>
            <p><strong>Mobile:</strong> <?php echo $worker['mobile']; ?></p>
            <p><strong>Address:</strong> <?php echo $worker['address']; ?></p>
            
            <!-- Certificate (If available) -->
            <?php if (!empty($worker['certificate'])): ?>
                <p><strong>Certificate:</strong> <a href="../Backend/uploads/<?php echo $worker['certificate']; ?>" target="_blank">View Certificate</a></p>
            <?php endif; ?>
            
            <!-- Action Buttons -->
        <div class="profile-actions">
            <form action="hire_worker.php" method="GET">
                <input type="hidden" name="id" value="<?php echo $worker['id']; ?>">
                <button type="submit" class="hire-btn">Hire</button>
            </form>

            <form action="report_worker.php" method="GET">
                <input type="hidden" name="id" value="<?php echo $worker['id']; ?>">
                <button type="submit" class="report-btn">Report</button>
            </form>
        </div>

                </div>
            </div>

</body>
</html>
