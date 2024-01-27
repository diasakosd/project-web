<?php
include 'session_citizen.php';
$_SESSION['site'] = '../citizen/citizens.php';
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

    <div class="container1">
            <div class="top-overlay">
                <br>
                <div class="header"> 
                    <h1>Request creation</h1>
                </div>
            </div>

    


    <div class="container">
        <div class="header">
        </div>
        <div class="content">
            <!-- Add your citizen-specific content here -->
            <p>Make your request here.</p>
        </div>


        

        <div class="logout">
            <p><a href="../logout.php">Logout</a></p>
        </div>
    </div>
    <br>
    <div class="request-form">
    <form method="post" action="fetch_request_creation.php" onsubmit="return validateForm()" id="request_creationForm">

    <div class="input-box">
    <label for="category">Category:</label><br>
    <input type="text" id="category" name="category" required>
    <i class='bx bxs-lock'></i>
</div>

<div class="input-box">
    <label for="item">Item:</label><br>
    <input type="text" id="item" name="item" required>
    <i class='bx bxs-user-circle'></i>
</div>


<div class="input-box">
    <label for="number">Number of people:</label><br>
    <input type="number" id="number" name="number" placeholder="Number" required min="1" step="1">
    <i class='bx bxs-phone'></i>
</div>


        <button type="submit" name="submit">Submit</button>
        <div class="error_message"></div>

       </form>
    </div>
            <br>
           
<!-- Add your scripts and stylesheets here -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="citizen-details-script.js"></script>
<script src="request_creation.js"></script>

</body>
</html>
