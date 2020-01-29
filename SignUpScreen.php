
<?php

require_once("getConnection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendra</title>

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

</head>
<body class="m-auto p-3 gradient" background="Images/Scooter.jpg">

<header>

    <nav class="navbar navbar-expand-md navbar-light">
        <a href="index.php"> <img class="navbar-brand" src="Images/schedule-icon-35778.png" width="120" height="120">  </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">

        </div>
    </nav>
    <br>


</header>

<section class="bodyStyle">

<div class="row">
    <h1 class="m-auto welcomeHeader">Sign Up for Calendra!</h1>
</div>

<br>
<br>

    <?php

// define variables and set to empty values
$FnameErr = $LnameErr = $UnameErr = $pwrdErr = "";
$Fname = $Lname = $Uname = $pwrd = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["FirstName"])) {
        $FnameErr = "First Name is required";
    } else {
        $Fname = test_input($_POST["FirstName"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $Fname)) {
            $FnameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["LastName"])) {
        $LnameErr = "Last Name is required";
    } else {
        $Lname = test_input($_POST["LastName"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $Lname)) {
            $LnameErr = "Only letters and white space allowed";
        }
    }


    if (empty($_POST["Username"])) {
        $UnameErr = "Username is required";
    } else {
        $Uname = test_input($_POST["Username"]);


    }

    if (empty($_POST["Password"])) {
        $pwrdErr = "Password is required";
    } else {
        $pwrd = test_input($_POST["Password"]);


    }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



if($Uname != "" && $Fname != "" && $Lname != "" && $pwrd != ""){
    $sql = "INSERT INTO `usersTable` (`userid`, `Username`, `FirstName`, `LastName`, `Password`) VALUES (NULL, '$Uname', '$Fname', '$Lname', '$pwrd') ";



    if (mysqli_query($conn, $sql)) {
        echo "<div class=' row '>
<br>
<p class='m-auto success'>Successfully created a record </p>

<br> <br>
</div>";
        $Uname = "";
        $Lname = "";
        $Fname = "";
        $pwrd = "";


    } else {

    ?>
    <div class=' row '>
        <br>
        <p class="m-auto error"><?php echo mysqli_error($conn) ?></p>


        <br> <br>
    </div>
    <?php
        $Uname = "";
        $Lname = "";
        $Fname = "";
        $pwrd = "";

        echo "<script>  </script>";

    }

}
    mysqli_close($conn);


?>


<div class="row">


    <form method="post"  action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="m-auto"  id="registerForm">

       <h4> First Name: </h4>
        <input type="text" name="FirstName" value="<?php echo $Fname;?>">
        <span class="error">* <?php echo $FnameErr;?></span>
        <br><br>

       <h4>Last Name:</h4>
        <input type="text" name="LastName" value="<?php echo $Lname;?>">
        <span class="error">* <?php echo $LnameErr;?></span>
        <br><br>

        <h4>Username:</h4>
            <input type="text" name="Username" value="<?php echo $Uname;?>">
        <span class="error">* <?php echo $UnameErr;?></span>
        <br><br>

        <h4>Password:</h4>
        <input type="password" name="Password" value="<?php echo $pwrd;?>">
        <span class="error">* <?php echo $pwrdErr;?></span>
        <br><br>


        <button type="submit" class="btn btn-info ml-auto" id="RegisterButton">Register <i class="fas fa-sign-in-alt" style="color: #ffffff"></i></button>


    </form>


</div>
</section>

</body>
</html>