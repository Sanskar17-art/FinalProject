<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Signup - Professional Services</title>
    <link rel="stylesheet" href="css/Worker_Signup.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Animated Background Elements -->
    <div class="background-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
        <div class="square square-1"></div>
        <div class="square square-2"></div>
        <div class="triangle triangle-1"></div>
    </div>

    <div class="form-container">
        <div class="form-section">
            <h3><i class="fas fa-user-plus"></i> Create Account</h3>
            <form action="Backend/Wsignup.php" method="POST" onsubmit="return validateWorkerForm()" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                    <div class="error-message" id="name-error"></div>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                    <div class="error-message" id="email-error"></div>
                </div>

                <div class="form-group">
                    <label for="mobile"><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="tel" id="mobile" name="mobile" required placeholder="Enter your phone number">
                    <div class="error-message" id="mobile-error"></div>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" required placeholder="Create a strong password">
                    <div class="error-message" id="password-error"></div>
                </div>

                <div class="form-group">
                    <label for="profile_photo"><i class="fas fa-camera"></i> Profile Photo</label>
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
                    <div class="error-message" id="photo-error"></div>
                </div>

                <div class="form-group">
                    <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea id="address" name="address" rows="2" required placeholder="Enter your complete address"></textarea>
                    <div class="error-message" id="address-error"></div>
                </div>

                <div class="form-group">
                    <label for="gender"><i class="fas fa-venus-mars"></i> Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <div class="error-message" id="gender-error"></div>
                </div>
        </div>

        <div class="form-section">
            <h3><i class="fas fa-briefcase"></i> Professional Details</h3>
            <div class="form-group">
                <label for="profession"><i class="fas fa-tools"></i> Profession</label>
                <input type="text" id="profession" name="profession" required placeholder="Enter your profession">
                <div class="error-message" id="profession-error"></div>
            </div>

            <div class="form-group">
                <label for="experience"><i class="fas fa-clock"></i> Years of Experience</label>
                <input type="number" id="experience" name="experience" min="0" required placeholder="Enter years of experience">
                <div class="error-message" id="experience-error"></div>
            </div>

            <div class="form-group">
                <label for="qualification"><i class="fas fa-graduation-cap"></i> Qualification</label>
                <input type="text" id="qualification" name="qualification" required placeholder="Enter your qualifications">
                <div class="error-message" id="qualification-error"></div>
            </div>

            <div class="form-group">
                <label for="experience_level"><i class="fas fa-chart-line"></i> Experience Level</label>
                <select id="experience_level" name="experience_level" required>
                    <option value="">Select Experience Level</option>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Expert">Expert</option>
                </select>
                <div class="error-message" id="level-error"></div>
            </div>

            <div class="form-group">
                <label for="certificate"><i class="fas fa-certificate"></i> Certificate</label>
                <input type="file" id="certificate" name="certificate" accept="application/pdf">
                <div class="error-message" id="certificate-error"></div>
            </div>

            <div class="form-group">
                <label for="languages"><i class="fas fa-language"></i> Languages</label>
                <input type="text" id="languages" name="languages" placeholder="e.g., English, Spanish">
                <div class="error-message" id="languages-error"></div>
            </div>

            <div class="success-message" id="success-message"></div>
            <input type="submit" value="Create Account" id="submit-btn">
            </form>
        </div>
    </div>

    <script>
        // Form validation
        function validateWorkerForm() {
            let isValid = true;
            const submitBtn = document.getElementById('submit-btn');
            const successMessage = document.getElementById('success-message');

            // Reset error messages
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
            document.querySelectorAll('input, select, textarea').forEach(el => el.classList.remove('error'));

            // Name validation
            const name = document.getElementById('name');
            if (name.value.length < 2) {
                showError(name, 'Name must be at least 2 characters long');
                isValid = false;
            }

            // Email validation
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                showError(email, 'Please enter a valid email address');
                isValid = false;
            }

            // Password validation
            const password = document.getElementById('password');
            if (password.value.length < 8) {
                showError(password, 'Password must be at least 8 characters long');
                isValid = false;
            }

            // Mobile validation
            const mobile = document.getElementById('mobile');
            const mobileRegex = /^[0-9]{10}$/;
            if (!mobileRegex.test(mobile.value)) {
                showError(mobile, 'Please enter a valid 10-digit mobile number');
                isValid = false;
            }

            // File validation
            const profilePhoto = document.getElementById('profile_photo');
            const certificate = document.getElementById('certificate');

            if (profilePhoto.files.length > 0) {
                const file = profilePhoto.files[0];
                if (!file.type.startsWith('image/')) {
                    showError(profilePhoto, 'Please upload a valid image file');
                    isValid = false;
                }
            }

            if (certificate.files.length > 0) {
                const file = certificate.files[0];
                if (file.type !== 'application/pdf') {
                    showError(certificate, 'Please upload a valid PDF file');
                    isValid = false;
                }
            }

            if (isValid) {
                submitBtn.disabled = true;
                submitBtn.value = 'Creating Account...';
                successMessage.style.display = 'block';
                successMessage.textContent = 'Account created successfully! Redirecting...';
            }

            return isValid;
        }

        function showError(element, message) {
            element.classList.add('error');
            const errorDiv = element.nextElementSibling;
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }

        // Add animation to form sections on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.form-section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'all 0.5s ease-out';
            observer.observe(section);
        });

        // Add hover effect to form groups
        document.querySelectorAll('.form-group').forEach(group => {
            group.addEventListener('mouseenter', () => {
                group.style.transform = 'translateX(10px)';
                group.style.transition = 'transform 0.3s ease';
            });

            group.addEventListener('mouseleave', () => {
                group.style.transform = 'translateX(0)';
            });
        });

        // Add mouse move effect for background elements
        document.addEventListener('mousemove', function(e) {
            const elements = document.querySelectorAll('.circle, .square, .triangle');
            const mouseX = e.clientX;
            const mouseY = e.clientY;
            
            elements.forEach(element => {
                const speed = element.getAttribute('data-speed') || 1;
                const x = (window.innerWidth - mouseX * speed) / 100;
                const y = (window.innerHeight - mouseY * speed) / 100;
                element.style.transform = `translateX(${x}px) translateY(${y}px)`;
            });
        });
    </script>
</body>
</html>
