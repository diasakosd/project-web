<?php

$db = mysqli_connect('localhost', 'root', '', 'web');

if (!$db) {
    echo json_encode(array('error' => 'Connection failed: ' . mysqli_connect_error()));
    exit();
}

session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(array('error' => 'User not logged in'));
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $offer = "SELECT full_name AS Fullname, phone AS Telephone, time_created AS Created, category AS Category, item AS Item, quantity AS Quantity, 
    citizen_offer.id, citizens.latitude, citizens.longitude FROM citizens 
    INNER JOIN citizen_offer ON citizen_offer.username = citizens.username WHERE citizen_offer.rescuer_username = '$username' AND accepted LIKE 'YES'";
    $result = mysqli_query($db, $offer);

    if ($result) {
        $cargoData = array(); 

        while ($row = mysqli_fetch_assoc($result)) {
            
            $cargoData[] = $row;
        }
    }

    $request = "SELECT full_name AS Fullname, phone AS Telephone, time_created AS Created, category AS Category, item AS Item, quantity AS Quantity, 
    citizen_request.id, citizens.latitude, citizens.longitude FROM citizens 
    INNER JOIN citizen_request ON citizen_request.username = citizens.username WHERE citizen_request.rescuer_username = '$username'AND accepted LIKE 'YES'";
    $result2 = mysqli_query($db, $request);

    if ($result2) {
        $cargoData2 = array(); 

        while ($row2 = mysqli_fetch_assoc($result2)) {
            
            $cargoData2[] = $row2;
        }
    }

    //combine results
    $combinedTasks = array(
        'offers' => $cargoData,
        'requests' => $cargoData2,
    );

    mysqli_close($db);

    echo json_encode($combinedTasks);
}
?>
