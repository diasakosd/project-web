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

// Query to get the rescuer's coordinates
$query = "SELECT latitude, longitude FROM rescuers WHERE username = '$username'";
$result = mysqli_query($db, $query);

if ($result) {
    $cargoData = array(); // Initialize an array to hold rescuer data

    while ($row = mysqli_fetch_assoc($result)) {
        // Append each rescuer row to the cargoData array
        $cargoData[] = $row;
    }

    echo json_encode($cargoData);
} else {
    echo json_encode(array('error' => 'No rescuer coordinates found'));
}

// Close the database connection
mysqli_close($db);
?>
