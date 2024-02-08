<?php
session_start();

//Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('location: ../logout.php');
    exit(); 
}

$site = $_SESSION['site'];

if ($_SESSION['userRole'] !== 'citizen') {
    //Redirect to some error page or display an error message
    echo "You do not have permission to access this pagess.<br>";
    echo " <a class='back-button' style='margin-right:2%' href='$site'>Back</a>   <a class='logout-button' href='logout.php'>Logout</a> ";

    exit();
}


$_SESSION['userRole'] = 'citizen';

$username = $_SESSION['username'];
$userRole = $_SESSION['userRole'];
?>
