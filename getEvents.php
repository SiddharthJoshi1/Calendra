
<?php
//php code to get the events from the database
session_start();
require_once("getConnection.php");

$initialGetEventsQuery = mysqli_query($conn, "SELECT * FROM `eventsTable` WHERE eventsTable.userid =" . $_SESSION['userid'] );

if(!$initialGetEventsQuery){
    mysqli_error($conn);

}else {

    $results = array();
    while($row = mysqli_fetch_array($initialGetEventsQuery, MYSQLI_ASSOC)){

        $results[] = $row;
    }
    $json = json_encode($results);
    echo $json;

}