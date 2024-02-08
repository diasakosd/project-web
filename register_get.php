<?php
session_start();

// If the user is already logged in, redirect to the appropriate page
if (isset($_SESSION['username'])) {
    // Check the user's role
    if ($_SESSION['userRole'] === 'citizen') {
        header('location: citizen/citizen.php');
    } elseif ($_SESSION['userRole'] === 'admin') {
        header('location: admin/admin.php');
    } elseif ($_SESSION['userRole'] === 'rescuer') {
        header('location: rescuer/rescuer.php');
    }
    exit();
}

unset($_SESSION['username']);
unset($_SESSION['userRole']);

$username = "";
$full_name = "";
$password = "";
$phone = "";
$errors = array();

$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the username already exists in either table
$username = mysqli_real_escape_string($db, $_POST['username']);
$check_query = "SELECT * FROM combined_data FORCE INDEX (user_data) WHERE username='$username';";
$check_result = mysqli_query($db, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    $errors[] = "Username '$username' is already taken.";
    echo json_encode(['error' => $errors]);
} else {
    // Username is available, proceed with registration
    $full_name = mysqli_real_escape_string($db, $_POST['full_name']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $latitude = mysqli_real_escape_string($db, $_POST['clickedLatitude']);
    $longitude = mysqli_real_escape_string($db, $_POST['clickedLongitude']);

    // Username is available, proceed with registration
$query = "INSERT INTO citizens (full_name, username, password, phone, latitude, longitude) VALUES ('$full_name', '$username', '$password', '$phone', '$latitude', '$longitude')";
mysqli_query($db, $query);
mysqli_close($db);

$_SESSION['username'] = $username;
$_SESSION['userRole'] = 'citizen';
$_SESSION['success'] = "You are now registered and logged in";
$_SESSION['site'] = '../citizen/citizen.php';

// Return JSON response
echo json_encode(['success' => true, 'redirect' => 'citizen/citizen.php']);
exit();
}
?>
