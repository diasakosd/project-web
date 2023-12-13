<?php
include 'session_admin.php';
$_SESSION['site'] = '../admin/admin_rescuer_managment.php';
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
            <p>This is your admin page for Rescuer Managment. Add more content as needed.</p>
        </div>
    </div>
        <div class="container1">
            <div class="top-overlay">
                <br>
                <div class="header"> 
                    <h1>Rescuer Creator</h1>
                </div>
            </div>
            
            <div class="register-form">
                <form method="post" action="register_get.php" onsubmit="return validateForm()" id="registerForm">


                    <div class="input-box">
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username" placeholder="Username" required> 
                        <i class='bx bxs-user-circle'></i>
                    </div>

                    <div class="input-box">
                        <label for="password">Password:</label><br>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <i class='bx bxs-lock'></i>
                    </div>

                    <div class="input-box">
                        <label for="phone">Phone:</label><br>
                        <input type="text" id="phone" name="phone" placeholder="Phone" required>
                        <i class='bx bxs-phone'></i>
                    </div>
                    <!-- Add hidden input fields for latitude and longitude -->
                    <input type="hidden" id="clickedLatitude" name="clickedLatitude">
                    <input type="hidden" id="clickedLongitude" name="clickedLongitude">

                    <button type="submit" name="reg_user">Register</button>
                    <div class="error_message"></div>
        
                </form>
            </div>

        <p>Already have an account? <a href="index.php">Login</a></p>
                
    </div>
    <div class="map1" id="map"></div>

    <script src="rescuer_manage_map.js"></script>
    <script src="register_error.js"></script>
    <script src="admin-details-script.js"></script>
</body>
</html>
