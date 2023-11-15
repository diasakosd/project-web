<?php
include 'session_rescuer.php';

// Check if the user is an admin
if ($_SESSION['userRole'] !== 'rescuer') {
    // Redirect to some error page or display an error message
    echo "You do not have permission to access this page.";
    exit();
}

// Continue with the rest of your code for admin users

// Now, you can use $username and other variables as needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!-- Add your stylesheets here -->
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?> (Rescuer)!</h1>
        </div>
        <div class="content">
            <!-- Add your admin-specific content here -->
            <p>This is your rescuer page. .</p>
        </div>
        <div class="logout">
            <p><a href="logout.php">Logout</a></p>
        </div>
    </div>
    <!-- Add your scripts here -->
</body>
</html>
