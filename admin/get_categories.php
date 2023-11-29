<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Fetch categories from the database
$sql = "SELECT DISTINCT category FROM base_storage";
$result = mysqli_query($db, $sql);

// Check if there are rows in the result
if (mysqli_num_rows($result) > 0) {
    // Build checkboxes based on fetched categories
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<label><input type="checkbox" class="category-checkbox" value="' . $row['category'] . '"> ' . $row['category'] . '</label>';
    }
} else {
    echo 'No categories found.';
}

// Close the database connection
mysqli_close($db);
?>
