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
        header('location: rescuer.php');
    }
    exit();
}

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

    $query = "INSERT INTO citizens (username, password, phone) VALUES ('$username', '$password', '$phone')";
    mysqli_query($db, $query);

    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now registered and logged in";
    header('location: citizens.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style_register.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Register</h1>
        </div>
        <div class="register-form">
            <form method="post" action="register.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>

                <button type="submit" name="reg_user">Register</button>
            </form>
            <p>Already have an account? <a href="index.php">Login</a></p>
        </div>
    </div>
</body>
</html>
