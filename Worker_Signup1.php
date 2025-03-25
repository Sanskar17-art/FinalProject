<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link rel="stylesheet" href="CSS/Worker_Signup.css"> 
</head>
<body>
    <div class="form-container">
         
        <div class="form-section">
            <h3>Personal Information</h3>
            <form action="Backend/Wsignup.php" method="POST" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

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
            </form>
        </div>

        <!-- Professional Information Section -->
        <div class="form-section">
            <h3>Professional Information</h3>
            <label for="experience">Years of Experience:</label>
            <input type="number" id="experience" name="experience" min="0" required>

            <label for="qualification">Qualification:</label>
            <input type="text" id="qualification" name="qualification" required>

            <label for="Profession">Profession:</label>
            <select id="Profession" name="Profession" required>
                <option value="Electrician">Electrician</option>
                <option value="Plumber">Plumber</option>
                <option value="Cook">Cook</option>
                <option value="Driver">Driver</option>
                <option value="Mechanic">Mechanic</option>
                <option value="Other">Other</option>
            </select>

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
        </div>
    </div>

    
<script src="Workervalidation.js"></script>
</body>
</html>
