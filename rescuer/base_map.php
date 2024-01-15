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


// Query to get the base coordinates
$query2 = "SELECT latitude, longitude FROM storage_location";
$result2 = mysqli_query($db, $query2);

if ($result2) {
    $cargoData2 = array(); // Initialize an array to hold base coordinates data

    while ($row2 = mysqli_fetch_assoc($result2)) {
        // Append each base coordinates row to the cargoData2 array
        $cargoData2[] = $row2;
    }

    echo json_encode($cargoData2);
} else {
    echo json_encode(array('error' => 'No base coordinates found'));
}

// Close the database connection
mysqli_close($db);
?>