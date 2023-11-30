<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Fetch category parameters from the client-side (JavaScript)
$categories = isset($_GET['categories']) ? $_GET['categories'] : '';

// Build the SQL query based on the selected categories
$sql = "SELECT * FROM base_storage";
if (!empty($categories)) {
    // Sanitize the input to prevent SQL injection
    $categories = implode(',', array_map(function ($cat) use ($db) {
        return "'" . mysqli_real_escape_string($db, $cat) . "'";
    }, explode(',', $categories)));

    // Include the selected categories in the query
    $sql .= " WHERE category IN ($categories)";
}

$result = mysqli_query($db, $sql);

// Check if there are rows in the result
if (mysqli_num_rows($result) > 0) {
    // Build the HTML table
    echo '<table border="1">
            <tr>
                <th>Id</th>
                <th>Category</th>
                <th>Item</th>
                <th>Quantity</th>
            </tr>';

    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['category'] . '</td>
                <td>' . $row['item'] . '</td>
                <td>' . $row['quantity'] . '</td>
              </tr>';
    }

    echo '</table>';
} else {
    echo 'No data found in the base_storage table.';
}

// Close the database connection
mysqli_close($db);
?>
