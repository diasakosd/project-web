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


        <div class="request-form">
                <form method="post" action="fetch_request_creation.php" onsubmit="return validateForm()" id="request_creationForm">

                <div class="input-box">
                        <label for="category">Category:</label><br>
                        <select id="category" name="category" placeholder="Category" required onclick="fetchOptions('category')">
                        </select>
                        <i class='bx bxs-lock'></i>
                    </div>

                    <div class="input-box">
                        <label for="item">Item:</label><br>
                        <select id="item" name="item" placeholder="Item" required onclick="fetchOptions('item')"> 
                        </select>
                        <i class='bx bxs-user-circle'></i>
                    </div>

                    <div class="input-box">
                    <label for="quantity">Quantity:</label><br>
                   <input type="number" id="quantity" name="quantity" placeholder="Quantity" value="100" readonly>
                  <i class='bx bxs-lock'></i>
                 </div>

                  <div class="input-box">
                  <label for="status">Status:</label><br>
                   <select id="status" name="status" required>
                    <option value="NO" selected>No</option>
                    <option value="YES">Yes</option>
                    </select>
                   <i class='bx bxs-user-circle'></i>
                    </div>

                    <div class="input-box">
                        <label for="number">Number of people:</label><br>
                        <input type="number" id="number" name="number" placeholder="Number" value="1" readonly>
                        <i class='bx bxs-phone'></i>
                    </div>
                    

                    <button type="submit" name="submit">Submit</button>
                    <div class="error_message"></div>
        
                </form>
            </div>

        <div class="logout">
            <p><a href="../logout.php">Logout</a></p>
        </div>
    </div>
 
    <!-- Add your scripts here -->
    <script src="citizen-details-script.js"></script>
    <script src="request_creation.js"></script>
</body>
</html>
