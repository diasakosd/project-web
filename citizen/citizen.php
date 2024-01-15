<?php
include 'session_citizen.php';
$_SESSION['site'] = '../citizen/citizens.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!-- Add your stylesheets here -->
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="navbar">
        <img class="logo" src="Screenshot_5.png" alt="Logo">
        <p><a class="logout-button" href="../logout.php">Logout</a></p>
        <a href="previous_offers.php">Previous Offers</a>
        <a href="current_offers.php">Current Offers</a>
        <a href="announcement_citizen.php">Announcements</a>
        <a href="citizen.php">Home</a>
    </div>
    <div class="container">
        <div class="header">
        </div>
        <div class="content">
            <!-- Add your citizen-specific content here -->
            <p>This is your citizens page. Add more content as needed.</p>
        </div>
        <div class="logout">
            <p><a href="../logout.php">Logout</a></p>
        </div>
    </div>
 
    <!-- Add your scripts here -->
    <script src="citizen-details-script.js"></script>
</body>
</html>
