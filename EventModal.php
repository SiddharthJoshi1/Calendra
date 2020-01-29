
<?php
//php code to get the data for the specific event and send it back to js
session_start();

require_once("getConnection.php");



if(isset($_GET['event_id'])){
    $eventid = $_GET['event_id'];
    $viewEventQuery = mysqli_query($conn, "SELECT * FROM `eventsTable` WHERE `eventid` =".$eventid);
    if(!$viewEventQuery){
        mysqli_error($conn);

    }else {

        $results = array();
        while($row = mysqli_fetch_array($viewEventQuery, MYSQLI_ASSOC)){

            $results[] = $row;
        }
        $json = json_encode($results);
        echo $json;

    }


}





?>



