
<?php
//php code to get the categories from the database
session_start();
require_once("getConnection.php");


$categoryGetQuery = mysqli_query($conn, "SELECT * FROM `categoriesTable` WHERE userid = " . $_SESSION['userid']);

if(!$categoryGetQuery){
    mysqli_error($conn);
}else {
    $results = array();
    while ($row = $categoryGetQuery->fetch_assoc()) {
        $results[] = $row;


    }
    $json = json_encode($results);
    echo $json;
}

?>
