<?php

$db = mysqli_connect('localhost', 'root', '', 'web');


if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

//Check if the user is logged in
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(array('error' => 'User not logged in'));
    exit();
}

//Get the admin name based on the session username
$username = $_SESSION['username'];


$query = "SELECT username FROM citizens WHERE username = '$username'";
$result = mysqli_query($db, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row !== null && isset($row['username'])) {
        $citizenName = $row['username'];
        echo json_encode(array('citizenName' => $citizenName));
    } else {
        echo json_encode(array('error' => 'Rescuer name not found'));
    }
} else {
    echo json_encode(array('error' => 'Query failed: ' . mysqli_error($db)));
}


mysqli_close($db);
?>
