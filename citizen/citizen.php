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
            <div class="header"></div>
            <div class="content">
                <!-- Add your citizen-specific content here -->
                <p>Make your request here.</p>
            </div>

            <div class="logout">
                <p><a href="../logout.php">Logout</a></p>
            </div>
        </div>
        <br>

       <!-- Autocomplete Request Form -->
<div class="request-form1">
    <form method="post" action="submit_autocomplete_request.php" onsubmit="return validateForm()" id="autocompleteForm">
        <div class="input-box">
            <label for="autocompleteCategory">Category:</label><br>
            <input type="text" id="autocompleteCategory" name="category" list="categoryList" required>
            <datalist id="categoryList"></datalist>
        </div>

        <div class="input-box">
            <label for="autocompleteItem">Item:</label><br>
            <input type="text" id="autocompleteItem" name="item" list="itemList" required>
            <datalist id="itemList"></datalist>
        </div>

        <div class="input-box">
            <label for="autocompleteNumber">Number of people:</label><br>
            <input type="number" id="autocompleteNumber" name="number" placeholder="Number" required min="1" step="1">
        </div>

        <button type="submit" name="submit">Submit (Autocomplete)</button>
        <div class="error_message"></div>
    </form>
</div>


        <!-- Dropdown Menu Request Form -->
        <br>
        <br>
<div class="request-form2">
    <form method="post" action="fetch_dropdown.php" id="dropdownForm">
        <div class="dropdown-box">
            <label for="dropdownCategory">Choose Category:</label><br>
            <select id="dropdownCategory" name="category"></select>
        </div>

        <div class="dropdown-box">
            <label for="dropdownItem">Choose Item:</label><br>
            <select id="dropdownItem" name="item"></select>
        </div>

        <div class="input-box">
            <label for="dropdownNumber">Number of people:</label><br>
            <input type="number" id="dropdownNumber" name="number" placeholder="Number" required min="1" step="1">
        </div>

        <button type="submit" name="submit">Submit (Dropdown)</button>
        <div class="error_message"></div>
    </form>

    
</div>


        <!-- Add your scripts and stylesheets here -->
 
    <script src="citizen-details-script.js"></script>
    <script src="autocomplete_request_creation.js"></script>
    <script src="dropdown_request_creation.js"></script>
    <script src="submit_request.js"></script>
    <script src="autocomplete_request_creation.js"></script>
    <script src="submit_autocomplete_request.js"></script>
    </div>
</body>

</html>
