<?php

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
// Fetch data from the rescuers table
$query = "SELECT * FROM rescuers";
$result = mysqli_query($db, $query);

// Create an array to store the markers
$markers = array();

// Loop through the results and add markers to the array
while ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];

    // Create a marker and bind a popup with the username
    $marker = "L.marker([$latitude, $longitude]).bindPopup('Username: $username')";
    $markers[] = $marker;
}

// Close the database connection
mysqli_close($db);

// Output the markers as a JavaScript array
echo "var markers = [", implode(',', $markers), "];";
?>
