<?php
// Start the session if needed
session_start();
header('Content-Type: application/json');

// Check if worker is logged in
if (!isset($_SESSION['worker_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

try {
    // Connect to database
    $conn = new mysqli("localhost", "root", "", "project");
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $worker_id = $_SESSION['worker_id'];
    $updates = [];
    $params = [];
    $types = "";

    // Handle profile photo upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['profile_photo'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($photo['type'], $allowed_types)) {
            throw new Exception("Invalid file type. Only JPEG, PNG, and GIF are allowed.");
        }

        if ($photo['size'] > $max_size) {
            throw new Exception("File size too large. Maximum size is 5MB.");
        }

        // Create uploads directory if it doesn't exist
        $upload_dir = "../uploads/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate unique filename
        $file_extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
        $filename = "profile_" . $worker_id . "_" . time() . "." . $file_extension;
        $target_path = $upload_dir . $filename;

        // Move uploaded file
        if (!move_uploaded_file($photo['tmp_name'], $target_path)) {
            throw new Exception("Failed to upload profile photo.");
        }

        // Update database with new photo path
        $updates[] = "profile_photo = ?";
        $params[] = $filename;
        $types .= "s";
    }

    // Handle certificate upload
    if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] === UPLOAD_ERR_OK) {
        $certificate = $_FILES['certificate'];
        $allowed_types = ['application/pdf'];
        $max_size = 10 * 1024 * 1024; // 10MB

        if (!in_array($certificate['type'], $allowed_types)) {
            throw new Exception("Invalid file type. Only PDF files are allowed.");
        }

        if ($certificate['size'] > $max_size) {
            throw new Exception("File size too large. Maximum size is 10MB.");
        }

        // Create uploads directory if it doesn't exist
        $upload_dir = "../uploads/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate unique filename
        $file_extension = pathinfo($certificate['name'], PATHINFO_EXTENSION);
        $filename = "certificate_" . $worker_id . "_" . time() . "." . $file_extension;
        $target_path = $upload_dir . $filename;

        // Move uploaded file
        if (!move_uploaded_file($certificate['tmp_name'], $target_path)) {
            throw new Exception("Failed to upload certificate.");
        }

        // Update database with new certificate path
        $updates[] = "certificate = ?";
        $params[] = $filename;
        $types .= "s";
    }

    // Handle basic profile information
    $fields = [
        'name' => 's',
        'email' => 's',
        'mobile' => 's',
        'address' => 's',
        'gender' => 's',
        'profession' => 's',
        'experience' => 'i',
        'qualification' => 's',
        'experience_level' => 's',
        'languages' => 's'
    ];

    foreach ($fields as $field => $type) {
        if (isset($_POST[$field]) && !empty($_POST[$field])) {
            $updates[] = "$field = ?";
            $params[] = $_POST[$field];
            $types .= $type;
        }
    }

    if (!empty($updates)) {
        // Prepare the SQL statement
        $sql = "UPDATE workers SET " . implode(", ", $updates) . " WHERE id = ?";
        $params[] = $worker_id;
        $types .= "i";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Bind parameters dynamically
        $bind_params = array();
        $bind_params[] = &$types;
        for ($i = 0; $i < count($params); $i++) {
            $bind_params[] = &$params[$i];
        }
        call_user_func_array(array($stmt, 'bind_param'), $bind_params);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No updates provided']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
