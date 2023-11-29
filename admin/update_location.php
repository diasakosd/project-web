<?php
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve latitude and longitude from the AJAX request
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Update the storage_location table
$queryUpdateLocation = "UPDATE storage_location SET latitude = $latitude, longitude = $longitude";
$resultUpdateLocation = mysqli_query($db, $queryUpdateLocation);

// Check if the update was successful
if ($resultUpdateLocation) {
    echo "Location updated successfully";
} else {
    echo "Error updating location: " . mysqli_error($db);
}
?>
