<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableID = $_POST['tableId'];
    $Accepted = $_POST['Accepted'];
    $taskID = $_POST['ID'];

    if($tableID == 'offerTable'){
        $offer = "UPDATE citizen_offer SET accepted = '$Accepted', time_accepted = NULL, rescuer_username = NULL WHERE id = '$taskID' AND rescuer_username = '$username'";
        $result = mysqli_query($db, $offer);
    
        if ($result) {
            echo 'citizen_offer updated successfully!';
        } else {
            echo 'ERROR in offer received';
        }
    } else if($tableID == 'requestTable'){
        $request = "UPDATE citizen_request SET accepted = '$Accepted', time_accepted = NULL, rescuer_username = NULL WHERE id = '$taskID' AND rescuer_username = '$username'";
        $result = mysqli_query($db, $request);
    
        if ($result) {
            echo 'Task canceled successfully!';
        } else {
            echo 'ERROR in canceling task';
        }
    } else {
        echo 'Invalid table ID';
    }

    mysqli_close($db);
}
?>