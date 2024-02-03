<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actionType = $_POST['action_type'];

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

    if($actionType == 'offer'){
        $offerid = $_POST['offerID']; echo $offerid;
        $acceptedOffer = $_POST['AcceptedOffer'];

        $offer = "UPDATE citizen_offer SET accepted = '$acceptedOffer', time_accepted = CURRENT_TIMESTAMP, rescuer_username = '$username' WHERE id = '$offerid'";
        $result = mysqli_query($conn, $offer);
    
        if ($result) {
            echo 'citizen_offer updated successfully!';
        } else {
            echo 'ERROR in offer received';
        }
    }else if($actionType == 'request'){
        $requestid = $_POST['requestID'];
        $acceptedRequest = $_POST['AcceptedRequest'];
        $request = "UPDATE citizen_request SET accepted = '$acceptedRequest', time_accepted = CURRENT_TIMESTAMP, rescuer_username = '$username' WHERE id = '$requestid'";
        echo $request;
        $result2 = mysqli_query($conn, $request);
    
        if ($result2) {
            echo 'citizen_request updated successfully!';
        } else {
            echo 'ERROR in request taken';
        }
    }
    // Close the database connection
    mysqli_close($conn);
}
?>