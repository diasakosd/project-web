<?php

$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(array('error' => 'User not logged in'));
    exit();
}

$username = $_SESSION['username'];

$query = "SELECT latitude, longitude FROM rescuers WHERE username = '$username'";
$result = mysqli_query($db, $query);

if ($result) {
    $cargoData = array(); 

    while ($row = mysqli_fetch_assoc($result)) {
        
        $cargoData[] = $row;
    }
} else {
    echo json_encode(array('error' => 'No rescuer coordinates found'));
}

//get the other rescuers' coordinates
$query2 = "SELECT latitude, longitude, rescuers.username, rescuers.phone FROM rescuers INNER JOIN citizen_offer ON rescuers.username=citizen_offer.rescuer_username WHERE accepted='YES' AND rescuers.username != '$username'
UNION
SELECT latitude, longitude, rescuers.username, rescuers.phone FROM rescuers INNER JOIN citizen_request ON rescuers.username=citizen_request.rescuer_username WHERE accepted='YES' AND rescuers.username != '$username';";
$result2 = mysqli_query($db, $query2);

if ($result2) {
    $cargoData2 = array(); 

    while ($row2 = mysqli_fetch_assoc($result2)) {
        
        $cargoData2[] = $row2;
    }
} else {
    echo json_encode(array('error' => 'No rescuer coordinates found'));
}

$query3 = "SELECT DISTINCT r.latitude, r.longitude, r.username, r.phone
FROM rescuers r
LEFT JOIN citizen_request cr ON r.username = cr.rescuer_username AND cr.accepted = 'YES'
LEFT JOIN citizen_offer co ON r.username = co.rescuer_username AND co.accepted = 'YES'
WHERE cr.rescuer_username IS NULL AND co.rescuer_username IS NULL AND r.username!='$username';";
$result3 = mysqli_query($db, $query3);

if ($result3) {
    $cargoData3 = array(); 

    while ($row3 = mysqli_fetch_assoc($result3)) {
        
        $cargoData3[] = $row3;
    }
} else {
    echo json_encode(array('error' => 'No rescuer coordinates found'));
}

//combine results
$combinedRescuers = array(
    'currResc' => $cargoData,
    'activeResc' => $cargoData2,
    'inactiveResc' => $cargoData3
);

echo json_encode($combinedRescuers);

mysqli_close($db);
?>
