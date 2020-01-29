
<?php session_start();
//php code to add categories based on the values passed by the categories modal
require_once("getConnection.php");

    if (isset($_GET["CatName"])) {

        $categoryAdd = $_GET["CatName"];
        }

        if(isset($_GET["ColorName"])){
            $colorAdd = $_GET["ColorName"];
        }



            $categoryAddQuery = mysqli_query($conn, "INSERT INTO `categoriesTable` (`categorid`, `category`, `color` , `userid`)VALUES (NULL, '$categoryAdd', '$colorAdd',  " .$_SESSION['userid'].")" );

            if (!$categoryAddQuery) {
                echo mysqli_error($conn);
            }









?>