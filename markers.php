<?php
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the rescuers and rescuer_inventory tables
$query = "SELECT r.username, r.latitude, r.longitude, GROUP_CONCAT(ri.category , ': ' , ri.item , ' (' , ri.quantity , ') '  ) AS items
          FROM rescuers r
          JOIN rescuer_inventory ri ON r.username = ri.username
          GROUP BY r.username";
$result = mysqli_query($db, $query);

// Create an array to store the markers
$markers = array();

// Loop through the results and add markers to the array
while ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $items = $row['items'];

    // Create a marker in the correct format
    $marker_rescuer = "L.marker([$latitude, $longitude]).bindPopup('Username: <b>$username<b><br>Items:<br>$items ')";
    $markers_rescuer[] = $marker_rescuer;
}

// Close the database connection
mysqli_close($db);

// Output the markers as a JavaScript array
echo "var markers_rescuer_Data = [", implode(',', $markers_rescuer), "];";
?>
