
<?php
// php code to get the color and the values of the event from the database
session_start();
require_once("getConnection.php");

$initialGetCategoryQuery = mysqli_query($conn, "SELECT eventsTable.*, categoriesTable.color FROM `eventsTable`, `categoriesTable` WHERE eventsTable.categorid = categoriesTable.categorid AND eventsTable.userid =" . $_SESSION['userid'] );

if(!$initialGetCategoryQuery){
    mysqli_error($conn);

}else {

    $results = array();
    while($row = mysqli_fetch_array($initialGetCategoryQuery, MYSQLI_ASSOC)){

        $results[] = $row;
    }
    $json = json_encode($results);
    echo $json;

}