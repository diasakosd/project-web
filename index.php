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
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Query to check in combined_data table
    $query = "SELECT table_name FROM combined_data WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row !== null && isset($row['table_name'])) {
            $table_name = $row['table_name'];

            if ($table_name) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";

                // Redirect based on table_name
                if ($table_name == 'citizens') {
                    $_SESSION['userRole'] = 'citizen';
                    header('location: citizens.php');
                } elseif ($table_name == 'rescuers') {
                    $_SESSION['userRole'] = 'rescuers';
                    header('location: rescuers.php');
                } elseif ($table_name == 'admin') {
                    $_SESSION['userRole'] = 'admin';
                    header('location: admin.php');
                } else {
                    $errors[] = "Unknown table name: $table_name";
                }
                exit();
            } else {
                $errors[] = "Wrong username/password combination";
            }
        } else {
            $errors[] = "Wrong username/password combination";
        }
    } else {
        $errors[] = "Query failed: " . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_login.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Login</h1>
        </div>
        <div class="login-form">
            <form method="post" action="index.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login_user">Login</button>
            </form>
            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
            ?>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>
