<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $selectedAnnouncementIds = isset($_POST['selectedAnnouncements']) ? $_POST['selectedAnnouncements'] : [];

   
    $citizenUsername = isset($_SESSION['username']) ? $_SESSION['username'] : 'your_default_citizen_username';

   
    $db = mysqli_connect('localhost', 'root', '', 'web');

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Escape the data to prevent SQL injection
    $citizenUsername = mysqli_real_escape_string($db, $citizenUsername);

   
    foreach ($selectedAnnouncementIds as $announcementId) {
        $announcementId = mysqli_real_escape_string($db, $announcementId);

        
        $offerQuery = "INSERT INTO citizen_offer (username, category, item, quantity) 
                       SELECT '$citizenUsername', category, item, 1
                       FROM announcements_items
                       WHERE announcement_id = $announcementId";
        
        $offerQuery2 = "DELETE FROM announcements WHERE id = $announcementId";

        if (!mysqli_query($db, $offerQuery)) {
           
            echo json_encode(array('success' => false, 'error' => mysqli_error($db)));

        }
        if (!mysqli_query($db, $offerQuery2)) {
           
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
