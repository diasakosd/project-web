<?php
include 'session_citizen.php';
$_SESSION['site'] = '../citizen/current_offers.php';
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
        <a href="announcement_citizen.php">Announcements</a>
        <a href="previous_offers.php">Previous Offers</a>
        <a href="current_offers.php">Current Offers</a>
        <a href="previous_requests.php">Previous Requests</a>
        <a href="current_requests.php">Current Requests</a>
        <a href="citizen.php">Home</a>
    </div>
    <div class="container">
        <div class="header">
        </div>
        <div class="content">
            <!-- Add your citizen-specific content here -->
            <p>This is your citizens for CURRENT OFFERS page. Add more content as needed.</p>
        </div>
        <div class="logout">
            <p><a href="../logout.php">Logout</a></p>
        </div>
    </div>

    <div class="announcement-container">
    <div class="content" id="announcementsContainer"></div>
    <br><br>
</div>

<div class="announcement-checkbox-container"></div>
<div class="announcement-submit">
    <form id="submitAnnouncementsForm"></form>
    <div id="selectedAnnouncementsMessage"></div>
    <!-- Corrected function name in the onclick attribute -->
    <button type="button" onclick="submitSelectedAnnouncements()">Delete Announcement</button>
    <div class="successmessage"></div>
</div>

<!-- Include your scripts here -->
<script src="citizen-details-script.js"></script>
<script src="current_offers.js"></script>
<script src="create_offers_checkboxes.js"></script>
</body>
</html>