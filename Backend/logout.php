<?php
session_start();
session_unset();
session_destroy();
header("Location: /FinalProject/Worker_Login.php"); 
exit();
?>
