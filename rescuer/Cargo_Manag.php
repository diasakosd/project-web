<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
echo "Received request method: $requestMethod";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the item ID, new quantity, and coordinates
    

    $itemId = $_POST['item_id'];
    $newQuantity = $_POST['quantity'];
    $category = $_POST['category'];
    $item = $_POST['item'];
    $baseLat = $_POST['baseLat'];
    $baseLon = $_POST['baseLon'];
    $rescuerLat = $_POST['rescuerLat'];
    $rescuerLon = $_POST['rescuerLon'];
        
        

        // Check if the distance between rescuer and base is <= 100 meters
        $distance = calculateDistance($baseLat, $baseLon, $rescuerLat, $rescuerLon);
        echo $distance;
        if ($distance <= 0.1) {
            // Connect to the database
            $db = mysqli_connect('localhost', 'root', '', 'web');

            // Check connection
            if (!$db) {
                echo json_encode(array('status' => 'error', 'message' => 'Connection failed: ' . mysqli_connect_error()));
                exit();
            }

            // Check if the user is logged in
            session_start();
            if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
                echo json_encode(array('status' => 'error', 'message' => 'User not logged in'));
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
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Rescuer is too far from the base (distance > 100 meters)'));
        }
    
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}

// Function to calculate the distance between two sets of coordinates (in meters)
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // Earth radius in kilometers

    $lat1Rad = deg2rad($lat1);
    $lon1Rad = deg2rad($lon1);
    $lat2Rad = deg2rad($lat2);
    $lon2Rad = deg2rad($lon2);

    $dlat = $lat2Rad - $lat1Rad;
    $dlon = $lon2Rad - $lon1Rad;

    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1Rad) * cos($lat2Rad) * sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earthRadius * $c * 1000; // Convert distance to meters

    return $distance;
}

?>
