<?php
// Your database connection logic here
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming you have a valid user session. Replace '$_SESSION['username']' with your actual session variable.
session_start();
$username = $_SESSION['username'];

// Retrieve data from the POST request
$category = mysqli_real_escape_string($db, $_POST['category']);
$item = mysqli_real_escape_string($db, $_POST['item']);
$quantity = mysqli_real_escape_string($db, $_POST['quantity']);

// Insert the data into the 'citizen_request' table
$sql = "INSERT INTO citizen_request (username, category, item, quantity, accepted) VALUES ('$username', '$category', '$item', $quantity, 'NO')";
$result = mysqli_query($db, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

mysqli_close($db);
echo "Request submitted successfully!";
?>
