<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableID = $_POST['tableId'];
    $taskID = $_POST['ID'];
    $action = $_POST['actionType'];

if($action == 'Cancel'){
    $Accepted = $_POST['Accepted'];
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
} else if($action == 'Finish'){
    $category = $_POST['category'];
    $item = $_POST['item'];

    if($tableID == 'offerTable'){
        $offerValue = $_POST['difference'];

        $offer = "DELETE FROM citizen_offer WHERE id = '$taskID' AND rescuer_username = '$username'";
        $result = mysqli_query($db, $offer);
        //Check if a row with the item already exists in rescuer_inventory
        $checkRescuerInventory = "SELECT * FROM rescuer_inventory WHERE category = '$category' AND item = '$item' AND username = '$username'";
        $resultCheck = mysqli_query($db, $checkRescuerInventory);

        if (mysqli_num_rows($resultCheck) > 0) {
            //If the row exists update the quantity
            $rescuerTableUpd = "UPDATE rescuer_inventory SET quantity = quantity + '$offerValue' WHERE category = '$category' AND item = '$item' AND username = '$username'";
        } else {
            //If the row doesn't exist insert a new row
            $rescuerTableUpd = "INSERT INTO rescuer_inventory (id, username, category, item, quantity) VALUES (NULL, '$username', '$category', '$item', '$offerValue')";
        }

        $result2 = mysqli_query($db, $rescuerTableUpd);
    } else if($tableID == 'requestTable'){
        $requestValue = $_POST['difference'];

        $rescuerTableUpd = "UPDATE rescuer_inventory SET quantity = quantity - '$requestValue' WHERE category = '$category' AND item = '$item' 
        AND username = '$username'";
        $result2 = mysqli_query($db, $rescuerTableUpd);
        
        $request = "DELETE FROM citizen_request WHERE id = '$taskID' AND rescuer_username = '$username'";
        $result = mysqli_query($db, $request);
    
        if ($result && $result2) {
            echo 'Task FINISHED successfully!';
        } else {
            echo 'ERROR in FINISHED task';
        }

        $request3 = "DELETE FROM rescuer_inventory WHERE quantity = 0 AND username = '$username'";
        $result3 = mysqli_query($db, $request3);
    } else {
        echo 'Invalid table ID';
    }
}
    mysqli_close($db);
}
?>