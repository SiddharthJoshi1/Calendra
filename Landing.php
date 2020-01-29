
<?php session_start();
//stating the session and getting the connection
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


<body class=" m-auto p-3 gradient">

<header>

<!-- navbar to hold the calendar icon and the user icon dropdown -->
    <nav class="navbar navbar-expand-md navbar-light">
        <a href="Landing.php"> <figure><img class="navbar-brand" src="Images/schedule-icon-35778.png" alt="Home" width="120" height="120">
                <figcaption class="pl-4"> Home</figcaption>
            </figure>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">

            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <div class="container">

                        <div class="dropdown">
<!-- User drop down provides buttons to add category and edit category which connect to the js and the xmlhttprequests -->
                            <button type="button" class="btn btn-success " data-toggle="dropdown">
                                <i class="fa fa-user fa-3x"> </i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right">
                                <h5 class="dropdown-item-text"> <?php echo $_SESSION['username'] ?></h5>
                                <div class="dropdown-divider"></div>

                                <button class="btn btn-secondary dropdown-item" id="addCat" name="addCatButton"
                                        type="button" data-toggle="modal" data-target="#addCatModal"> Add Category
                                </button>

                                <button class="btn btn-secondary dropdown-item" id="editCat" name="editCatButton"
                                        type="button" data-toggle="modal" data-target="#editCatModal"> Edit Category
                                </button>

                    <!-- logout function logs the user out -->
                                <a href="index.php" class="btn btn-secondary dropdown-item" id="LogoutBtn"
                                   name="LogoutButton" type="button"> Logout </a>
                            </div>


                        </div>
                    </div>

                </li>

            </ul>
        </div>
    </nav>


<!-- add category modal -->
    <div class="modal" id="addCatModal" data-backdrop="static" role="dialog">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Category</h4>

                </div>
                <div class="modal-body">
                    <form method="post" class="m-auto" id="addItem">
                        <div>
                            <h4>Category Name:</h4>
                            <input type="text" name="CatName" id="catName" >
                            <span class="error">* </span>
                            <br><br>

                            <h4>Pick a color for this category</h4>
                            <input type="color" name="ColorName" id="colorPicker">
                            <span class="error">* </span>
                            <br><br>

                            <button type="button" class="btn btn-info ml-auto" id="addCatButton" name="addCat"
                                    value="addCat">Add
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                        </div>


                    </form>


                </div>
            </div>
        </div>


    </div>

<!-- edit category modal -->
    <div class="modal" id="editCatModal" data-backdrop="static" role="dialog">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Category</h4>

                </div>
                <div class="modal-body" id="editCategoryModalBody">





                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>


    </div>



</header>
<br>
<!-- creating the top of the calendar and the table_body element -->
<section class="card">

<!-- creating a table header with the days of the week -->
    <h3 class="card-header" id="monthAndYear"></h3>
    <table class="card-body table table-bordered table-responsive-sm" id="calendar">
        <thead>
        <tr>
            <th>Sun</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
        </tr>
        </thead>

        <tbody id="calendar_body">



        </tbody>
    </table>
<!-- buttons for next and previous -->
    <div class="form-inline card-footer p-3">

        <button class="btn btn-outline-primary col-sm-6" id="previous" onclick="previous()">Previous</button>

        <button class="btn btn-outline-primary col-sm-6" id="next" onclick="next()">Next</button>
    </div>

    <br/>


</section>
<!-- rendering the rest of the calendar  -->
<script>renderCalendar(new Date().getFullYear(), new Date().getMonth())</script>

<!-- modal to add the events -->

<div class="modal" id="addModal">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title justify-content-center">Add Item</h3>
            </div>

            <div class="modal-body">

                <form method="post" class="m-auto" id="addEvent">

                    <div>
                        <h4>Event Name:</h4>
                        <input type="text" name="EventName" id="EventName" value="">
                        <span class="error">*</span>
                        <br><br>


                        <div class="form-group">
                            <label for="cat"><h4>Select Category:</h4></label>
                            <select class="form-control" id="cat" name="categories">

                                <?php

                                $categoryGetQuery = mysqli_query($conn, "SELECT category FROM `categoriesTable` WHERE userid = " . $_SESSION['userid']);
                                while ($row = $categoryGetQuery->fetch_assoc()) {

                                    echo "<option value='"  . $row['category'] . "'> " . $row['category'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="error">* </span>
                        </div>

                        <h4>Location:</h4>
                        <input type="text" name="Location" id="EventLocation" value="">
                        <span class="error">* </span>

                        <br><br>

                        <h4>Start Date:</h4>
                        <input type="text" name="startDate" id="startDate" disabled="true" >


                        <br><br>

                        <h4>End Date:</h4>
                        <input type="date" name="endDate" id="endDate" value="">
                        <span class="error">*</span>


                        <br><br>

                        <div class="form-group">
                            <label for="description"><h4>Description: </h4></label>

                            <textarea class="form-control" rows="5" id="description" name="description"></textarea>


                        </div>

                        <br>
                    </div>


                    <button type="button" class="btn btn-info ml-auto"  id="addEventButton" name="addEvent"
                            value="addEvent">Add
                    </button>

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                </form>

            </div>


        </div>


    </div>


</div>


<!-- view modal shows data of clicked event -->
<div class="modal" id="viewModal" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title justify-content-center" id="viewEventModalHeader"></h1>

            </div>


            <div class="modal-body" id="viewEventModalBody">



                <h4 id="viewEventCategory">Category: </h4>
                <h4 id="viewEventLocation">Location: </h4>
                <h4 id="viewEventStartDate">Event Start Date: </h4>
                <h4 id="viewEventEndDate">Event End Date: </h4>
                <h4 id="viewEventDescription">Description</h4>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" id="updateEventButton" data-toggle="modal" data-target="#updateModal">Update Event</button>

                <button type="button" class="btn btn-warning" id="deleteEventButton">Delete Event</button>

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>


        </div>


    </div>


</div>

<!-- updates the event that was selected -->
<div class="modal" id="updateModal">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title justify-content-center">Add Item</h3>
            </div>

            <div class="modal-body">

                <form method="post"   class="m-auto" id="updateEvent">

                    <div>
                        <h4>Event Name:</h4>
                        <input type="text" name="EventName" id="UpdateEventName" value="">

                        <br><br>

                        <div class="form-group">
                            <label for="cat"><h4>Select Category:</h4></label>
                            <select class="form-control" id="UpdateEventCat" name="categories">
                            </select>

                        </div>

                        <h4>Location:</h4>
                        <input type="text" name="Location" id="UpdateEventLocation" value="">


                        <br><br>

                        <h4>End Date:</h4>
                        <input type="date" name="endDate" id="UpdateEventEndDate" value="">


                        <br><br>

                        <div class="form-group">
                            <label for="description"><h4>Description: </h4></label>

                            <textarea class="form-control" rows="5" id="UpdateEventDescription" name="description"> </textarea>


                        </div>

                        <br>
                    </div>


                    <button type="button" class="btn btn-info ml-auto"  id="SubmitUpdateEventButton" name="updateEvent"
                            value="addEvent">Update
                    </button>

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                </form>

            </div>


        </div>


    </div>


</div>


</body>
</html>
