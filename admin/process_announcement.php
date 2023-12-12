<?php
// process_announcement.php

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $postData = file_get_contents('php://input');

    // Decode the JSON data
    $formData = json_decode($postData, true);

    // Check if the required fields are present
    if (isset($formData['title'], $formData['body'], $formData['selectedItems'], $formData['itemCategories'])) {
        // Get the form data
        $title = $formData['title'];
        $body = $formData['body'];
        $selectedItems = $formData['selectedItems'];
        $itemCategories = $formData['itemCategories'];

        // Additional data (admin username) - replace 'your_admin_username' with the actual admin username retrieval logic
        session_start();
        $admin = isset($_SESSION['username']) ? $_SESSION['username'] : 'your_admin_username';

        // Connect to the database (adjust the connection details)
        $db = mysqli_connect('localhost', 'root', '', 'web');

        if (!$db) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Escape the data to prevent SQL injection
        $title = mysqli_real_escape_string($db, $title);
        $body = mysqli_real_escape_string($db, $body);
        $admin = mysqli_real_escape_string($db, $admin);

        // Insert the announcement into the announcements table
        $query = "INSERT INTO announcements (title, body, admin) VALUES ('$title', '$body', '$admin')";

        if (mysqli_query($db, $query)) {
            // Get the ID of the inserted announcement
            $announcementId = mysqli_insert_id($db);

            // Insert selected items into the announcements_items table with categories
            foreach ($selectedItems as $index => $item) {
                $item = mysqli_real_escape_string($db, $item);
                $category = mysqli_real_escape_string($db, $itemCategories[$index]);

                // Insert into the announcements_items table
                $itemQuery = "INSERT INTO announcements_items (announcement_id, category, item) VALUES ('$announcementId', '$category', '$item')";

                if (!mysqli_query($db, $itemQuery)) {
                    // Handle errors for announcements_items
                    echo json_encode(array('success' => false, 'error' => mysqli_error($db)));
                    mysqli_close($db);
                    exit; // Stop further execution
                }
            }

            // Send a success response
            echo json_encode(array('success' => true));
        } else {
            // Send an error response for announcements
            echo json_encode(array('success' => false, 'error' => mysqli_error($db)));
        }

        // Close the database connection
        mysqli_close($db);
    } else {
        // Send an error response if required fields are missing
        echo json_encode(array('success' => false, 'error' => 'Required fields are missing.'));
    }
} else {
    // Send an error response for invalid request method
    echo json_encode(array('success' => false, 'error' => 'Invalid request method.'));
}
?>
