<?php
//Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

//Fetch categories from the base_storage table
$query = "SELECT DISTINCT category FROM base_storage";
$result = mysqli_query($db, $query);

$categories = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }
}

echo json_encode($categories);

mysqli_close($db);
?>
