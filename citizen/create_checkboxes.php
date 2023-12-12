<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch announcements with status 'NO'
$query = "SELECT id, title FROM announcements WHERE status = 'NO'";
$result = mysqli_query($db, $query);

if ($result) {
    echo '<form id="submitAnnouncementsForm">';

    // Loop through announcements and generate checkboxes
    while ($row = mysqli_fetch_assoc($result)) {
        $announcementId = $row['id'];
        $title = $row['title'];

        echo '<input type="checkbox" name="selectedAnnouncements[]" value="' . $announcementId . '"> Announcement ' . $announcementId . ': ' . $title . '<br><br>';
    }

    echo '</form>';
} else {
    echo 'Error fetching announcements: ' . mysqli_error($db);
}

// Close the database connection
mysqli_close($db);
?>
