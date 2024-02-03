<?php
// Assuming you have a database connection established

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the AJAX request
    //$itemId = $_POST['item_id'];
    $newQuantity = $_POST['quantity'];
    $category = $_POST['category'];
    $item = $_POST['item'];

    // Example connection details; replace with your own
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "web";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user is logged in
    session_start();
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        echo json_encode(array('error' => 'User not logged in'));
        exit();
    }

    // Get the rescuer name based on the session username
    $username = $_SESSION['username'];

    // Check if the specified category and item exist in base_storage
    $checkExistence = "SELECT COUNT(*) AS count FROM base_storage WHERE category = '$category' AND item = '$item'";
    $resultExistence = $conn->query($checkExistence);

    if ($resultExistence && $resultExistence->num_rows > 0) {
        $row = $resultExistence->fetch_assoc();
        $existenceCount = $row['count'];

        if ($existenceCount == 0) {
            // If the category and item do not exist, insert a new row
            $insertNewRow = "INSERT INTO base_storage (category, item, quantity) VALUES ('$category', '$item', '$newQuantity')";
            $sql = "UPDATE rescuer_inventory SET rescuer_inventory.quantity = rescuer_inventory.quantity - '$newQuantity' WHERE username = '$username' AND category = '$category' AND item = '$item'";
            if ($conn->query($insertNewRow) === TRUE) {
                echo "New row inserted successfully" . $category . ' ' . $item;
            } else {
                echo "Error inserting new row: " . $conn->error;
            }
        } else {
            // If the category and item already exist, update the quantity
            $sql2 = "UPDATE base_storage SET quantity = quantity + '$newQuantity' WHERE category = '$category' AND item = '$item'";
            $sql = "UPDATE rescuer_inventory SET quantity = quantity - '$newQuantity' WHERE username = '$username' AND category = '$category' AND item = '$item'";
            $sql3 = "DELETE FROM rescuer_inventory WHERE quantity = 0";
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
