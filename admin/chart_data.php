<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Function to fetch data from the database
function fetchData($table, $condition) {
    global $db;
    $sql = "SELECT COUNT(*) as count FROM $table WHERE accepted = '$condition'";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    } else {
        return 0;
    }
}

// Fetch data for each category
$newRequests = fetchData('citizen_request', 'NO');
$newOffers = fetchData('citizen_offer', 'NO');
$requestsCompleted = fetchData('citizen_request', 'DONE');
$offersCompleted = fetchData('citizen_offer', 'DONE');

// Output the data as JSON
echo json_encode(array(
    'newRequests' => $newRequests,
    'newOffers' => $newOffers,
    'requestsCompleted' => $requestsCompleted,
    'offersCompleted' => $offersCompleted,
));

// Close the database connection
mysqli_close($db);
?>
