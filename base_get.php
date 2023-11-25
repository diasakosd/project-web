<?php

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Fetch data from the base_storage table
$sql = "SELECT * FROM base_storage";
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
