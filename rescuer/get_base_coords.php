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

$query = "SELECT latitude, longitude FROM storage_location LIMIT 1";
$result = mysqli_query($db, $query);

if ($result) {
    $baseCoords = mysqli_fetch_assoc($result);
    echo json_encode(['latitude' => $baseCoords['latitude'], 'longitude' => $baseCoords['longitude']]);
} else {
    echo json_encode(['error' => 'Error fetching base coordinates']);
}

mysqli_close($db);
?>
