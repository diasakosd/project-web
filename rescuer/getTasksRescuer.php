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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $offer = "SELECT full_name AS Fullname, phone AS Telephone, time_created AS Created, category AS Category, item AS Item, quantity AS Quantity, 
    citizen_offer.id, citizens.latitude, citizens.longitude FROM citizens 
    INNER JOIN citizen_offer ON citizen_offer.username = citizens.username WHERE citizen_offer.rescuer_username = '$username'";
    $result = mysqli_query($db, $offer);

    if ($result) {
        $cargoData = array(); // Initialize an array to hold cargo data

        while ($row = mysqli_fetch_assoc($result)) {
            // Append each cargo row to the cargoData array
            $cargoData[] = $row;
        }
    }

    $request = "SELECT full_name AS Fullname, phone AS Telephone, time_created AS Created, category AS Category, item AS Item, quantity AS Quantity, 
    citizen_request.id, citizens.latitude, citizens.longitude FROM citizens 
    INNER JOIN citizen_request ON citizen_request.username = citizens.username WHERE citizen_request.rescuer_username = '$username'";
    $result2 = mysqli_query($db, $request);

    if ($result2) {
        $cargoData2 = array(); // Initialize an array to hold cargo data

        while ($row2 = mysqli_fetch_assoc($result2)) {
            // Append each cargo row to the cargoData array
            $cargoData2[] = $row2;
        }
    }

    // Combine both results
    $combinedTasks = array(
        'offers' => $cargoData,
        'requests' => $cargoData2,
    );

    // Close the database connection
    mysqli_close($db);

    // Output the combinedTasks array as JSON
    echo json_encode($combinedTasks);
}
?>
