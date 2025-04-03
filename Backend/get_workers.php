<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Get profession from query string
$profession = isset($_GET['profession']) ? $conn->real_escape_string($_GET['profession']) : '';

// Prepare the query to fetch only available workers
$sql = "SELECT * FROM workers WHERE is_available = 1";
if (!empty($profession)) {
    $sql .= " AND profession LIKE '%$profession%'";
}
$sql .= " ORDER BY name ASC";

$result = $conn->query($sql);

$workers = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Set default profile photo if none exists
        if (empty($row['profile_photo'])) {
            $row['profile_photo'] = 'default-profile.jpg';
        }
        $workers[] = $row;
    }
}

echo json_encode($workers);

$conn->close();
?>
