<?php
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}


// Fetch data from the storage_location table
$queryBaseLocation = "SELECT latitude, longitude FROM storage_location";
$resultBaseLocation = mysqli_query($db, $queryBaseLocation);

// Check if there are rows in the result set
if ($resultBaseLocation && mysqli_num_rows($resultBaseLocation) > 0) {
    // Fetch the base location
    $baseLocation = $resultBaseLocation->fetch_assoc();
    $baseLatitude = $baseLocation['latitude'];
    $baseLongitude = $baseLocation['longitude'];

    // Output the base location as JavaScript variable
    echo "var baseLocation = { lat: $baseLatitude, lng: $baseLongitude };";
} else {
    // Provide default coordinates if no base location is found
    echo "var baseLocation = { lat: 0, lng: 0 };";
}


// Fetch data from the rescuers, rescuer_inventory, and citizens_request tables
$query0 = "SELECT r.username, r.latitude, r.longitude, 
    GROUP_CONCAT(CONCAT('<li>', ri.category, ': ', ri.item, ' (', ri.quantity, ')','</li>') SEPARATOR '') AS items
    FROM rescuers r
    LEFT JOIN rescuer_inventory ri ON r.username = ri.username
    LEFT JOIN citizen_offer co ON r.username = co.rescuer_username
    LEFT JOIN citizen_request cr ON r.username = cr.rescuer_username
    WHERE co.rescuer_username IS NULL AND cr.rescuer_username IS NULL
    GROUP BY r.username";

$result0 = mysqli_query($db, $query0);

// Create an array to store the markers
$markers_rescuer_noactive = array();

// Loop through the results and add markers to the array
while ($row = $result0->fetch_assoc()) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $items = $row['items'];

    // Create a marker in the correct format
    $marker_rescuer_noactive = "L.marker([$latitude, $longitude]).bindPopup('Username: <b>$username</b><br>Items in Car:<ul>$items</ul>')";
    $markers_rescuer_noactive[] = $marker_rescuer_noactive;
}

$query1 = "SELECT 
r.username, 
r.latitude, 
r.longitude, 
GROUP_CONCAT(DISTINCT CONCAT('<li>', ri.category, ': ', ri.item, ' (', ri.quantity, ')', '</li>') SEPARATOR '') AS items,
GROUP_CONCAT(DISTINCT CONCAT('Request from: ', COALESCE(cr.username, '')) SEPARATOR ', ') AS request_status,
GROUP_CONCAT(DISTINCT CONCAT('Offer from: ', COALESCE(co.username, '')) SEPARATOR ', ') AS offer_status
FROM rescuers r
LEFT JOIN rescuer_inventory ri ON r.username = ri.username
LEFT JOIN citizen_request cr ON r.username = cr.rescuer_username AND cr.accepted != 'DONE'
LEFT JOIN citizen_offer co ON r.username = co.rescuer_username AND co.accepted != 'DONE'
WHERE cr.username IS NOT NULL OR co.username IS NOT NULL
GROUP BY r.username";


$result1 = mysqli_query($db, $query1);

// Create an array to store the markers
$markers_rescuer_active = array();

// Loop through the results and add markers to the array
while ($row = $result1->fetch_assoc()) {
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

    $marker_rescuer_active = "L.marker([$latitude, $longitude]).bindPopup('$popupMessage')";
    $markers_rescuer_active[] = $marker_rescuer_active;
}




// Fetch data from the citizen_request table
$query2 = "SELECT c.username, c.latitude, c.longitude, c.full_name, c.phone, GROUP_CONCAT(CONCAT('<li>', cr.category, ': ', cr.item, ' (', cr.quantity, ')', '</li>') SEPARATOR '') AS items
FROM citizens c
JOIN citizen_request cr ON c.username = cr.username
WHERE cr.accepted = 'NO'
GROUP BY c.username";
$result2 = mysqli_query($db, $query2);

// Create an array to store the markers
$markers_citizen_request_no = array();

// Loop through the results and add markers to the array
while ($row = $result2->fetch_assoc()) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $fullName = $row['full_name'];
    $phone = $row['phone'];
    $items = $row['items'];

    // Create a marker in the correct format
    $marker_citizen_request_no = "L.marker([$latitude, $longitude], {icon: requests_noIcon}).bindPopup('Username: <b>$username</b><br>Full Name: $fullName<br>Phone: $phone<br>Items:<ul>$items</ul>')";
    $markers_citizen_request_no[] = $marker_citizen_request_no;
}

// Fetch data from the citizen_offer table
$query3 = "SELECT c.username, c.latitude, c.longitude, c.full_name, c.phone, GROUP_CONCAT(CONCAT('<li>', co.category, ': ', co.item, ' (', co.quantity, ')', '</li>') SEPARATOR '') AS items
FROM citizens c
JOIN citizen_offer co ON c.username = co.username
WHERE co.accepted = 'NO'
GROUP BY c.username";
$result3 = mysqli_query($db, $query3);

// Create an array to store the markers
$markers_citizen_offer_no = array();

// Check if there are rows in the result set
if ($result3 && mysqli_num_rows($result3) > 0) {
    // Loop through the results and add markers to the array
    while ($row1 = $result3->fetch_assoc()) {
        $username = $row1['username'];
        $latitude = $row1['latitude'];
        $longitude = $row1['longitude'];
        $fullName = $row1['full_name'];
        $phone = $row1['phone'];
        $items = $row1['items'];

        // Create a marker in the correct format
        $marker_citizen_offer_no = "L.marker([$latitude, $longitude], {icon: offers_noIcon}).bindPopup('Username: <b>$username</b><br>Full Name: $fullName<br>Phone: $phone<br>Items: $items')";
        $markers_citizen_offer_no[] = $marker_citizen_offer_no;
    }
}

// Fetch data from the citizen_request table for accepted requests
$query4 = "SELECT c.username, c.latitude, c.longitude, c.full_name, c.phone, GROUP_CONCAT(CONCAT('<li>Rescuer: ', cr.rescuer_username, ', Time Accepted: ', cr.time_accepted, ', Items: ', cr.category, ': ', cr.item, ' (', cr.quantity, ')') SEPARATOR '<br>') AS details
FROM citizens c
JOIN citizen_request cr ON c.username = cr.username
WHERE cr.accepted = 'YES'
GROUP BY c.username";
$result4 = mysqli_query($db, $query4);

// Create an array to store the markers
$markers_citizen_request_yes = array();

// Loop through the results and add markers to the array
while ($row = $result4->fetch_assoc()) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $fullName = $row['full_name'];
    $phone = $row['phone'];
    $details = $row['details'];

    // Create a marker in the correct format
    $marker_citizen_request_yes = "L.marker([$latitude, $longitude], {icon: requests_yesIcon}).bindPopup('Username: <b>$username</b><br>Full Name: $fullName<br>Phone: $phone<br>Details:<ul>$details</ul>')";
    $markers_citizen_request_yes[] = $marker_citizen_request_yes;
}

// Fetch data from the citizen_offer table for accepted offers
$query5 = "SELECT c.username, c.latitude, c.longitude, c.full_name, c.phone, GROUP_CONCAT(CONCAT('<li>Rescuer: ', co.rescuer_username, ', Time Accepted: ', co.time_accepted, ', Items: ', co.category, ': ', co.item, ' (', co.quantity, ')') SEPARATOR '<br>') AS details
FROM citizens c
JOIN citizen_offer co ON c.username = co.username
WHERE co.accepted = 'YES'
GROUP BY c.username";
$result5 = mysqli_query($db, $query5);

// Create an array to store the markers
$markers_citizen_offer_yes = array();

// Loop through the results and add markers to the array
while ($row = $result5->fetch_assoc()) {
    $username = $row['username'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $fullName = $row['full_name'];
    $phone = $row['phone'];
    $details = $row['details'];

    // Create a marker in the correct format
    $marker_citizen_offer_yes = "L.marker([$latitude, $longitude], {icon: offers_yesIcon}).bindPopup('Username: <b>$username</b><br>Full Name: $fullName<br>Phone: $phone<br>Details:<ul>$details</ul>')";
    $markers_citizen_offer_yes[] = $marker_citizen_offer_yes;
}

// Fetch data from the citizen_request table for accepted requests
$query6 = "SELECT r.username AS rescuer_username, r.latitude AS rescuer_lat, r.longitude AS rescuer_lng, c.latitude AS citizen_lat, c.longitude AS citizen_lng
FROM rescuers r
JOIN citizen_request cr ON r.username = cr.rescuer_username
JOIN citizens c ON cr.username = c.username
WHERE cr.accepted = 'YES'
GROUP BY r.username, c.username"; 

$result6 = mysqli_query($db, $query6);

// Create an array to store the line coordinates for accepted requests
$lines_request_yes = array();

// Loop through the results and add line coordinates to the array
while ($row = $result6->fetch_assoc()) {
    $rescuer_lat = $row['rescuer_lat'];
    $rescuer_lng = $row['rescuer_lng'];
    $citizen_lat = $row['citizen_lat'];
    $citizen_lng = $row['citizen_lng'];

    // Create a line coordinate entry in the correct format
    $line_request_yes = "[$rescuer_lat, $rescuer_lng], [$citizen_lat, $citizen_lng]";
    $lines_request_yes[] = "L.polyline([$line_request_yes], { color: 'red' })";
}

$query7 = "SELECT r.username AS rescuer_username, r.latitude AS rescuer_lat, r.longitude AS rescuer_lng, c.latitude AS citizen_lat, c.longitude AS citizen_lng
    FROM rescuers r
    INNER JOIN citizen_offer co ON r.username = co.rescuer_username
    INNER JOIN citizens c ON co.username = c.username
    WHERE co.accepted = 'YES'";

$result7 = mysqli_query($db, $query7);

// Create an array to store the line coordinates for accepted offers
$lines_offer_yes = array();

// Loop through the results and add line coordinates to the array
while ($row = $result7->fetch_assoc()) {
    $rescuer_username = $row['rescuer_username'];
    $rescuer_lat = $row['rescuer_lat'];
    $rescuer_lng = $row['rescuer_lng'];
    $citizen_lat = $row['citizen_lat'];
    $citizen_lng = $row['citizen_lng'];

    // Create a line coordinate entry in the correct format
    $line_offer_yes = "[$rescuer_lat, $rescuer_lng], [$citizen_lat, $citizen_lng]";

    // Create a new polyline for each pair and add it to the array
    $lines_offer_yes[] = "L.polyline([$line_offer_yes], { color: 'red' })";
}



// Close the database connection
mysqli_close($db);
// Output the markers as a JavaScript array

echo "var markers_rescuer_active_Data = [", implode(',', $markers_rescuer_active), "];";
echo "var markers_rescuer_noactive_Data = [", implode(',', $markers_rescuer_noactive), "];";
echo "var markers_citizen_request_Data_no = [", implode(',', $markers_citizen_request_no), "];";


echo "var markers_citizen_offer_Data_no = [", implode(',', $markers_citizen_offer_no), "];";



echo "var markers_citizen_request_Data_yes = [", implode(',', $markers_citizen_request_yes), "];";
echo "var markers_citizen_offer_Data_yes = [", implode(',', $markers_citizen_offer_yes), "];";

// Output the line coordinates as JavaScript arrays
echo "var lines_request_yes_Data = [", implode(',', $lines_request_yes), "];";
echo "var lines_offer_yes_Data = [", implode(',', $lines_offer_yes), "];";

?>
