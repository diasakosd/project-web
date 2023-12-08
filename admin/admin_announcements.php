<!-- admin_announcements.php -->

<?php
include 'session_admin.php';
$_SESSION['site'] = '../admin/admin_announcements.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    <!-- Adjust the paths to your CSS file and Leaflet map script -->
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

</head>
<body>
    <div class="navbar">
        <!-- ... Your existing navbar code ... -->
    </div>

    <div class="container">
        <div class="header"></div>
        <br><br>
        <div class="content">
            <p>This is your admin page for Announcements. Add more content as needed.</p>
        </div>
    </div>

    <!-- New div for the form and success message -->
    <div class="announcement-form-container">
        <form id="announcementForm">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <br>
            <label for="body">Body:</label>
            <textarea id="body" name="body" required></textarea>
            <br>
            <button type="button" onclick="submitForm()">Submit</button>
        </form>

        <!-- Display a message if the insertion was successful -->
        <div id="successMessage"></div>
    </div>

    <br>
    <br>
    <br><br>

    <!-- Include the new JavaScript file -->
    <script src="announcement_script.js"></script>

    <!-- Add your scripts here -->
    <script src="admin-details-script.js"></script>
</body>
</html>
