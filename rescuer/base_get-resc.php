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

$baseContent = "SELECT id AS id, category AS Category, item AS Item, quantity AS Quantity FROM `base_storage` WHERE quantity>0";
$result = mysqli_query($db, $baseContent);

if($result){
    $cargoData = array(); 

    while ($row = mysqli_fetch_assoc($result)) {

        $cargoData[] = $row;
    }

    echo json_encode($cargoData);
}

mysqli_close($db);
?>