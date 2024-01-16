<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');


// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Fetch categories from the base_storage table
$query = "SELECT DISTINCT category FROM base_storage";
$result = mysqli_query($db, $query);
$categories = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }
}

// Fetch items and categories from the base_storage table
$query = "SELECT DISTINCT category, item FROM base_storage";
$result = mysqli_query($db, $query);
$data = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'category' => $row['category'],
            'item' => $row['item']
        );
    }
// Close the database connection
mysqli_close($db);

// Send a JSON response
header('Content-Type: application/json');
echo json_encode($data);
} else {
// Handle errors
echo json_encode(array('error' => 'Query failed: ' . mysqli_error($db)));


// Close the database connection
mysqli_close($db);
}

?>
