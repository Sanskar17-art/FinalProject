<?php
session_start();
header('Content-Type: application/json');

include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['worker_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

// Check if request is POST and contains is_available parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['is_available'])) {
    $worker_id = $_SESSION['worker_id'];
    $is_available = $_POST['is_available'] == 1 ? 1 : 0;

    try {
        // Update the availability status in the workers table
        $sql = "UPDATE workers SET is_available = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $is_available, $worker_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Availability updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update availability']);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?> 