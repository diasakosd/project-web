<?php
include 'session_rescuer.php';
$_SESSION['site'] = '../rescuer/rescuer.php';

$db = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "web";

$conn = mysqli_connect($db, $dbUsername, $dbPassword, $dbName);
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
        <a href="resc_see_cargo.php">See cargo</a>
        <a href="resc_load_manag.php">Cargo Management</a>
        <a href="rescuer.php">Home</a>
    </div>   
    
    <div class="content">
        <h3>This is your rescuer page to see your loaded cargo. Add more content as needed.</h3>
        
        <table id="loadedCargoTable" border="1">
                <tbody></tbody>
        </table>
        <br>
        <button type="button" id="dischargeBtn">Discharge cargo.</button>
        <button type="button" id="LoadBtn">Load cargo.</button>
    </div>
    
<br>
<br>
<br><br>

    <script src="rescuer-details-script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="cargo_table.js"></script>
</body>
</html>