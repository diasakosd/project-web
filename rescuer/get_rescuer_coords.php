<?php

$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

session_start();
if (!isset($_SESSION['username'])) {
    //for unauthorized access
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

$username = $_SESSION['username'];

$query = "SELECT latitude, longitude FROM rescuers WHERE username = '$username'";
$result = mysqli_query($db, $query);

if ($result) {
    $rescuerCoords = mysqli_fetch_assoc($result);
    echo json_encode([$rescuerCoords]); 
} else {
    echo json_encode(['error' => 'Error fetching rescuer coordinates']);
}

mysqli_close($db);
?>
