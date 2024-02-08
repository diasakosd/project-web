<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Get the selected announcement IDs
    $selectedAnnouncementIds = isset($_POST['selectedAnnouncements']) ? $_POST['selectedAnnouncements'] : [];

    
    $db = mysqli_connect('localhost', 'root', '', 'web');

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

  
    //Fetch the citizen username 
    $citizenUsername = isset($_SESSION['username']) ? $_SESSION['username'] : 'your_default_citizen_username';
    $citizenUsername = mysqli_real_escape_string($db, $citizenUsername);

    //Insert selected announcements into the citizen_offer table
    foreach ($selectedAnnouncementIds as $announcementId) {
        $announcementId = mysqli_real_escape_string($db, $announcementId);

        
        $offerQuery = "DELETE FROM citizen_offer WHERE id = $announcementId AND username = '$citizenUsername'";

        if (!mysqli_query($db, $offerQuery)) {

            echo json_encode(array('success' => false, 'error' => mysqli_error($db)));
            mysqli_close($db);
            exit; 
        }
    }

    
    echo json_encode(array('success' => true));

    
    mysqli_close($db);
} else {
    
    echo json_encode(array('success' => false, 'error' => 'Invalid request method.'));
}
?>
