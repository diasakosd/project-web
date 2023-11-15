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

    // Check if the username already exists
    $check_query = "SELECT * FROM combined_data WHERE username='$username'";
    $check_result = mysqli_query($db, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Username already exists, show an error message
        $errors[] = "Username '$username' is already taken.";
    } else {
        // Username is available, proceed with registration
        $query = "INSERT INTO citizens (username, password, phone) VALUES ('$username', '$password', '$phone')";
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
</body>
</html>
