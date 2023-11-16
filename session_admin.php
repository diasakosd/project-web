<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('location: index.php');
    exit(); // Stop further execution
}

// Check if the user is a rescuer
if ($_SESSION['userRole'] !== 'admin') {
    // Redirect to some error page or display an error message
    echo "You do not have permission to access this page.";
    exit();
}
// Set the user's role
$_SESSION['userRole'] = 'admin';

$username = $_SESSION['username'];
$userRole = $_SESSION['userRole'];
?>
