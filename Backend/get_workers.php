<?php
require_once "connection.php"; // Include database connection

$profession = isset($_GET['profession']) ? $_GET['profession'] : '';

// Prepare SQL query
$query = "SELECT id, name, email, mobile, profession, experience, qualification, profile_photo FROM workers";
if (!empty($profession)) {
    $query .= " WHERE profession LIKE ?";
}

$stmt = $conn->prepare($query);

if (!empty($profession)) {
    $searchTerm = "%$profession%";
    $stmt->bind_param("s", $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch worker profiles
$workers = [];
while ($row = $result->fetch_assoc()) {
    $workers[] = $row;
}

// Return JSON response
echo json_encode($workers);
$stmt->close();
$conn->close();
?>
