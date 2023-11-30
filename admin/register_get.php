<?php
session_start();
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

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $latitude = mysqli_real_escape_string($db, $_POST['clickedLatitude']);
    $longitude = mysqli_real_escape_string($db, $_POST['clickedLongitude']);

    // Check if the username already exists in either table
    $check_query = "SELECT * FROM combined_data FORCE INDEX (user_data) WHERE username='$username';";
    $check_result = mysqli_query($db, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        // Username already exists, send error response
        echo "Username '$username' is already taken.";
    } else {
        // Username is available, proceed with registration and insert latitude and longitude
        $query = "INSERT INTO rescuers (username, password, phone, latitude, longitude) VALUES ('$username', '$password', '$phone', '$latitude', '$longitude')";
        if (mysqli_query($db, $query)) {
            // Registration successful
            echo "Registration successful!";
        } else {
            // Error in registration
            echo "Error in registration: " . mysqli_error($db);
        }
        
    }
}
mysqli_close($db);
?>
