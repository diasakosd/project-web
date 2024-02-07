<?php
include 'session_rescuer.php';
$_SESSION['site'] = '../rescuer/resc_load_manag.php';

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
    
    <link rel="stylesheet" href="rescuer.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
            <input type="checkbox" id="check">
            <label for="check" class="chBtn">
                <i class='bx bx-menu'></i>
            </label>
            <div id="sidebar" class="sidebar">
                <label for="check" class="chBtn2">
                    <i class='bx bx-menu'></i>
                </label><br>
                <table id="side-table">
                    <tr>
                        <td><a href="resc_see_cargo.php">See cargo</a></td>
                    </tr>
                    <tr>
                        <td><a href="resc_load_manag.php">Cargo Management</a></td>
                    </tr>
                    <tr>
                        <td><a href="rescuer.php">Home</a></td>
                    </tr>
                    <tr>
                        <td><br><a class="logout-button" href="../logout.php">Logout</a></td>
                    </tr>
                </table>
            </div>
            
            <table class="tableResc" id="baseCargoTable" border="1">
                <tbody></tbody>
            </table>
            <br>
            <label for="getFromBaseItem">Enter Quantity:</label><br>
            <input type="number" id="getFromBaseItem">
            <br><br>
            <div class="cargo" id="cargo">
            <button type="button" id="LoadBtn">Load cargo.</button>
            </div>
            <br>
            <br>
            <br>
            </div>  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="base_table-resc.js"></script>
    <script src="Cargo_Manag.js"></script>
    <script src="extras.js"></script>
    <script src="distance_check.js"></script>
    
</body>
</html>