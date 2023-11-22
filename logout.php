<?php
session_start();
session_destroy();
unset($_SESSION['username']);
unset($_SESSION['userRole']);
unset($_SESSION['site']);
header('location: index.php');
?>
