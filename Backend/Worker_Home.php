<?php
session_start();
header('Content-Type: application/json');

include 'connection.php';$username = "root";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['worker_id'])) {
    $worker_id = $_POST['worker_id'];

    $sql = "SELECT name, email, profession, profile_photo FROM workers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $worker_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $profileImage = !empty($row['profile_photo']) ? "Backend/uploads/" . $row['profile_photo'] : "uploads/default.png";

        echo json_encode([
            "success" => true,
            "name" => $row['name'],
            "email" => $row['email'],
            "profession" => $row['profession'],
            "profile_photo" => $profileImage
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Worker not found."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

$conn->close();
?>
