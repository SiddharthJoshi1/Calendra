
<?php
//starting the session and connection to database
session_start();
require_once("getConnection.php");
?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
<link rel="stylesheet" type="text/css" href="css/Calendra.css">
<link href="https://fonts.googleapis.com/css?family=Average&display=swap" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/Calendra.js"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
      integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

<head>
    <meta charset="UTF-8">
    <title>Calendra</title>

</head>


<body class="m-auto p-3 gradient">
<header>

    <nav class="navbar navbar-expand-md navbar-light">
        <a href="index.php"> <img class="navbar-brand" src="Images/schedule-icon-35778.png" width="120" height="120">  </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">

            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="SignUpScreen.php">Sign Up</a>
                </li>

            </ul>
        </div>
    </nav>
    <br>


</header>

<section class="bodyStyle">

    <div class="row">
        <h1 class="m-auto welcomeHeader">Welcome to Calendra!</h1>
    </div>

    <br>
    <br>

    <div class="row">
        <h3 class="m-auto p-3">The calendar that aims to provide you with an aesthetically pleasing solution to day
            management!</h3>
    </div>

    <br>
    <br>
    <br>
    <br>
<!-- creating the input php check based on POST-->
    <?php

    // define variables and set to empty values
    $UnameErr = $pwrdErr = "";
    $Uname = $pwrd = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {



        if (empty($_POST["Username"])) {
            $UnameErr = "Username is required";
        } else {
            $Uname = test_input($_POST["Username"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $Uname)) {
                $UnameErr = "Only letters and white space allowed";
            }
        }

        if (empty($_POST["Password"])) {
            $pwrdErr = "Password is required";
        } else {
            $pwrd = test_input($_POST["Password"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $pwrd)) {
                $pwrdErr = "Only letters and white space allowed";
            }
        }
    }
// function to check the input
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

// if the fields are filled then execute the two queries below
    if($Uname != "" && $pwrd != ""){

        //SQL is used to get the values from the user table
        //SQL2 is used to get the username and userid to be passed to the session
        $sql = "SELECT * FROM `usersTable` WHERE `Username` = '$Uname' AND `Password` = '$pwrd' ";
        $sql2 = "SELECT Username, userid FROM `usersTable` WHERE Username = '$Uname' AND Password = '$pwrd'";

        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        //checking if the result is more than 0 hence there is a value and the user is logged in

        if ($count > 0) {
            // output data of each row
                echo $count;
                $_SESSION['username'] = $row2['Username'];
                $_SESSION['userid'] = $row2['userid'];

                header('Location: Landing.php');

        } else {
            echo "<div class=' row '>
<br>
<p class='m-auto success'> No such combination of username and password </p>

<br> <br>
</div>" ;
        }

    }



    mysqli_close($conn);


    ?>

<!-- form to login -->
    <div class="row">


        <form method="post"  action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="m-auto"  id="registerForm">

            <div class="loginFieldHidden" id="loginField">
            <h4>Username:</h4>
            <input type="text" name="Username" value="<?php echo $Uname;?>">
            <span class="error">* <?php echo $UnameErr;?></span>
            <br><br>

            <h4>Password:</h4>
            <input type="password" name="Password" value="<?php echo $pwrd;?>">
            <span class="error">* <?php echo $pwrdErr;?></span>
            <br><br>
            </div>

            <button type="button" class="btn btn-info ml-auto" id="loginButton">Login <i class="fas fa-sign-in-alt" style="color: #ffffff"></i></button>


        </form>


    </div>




</section>


</body>
</html>