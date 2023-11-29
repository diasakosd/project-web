<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

// Check if the user is logged in
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "You cant access this file";
    exit();
}

// Get the admin name based on the session username
$username = $_SESSION['username'];

// Query to get the admin name from the admin table (change the table name accordingly)
$query = "SELECT username FROM admin WHERE username = '$username'";
$result = mysqli_query($db, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row !== null && isset($row['username'])) {
        $adminName = $row['username'];
        echo json_encode(array('adminName' => $adminName));
    } else {
        echo json_encode(array('error' => 'Admin name not found'));
    }
} else {
    echo json_encode(array('error' => 'Query failed: ' . mysqli_error($db)));
}

// Close the database connection
mysqli_close($db);
?>
