<?php

$db = mysqli_connect('localhost', 'root', '', 'web');


if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

session_start();
$username = $_SESSION['username'];

$query = "SELECT * FROM citizen_offer WHERE username = '$username' AND accepted = 'DONE'";

$result = mysqli_query($db, $query);

if ($result) {
    
    if (mysqli_num_rows($result) > 0) {
        //Display each offer in a white box container
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="offer-container" style="background-color: #fff; border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 8px;">';
            echo '<div class="offer">';
            
            //Display offer details
            echo '<p style="color: #777;">Time Created: ' . $row['time_created'] . '</p>';
            echo '<p style="color: #777;">Accepted: ' . $row['accepted'] . '</p>';
            echo '<p style="color: #777;">Time Accepted: ' . $row['time_accepted'] . '</p>';

            
            echo '<p style="color: #777;">Username: ' . $row['username'] . '</p>';
            echo '<p style="color: #777;">Category: ' . $row['category'] . '</p>';
            echo '<p style="color: #777;">Item: ' . $row['item'] . '</p>';
            echo '<p style="color: #777;">Quantity: ' . $row['quantity'] . '</p>';
            
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'No offers found with accepted status "DONE".';
    }
} else {
    echo json_encode(array('error' => 'Query failed: ' . mysqli_error($db)));
}


mysqli_close($db);
?>
