<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both URL and file are provided
    if (!empty($_POST["url"]) && !empty($_FILES["file"]["name"])) {
        echo "Please provide either a URL or upload a file, not both.";
    } else {
        // Check if a URL is provided
        if (!empty($_POST["url"])) {
            $url = $_POST["url"];
            echo "You submitted a URL: $url";
        }

        // Check if a file is uploaded
        if (!empty($_FILES["file"]["name"])) {
            $uploadedFile = $_FILES["file"];
            $fileName = $uploadedFile["name"];
            $tempFile = $uploadedFile["tmp_name"];

            // Move the uploaded file to a desired location
            move_uploaded_file($tempFile, "tempfiles/" . $fileName);

            echo "You uploaded a file: $fileName";
        }
    }
}
?>
