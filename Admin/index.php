<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit();
}
include 'sidebar.php';
?>

    <h2>Welcome to Admin Dashboard</h2>
    <p>Choose an option from the sidebar.</p>

</div> <!-- Closing content div from sidebar.php -->
</body>
</html>
