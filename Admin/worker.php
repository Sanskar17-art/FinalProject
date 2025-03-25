<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit();
}
include 'sidebar.php';
?>

    <h2>User Management</h2>
    <p>Manage all registered users here.</p>

</div>
</body>
</html>
