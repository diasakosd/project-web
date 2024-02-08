<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}


$username = $_SESSION['username'];


$category = mysqli_real_escape_string($db, $_POST['category']);
$item = mysqli_real_escape_string($db, $_POST['item']);
$quantity = mysqli_real_escape_string($db, $_POST['quantity']);


$sql = "INSERT INTO citizen_request (username, category, item, quantity, accepted) VALUES ('$username', '$category', '$item', $quantity, 'NO')";
$result = mysqli_query($db, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

mysqli_close($db);
echo "Request submitted successfully!";
?>
