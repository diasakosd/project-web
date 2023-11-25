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
<div class="table-container">
        <div class="table_base" id="tableBase"></div>
</div>
<br>
<button id="updateTableBtn">Update Table</button>
<br><br>


    <div class="form-container">
        <p><h3>Update the Storage Table either by URL or File</h3></p>
        <br>
        <form action="table_storage.php" method="post" onsubmit="return validate_url_file()" enctype="multipart/form-data">
            <!-- URL Input -->
            <label for="url">URL:</label>
            <input type="text" name="url" id="url">
            <br>    
            <br>
            <!-- File Input -->
            <label for="file">File:</label>
            <input type="file" name="file" id="file">
            <button type="button" onclick="clearFileInput()">Clear File</button>
            <br>
            <br>
            <!-- Submit Button -->
            <input type="submit" value="Submit">
            <br>
            <br>
            <div class="message-container" id="messageContainer"></div>
        </form>
    </div>
    
<br>
    <!-- Add your scripts here -->
    <script src="url-file.js"></script>
    <script src ="url-file-validate.js"></script>
    <script src="clear_file.js"></script>
    <script src="base_table.js"></script>
   <script src="admin-details-script.js"></script>
</body>
</html>
