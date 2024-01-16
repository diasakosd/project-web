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

// Query Offers taken
$queryOfferYes = "SELECT citizens.latitude, citizens.longitude FROM citizens
INNER JOIN citizen_offer ON citizens.username = citizen_offer.username 
INNER JOIN rescuers ON citizen_offer.rescuer_username = rescuers.username WHERE citizen_offer.accepted LIKE 'YES' AND rescuers.username = '$username'";
$result = mysqli_query($db, $queryOfferYes);

if ($result) {
    $cargoData = array(); // Initialize an array to hold base coordinates data

    while ($row = mysqli_fetch_assoc($result)) {
        // Append each base coordinates row to the cargoData array
        $cargoData[] = $row;
    }
} else {
    echo json_encode(array('error' => 'No base coordinates found'));
    exit();
}

// Query Offers waiting
$queryOfferNo = "SELECT citizens.latitude, citizens.longitude FROM citizens
INNER JOIN citizen_offer ON citizens.username = citizen_offer.username 
WHERE citizen_offer.accepted LIKE 'NO'";
$result2 = mysqli_query($db, $queryOfferNo);

if ($result2) {
    $cargoData2 = array(); 

    while ($row2 = mysqli_fetch_assoc($result2)) {
        $cargoData2[] = $row2;
    }
} else {
    echo json_encode(array('error' => 'No base coordinates found for Offers(no)'));
    exit();
}

// Combine both results
$combinedData = array(
    'offersYes' => $cargoData,
    'offersNo' => $cargoData2
);

echo json_encode($combinedData);

// Close the database connection
mysqli_close($db);
?>
