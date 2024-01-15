<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Fetch request from citizen_request where accepted is 'DONE'
$query = "SELECT * FROM citizen_request WHERE accepted = 'DONE'";

$result = mysqli_query($db, $query);

if ($result) {
    // Check if there are rows in the result
    if (mysqli_num_rows($result) > 0) {
        // Display each request in a white box container
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="request-container" style="background-color: #fff; border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 8px;">';
            echo '<div class="request">';
            
            // Display request details
            echo '<p style="color: #777;">Time Created: ' . $row['time_created'] . '</p>';
            echo '<p style="color: #777;">Accepted: ' . $row['accepted'] . '</p>';
            echo '<p style="color: #777;">Time Accepted: ' . $row['time_accepted'] . '</p>';

            // Other information as needed
            echo '<p style="color: #777;">Username: ' . $row['username'] . '</p>';
            echo '<p style="color: #777;">Category: ' . $row['category'] . '</p>';
            echo '<p style="color: #777;">Item: ' . $row['item'] . '</p>';
            echo '<p style="color: #777;">Quantity: ' . $row['quantity'] . '</p>';
            
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'No requests found with accepted status "DONE".';
    }
} else {
    echo json_encode(array('error' => 'Query failed: ' . mysqli_error($db)));
}

// Close the database connection
mysqli_close($db);
?>
