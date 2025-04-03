<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: User_Login.php');
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch user data
$user_email = $_SESSION['user_email'];
$sql = "SELECT name, email, phone, address, profile_photo FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Error preparing SQL statement: ' . $conn->error);
}

$stmt->bind_param('s', $user_email);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

$stmt->close();
$conn->close();

include('Navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="Profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="profile-section">
    <div class="profile-header">
        <h2><i class="fas fa-user-circle"></i> Your Profile</h2>
    </div>
    <div class="profile-card">
        <div class="profile-photo">
            <?php if (!empty($user_data['profile_photo'])): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($user_data['profile_photo']); ?>" alt="Profile Photo">
            <?php else: ?>
                <img src="user.png" alt="Default Profile Photo">
            <?php endif; ?>
            <div class="photo-overlay">
                <i class="fas fa-camera"></i>
            </div>
        </div>
        <div class="profile-details">
            <div class="detail-item">
                <i class="fas fa-user"></i>
                <p><strong>Name:</strong> <span id="display-name"><?php echo htmlspecialchars($user_data['name']); ?></span></p>
            </div>
            <div class="detail-item">
                <i class="fas fa-envelope"></i>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
            </div>
            <div class="detail-item">
                <i class="fas fa-phone"></i>
                <p><strong>Phone:</strong> <span id="display-phone"><?php echo htmlspecialchars($user_data['phone']); ?></span></p>
            </div>
            <div class="detail-item">
                <i class="fas fa-map-marker-alt"></i>
                <p><strong>Address:</strong> <span id="display-address"><?php echo htmlspecialchars($user_data['address']); ?></span></p>
            </div>
        </div>
        <button class="edit-btn" onclick="openEditModal()">
            <i class="fas fa-edit"></i> Edit Profile
        </button>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2><i class="fas fa-user-edit"></i> Edit Profile</h2>
        <form id="editProfileForm" enctype="multipart/form-data">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>">
            
            <div class="form-group">
                <label><i class="fas fa-user"></i> Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-phone"></i> Phone:</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($user_data['phone']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-map-marker-alt"></i> Address:</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($user_data['address']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-camera"></i> Profile Photo:</label>
                <input type="file" name="profile_photo" accept="image/*">
            </div>

            <button type="submit" class="save-btn">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>

<script>
function openEditModal() {
    document.getElementById("editProfileModal").style.display = "block";
}

function closeEditModal() {
    document.getElementById("editProfileModal").style.display = "none";
}

// Close modal when clicking outside
window.onclick = function(event) {
    var modal = document.getElementById("editProfileModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

$(document).ready(function () {
    $("#editProfileForm").on("submit", function (e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            type: "POST",
            url: "update_profile.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Error updating profile. Please try again.");
            }
        });
    });
});
</script>

</body>
</html>
