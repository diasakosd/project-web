<?php
include 'session_rescuer.php';
$_SESSION['site'] = '../rescuer/rescuer.php';

$db = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "web";

$conn = mysqli_connect($db, $dbUsername, $dbPassword, $dbName);

// Check if the user is logged in
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "You cant access this file";
    exit();
}

// Get the admin name based on the session username
$username = $_SESSION['username'];

// Fetch marker data from the database
// Example: Fetch data from 'locations' table with columns 'latitude', 'longitude', 'title', 'description'
$sql = "SELECT latitude, longitude FROM rescuers WHERE username = '$username'";
$data = array();
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'latitude' => $row['latitude'],
        'longitude' => $row['longitude'],
    );
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
