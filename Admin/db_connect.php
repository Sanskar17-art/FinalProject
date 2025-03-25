<?php
$host = "localhost";
$user = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "project"; // Change this to your database name

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
