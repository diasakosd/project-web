<?php
// Your database connection logic here
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT DISTINCT category FROM base_storage";
$result = mysqli_query($db, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

$categories = '<option value="">Select Category</option>';

while ($row = mysqli_fetch_assoc($result)) {
    $categories .= '<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
}

echo $categories;

mysqli_free_result($result);
mysqli_close($db);
?>
