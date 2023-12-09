<?php
// fetch_items.php

// Connect to the database (adjust the connection details)
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch items from the base_storage table
$query = "SELECT item FROM base_storage";
$result = mysqli_query($db, $query);

$items = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row['item'];
    }
}

echo json_encode($items);

mysqli_close($db);
?>
