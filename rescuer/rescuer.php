<?php
include 'session_rescuer.php';
$_SESSION['site'] = '../rescuer/rescuer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rescuer.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
    </div>
    <!-- Add your scripts here -->
    <script src="extras.js"></script>
</body>
</html>
