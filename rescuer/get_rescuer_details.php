<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Check if the user is logged in
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(array('error' => 'User not logged in'));
    exit();
}

// Get the rescuer name based on the session username
$username = $_SESSION['username'];

// Query to get the categories from the base_storage table 
$seeContent = "SELECT * FROM rescuer_inventory WHERE username = '$username'";
$result = mysqli_query($db, $seeContent);

if ($result) {
    if (mysqli_num_rows($result) == 0) {
        echo "You do not have any cargo yet!";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['category'] . "\t" . $row['item'] . "<br>"; // Output loaded cargo
        }
    }
    
} else {
        echo "No loaded cargo found";
    } 

// Close the database connection
mysqli_close($db);
?>
