<?php
// Connect to the database (adjust the connection details)
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
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
