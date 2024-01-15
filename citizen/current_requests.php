<?php
session_start();
include 'db_connect.php';

// Assuming you have a session variable for the citizen ID
$citizenId = $_SESSION['citizen_id'];

$db = connectToDatabase();

// Query for requests with status 'NO' (not accepted) for the current citizen
$stmt = $db->prepare("SELECT * FROM citizen_request WHERE username = ? AND accepted = 'NO'");
$stmt->execute([$citizenId]);
$currentRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <a href="previous_requests.php">Previous Requests</a>
        <a href="current_requests.php">Current Requests</a>
        <a href="previous_offers.php">Previous Offers</a>
        <a href="current_offers.php">Current Offers</a>
        <a href="announcement_citizen.php">Announcements</a>
        
    </div>
    <div class="container">
        <div class="header">
        </div>
        <div class="content">
            <!-- Add your citizen-specific content here -->
            <p>This is your citizens for CURRENT REQUESTS page.</p>
        </div>
        <div class="logout">
            <p><a href="../logout.php">Logout</a></p>
        </div>
    </div>

    <div class="announcement-container">
        <div class="content" id="announcementsContainer"></div>
        <br><br>
    </div>
 
    <!-- Add your scripts here -->
    <script src="citizen-details-script.js"></script>
   
</body>
</html>