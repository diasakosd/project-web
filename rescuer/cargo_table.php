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

$seeContent = "SELECT category AS Category, item AS Item, quantity AS Quantity FROM rescuer_inventory WHERE username = '$username'";
$result = mysqli_query($db, $seeContent);

if ($result) {
    $cargoData = array(); 

    while ($row = mysqli_fetch_assoc($result)) {
       
        $cargoData[] = $row;
    }

    if (empty($cargoData)) {
        
        echo json_encode(array('message' => 'You do not have any cargo yet!'));
    } else {
       
        echo json_encode($cargoData);
    }
} else {
    echo json_encode(array('error' => 'No loaded cargo found'));
}


mysqli_close($db);
?>
