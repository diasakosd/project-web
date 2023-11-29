<?php

session_start();

// If the user is already logged in, redirect to the appropriate page
if (isset($_SESSION['username'])) {
    // Check the user's role
    if ($_SESSION['userRole'] === 'citizen') {
        header('location: citizen/citizens.php');
    } elseif ($_SESSION['userRole'] === 'admin') {
        header('location: admin/admin.php');
    } elseif ($_SESSION['userRole'] === 'rescuer') {
        header('location: rescuer/rescuers.php');
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
    <link rel="stylesheet" href="style_login.css">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Login</h1>
        </div>
        <div class="login-form">
            <form method="post" action="login.php" id="loginForm">
                <div class="input-box">
                    <input type="text" id="username" name="username" placeholder="Username" required> 
                    <i class='bx bxs-user-circle'></i>
                </div>

                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock'></i>
                </div>
                <button type="submit" name="login_user" id="loginButton">Login</button>
            </form>
            <div class="reg">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </div>
        <div class="error_message">
        </div>
    </div>
    <script src="login_error.js"></script>
</body>
</html>
