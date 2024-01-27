<?php
// get_rescuer_coords.php

// Establish a database connection
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Check for a valid session
session_start();
if (!isset($_SESSION['username'])) {
    // Handle unauthorized access
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

$username = $_SESSION['username'];

// Fetch the rescuer's coordinates from the rescuers table
$query = "SELECT latitude, longitude FROM rescuers WHERE username = '$username'";
$result = mysqli_query($db, $query);

if ($result) {
    $rescuerCoords = mysqli_fetch_assoc($result);
    echo json_encode([$rescuerCoords]); // Wrap the result in an array
} else {
    echo json_encode(['error' => 'Error fetching rescuer coordinates']);
}

// Close the database connection
mysqli_close($db);
?>
