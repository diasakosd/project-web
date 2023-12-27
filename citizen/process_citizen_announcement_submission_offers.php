<?php
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected announcement IDs
    $selectedAnnouncementIds = isset($_POST['selectedAnnouncements']) ? $_POST['selectedAnnouncements'] : [];

    // Connect to the database (adjust the connection details)
    $db = mysqli_connect('localhost', 'root', '', 'web');

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape the data to prevent SQL injection
    // Adjust the way you fetch the citizen username based on your authentication mechanism
    $citizenUsername = isset($_SESSION['username']) ? $_SESSION['username'] : 'your_default_citizen_username';
    $citizenUsername = mysqli_real_escape_string($db, $citizenUsername);

    // Insert selected announcements into the citizen_offer table
    foreach ($selectedAnnouncementIds as $announcementId) {
        $announcementId = mysqli_real_escape_string($db, $announcementId);

        // Delete from the citizen_offer table
        $offerQuery = "DELETE FROM citizen_offer WHERE id = $announcementId AND username = '$citizenUsername'";

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
