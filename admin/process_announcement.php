<?php
// process_announcement.php
session_start();
if (isset($_POST['submit'])) {
    // Get the form data
    $title = $_POST['title'];
    $body = $_POST['body'];

    // Additional data (admin username)
    $admin =  $_SESSION['username']; // Replace with the actual admin username

    // Connect to the database (adjust the connection details)
    $db = mysqli_connect('localhost', 'root', '', 'web');

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape the data to prevent SQL injection
    $title = mysqli_real_escape_string($db, $title);
    $body = mysqli_real_escape_string($db, $body);
    $admin = mysqli_real_escape_string($db, $admin);

    // Insert the data into the database
    $query = "INSERT INTO announcements (title, body, admin) VALUES ('$title', '$body', '$admin')";

    if (mysqli_query($db, $query)) {
        echo "Announcement added successfully!";
    } else {
        echo "Error adding announcement: " . mysqli_error($db);
    }

    mysqli_close($db);
} else {
    echo "Invalid request.";
}
?>
