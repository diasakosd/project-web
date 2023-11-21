<?php
session_start();
session_destroy();
unset($_SESSION['username']);
unset($_SESSION['userRole']);
header('location: index.php');
?>
