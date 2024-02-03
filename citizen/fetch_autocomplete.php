<?php
// Your database connection logic here
$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['type']) && isset($_GET['input'])) {
    $type = $_GET['type'];
    $input = mysqli_real_escape_string($db, $_GET['input']);

    $sql = "SELECT DISTINCT $type FROM base_storage WHERE $type LIKE '$input%'";

    // Filter items based on the selected category
    if ($type === 'item' && isset($_GET['category'])) {
        $category = mysqli_real_escape_string($db, $_GET['category']);
        $sql .= " AND category = '$category'";
    }

    $result = mysqli_query($db, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($db));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row[$type] . '">';
    }

    mysqli_free_result($result);
}

mysqli_close($db);
?>
