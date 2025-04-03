<?php
session_start();
require_once 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to submit a hiring request.";
    header("Location: ../User/login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = $_SESSION['user_id'];
    $worker_id = $_POST['worker_id'];
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $job_type = $_POST['job_type'];
    $budget = isset($_POST['budget']) ? $_POST['budget'] : null;
    $estimated_hours = isset($_POST['estimated_hours']) ? $_POST['estimated_hours'] : null;
    $start_date = $_POST['start_date'];
    $deadline = $_POST['deadline'];
    $contact_person = $_POST['contact_person'];
    $mobile_number = $_POST['mobile_number'];
    
    // Get location data
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $location_address = $_POST['location_address'];
    
    // Validate inputs
    $errors = [];
    
    if (empty($job_title)) {
        $errors[] = "Job title is required";
    }
    
    if (empty($job_description)) {
        $errors[] = "Job description is required";
    }
    
    if (empty($job_type)) {
        $errors[] = "Job type is required";
    }
    
    if ($job_type == 'hourly' && empty($estimated_hours)) {
        $errors[] = "Estimated hours is required for hourly jobs";
    }
    
    if ($job_type == 'fixed' && empty($budget)) {
        $errors[] = "Budget is required for fixed price jobs";
    }
    
    if (empty($start_date)) {
        $errors[] = "Start date is required";
    }
    
    if (empty($deadline)) {
        $errors[] = "Deadline is required";
    }
    
    if (empty($contact_person)) {
        $errors[] = "Contact person is required";
    }
    
    if (empty($mobile_number)) {
        $errors[] = "Mobile number is required";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobile_number)) {
        $errors[] = "Mobile number must be 10 digits";
    }
    
    // Validate location data
    if (empty($latitude) || empty($longitude)) {
        $errors[] = "Please select a location on the map";
    }
    
    if (empty($location_address)) {
        $errors[] = "Location address is required";
    }
    
    // If no errors, proceed with database insertion
    if (empty($errors)) {
        try {
            // Prepare SQL statement
            $sql = "INSERT INTO hiring_requests (user_id, worker_id, job_title, job_description, 
                    job_type, budget, estimated_hours, start_date, deadline, status, 
                    contact_person, mobile_number, latitude, longitude, location_address) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisssdisssssds", 
                $user_id, 
                $worker_id, 
                $job_title, 
                $job_description, 
                $job_type, 
                $budget, 
                $estimated_hours, 
                $start_date, 
                $deadline, 
                $contact_person, 
                $mobile_number, 
                $latitude, 
                $longitude, 
                $location_address
            );
            
            // Execute the statement
            if ($stmt->execute()) {
                // Update worker availability status
                $update_sql = "UPDATE workers SET is_available = 0 WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("i", $worker_id);
                $update_stmt->execute();
                
                $_SESSION['success'] = "Hiring request submitted successfully!";
                header("Location: ../User/worker_profile.php?id=" . $worker_id);
                exit();
            } else {
                $errors[] = "Error submitting hiring request. Please try again.";
            }
        } catch (Exception $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
    
    // If there are errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        $_SESSION['form_data'] = $_POST; // Store form data to repopulate the form
        header("Location: ../User/Hire_Worker.php");
        exit();
    }
} else {
    // If not a POST request, redirect to workers page
    header("Location: ../User/Workers.php");
    exit();
}
?> 