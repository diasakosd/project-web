<?php
// Your database connection logic here
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['category'])) {
    $category = $_POST['category'];

    $category = mysqli_real_escape_string($db, $category);

    $sql = "SELECT DISTINCT item FROM base_storage WHERE category = '$category'";
    $result = mysqli_query($db, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($db));
    }

    $items = '<option value="">Select Item</option>';

    while ($row = mysqli_fetch_assoc($result)) {
        $items .= '<option value="' . $row['item'] . '">' . $row['item'] . '</option>';
    }

    echo $items;

    mysqli_free_result($result);
}

mysqli_close($db);
?>
