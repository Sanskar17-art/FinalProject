<?php
session_start();
session_destroy();
header('Location: /FinalProject/User_Login.php');
exit();
?>
