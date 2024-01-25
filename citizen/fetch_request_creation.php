<?php
// Your database connection logic here
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$field = $_GET['field'];
$term = $_GET['term'];

if ($field === 'category') {
    // Autocomplete for category
    $query = "SELECT DISTINCT category FROM base_storage WHERE category LIKE '$term%'";
    $result = mysqli_query($db, $query);
    $categories = array();

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['category'];
        }

        echo json_encode(['categories' => $categories]);
    } else {
        echo json_encode(['error' => 'Query failed']);
    }
} elseif ($field === 'item') {
    // Autocomplete for item
    $selectedCategory = $_GET['selectedCategory'];

    $query = "SELECT DISTINCT item FROM base_storage WHERE category = '$selectedCategory' AND item LIKE '$term%'";
    $result = mysqli_query($db, $query);
    $items = array();

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row['item'];
        }

        echo json_encode(['items' => $items]);
    } else {
        echo json_encode(['error' => 'Query failed']);
    }
} else {
    echo json_encode(['error' => 'Invalid field requested']);
}

// Close connection
mysqli_close($db);
?>