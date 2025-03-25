function validateWorkerForm() {
    let valid = true;

    // Get form values
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const address = document.getElementById("address").value.trim();
    const mobile = document.getElementById("mobile").value.trim();
    const gender = document.getElementById("gender").value;
    const experience = document.getElementById("experience").value;
    const qualification = document.getElementById("qualification").value.trim();
    const profession = document.getElementById("profession").value;
    const experienceLevel = document.getElementById("experience_level").value;
    const languages = document.getElementById("languages").value.trim();

    // Clear previous error messages
    document.querySelectorAll(".error").forEach((error) => (error.innerText = ""));

    // Name Validation
    if (!name.match(/^[a-zA-Z ]{2,30}$/)) {
        document.getElementById("nameError").innerText = "Please enter a valid name.";
        valid = false;
    }

    // Email Validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        document.getElementById("emailError").innerText = "Please enter a valid email address.";
        valid = false;
    }

    // Password Validation
    if (password.length < 6) {
        document.getElementById("passwordError").innerText = "Password must be at least 6 characters.";
        valid = false;
    }

    // Address Validation
    if (address === "") {
        document.getElementById("addressError").innerText = "Address cannot be empty.";
        valid = false;
    }

    // Mobile Number Validation
    const mobilePattern = /^[0-9]{10}$/;
    if (!mobilePattern.test(mobile)) {
        document.getElementById("mobileError").innerText = "Please enter a valid 10-digit mobile number.";
        valid = false;
    }

    // Gender Validation
    if (gender === "") {
        document.getElementById("genderError").innerText = "Please select a gender.";
        valid = false;
    }

    // Experience Validation
    if (isNaN(experience) || experience < 0) {
        document.getElementById("experienceError").innerText = "Experience must be a non-negative number.";
        valid = false;
    }

    // Qualification Validation
    if (qualification === "") {
        document.getElementById("qualificationError").innerText = "Qualification cannot be empty.";
        valid = false;
    }

    // Profession Validation
    if (profession === "") {
        document.getElementById("professionError").innerText = "Please select a profession.";
        valid = false;
    }

    // Experience Level Validation
    if (experienceLevel === "") {
        document.getElementById("experienceLevelError").innerText = "Please select an experience level.";
        valid = false;
    }

    // Languages Validation
    if (languages === "") {
        document.getElementById("languagesError").innerText = "Please enter at least one language.";
        valid = false;
    }

    return valid;
}
