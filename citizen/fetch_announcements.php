<?php

$db = mysqli_connect('localhost', 'root', '', 'web');


if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}


$query = "SELECT * FROM announcements WHERE status = 'NO'";
$result = mysqli_query($db, $query);

if ($result) {
   
    if (mysqli_num_rows($result) > 0) {
        //Display each announcement in a white box container
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="announcement-container" style="background-color: #fff; border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 8px;">';
            echo '<div class="announcement">';
            
            //Display the ID
            echo '<p style="color: #777;">ID: ' . $row['id'] . '</p>';

            echo '<h3 style="color: #333;">' . $row['title'] . '</h3>';
            echo '<p style="color: #555;">' . $row['body'] . '</p>';
            
            //Fetch items related to the announcement
            $announcementId = $row['id'];
            $itemQuery = "SELECT item FROM announcements_items WHERE announcement_id = $announcementId";
            $itemResult = mysqli_query($db, $itemQuery);

            if ($itemResult) {
                echo '<ul>';
                while ($itemRow = mysqli_fetch_assoc($itemResult)) {
                    echo '<li style="color: #777;">' . $itemRow['item'] . '</li>';
                }
                echo '</ul>';
            }

            
            echo '<p style="color: #777;">Date Written: ' . $row['date_written'] . '</p>';

            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'No announcements found with status "NO".';
    }
} else {
    echo json_encode(array('error' => 'Query failed: ' . mysqli_error($db)));
}


mysqli_close($db);
?>
