<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit();
}
include 'sidebar.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the logged-in user's ID (assuming it's stored in session)
$user_id = $_SESSION["user_id"];  // Ensure this session variable is set when a user logs in

// Fetch reports submitted by the logged-in user
$sql = "SELECT reports.id, reports.worker_name, reports.email, reports.evidence, reports.submitted_at, 
               users.username AS submitted_by 
        FROM reports 
        JOIN users ON reports.user_id = users.id
        WHERE reports.user_id = ?"; // Filter by logged-in user

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="user_report.css">
</head>
<body>

    <h2>Your Submitted Reports</h2>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Worker Name</th>
                <th>Email</th>
                <th>Evidence/Report</th>
                <th>Date Submitted</th>
                <th>Submitted By (User)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['worker_name'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['evidence'] . "</td>
                        <td>" . $row['submitted_at'] . "</td>
                        <td>" . $row['submitted_by'] . "</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
