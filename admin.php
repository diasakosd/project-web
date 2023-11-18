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
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="admin.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
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
        
    </div>
    <!-- Add your scripts here -->
    <br>
    <br>
    <br>
    <div id="map">

    </div>
    <br>
    <br>
    <br>
</body>
<script src="admin-map-script.js"></script>
</html>

