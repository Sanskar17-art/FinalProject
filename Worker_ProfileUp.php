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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="view-user-details-container">
        <h2 class="profile-heading">Edit Worker Profile</h2>
        <div class="card">
            <div class="profile-photo-container">
                <img src="<?php echo $worker['profile_photo'] ? '../uploads/' . $worker['profile_photo'] : '../images/default-profile.png'; ?>" 
                     alt="Profile Photo" class="profile-photo" id="profile-photo-preview">
                <label for="profile_photo" class="file-input-label">
                    <i class="fas fa-camera"></i> Change Photo
                </label>
                <input type="file" name="profile_photo" id="profile_photo" accept="image/*" style="display: none;">
            </div>
            <form id="profile-form" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($worker['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($worker['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="tel" id="mobile" name="mobile" value="<?php echo htmlspecialchars($worker['mobile']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="2" required><?php echo htmlspecialchars($worker['address']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?php echo htmlspecialchars($worker['gender']) === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo htmlspecialchars($worker['gender']) === 'Female' ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo htmlspecialchars($worker['gender']) === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="profession">Profession</label>
                        <input type="text" id="profession" name="profession" value="<?php echo htmlspecialchars($worker['profession']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="experience">Years of Experience</label>
                        <input type="number" id="experience" name="experience" min="0" value="<?php echo htmlspecialchars($worker['experience']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="qualification">Qualification</label>
                        <input type="text" id="qualification" name="qualification" value="<?php echo htmlspecialchars($worker['qualification']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="experience_level">Experience Level</label>
                        <select id="experience_level" name="experience_level" required>
                            <option value="">Select Experience Level</option>
                            <option value="Beginner" <?php echo htmlspecialchars($worker['experience_level']) === 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
                            <option value="Intermediate" <?php echo htmlspecialchars($worker['experience_level']) === 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                            <option value="Expert" <?php echo htmlspecialchars($worker['experience_level']) === 'Expert' ? 'selected' : ''; ?>>Expert</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="languages">Languages</label>
                        <input type="text" id="languages" name="languages" value="<?php echo htmlspecialchars($worker['languages']); ?>" placeholder="e.g., English, Spanish">
                    </div>

                    <div class="form-group">
                        <label for="certificate">Certificate (PDF)</label>
                        <input type="file" id="certificate" name="certificate" accept=".pdf">
                        <?php if ($worker['certificate']): ?>
                            <p class="current-file">Current file: <?php echo htmlspecialchars($worker['certificate']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Preview profile photo
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Form validation
        function validateForm() {
            let isValid = true;
            const form = document.getElementById('profile-form');
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

            // Clear previous errors
            inputs.forEach(input => {
                clearFieldError(input);
            });

            // Check required fields
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    showFieldError(input, 'This field is required');
                    isValid = false;
                }
            });

            // Email validation
            const emailInput = document.getElementById('email');
            if (emailInput.value && !isValidEmail(emailInput.value)) {
                isValid = false;
                showFieldError(emailInput, 'Please enter a valid email address');
            }

            // Mobile number validation
            const mobileInput = document.getElementById('mobile');
            if (mobileInput.value && !isValidMobile(mobileInput.value)) {
                isValid = false;
                showFieldError(mobileInput, 'Please enter a valid 10-digit mobile number');
            }

            return isValid;
        }

        // Helper functions for validation
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function isValidMobile(mobile) {
            return /^[0-9]{10}$/.test(mobile);
        }

        function showFieldError(input, message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            input.classList.add('error');
            input.parentNode.appendChild(errorDiv);
        }

        function clearFieldError(input) {
            input.classList.remove('error');
            const errorDiv = input.parentNode.querySelector('.error-message');
            if (errorDiv) {
                errorDiv.remove();
            }
        }

        // Form submission
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                showNotification('Please fix the errors before submitting', 'error');
                return;
            }

            const form = this;
            const submitBtn = form.querySelector('.btn-primary');
            submitBtn.classList.add('loading');
            submitBtn.textContent = 'Updating...';

            const formData = new FormData(form);

            fetch('Backend/save_worker_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            })
            .finally(() => {
                submitBtn.classList.remove('loading');
                submitBtn.textContent = 'Update Profile';
            });
        });

        // Notification function
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            // Trigger reflow
            notification.offsetHeight;

            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Animate elements on page load
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.card, .form-group, .btn-primary');
            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
                element.classList.add('fade-in');
            });
        });
    </script>
</body>
</html>