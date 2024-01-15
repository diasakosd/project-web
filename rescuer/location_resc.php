<?php
session_start();
include 'session_rescuer.php';
$_SESSION['site'] = '../rescuer/rescuer.php';

$db = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "web";

// Check if the user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    http_response_code(403); // Forbidden
    echo json_encode(array("error" => "You can't access this file"));
    die(); // Ensure no further output
}

// Get the admin name based on the session username
$username = $_SESSION['username'];



// Fetch marker data from the database
$conn = mysqli_connect($db, $dbUsername, $dbPassword, $dbName);
$sql = "SELECT latitude, longitude FROM rescuers WHERE username = '$username'";
$result = $conn->query($sql);

// Check for errors in the query
if (!$result) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("error" => "Database query error"));
    die(); // Ensure no further output
}

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'latitude' => $row['latitude'],
        'longitude' => $row['longitude'],
    );
}

// Return data as JSON
header('Content-Type: application/json');

// Check if there is any data to encode
if (!empty($data)) {
    echo json_encode($data);
} else {
    http_response_code(204); // No Content
    echo json_encode(array("error" => "No data available"));
}

// Ensure no further output
die();
?>
