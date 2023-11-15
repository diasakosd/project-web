<?php
include 'session_citizen.php';

// Check if the user is a citizen
if ($_SESSION['userRole'] !== 'citizen') {
    // Redirect to some error page or display an error message
    echo "You do not have permission to access this page.";
    exit();
}

// Continue with the rest of your code for citizen users

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
            <h1>Welcome, <?php echo htmlspecialchars($userRole); echo " ";echo $username; ?>!</h1>
        </div>
        <div class="content">
            <!-- Add your citizen-specific content here -->
            <p>This is your citizen page. Add more content as needed.</p>
        </div>
        <div class="logout">
            <p><a href="logout.php">Logout</a></p>
        </div>
    </div>
    <!-- Add your scripts here -->
</body>
</html>
