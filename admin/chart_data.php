<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Function to fetch data from the database within the specified date range
function fetchDataByDateRange($table, $condition, $startDate, $endDate) {
    global $db;
    $sql = "SELECT COUNT(*) as count FROM $table WHERE accepted = '$condition' AND time_created BETWEEN '$startDate' AND '$endDate'";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    } else {
        return 0;
    }
}

// Fetch data for each category within the specified date range
$newRequests = fetchDataByDateRange('citizen_request', 'NO', $_GET['startDate'], $_GET['endDate']);
$newOffers = fetchDataByDateRange('citizen_offer', 'NO', $_GET['startDate'], $_GET['endDate']);
$requestsCompleted = fetchDataByDateRange('citizen_request', 'DONE', $_GET['startDate'], $_GET['endDate']);
$offersCompleted = fetchDataByDateRange('citizen_offer', 'DONE', $_GET['startDate'], $_GET['endDate']);

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
