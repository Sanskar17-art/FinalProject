<?php
session_start();
require_once "connection.php"; // Database connection file

// Check if the worker is logged in
if (!isset($_SESSION['worker_id'])) {
    header("Location: ../Worker_Login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $worker_id = $_POST["worker_id"];
    $worker_name = $_POST["worker_name"];
    $worker_email = $_POST["email"];
    $user_id = $_POST["user_id"]; // User being reported
    $report_details = $_POST["evidence"];

    // Insert report into database
    $query = "INSERT INTO worker_reports (worker_id, worker_name, worker_email, user_id, report_details) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issis", $worker_id, $worker_name, $worker_email, $user_id, $report_details);

    if ($stmt->execute()) {
        echo "Report submitted successfully.";
        header("Location: ../Worker_Home.php"); // Redirect after submission
        exit();
    } else {
        echo "Error submitting report: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
