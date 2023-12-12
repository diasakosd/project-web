<?php
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected announcement IDs
    $selectedAnnouncementIds = isset($_POST['selectedAnnouncements']) ? $_POST['selectedAnnouncements'] : [];

    // Additional data (citizen username)
    $citizenUsername = isset($_SESSION['username']) ? $_SESSION['username'] : 'your_default_citizen_username';

    // Connect to the database (adjust the connection details)
    $db = mysqli_connect('localhost', 'root', '', 'web');

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape the data to prevent SQL injection
    $citizenUsername = mysqli_real_escape_string($db, $citizenUsername);

    // Insert selected announcements into the citizen_offer table
    foreach ($selectedAnnouncementIds as $announcementId) {
        $announcementId = mysqli_real_escape_string($db, $announcementId);

        // Insert into the citizen_offer table
        $offerQuery = "INSERT INTO citizen_offer (username, category, item, quantity) 
                       SELECT '$citizenUsername', category, item, 1
                       FROM announcements_items
                       WHERE announcement_id = $announcementId";

        if (!mysqli_query($db, $offerQuery)) {
            // Handle errors for citizen_offer
            echo json_encode(array('success' => false, 'error' => mysqli_error($db)));
            mysqli_close($db);
            exit; // Stop further execution
        }
    }

    // Send a success response
    echo json_encode(array('success' => true));

    // Close the database connection
    mysqli_close($db);
} else {
    // Send an error response for invalid request method
    echo json_encode(array('success' => false, 'error' => 'Invalid request method.'));
}
?>
