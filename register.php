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
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);

    // Check if latitude and longitude are set (user has clicked the map)
    if (isset($_SESSION['clickedLatitude']) && isset($_SESSION['clickedLongitude'])) {
        $latitude = $_SESSION['clickedLatitude'];
        $longitude = $_SESSION['clickedLongitude'];

        // Proceed with registration and insert latitude and longitude
        $query = "INSERT INTO citizens (username, password, phone) VALUES ('$username', '$password', '$phone')";
        mysqli_query($db, $query);

        $_SESSION['username'] = $username;
        $_SESSION['userRole'] = 'citizen';
        $_SESSION['success'] = "You are now registered and logged in";
        header('location: citizens.php');
        exit();
    } else {
        // Latitude and longitude are not set, show an error message
        $errors[] = "You need to select a location on the map.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/path/to/leaflet.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="style_register.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
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
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>

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
        </div>
    </div>
    <br>
    <br>
    <br>
    <div id="map">





    </div>
    <br>
    <br>
    <br>
</body>
<script src="map-script.js"></script>
</html>
