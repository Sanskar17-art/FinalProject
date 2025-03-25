<?php
include '../Backend/connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = 19 ;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $start_datetime = $_POST['start_datetime'];
    $end_datetime = $_POST['end_datetime'];
    $location = $_POST['location'];
    $contact_person = $_POST['contact_person'];
    $contact_number = $_POST['contact_number'];
    $budget = $_POST['budget'];
    $payment_mode = $_POST['payment_mode'];
    $advance_payment = $_POST['advance_payment'] ?: NULL;
    $special_instructions = $_POST['special_instructions'];

    $sql = "INSERT INTO tasks 
        (user_id, title, description, category, priority, start_datetime, end_datetime, location, contact_person, contact_number, budget, payment_mode, advance_payment, special_instructions)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssssdsss", $user_id, $title, $description, $category, $priority, $start_datetime, $end_datetime, $location, $contact_person, $contact_number, $budget, $payment_mode, $advance_payment, $special_instructions);

    if ($stmt->execute()) {
        echo "Task submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
