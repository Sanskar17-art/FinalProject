<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link rel="stylesheet" href="css/Worker_Signup.css">
    <script src="JAVASCRIPT/Worker_Signup.js"></script>
</head>
<body>
    <div class="form-container">
         
        <div class="form-section">
            <h3>Personal Information</h3>
            <form action="Backend/Wsignup.php" method="POST" onsubmit="return validateWorkerForm()" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="mobile">Mobile Number:</label>
                <input type="tel" id="mobile" name="mobile" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <label for="profile_photo">Profile Photo:</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
            
        </div>

        <!-- Professional Information Section -->
        <div class="form-section">
            <h3>Professional Information</h3>
            <label for="experience">Years of Experience:</label>
            <input type="number" id="experience" name="experience" min="0" required>

            <label for="profession">Profession:</label>
            <input type="text" id="profession" name="profession" required>

            <label for="qualification">Qualification:</label>
            <input type="text" id="qualification" name="qualification" required>

            <label for="experience_level">Experience Level:</label>
            <select id="experience_level" name="experience_level" required>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Expert">Expert</option>
            </select>

            <label for="certificate">Certificate:</label>
            <input type="file" id="certificate" name="certificate" accept="application/pdf">

            <label for="languages">Languages:</label>
            <input type="text" id="languages" name="languages" placeholder="e.g., English, Spanish">

            <input type="submit" value="Submit">
            </form>
        </div>
    </div>

    
</body>
</html>
