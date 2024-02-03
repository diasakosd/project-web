<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('location: ../logout.php');
    exit(); // Stop further execution
}
// Check if the user is a rescuer
$site = $_SESSION['site'];
if ($_SESSION['userRole'] !== 'rescuer') {
    // Redirect to some error page or display an error message
    echo "You do not have permission to access this page.<br>";
    echo " <a class='back-button' style='margin-right:2%' href='$site'>Back</a>   <a class='logout-button' href='logout.php'>Logout</a> ";
    exit();
}


$_SESSION['userRole'] = 'rescuer';

$username = $_SESSION['username'];
$userRole = $_SESSION['userRole'];
?>
