<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //$itemId = $_POST['item_id'];
    $newQuantity = $_POST['quantity'];
    $category = $_POST['category'];
    $item = $_POST['item'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "web";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start();
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        echo json_encode(array('error' => 'User not logged in'));
        exit();
    }

    $username = $_SESSION['username'];

    //Check if the specified item exist in base_storage
    $checkExistence = "SELECT COUNT(*) AS count FROM base_storage WHERE category = '$category' AND item = '$item'";
    $resultExistence = $conn->query($checkExistence);

    if ($resultExistence && $resultExistence->num_rows > 0) {
        $row = $resultExistence->fetch_assoc();
        $existenceCount = $row['count'];

        //If the item do not exist insert a new row
        if ($existenceCount == 0) {
            
            $insertNewRow = "INSERT INTO base_storage (category, item, quantity) VALUES ('$category', '$item', '$newQuantity')";
            $sql = "UPDATE rescuer_inventory SET rescuer_inventory.quantity = rescuer_inventory.quantity - '$newQuantity' WHERE username = '$username' AND category = '$category' AND item = '$item'";
            if ($conn->query($insertNewRow) === TRUE) {
                echo "New row inserted successfully" . $category . ' ' . $item;
            } else {
                echo "Error inserting new row: " . $conn->error;
            }
        } else {
            //If the item already exist update the quantity
            $sql2 = "UPDATE base_storage SET quantity = quantity + '$newQuantity' WHERE category = '$category' AND item = '$item'";
            $sql = "UPDATE rescuer_inventory SET quantity = quantity - '$newQuantity' WHERE username = '$username' AND category = '$category' AND item = '$item'";
            $sql3 = "DELETE FROM rescuer_inventory WHERE quantity <= 0";
            if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
                echo "Update successful" . $category . ' ' . $item;
            } else {
                echo "Error updating rescuer_inventory: " . $conn->error;
            }
        }
    } else {
        echo "Error checking existence: " . $conn->error;
    }

    $conn->close();
}
?>
