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
if (!(isset($_POST['username'])) || !(isset($_POST['password']))) {
    header('location: index.php');
    exit();
}
unset($_SESSION['username']);
unset($_SESSION['userRole']);

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
    $query = "SELECT table_name FROM combined_data FORCE INDEX (user_data) WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);
    echo "hi5";
    if ($result) {
        $row = $result->fetch_assoc();

        if ($row !== null && isset($row['table_name'])) {
            $table_name = $row['table_name'];

            if ($table_name) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";

                // Redirect based on table_name
                if ($table_name == 'citizens') {
                    $_SESSION['userRole'] = 'citizen';
                    $_SESSION['site'] = 'citizen.php';
                    header('location: citizens.php');
                } elseif ($table_name == 'rescuers') {
                    $_SESSION['userRole'] = 'rescuer';
                    $_SESSION['site'] = 'rescuer.php';
                    header('location: rescuers.php');
                } elseif ($table_name == 'admin') {
                    $_SESSION['userRole'] = 'admin';
                    $_SESSION['site'] = 'admin.php';
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

