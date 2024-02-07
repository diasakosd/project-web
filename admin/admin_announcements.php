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
        <img class="logo" src="Screenshot_5.png" alt="Logo">
        <p><a class="logout-button" href="../logout.php">Logout</a></p>
        <a href="admin_announcements.php">Announcements</a>
        <a href="admin_rescuer_managment.php">Rescuer Managment</a>
        <a href="admin_storage_managment.php">Storage Managment</a>
        <a href="admin.php">Home</a>
    </div>

    <div class="container">
        <div class="header"></div>
        <br><br>
        <div class="content">
            <p>This is your page for Announcements.</p>
        </div>
    </div>

    <div class="announcement-form-container">
        <form id="announcementForm">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <br>
            <label for="body">Body:</label>
            <textarea id="body" name="body" required></textarea>
            <br>
            <label for="selectedItems">Select Items:</label><br>
            <select id="selectedItems" name="selectedItems[]" multiple>
                <!--Items will be populated asycronically using Javascript-->
            </select>

            <!--Hidden field to save each selected item-->
            <input type="hidden" id="itemCategories" name="itemCategories" value="">

            <br>
            <button type="button" onclick="submitForm()">Submit</button>
        </form>

        <!--Message if the insertion was successful-->
        <div id="successMessage"></div>
        <!--Display the selected items and categories-->
        <div id="selectedItemsMessage"></div>

    
    <script src="announcement_script.js"></script><!--script for handling the announcements-->


 
    <script src="admin-details-script.js"></script><!--script for displaying admin name-->
</body>
</html>
