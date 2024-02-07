<?php

$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

//Check if the provided username and password match
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $query = "SELECT * FROM combined_data FORCE INDEX (user_data) WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $row = $result->fetch_assoc();

        if ($row !== null) {
            $response = array('userMatch' => true);
            echo json_encode($response);
        } else {
            $response = array('userMatch' => false);
            echo json_encode($response);
        }
    } else {
        $response = array('userMatch' => false, 'error' => 'Query failed: ' . mysqli_error($db));
        echo json_encode($response);
    }
}

?>
