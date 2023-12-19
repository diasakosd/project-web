<?php
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected offer IDs
    $selectedOfferIds = isset($_POST['selectedAnnouncements']) ? $_POST['selectedAnnouncements'] : [];

    // Additional data (citizen username)
    $citizenUsername = isset($_SESSION['username']) ? $_SESSION['username'] : 'your_default_citizen_username';

    // Connect to the database (adjust the connection details)
    $db = mysqli_connect('localhost', 'root', '', 'web');

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape the data to prevent SQL injection
    $citizenUsername = mysqli_real_escape_string($db, $citizenUsername);

    // Delete selected offers from the citizen_offer table
    foreach ($selectedOfferIds as $offerId) {
        $offerId = mysqli_real_escape_string($db, $offerId);

        // Delete from the citizen_offer table
        $deleteQuery = "DELETE FROM citizen_offer WHERE id = $offerId";

        if (!mysqli_query($db, $deleteQuery)) {
            // Handle errors for citizen_offer deletion
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
