<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = ""; // To store success or error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $worker_name = trim($_POST['worker_name']);
    $email = trim($_POST['email']);
    $evidence_text = trim($_POST['evidence']);

    // Insert data into the database
    $sql = "INSERT INTO reports (worker_name, email, evidence) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $worker_name, $email, $evidence_text);

    if ($stmt->execute()) {
        $message = "success"; // Report submitted successfully
    } else {
        $message = "error"; // Error occurred
    }

    $stmt->close();
}
include('Navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Form</title>
    <link rel="stylesheet" href="../CSS/Report.css">

    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <h2>Report Form</h2>
    <center>
    <form method="POST" action="report.php">
        <label for="worker_name">Worker Name:</label>
        <input type="text" id="worker_name" name="worker_name" required><br>
 
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="evidence">Evidence/Report Text:</label>
        <textarea id="evidence" name="evidence" rows="4" required></textarea><br>

        <input type="submit" value="Submit Report">
    </form>
    </center>

    <!-- JavaScript for SweetAlert Popups -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($message == "success") { ?>
                Swal.fire({
                    title: "Success!",
                    text: "Your report has been submitted successfully!",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            <?php } elseif ($message == "error") { ?>
                Swal.fire({
                    title: "Error!",
                    text: "Something went wrong. Please try again.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            <?php } ?>
        });
    </script>

</body>
</html>
