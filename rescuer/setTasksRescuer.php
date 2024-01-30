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
    $taskID = $_POST['ID'];
    $action = $_POST['actionType'];

if($action == 'Cancel'){
    if($tableID == 'offerTable'){
        $Accepted = $_POST['Accepted'];

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
} else if($action == 'Finish'){
    $category = $_POST['category'];
    $item = $_POST['item'];

    if($tableID == 'offerTable'){
        $offerValue = $_POST['difference'];

        $offer = "DELETE FROM citizen_offer WHERE id = '$taskID' AND rescuer_username = '$username'";
        $result = mysqli_query($db, $offer);
        $rescuerTableUpd = "UPDATE rescuer_inventory SET quantity = quantity + '$offerValue' WHERE category = '$category' AND item = '$item' AND username = '$username'";
        $result2 = mysqli_query($db, $rescuerTableUpd);
    
        if ($result && $result2) {
            echo 'citizen_offer FINISHED successfully!';
        } else {
            echo 'ERROR in offer FINISHED';
        }
    } else if($tableID == 'requestTable'){
        $requestValue = $_POST['difference'];

        $request = "DELETE FROM citizen_request WHERE id = '$taskID' AND rescuer_username = '$username'";
        $result = mysqli_query($db, $request);
        $rescuerTableUpd = "UPDATE rescuer_inventory SET quantity = quantity - '$requestValue' WHERE category = '$category' AND item = '$item' 
        AND username = '$username' AND quantity >= '$requestValue'";
        $result2 = mysqli_query($db, $rescuerTableUpd);
    
        if ($result && $result2) {
            echo 'Task FINISHED successfully!';
        } else {
            echo 'ERROR in FINISHED task';
        }
    } else {
        echo 'Invalid table ID';
    }
}
    mysqli_close($db);
}
?>