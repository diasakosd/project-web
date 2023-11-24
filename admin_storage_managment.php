<?php
include 'session_admin.php';
$_SESSION['site'] = 'admin_storage_managment.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    
    <!-- Adjust the paths to your CSS file and Leaflet map script -->
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="navbar">
        <img class="logo" src="Screenshot_5.png" alt="Logo">
        <p><a class="logout-button" href="logout.php">Logout</a></p>
        <a href="admin_announcements.php">Announcements</a>
        <a href="admin_rescuer_managment.php">Rescuer Managment</a>
        <a href="admin_storage_managment.php">Storage Managment</a>
        <a href="admin.php">Home</a>
    </div>

    <div class="container">
        <div class="header">
            
        </div>
        <br><br>
        <div class="content">
            <p>This is your admin page for Storage Managment. Add more content as needed.</p>
        </div>
        <!-- Include any additional HTML content here if needed -->
    </div>
<br>
<br>
<br>
<div class="table_base">
</div>
<br>
    <!-- Add your scripts here -->
    <script src="admin-details-script.js"></script>
</body>
</html>
