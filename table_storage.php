<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both URL and file are provided
    if (!empty($_POST["url"]) && !empty($_FILES["file"]["name"])) {
        echo "Please provide either a URL or upload a file, not both.";}
    elseif (empty($_POST["url"]) && empty($_FILES["file"]["name"])){
        echo "Please provide either a URL or upload a file.";}
     else {
        // Check if a URL is provided
        if (!empty($_POST["url"])) {
            $url = $_POST["url"];

            // Check if the URL has a valid file extension
            if (!isValidUrl($url)) {
                echo 'The URL you provided does not correspond to a valid JSON or PHP file.';
            } else {
                // Fetch JSON data from the URL
                $jsonArray = fetchJsonFromUrl($url);

                // Process and insert data into the database
                processJsonData($jsonArray);

                echo "You submitted a URL: $url";
            }
        }

        // Check if a file is uploaded
        if (!empty($_FILES["file"]["name"])) {
            $uploadedFile = $_FILES["file"];
            $fileName = $uploadedFile["name"];
            $tempFile = $uploadedFile["tmp_name"];

            // Check if the file has a valid extension
            if (!isValidFileExtension($fileName)) {
                echo 'The file you uploaded is not a valid JSON or PHP file.';
            } else {
                // Move the uploaded file to the tempfiles directory
                $tempFilePath = "tempfiles/" . $fileName;
                if (move_uploaded_file($tempFile, $tempFilePath)) {
                    // Fetch JSON data from the uploaded file
                    $jsonArray = fetchJsonFromFile($tempFilePath);

                    // Process and insert data into the database
                    processJsonData($jsonArray);

                    echo "You uploaded a file: $fileName";
                } else {
                    echo "Error moving the uploaded file to the destination.";
                }
            }
        }

    }
}

// Function to check if a URL has a valid extension
function isValidUrl($url) {
    $validExtensions = array('json', 'php');
    $urlExtension = pathinfo($url, PATHINFO_EXTENSION);
    return in_array($urlExtension, $validExtensions);
}

// Function to check if a file has a valid extension
function isValidFileExtension($fileName) {
    $validExtensions = array('json', 'php');
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    return in_array($fileExtension, $validExtensions);
}

// Function to fetch JSON data from a URL
function fetchJsonFromUrl($url) {
    $jsonData = file_get_contents($url);

    if ($jsonData === false) {
        die("Error fetching JSON data from URL: $url");
    }

    return json_decode($jsonData, true);
}


// Fetch JSON data from an uploaded file
function fetchJsonFromFile($file) {
    $jsonData = file_get_contents($file);

    if ($jsonData === false) {
        die("Error fetching JSON data from uploaded file.");
    }

    return json_decode($jsonData, true);
}


// Function to process and insert data into the database
function processJsonData($jsonArray) {
    // Connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'web');

    // Check connection
    if (!$db) {
        echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
        exit();
    }
    $sql0 = "DELETE FROM base_storage;";
    $sql1= "ALTER TABLE `base_storage` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    // Execute the query
    mysqli_query($db, $sql0);
    // Execute the query
    mysqli_query($db, $sql1);
    // Initialize an array to store lowercase category and item pairs
    $insertedPairs = [];

    // Iterate through items and insert into the base_storage table
    foreach ($jsonArray['items'] as $item) {
        $category_id = $item['category'];
        $itemName = $item['name'];

        // Check if the item is only whitespaces
        if (!empty(trim($itemName))) {
            $quantity = 100;  // Set the default quantity to 100

            $category_id_name = null;

            // Find the category details based on category_id
            foreach ($jsonArray['categories'] as $category) {
                if ($category['id'] === $category_id) {
                    $category_id_name = $category['category_name'];
                    break; // Stop searching once the category is found
                }
            }

            // Convert to lowercase and remove whitespaces from the start and end
            $lowercaseCategory = strtolower(trim($category_id_name));
            $lowercaseItem = strtolower(trim($itemName));

            // Check if the pair exists in the insertedPairs array
            $pairKey = $lowercaseCategory . '-' . $lowercaseItem;
            if (!isset($insertedPairs[$pairKey])) {
                // Your SQL query to insert data into base_storage
                $sql2 = "INSERT INTO base_storage (category, item, quantity) VALUES ('$category_id_name', '$itemName', $quantity)";

                // Execute the query
                mysqli_query($db, $sql2);

                // Add the pair to the insertedPairs array to mark it as inserted
                $insertedPairs[$pairKey] = true;
            }
        }
    }

    mysqli_close($db);
}
?>
