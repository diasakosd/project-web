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
else{
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['userRole']);
    unset($_SESSION['site']);
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
        <div class="top-overlay">
            <br>
            <div class="header"> 
                <h1>Register</h1>
            </div>
        </div>
        
        <div class="register-form">
            <form method="post" action="register_get.php" onsubmit="return validateForm()" id="registerForm">

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
                <div class="error_message">
        </div>
             </form>
             <br>

            <p>Already have an account? <a href="index.php">Login</a></p>
            
            <div class="map" id="map"></div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <script src="register-map-script.js"></script>
    <script src="register_error.js"></script>
</body>
</html>
