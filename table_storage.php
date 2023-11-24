<?php

// Function to fetch JSON data from a URL
function fetchJsonFromUrl($url) {
    $jsonData = file_get_contents($url);
    return json_decode($jsonData, true);
}

// Function to fetch JSON data from an uploaded file
function fetchJsonFromFile($file) {
    $jsonData = file_get_contents($file['tmp_name']);
    return json_decode($jsonData, true);
}

// Choose whether to fetch JSON from a URL or an uploaded file
// Adjust these variables accordingly
$loadFromUrl = true;  // Set to true if you want to load from a URL
$loadFromFile = false;  // Set to true if you want to load from an uploaded file

// URL or file path, adjust accordingly
$url = 'http://usidas.ceid.upatras.gr/web/2023/export.php';  // Change this to your URL
//$uploadedFile = $_FILES['jsonFile'];  // Change this to your file input name

/*if ($loadFromUrl) {
    $jsonArray = fetchJsonFromUrl($url);
} elseif ($loadFromFile && isset($uploadedFile)) {
    $jsonArray = fetchJsonFromFile($uploadedFile);
}
*/
$jsonArray = fetchJsonFromUrl($url);
// Check if JSON data is successfully loaded
if (!$jsonArray) {
    die('Error loading JSON data');
}

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'web');

// Check connection
if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}
tablenames=[]
// Iterate through items and insert into the base_storage table
foreach ($jsonArray['items'] as $item) {
    $category_id = $item['category'];
    $itemName = $item['name'];
    $quantity = 100;  // Set the default quantity to 100

    $category_id_name = null;

    // Find the category details based on category_id
    foreach ($jsonArray['categories'] as $category) {
        if ($category['id'] === $category_id) {
            $category_id_name = $category['category_name'];
            break; // Stop searching once the category is found
        }
    }

    // Your SQL query to insert data into base_storage
    if ($category_id_name) {
        $sql = "INSERT INTO base_storage (category, item, quantity) VALUES ('$category_id_name', '$itemName', $quantity)";
        mysqli_query($db, $sql);
        // Note: Make sure to use prepared statements to prevent SQL injection
        // mysqli_query($yourDbConnection, $sql);
    }
}


echo 'Data inserted successfully';
mysqli_close($db);
?>