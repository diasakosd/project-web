<?php
session_start();

//Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('location: ../logout.php');
    exit(); //Stop further execution
}
$site = $_SESSION['site'];
//Check if the user is a rescuer
if ($_SESSION['userRole'] !== 'admin') {
    //Redirect to some error page or display an error message
    echo "You do not have permission to access this pagesss.<br>";
    echo " <a class='back-button' style='margin-right:2%' href='$site'>Back</a>   <a class='logout-button' href='logout.php'>Logout</a> ";
    exit();
}

//Set the user's role
$_SESSION['userRole'] = 'admin';

$username = $_SESSION['username'];
$userRole = $_SESSION['userRole'];
?>
