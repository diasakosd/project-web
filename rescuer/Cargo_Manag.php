<?php
// Add this at the beginning of your PHP script
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Reached point A";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the item ID and new quantity
    $itemId = $_POST['item_id'];
    $newQuantity = $_POST['quantity'];

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
        echo json_encode(array('error' => 'User not logged in'));
        exit();
    }

    // Get the rescuer name based on the session username
    $username = $_SESSION['username'];

    // Update the quantity in the database using prepared statement
    $query = "UPDATE base_storage SET quantity = ? WHERE base_storage.id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ii", $newQuantity, $itemId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($db);
        echo "Debug info: itemId=$itemId, newQuantity=$newQuantity";
    }

    mysqli_stmt_close($stmt);

    mysqli_close($db);
    echo "Reached point B";
} else {
    echo "Invalid request method";
}
// SELECT * FROM `base_storage` WHERE category = 'TOOLS'
?>
