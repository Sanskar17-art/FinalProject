<?php
header("Content-Type: application/json");

include 'connection.php';

// Check for a valid worker ID parameter
if (isset($_POST['worker_id'])) {
    $worker_id = intval($_POST['worker_id']);

    // Fetch worker details
    $query = "SELECT * FROM workers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $worker_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $worker = $result->fetch_assoc();
        echo json_encode([
            "success" => true,
            "data" => $worker
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Worker not found"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid worker ID"
    ]);
}
?>
