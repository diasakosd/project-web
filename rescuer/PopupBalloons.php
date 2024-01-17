<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Check if the user is logged in
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(array('error' => 'User not logged in'));
    exit();
}

// Get the rescuer name based on the session username
$username = $_SESSION['username'];

// Query to get the requests details
$query = "SELECT citizens.full_name, citizens.phone, 
DATE_FORMAT(citizen_request.time_created, '%Y-%m-%d %H:%i:%s') AS formatted_time_created, 
citizen_request.item, citizen_request.quantity, 
DATE_FORMAT(citizen_request.time_accepted, '%Y-%m-%d %H:%i:%s') AS formatted_time_accepted, 
citizen_request.rescuer_username FROM citizens
INNER JOIN citizen_request ON citizens.username = citizen_request.username
WHERE citizen_request.rescuer_username = '$username' AND accepted LIKE 'YES'";
$result = mysqli_query($db, $query);

if ($result) {
    $cargoData = array(); // Initialize an array to hold rescuer data

    while ($row = mysqli_fetch_assoc($result)) {
        // Append each rescuer row to the cargoData array
        $cargoData[] = $row;
    }
} else {
    echo json_encode(array('error' => 'No rescuer coordinates found'));
}

$query2 = "SELECT citizens.full_name, citizens.phone, 
DATE_FORMAT(citizen_request.time_created, '%Y-%m-%d %H:%i:%s') AS formatted_time_created, 
citizen_request.item, citizen_request.quantity FROM citizens
INNER JOIN citizen_request ON citizens.username = citizen_request.username
WHERE accepted LIKE 'NO'";
$result2 = mysqli_query($db, $query2);

if ($result2) {
    $cargoData2 = array(); // Initialize an array to hold rescuer data

    while ($row2 = mysqli_fetch_assoc($result2)) {
        // Append each rescuer row to the cargoData array
        $cargoData2[] = $row2;
    }
} else {
    echo json_encode(array('error' => 'No rescuer coordinates found'));
}


// Query to get the offers details
$query3 = "SELECT citizens.full_name, citizens.phone, 
DATE_FORMAT(citizen_offer.time_created, '%Y-%m-%d %H:%i:%s') AS formatted_time_created, 
citizen_offer.item, citizen_offer.quantity, 
DATE_FORMAT(citizen_offer.time_accepted, '%Y-%m-%d %H:%i:%s') AS formatted_time_accepted, 
citizen_offer.rescuer_username FROM citizens
INNER JOIN citizen_offer ON citizens.username = citizen_offer.username
WHERE citizen_offer.rescuer_username = '$username' AND accepted LIKE 'YES'";
$result3 = mysqli_query($db, $query3);

if ($result3) {
    $cargoData3 = array(); // Initialize an array to hold rescuer data

    while ($row3 = mysqli_fetch_assoc($result3)) {
        // Append each rescuer row to the cargoData array
        $cargoData3[] = $row3;
    }
} else {
    echo json_encode(array('error' => 'No rescuer coordinates found'));
}

$query4 = "SELECT citizens.full_name, citizens.phone, 
DATE_FORMAT(citizen_offer.time_created, '%Y-%m-%d %H:%i:%s') AS formatted_time_created, 
citizen_offer.item, citizen_offer.quantity FROM citizens
INNER JOIN citizen_offer ON citizens.username = citizen_offer.username
WHERE accepted LIKE 'NO'";
$result4 = mysqli_query($db, $query4);

if ($result4) {
    $cargoData4 = array(); // Initialize an array to hold rescuer data

    while ($row4 = mysqli_fetch_assoc($result4)) {
        // Append each rescuer row to the cargoData array
        $cargoData4[] = $row4;
    }
} else {
    echo json_encode(array('error' => 'No rescuer coordinates found'));
}


// Combine both results
$Popups = array(
    'reqT' => $cargoData,
    'reqW' => $cargoData2,
    'offT' => $cargoData3,
    'offW' => $cargoData4
);

echo json_encode($Popups);

// Close the database connection
mysqli_close($db);
?>
