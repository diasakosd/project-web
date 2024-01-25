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

    // Retrieve category, item, and old quantity from base_storage
    $selectBaseStorageQuery = "SELECT category, item, quantity FROM base_storage WHERE id = ?";
    $stmtSelectBaseStorage = mysqli_prepare($db, $selectBaseStorageQuery);
    mysqli_stmt_bind_param($stmtSelectBaseStorage, "i", $itemId);
    mysqli_stmt_execute($stmtSelectBaseStorage);
    mysqli_stmt_bind_result($stmtSelectBaseStorage, $category, $item, $oldQuantity);
    mysqli_stmt_fetch($stmtSelectBaseStorage);
    mysqli_stmt_close($stmtSelectBaseStorage);

    // Calculate the difference between old and new quantities
    $quantityDifference = $oldQuantity - $newQuantity;

    // Update the quantity in the database using prepared statement
    $updateBaseStorageQuery = "UPDATE base_storage SET quantity = ? WHERE id = ?";
    $stmtUpdateBaseStorage = mysqli_prepare($db, $updateBaseStorageQuery);
    mysqli_stmt_bind_param($stmtUpdateBaseStorage, "ii", $newQuantity, $itemId);

    if (mysqli_stmt_execute($stmtUpdateBaseStorage)) {
        // Record updated successfully, proceed to insert/update rescuer_inventory table
        $selectInventoryQuery = "SELECT quantity FROM rescuer_inventory WHERE username = ? AND category = ? AND item = ?";
        $stmtSelectInventory = mysqli_prepare($db, $selectInventoryQuery);
        mysqli_stmt_bind_param($stmtSelectInventory, "sss", $username, $category, $item);
        mysqli_stmt_execute($stmtSelectInventory);
        mysqli_stmt_store_result($stmtSelectInventory);

        if (mysqli_stmt_num_rows($stmtSelectInventory) > 0) {
            // Row exists, update the quantity
            $updateInventoryQuery = "UPDATE rescuer_inventory SET quantity = quantity + ? WHERE username = ? AND category = ? AND item = ?";
            $stmtUpdateInventory = mysqli_prepare($db, $updateInventoryQuery);
            mysqli_stmt_bind_param($stmtUpdateInventory, "isss", $quantityDifference, $username, $category, $item);

            if (mysqli_stmt_execute($stmtUpdateInventory)) {
                echo json_encode(array('status' => 'success', 'message' => 'Record updated successfully in rescuer_inventory table'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Error updating rescuer_inventory table: ' . mysqli_error($db)));
            }

            mysqli_stmt_close($stmtUpdateInventory);
        } else {
            // Row does not exist, insert a new row
            $insertInventoryQuery = "INSERT INTO rescuer_inventory (username, category, item, quantity) VALUES (?, ?, ?, ?)";
            $stmtInsertInventory = mysqli_prepare($db, $insertInventoryQuery);
            mysqli_stmt_bind_param($stmtInsertInventory, "sssi", $username, $category, $item, $quantityDifference);

            if (mysqli_stmt_execute($stmtInsertInventory)) {
                echo json_encode(array('status' => 'success', 'message' => 'Record inserted successfully in rescuer_inventory table'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Error inserting into rescuer_inventory table: ' . mysqli_error($db)));
            }

            mysqli_stmt_close($stmtInsertInventory);
        }

        mysqli_stmt_close($stmtSelectInventory);
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error updating record: ' . mysqli_error($db)));
        echo json_encode(array('status' => 'error', 'message' => 'Debug info: itemId=' . $itemId . ', newQuantity=' . $newQuantity));
    }

    mysqli_stmt_close($stmtUpdateBaseStorage);
    mysqli_close($db);
    echo "Reached point B";
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>
