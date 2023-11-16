<?php
include 'session_admin.php';

// Check if the user is an admin
if ($userRole !== 'admin') {
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
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<br>
<br>
     <!-- Menu Bar -->
     <div class="menu">
        <ul>
            <li><a href="admin_storage_managment.php">Storage Management</a></li>
            <li><a href="admin_rescuer_managment.php">Rescuer Management</a></li>
            <li><a href="admin_announcements.php">Announcements</a></li>
            <li><a href="logout.php">Logout</a></li>
            <br>
            <li><?php 
                echo htmlspecialchars($username);?></li>
        </ul>
    </div>
<br>

    <div class="container">
        <div class="header">
            <h1>Welcome, <?php 
                echo htmlspecialchars($username);
                echo "(";
                echo htmlspecialchars($userRole);
                echo ")!";
            ?></h1>
        </div>
        <br>
        <div class="content">
            <!-- Add your admin-specific content here -->
            <p>This is your admin page. Add more content as needed.</p>
        </div>
        <div class="logout">
            <p><a href="logout.php">Logout</a></p>
        </div>
    </div>
    <!-- Add your scripts here -->
</body>
</html>

