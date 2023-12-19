<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo 'Connection failed: ' . mysqli_connect_error();
    exit;
}

// Fetch offers from citizen_offer where accepted is not 'DONE'
$query = "SELECT id, time_created, accepted, time_accepted FROM citizen_offer WHERE accepted != 'DONE'";

$result = mysqli_query($db, $query);

if ($result) {
    // Check if there are rows in the result
    if (mysqli_num_rows($result) > 0) {
        // Display checkboxes for each offer
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div>';
            echo '<input type="checkbox" name="selectedAnnouncements[]" value="' . $row['id'] . '">';
            echo 'ID: ' . $row['id'] . ' | Time Created: ' . $row['time_created'] . ' | Accepted: ' . $row['accepted'] . ' | Time Accepted: ' . $row['time_accepted'];
            echo '</div>';
        }
    } else {
        echo 'No offers found with accepted status other than "DONE".';
    }
} else {
    echo 'Query failed: ' . mysqli_error($db);
}

// Close the database connection
mysqli_close($db);
?>
