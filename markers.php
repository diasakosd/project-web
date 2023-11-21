<?php
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}


// Fetch data from the rescuers, rescuer_inventory, and citizens_request tables
$query0 = "SELECT r.username, r.latitude, r.longitude, 
    GROUP_CONCAT(CONCAT('<li>', ri.category, ': ', ri.item, ' (', ri.quantity, ')','</li>') SEPARATOR '') AS items
    FROM rescuers r
    JOIN rescuer_inventory ri ON r.username = ri.username
    LEFT JOIN citizen_offer co ON r.username = co.rescuer_username
    LEFT JOIN citizen_request cr ON r.username = cr.rescuer_username
    WHERE co.rescuer_username IS NULL AND cr.rescuer_username IS NULL
    GROUP BY r.username";

$result0 = mysqli_query($db, $query0);

// Create an array to store the markers
$markers0 = array();

// Loop through the results and add markers to the array
while ($row = mysqli_fetch_assoc($result0)) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $items = $row['items'];

    // Create a marker in the correct format
    $marker_rescuer_offer = "L.marker([$latitude, $longitude]).bindPopup('Username: <b>$username</b><br>Items in Car:<ul>$items</ul>')";
    $markers_rescuer_offer[] = $marker_rescuer_offer;
}

$query1 = "SELECT 
    r.username, 
    r.latitude, 
    r.longitude, 
    GROUP_CONCAT(CONCAT('<li>', ri.category, ': ', ri.item, ' (', ri.quantity, ')', '</li>') SEPARATOR '') AS items,
    GROUP_CONCAT(DISTINCT CONCAT('Request from: ', cr.username) SEPARATOR ', ') AS request_status,
    GROUP_CONCAT(DISTINCT CONCAT('Offer from: ', co.username) SEPARATOR ', ') AS offer_status
FROM rescuers r
JOIN rescuer_inventory ri ON r.username = ri.username
LEFT JOIN citizen_request cr ON r.username = cr.rescuer_username
LEFT JOIN citizen_offer co ON r.username = co.rescuer_username
WHERE cr.username IS NOT NULL OR co.username IS NOT NULL
GROUP BY r.username";

$result1 = mysqli_query($db, $query1);

// Create an array to store the markers
$markers1 = array();

// Loop through the results and add markers to the array
while ($row = mysqli_fetch_assoc($result1)) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $items = $row['items'];
    $requestStatus = $row['request_status'];
    $offerStatus = $row['offer_status'];

    // Create a marker in the correct format with popup message based on status
    $popupMessage = "Username: <b>$username</b><br>Items in Car:<ul>$items</ul>";

    if ($requestStatus) {
        $popupMessage .= "<br>$requestStatus";
    }

    if ($offerStatus) {
        $popupMessage .= "<br>$offerStatus";
    }

    $marker_rescuer_request = "L.marker([$latitude, $longitude]).bindPopup('$popupMessage')";
    $markers_rescuer_request[] = $marker_rescuer_request;
}



// Fetch data from the rescuers and rescuer_inventory tables
$query2 = "SELECT c.username, c.latitude, c.longitude, GROUP_CONCAT(CONCAT('<li>', cr.category, ': ', cr.item, ' (', cr.quantity, ')', '</li>') SEPARATOR '') AS items
FROM citizens c
JOIN citizen_request cr ON c.username = cr.username
WHERE cr.accepted = 'NO'
GROUP BY c.username";
$result2 = mysqli_query($db, $query2);

// Create an array to store the markers
$markers2 = array();

// Loop through the results and add markers to the array
while ($row = mysqli_fetch_assoc($result2)) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $items = $row['items'];

    // Create a marker in the correct format
    //$marker_citizen_request_no = "L.marker([$latitude, $longitude]).bindPopup('Username: <b>$username<b><br>Items:<br>$items')";
    $marker_citizen_request_no = "L.marker([$latitude, $longitude], {icon: requests_noIcon}).bindPopup('Username: <b>$username</b><br>Items:<ul>$items</ul>')";
    $markers_citizen_request_no[] = $marker_citizen_request_no;
}

// Fetch data from the rescuers and rescuer_inventory tables
$query3 = "SELECT c.username, c.latitude, c.longitude, GROUP_CONCAT(CONCAT('<li>', co.category, ': ', co.item, ' (', co.quantity, ')', '</li>') SEPARATOR '') AS items
FROM citizens c
JOIN citizen_offer co ON c.username = co.username
WHERE co.accepted = 'NO'
GROUP BY c.username";
$result3 = mysqli_query($db, $query3);

// Create an array to store the markers
$markers3 = array();

// Loop through the results and add markers to the array
while ($row1 = mysqli_fetch_assoc($result3)) {
    $username = $row1['username'];
    $latitude = $row1['latitude'];
    $longitude = $row1['longitude'];
    $items = $row1['items'];

    // Create a marker in the correct format
    //$marker_citizen_offer_no = "L.marker([$latitude, $longitude]).bindPopup('Username: <b>$username<b><br>Items:<br>$items')";
    $marker_citizen_offer_no = "L.marker([$latitude, $longitude], {icon: offers_noIcon}).bindPopup('Username: <b>$username</b><br>Items:<ul>$items</ul>')";
    $markers_citizen_offer_no[] = $marker_citizen_offer_no;
}

// Fetch data from the rescuers and rescuer_inventory tables
$query4 = "SELECT c.username, c.latitude, c.longitude, GROUP_CONCAT(CONCAT('<li>', cr.category, ': ', cr.item, ' (', cr.quantity, ')', '</li>') SEPARATOR '') AS items
FROM citizens c
JOIN citizen_request cr ON c.username = cr.username
WHERE cr.accepted = 'YES'
GROUP BY c.username";
$result4 = mysqli_query($db, $query4);

// Create an array to store the markers
$markers4 = array();

// Loop through the results and add markers to the array
while ($row = mysqli_fetch_assoc($result4)) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $items = $row['items'];

    // Create a marker in the correct format
    //$marker_citizen_request_yes = "L.marker([$latitude, $longitude]).bindPopup('Username: <b>$username<b><br>Items:<br>$items')";
    $marker_citizen_request_yes = "L.marker([$latitude, $longitude], {icon: requests_yesIcon}).bindPopup('Username: <b>$username</b><br>Items:<ul>$items</ul>')";
    $markers_citizen_request_yes[] = $marker_citizen_request_yes;
}

// Fetch data from the rescuers and rescuer_inventory tables
$query5 = "SELECT c.username, c.latitude, c.longitude, GROUP_CONCAT(CONCAT('<li>', co.category, ': ', co.item, ' (', co.quantity, ')', '</li>') SEPARATOR '') AS items
FROM citizens c
JOIN citizen_offer co ON c.username = co.username
WHERE co.accepted = 'YES'
GROUP BY c.username";
$result5 = mysqli_query($db, $query5);

// Create an array to store the markers
$markers5 = array();

// Loop through the results and add markers to the array
while ($row = mysqli_fetch_assoc($result5)) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $items = $row['items'];

    // Create a marker in the correct format
   //$marker_citizen_offer_yes = "L.marker([$latitude, $longitude]).bindPopup('Username: <b>$username<b><br>Items:<br>$items')";
    $marker_citizen_offer_yes = "L.marker([$latitude, $longitude], {icon: offers_yesIcon}).bindPopup('Username: <b>$username</b><br>Items:<ul>$items</ul>')";
    $markers_citizen_offer_yes[] = $marker_citizen_offer_yes;
}

// Close the database connection
mysqli_close($db);

// Output the markers as a JavaScript array
echo "var markers_rescuer_request_Data = [", implode(',', $markers_rescuer_request), "];";
echo "var markers_rescuer_offer_Data = [", implode(',', $markers_rescuer_offer), "];";
echo "var markers_citizen_request_Data_no = [", implode(',', $markers_citizen_request_no), "];";
echo "var markers_citizen_offer_Data_no = [", implode(',', $markers_citizen_offer_no), "];";
echo "var markers_citizen_request_Data_yes = [", implode(',', $markers_citizen_request_yes), "];";
echo "var markers_citizen_offer_Data_yes = [", implode(',', $markers_citizen_offer_yes), "];";
?>
