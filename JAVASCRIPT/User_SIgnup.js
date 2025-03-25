function validateForm() {
    let valid = true;

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const password = document.getElementById("password").value;
    const address = document.getElementById("address").value;

    // Name Validation
    if (!name.match(/^[a-zA-Z ]{2,30}$/)) {
        document.getElementById("nameError").innerText = "Please enter a valid name.";
        valid = false;
    } else {
        document.getElementById("nameError").innerText = "";
    }

     

    // Password Validation
    if (password.length < 6) {
        document.getElementById("passwordError").innerText = "Password must be at least 6 characters.";
        valid = false;
    } else {
        document.getElementById("passwordError").innerText = "";
    }

    // Address Validation
    if (address.trim() === "") {
        document.getElementById("addressError").innerText = "Address cannot be empty.";
        valid = false;
    } else {
        document.getElementById("addressError").innerText = "";
    }

    return valid;
}
