<?php
include 'session_admin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set
    if (isset($_POST["category-form"], $_POST["item-form"], $_POST["quantity-form"], $_POST["action-form"])) {
        $category = $_POST["category-form"];
        $item = $_POST["item-form"];
        $quantity = $_POST["quantity-form"];
        $action = strtoupper($_POST["action-form"]); // Convert action to uppercase for case-insensitive comparison

        // Connect to the database
        $db = mysqli_connect('localhost', 'root', '', 'web');

        // Check connection
        if (!$db) {
            echo 'Connection failed: ';
            exit();
        }

        switch ($action) {
            case 'ADD':
                // Check if the item already exists
                $sqlCheck = "SELECT * FROM base_storage WHERE category = '$category' AND item = '$item'";
                $resultCheck = mysqli_query($db, $sqlCheck);

                if (mysqli_num_rows($resultCheck) > 0) {
                    echo 'Item already exists. Use UPDATE instead of ADD.';
                } else {
                    // Add the item to the base_storage table
                    $sqlAdd = "INSERT INTO base_storage (category, item, quantity) VALUES ('$category', '$item', $quantity)";
                    mysqli_query($db, $sqlAdd);
                    echo 'Item added successfully.';
                }
                break;

            case 'UPDATE':
                // Update the quantity of an existing item in the base_storage table
                $sqlUpdate = "UPDATE base_storage SET quantity = $quantity WHERE category = '$category' AND item = '$item'";
                mysqli_query($db, $sqlUpdate);

                if (mysqli_affected_rows($db) > 0) {
                    echo 'Item updated successfully.';
                } else {
                    echo 'Item not found. Use ADD instead of UPDATE.';
                }
                break;

            case 'DELETE':
                // Delete an item from the base_storage table
                $sqlDelete = "DELETE FROM base_storage WHERE category = '$category' AND item = '$item'";
                mysqli_query($db, $sqlDelete);

                if (mysqli_affected_rows($db) > 0) {
                    echo 'Item deleted successfully.';
                } else {
                    echo 'Item not found. Nothing deleted.';
                }
                break;

            default:
                echo 'Invalid action. Use ADD, UPDATE, or DELETE.';
                break;
        }

        mysqli_close($db);
    } else {
        echo 'All form fields are required.';
    }
}
?>
