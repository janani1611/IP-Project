<?php
session_start();
session_destroy();  // Destroy session data
header("Location: login.php");
exit();
?>
