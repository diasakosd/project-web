<?php
session_start();
// If the user is already logged in, redirect to the appropriate page
if (isset($_SESSION['username'])) {
    // Check the user's role
    if ($_SESSION['userRole'] === 'citizen') {
        header('location: citizens.php');
    } elseif ($_SESSION['userRole'] === 'admin') {
        header('location: admin.php');
    } elseif ($_SESSION['userRole'] === 'rescuer') {
        header('location: rescuers.php');
    }
    exit();
}
unset($_SESSION['username']);
unset($_SESSION['userRole']);
// initializing variables
$username = "";
$password = "";
$phone = "";
$errors = array();
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');
// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
// REGISTER USER
if (isset($_POST['reg_user'])) {
    $full_name = mysqli_real_escape_string($db, $_POST['full_name']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $latitude = mysqli_real_escape_string($db, $_POST['clickedLatitude']);
    $longitude = mysqli_real_escape_string($db, $_POST['clickedLongitude']);
    // Check if the username already exists in either table
    $check_query = "SELECT * FROM combined_data FORCE INDEX (user_data) WHERE username='$username'";
    
    $check_result = mysqli_query($db, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        // Username already exists, show an error message
        $errors[] = "Username '$username' is already taken.";
    } else {
        // Username is available, proceed with registration and insert latitude and longitude
        $query = "INSERT INTO citizens (full_name,username, password, phone, latitude, longitude) VALUES ('$full_name','$username', '$password', '$phone', '$latitude', '$longitude')";
        mysqli_query($db, $query);
        mysqli_close($db);
        $_SESSION['username'] = $username;
        $_SESSION['userRole'] = 'citizen';
        $_SESSION['success'] = "You are now registered and logged in";
        $_SESSION['site'] = 'citizen.php';
        header('location: citizens.php');
        exit();
    }
}
?>