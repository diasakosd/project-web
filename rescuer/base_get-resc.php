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

$baseContent = "SELECT category AS Category, item AS Item, quantity AS Quantity FROM `base_storage` GROUP BY item ORDER BY category";
$result = mysqli_query($db, $baseContent);

if($result){
    $cargoData = array(); // Initialize an array to hold cargo data

    while ($row = mysqli_fetch_assoc($result)) {
        // Append each cargo row to the cargoData array
        $cargoData[] = $row;
    }

    echo json_encode($cargoData);
}

// Close the database connection
mysqli_close($db);
?>