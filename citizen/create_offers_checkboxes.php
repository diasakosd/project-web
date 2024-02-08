<?php

$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
$username = $_SESSION['username'];


$query = "SELECT id, time_created, accepted, time_accepted FROM citizen_offer WHERE username = '$username' AND accepted != 'DONE'";
$result = mysqli_query($db, $query);

if ($result) {
    echo '<form id="submitAnnouncementsForm">';

    //Loop through announcements and generate checkboxes
    while ($row = mysqli_fetch_assoc($result)) {
        $announcementId = $row['id'];
        $title = '';

        echo '<input type="checkbox" name="selectedAnnouncements[]" value="' . $announcementId . '"> Announcement ' . $announcementId . '<br><br>';
    }

    echo '</form>';
} else {
    echo 'Error fetching announcements: ' . mysqli_error($db);
}


mysqli_close($db);
?>
