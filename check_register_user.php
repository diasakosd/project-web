<?php

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the provided username exists
if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);

    // Query to check in combined_data table
    $query = "SELECT * FROM combined_data FORCE INDEX (user_data) WHERE username='$username';";
    $result = mysqli_query($db, $query);

    if ($result) {
        $row = $result->fetch_assoc();

        if ($row !== null) {
            $response = array('userExists' => true);
            echo json_encode($response);
        } else {
            $response = array('userExists' => false);
            echo json_encode($response);
        }
    } else {
        $response = array('userExists' => false);
        echo json_encode($response);
    }
}

?>
