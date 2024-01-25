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

// Query to get the rescuer's coordinates
$query = "SELECT latitude, longitude FROM rescuers WHERE username = '$username'";
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

// Query to get the other rescuers' coordinates
$query2 = "SELECT latitude, longitude FROM rescuers INNER JOIN citizen_offer ON rescuers.username=citizen_offer.rescuer_username WHERE accepted='YES' AND rescuers.username != '$username'
UNION
SELECT latitude, longitude FROM rescuers INNER JOIN citizen_request ON rescuers.username=citizen_request.rescuer_username WHERE accepted='YES' AND rescuers.username != '$username';";
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

$query3 = "SELECT DISTINCT r.latitude, r.longitude
FROM rescuers r
LEFT JOIN citizen_request cr ON r.username = cr.rescuer_username AND cr.accepted = 'YES'
LEFT JOIN citizen_offer co ON r.username = co.rescuer_username AND co.accepted = 'YES'
WHERE cr.rescuer_username IS NULL AND co.rescuer_username IS NULL AND r.username!='$username';";
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

// Combine both results
$combinedRescuers = array(
    'currResc' => $cargoData,
    'activeResc' => $cargoData2,
    'inactiveResc' => $cargoData3
);

echo json_encode($combinedRescuers);

// Close the database connection
mysqli_close($db);
?>
