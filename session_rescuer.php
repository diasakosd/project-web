<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit(); // Stop further execution
}
// Check if the user is a rescuer
if ($_SESSION['userRole'] !== 'rescuer') {
    // Redirect to some error page or display an error message
    echo "You do not have permission to access this page.";
    exit();
}

$_SESSION['userRole'] = 'rescuer';

$username = $_SESSION['username'];
$userRole = $_SESSION['userRole'];
?>
