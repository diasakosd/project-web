<?php

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

$query = "SELECT latitude, longitude FROM rescuers WHERE username = '$username'";
$result = mysqli_query($db, $query);

if ($result) {
    $cargoData = array(); 

    while ($row = mysqli_fetch_assoc($result)) {
        y
        $cargoData[] = $row;
    }
    echo json_encode($cargoData);
} else {
    echo json_encode(array('error' => 'No rescuer coordinates found'));
}

mysqli_close($db);
?>