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
    <div class="table-content">
        <div class="table_base" id="tableBase"></div>
    </div>
    <div class="category-container">
        <div class="category-menu" id="categoryMenu"></div>
    </div>
</div>




<br>
<button id="updateTableBtn">Update Table</button>
<br><br>
<div class="update-form">
    <form id="updateTableForm" method="post" action="update_table.php" novalidate>

        <div class="input-box">
            <label for="category-form">Category:</label><br>
            <input type="text" id="category-form" name="category-form" placeholder="Category" required>
            <i class='bx bxs-user-plus'></i>
        </div>

        <div class="input-box">
            <label for="item-form">Item:</label><br>
            <input type="text" id="item-form" name="item-form" placeholder="Item" required>
            <i class='bx bxs-user-circle'></i>
        </div>

        <div class="input-box">
            <label for="quantity-form">Quantity:</label><br>
            <input type="number" id="quantity-form" name="quantity-form" placeholder="Quantity" required>
            <i class='bx bxs-lock'></i>
        </div>

        <div class="input-box">
            <label for="action-form">Action:</label><br>
            <select id="action-form" name="action-form" required>
                <option value="ADD">Add</option>
                <option value="UPDATE">Update</option>
                <option value="DELETE">Delete</option>
            </select>
            <i class='bx bxs-phone'></i>
        </div>
        <br>
        <button type="submit" name="table_submit">Submit</button>
        <br>
        <div class="err_message"> </div>
    </form>
</div>


<br><br>
    <div class="form-container">
        <p><h3>Update the Storage Table either by URL or File</h3></p>
        <br>
        <form id = "jsonForm" action="table_storage.php" method="post" onsubmit="return validate_url_file()" enctype="multipart/form-data">
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
<div>
  <canvas id="myChart" width="800" height="400"></canvas>
</div>

    
<br>

    <!-- Add your scripts here -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="graph.js"></script>
    <script src="update_table_error.js"></script>
    <script src="url-file.js"></script>
    <script src ="url-file-validate.js"></script>
    <script src="clear_file.js"></script>
    <script src="base_table.js"></script>
   <script src="admin-details-script.js"></script>
</body>
</html>
