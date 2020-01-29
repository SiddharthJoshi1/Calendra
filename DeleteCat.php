
<?php
//php code to delete category on the click of the delete category button
session_start();

require_once("getConnection.php");



if(isset($_GET['catid'])){
    $catid = $_GET['catid'];
    $deleteEventQuery = mysqli_query($conn, "DELETE FROM `categoriesTable` WHERE `categorid` =".$catid);
    if(!$deleteEventQuery){
        mysqli_error($conn);

    }





}


?>



