
<?php session_start();
//php code to add the event to the database
require_once("getConnection.php");


    if (isset($_GET["EventName"])) {

        $eventName = $_GET["EventName"];


    }

    if (isset($_GET["Location"])) {

        $location = $_GET["Location"];
        // check if name only contains letters and whitespace

    }

    if (isset($_GET["categories"])) {

        $category = $_GET["categories"];


        $GetCategoryidQuery = mysqli_query($conn, "SELECT * FROM `categoriesTable` WHERE  `category` = '$category'" );

        if(!$GetCategoryidQuery){
            mysqli_error($conn);

        }else {

            $results = array();
            while($row = mysqli_fetch_array($GetCategoryidQuery, MYSQLI_ASSOC)){


             $categoryid = $row['categorid'];
            }


        }

    }

    if (isset($_GET["endDate"])) {

        $endDate = $_GET["endDate"];
        // check if name only contains letters and whitespace

    }

    if (isset($_GET["startDate"])) {

        $actualStartDate = $_GET["startDate"];


    }

    if(isset($_GET["description"])){
        $description = $_GET["description"];
    }





    if($eventName != "" && $location != "" && $category != "" && $endDate != "") {
        echo $actualStartDate;
        echo $_GET['startDate'];

        $eventAddQuery = mysqli_query($conn, "INSERT INTO `eventsTable` (`eventid`, `userid`, `StartDate`, `EndDate`, `Name`, `Description`, `Location`, `category`, `categorid`) VALUES (NULL," . $_SESSION['userid'] . ", '$actualStartDate', '$endDate', '$eventName', '$description', '$location', '$category', '$categoryid')");
        if (!$eventAddQuery) {
            echo mysqli_error($conn);
//
        }
    }

    ?>







