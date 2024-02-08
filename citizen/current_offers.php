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

    <link rel="stylesheet" href="citizen.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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

    <div class="content">
            <input type="checkbox" id="check">
            <label for="check" class="chBtn">
                <i class='bx bx-menu'></i>
            </label>
            <!-- SIDEBAR CODE -->
            <div id="sidebar" class="sidebar">
                <label for="check" class="chBtn2">
                    <i class='bx bx-menu'></i>
                </label><br>
                <table id="side-table">
                    <tr>
                        <td><a href="announcement_citizen.php">Announcements</a></td>
                    </tr>
                    <tr>
                        <td><a href="previous_offers.php">Previous Offers</a></td>
                    </tr>
                    <tr>
                        <td><a href="current_offers.php">Current Offers</a></td>
                    </tr>
                    <tr>
                        <td><a href="previous_requests.php">Previous Requests</a></td>
                    </tr>
                    <tr>
                        <td><a href="current_requests.php">Current Requests</a></td>
                    </tr>
                    <tr>
                        <td><a href="citizen.php">Home</a></td>
                    </tr>
                    <tr>
                        <td><br><a class="logout-button" href="../logout.php">Logout</a></td>
                    </tr>
                </table>
            </div>
    </div>

    <div class="container">
        <div class="header">
        </div>
        <div class="content">
           
            <p>This is your Current Offers page.</p>
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
    <button type="button" onclick="submitSelectedAnnouncements()">Delete Offer</button>
    <div class="successmessage"></div>
</div>

<!-- Scripts -->
<script src="citizen-details-script.js"></script>
<script src="current_offers.js"></script>
<script src="create_offers_checkboxes.js"></script>
<script src="extras.js"></script>
</body>
</html>