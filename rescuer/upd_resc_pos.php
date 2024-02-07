<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Retrieve the new coordinates
    $newLat = $_POST['latitude'];
    $newLon = $_POST['longitude'];

$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(array('error' => 'User not logged in'));
    exit();
}

$username = $_SESSION['username'];

 $query = "UPDATE rescuers SET latitude = $newLat, longitude = $newLon WHERE username = '$username'"; 

if ($db->query($query) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $db->error;
}

$db->close();
} else {
    echo "Invalid request method";
}
?>