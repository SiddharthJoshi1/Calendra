
<?php
//php code to delete events on the click of the delete event button
session_start();

require_once("getConnection.php");



if(isset($_GET['event_id'])){
    $eventid = $_GET['event_id'];
    $deleteEventQuery = mysqli_query($conn, "DELETE FROM `eventsTable` WHERE `eventid` =".$eventid);
    if(!$deleteEventQuery){
        mysqli_error($conn);

    }





}


?>



