
<?php session_start();
// php code which updates the events with the passed event values
require_once("getConnection.php");



if(isset($_GET['Eventid'])) {
    $eventid = $_GET['Eventid'];
}

if(isset($_GET['Name'])) {
    $name = $_GET['Name'];
}
if(isset($_GET['location'])) {
    $location = $_GET['location'];
}

if(isset($_GET['description'])) {
    $description = $_GET['description'];
}

if(isset($_GET['endDate'])) {

    $actualEndDate = $_GET['endDate'];

//    $endDate = strtotime($_GET["endDate"]);
//    $actualEndDate = date('Y-d-m', $endDate);
//    echo $actualEndDate;
}

if(isset($_GET['category'])) {
    $cat = $_GET['category'];
    $getCatidQuery= mysqli_query($conn, "SELECT `categorid` FROM `categoriesTable` WHERE `category` = '$cat' ");
    if(!$getCatidQuery){
        echo mysqli_error($conn);

    }
        $result = mysqli_fetch_array($getCatidQuery, MYSQLI_ASSOC);
        $catid = $result['categorid'];


}

$updateQuery = mysqli_query($conn, "UPDATE `eventsTable` SET `Name` ='$name', `Description` ='$description', `Location` = '$location', `category` = '$cat', `EndDate` ='$actualEndDate', `categorid` = '$catid' WHERE `eventid`= '$eventid'" );
//echo $updateQuery;
if(!$updateQuery){
   echo mysqli_error($conn);

}else{
    echo "success";
}
?>

