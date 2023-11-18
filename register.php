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

        $_SESSION['username'] = $username;
        $_SESSION['userRole'] = 'citizen';
        $_SESSION['success'] = "You are now registered and logged in";
        header('location: citizens.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="style_register.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="header">
            <h1>Register</h1>
        </div>
        <div class="register-form">
            <form method="post" action="register.php" onsubmit="return validateForm()">

            <div class="input-box">
                <label for="full_name">Fullname:</label><br>
                <input type="text" id="full_name" name="full_name" placeholder="Fullname" required>
                <i class='bx bxs-user-plus'></i>
            </div>

            <div class="input-box">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" placeholder="Username" required> 
                <i class='bx bxs-user-circle'></i>
            </div>

            <div class="input-box">
                <label for="password">Password:</label><br>
               <input type="password" id="password" name="password" placeholder="Password" required>
               <i class='bx bxs-lock'></i>
            </div>

            <div class="input-box">
                <label for="phone">Phone:</label><br>
               <input type="text" id="phone" name="phone" placeholder="Phone" required>
               <i class='bx bxs-phone'></i>
            </div>
                <!-- Add hidden input fields for latitude and longitude -->
                <input type="hidden" id="clickedLatitude" name="clickedLatitude">
                <input type="hidden" id="clickedLongitude" name="clickedLongitude">

                <button type="submit" name="reg_user">Register</button>
             </form>

            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
            ?>
            <p>Already have an account? <a href="index.php">Login</a></p>
            
            <div class="map" id="map"></div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</body>
<script src="register-map-script.js"></script>
</html>
