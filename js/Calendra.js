//setting no cache on ajax;

//DISCLAIMER: I HAVE MADE ALL DATABASE CRUD OPERATIONS USING AJAX/XML HTTP REQUESTS DUE TO THE NATURE OF MY PROJECT AND ARE IN THEIR OWN .PHP FILES


$.ajaxSetup ({cache: false});
// Assigning variables for the functions that get the next and previous months
let nextMonth = new Date().getMonth();
let nextYear = new Date().getFullYear();


//Creating an array for months

var months = new Array();
months[0] = "January";
months[1] = "February";
months[2] = "March";
months[3] = "April";
months[4] = "May";
months[5] = "June";
months[6] = "July";
months[7] = "August";
months[8] = "September";
months[9] = "October";
months[10] = "November";
months[11] = "December";

//using an http request to get all the categories in the categories table and add them to the updateEventCategory element
function addUpdateCategories() {
    var httpCat = new XMLHttpRequest();
    var myObjCat;
    httpCat.open("GET", "getCategories.php", true);
    httpCat.onreadystatechange = function () {
        if (httpCat.readyState == 4 && httpCat.status == 200) {
            myObjCat = JSON.parse(this.responseText);
            for (var j = 0; j < myObjCat.length; j++) {

                var tempCat = myObjCat[j];

                console.log(tempCat);
                $("#UpdateEventCat").append($("<option />").val("").text(tempCat.category));
            }

        }

    }
    httpCat.send();
}

addUpdateCategories();


//function used to get the current full date
function todayDate() {
    var today = new Date();
    var d = today.getDate();
    var m = today.getMonth()+1;
    var y = today.getFullYear();


    if(d<10) {
        //checking if the day is 0
        d='0'+d
    }
    if(m<10) {
        //checking if the month is 0
        m='0'+m
    }
    return y+'-'+m+'-'+d;
}

//Function that renders the calendar 
function renderCalendar(year, month) {
    //gets the first day of the month
    let startOfMonth = new Date(year, month).getDay()
    //getting the number of days in the month
    let numOfDays = 32 - new Date(year, month, 32).getDate()


    //used to get the number values for the days which will be fed into the table elements

    let renderNum = 1

    //getting the calendar body
    let tableBody = document.getElementById('calendar_body')
    //getting the title at the top of the calendar
    let renderMonthAndYear = document.getElementById('monthAndYear')

    //setting the text value of the title to the current month and year
    renderMonthAndYear.textContent =  months[`${month}`] + " " + year

    //looping through the table to create six rows dynamically to make the calendar
    for( i=0; i<6; i++){
        let row = document.createElement('tr')
        for (j=0; j<7; j++){
            //checking if i is 0 or if the start of the month is less than j thus the inside of the td element would be empty
            if(i ===0 && j<startOfMonth){
                //creating the element inside the table
                let td = document.createElement('td')
                td.style.height = "120px";
                //appending the td to the rows
                row.append(td)


            }else if(renderNum > numOfDays){
                //breaking if the number of times the rows were rendered is over the number of days
                break
            }else {
                //else create a td element with a day value inside it
                let td = document.createElement('td')
                td.style.height = "120px";
                td.textContent = renderNum
                td.id = "td"

                let datevar = year  + "-" +  (month+ Number(1)) + "-" + td.textContent ;
                let datevar2 = year + "-" + (month+ Number(1)) + "-" + td.textContent;
                let date = Date.parse(datevar2);

                    //adding a clickble event to the td that will be added to the table
                    //clickable would bring up a modal to add events on that day 
                    td.addEventListener("click", function(e){
                        var target = e.target
                        if(target.id == "td"){
                        $(document).ready(function () {

                            $("#addModal").modal();
                            document.getElementById("startDate").setAttribute('value', datevar);

                            $(document).ready(function(){
                                //adding date var to the addModal modal
                                $('#endDate').attr('min', datevar);
                            });

                        });
                        }
                    });

                //adding the events that were previously added to the database as badge buttons that can be clicked on to be edited using an xmlhttp request
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var myObj = JSON.parse(this.responseText);
                        for(var i =0; i< myObj.length; i++){
                            var temp = myObj[i];

                            if(date.toString() >= Date.parse(temp.StartDate).toString() && date.toString() <= Date.parse(temp.EndDate)){
                                //event buttons
                                td.insertAdjacentHTML("beforeend", " <br>" +
                                    "<button type=button   style='background-color: "+ temp.color +";  font-size: 1vw;' class =' wrapword btn badge badge-primary' id='viewPillButton' onclick='{showModal(" + temp.eventid + ")}'>" + temp.Name +  " </button>");

                            }


                        }


                    }
                };
                xmlhttp.open("GET", "addPills.php", true, );
                xmlhttp.send();





                //current day 
                if((td.textContent === new Date(Date.now()).getDate().toString()) && (month == new Date(Date.now()).getMonth()) && (year === new Date(Date.now()).getFullYear()) ){

                    td.style.backgroundColor = 'lightblue'
                }
                //appending the td
                row.append(td);

                //increasing render number
                renderNum++
            }
        }
        //appending the row
    tableBody.append(row)

    }

}
//next month function
function next() {
    let tableBody = document.getElementById('calendar_body')
    //reseting the tableBody
    tableBody.innerHTML = ""


//check if the month is at 11 then the year is incremented 
        if(nextMonth == 11){
            ++nextYear
            nextMonth = Number(0)
            renderCalendar(nextYear , nextMonth)
        }else {
            renderCalendar(nextYear , nextMonth + 1)
            ++nextMonth
        }


}
//previous month function 
function  previous() {
    let tableBody = document.getElementById('calendar_body')
    tableBody.innerHTML = ""

    //check if the month is at 0 then the year is decremented

    if(nextMonth == 0){
        --nextYear
        nextMonth = 11
        renderCalendar(nextYear , nextMonth)
    }else{
        renderCalendar(nextYear , nextMonth - 1)
        --nextMonth
    }
}

//checking if the login is clicked and then shows the username and password field
var LoginClicks = 0;
$(document).ready(function(){
    $("#loginButton").click(function(){
      $("#loginField").removeClass("loginFieldHidden");

        LoginClicks++;
        if(LoginClicks > 1){

            $('#loginButton').removeAttr("type").attr("type", "submit");

        }
    });
});


//function which shows the modal with the information for the event and the option to delete the event or update it 

function showModal(eventid) {




//showing the modal
    $("#viewModal").modal("show");
    //using an xmlhttp request to get the data from the database for the event with the event id that was passed into the function
    var http = new XMLHttpRequest();

    http.open("GET", "EventModal.php?event_id="+eventid+"&"+new Date().getTime(), true);
    http.onreadystatechange = function() {
        if (http.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            for (let i = 0; i < myObj.length; i++) {
                let temp = myObj[i];
                //filling the respective elements with the values of the event stored in the database
                $(document).ready(function () {


                    $("#viewEventModalHeader").text(temp.Name);
                    $("#viewEventCategory").text("Category: " + temp.category);
                    $("#viewEventLocation").text("Location: " + temp.Location);
                    $("#viewEventDescription").text("Description: " + temp.Description);
                    $("#viewEventStartDate").text("Start Date: " + temp.StartDate.toString().split(' ')[0]);
                    $("#viewEventEndDate").text("End Date: " + temp.EndDate.toString().split(' ')[0]);



                //on click event for the the updateEventButton in order to update the chosen event
                // this shows the update modal
                $("#updateEventButton").click(function () {
                    $("#UpdateEventEndDate").attr('min', temp.StartDate.toString().split(' ')[0]);
                    $("#UpdateEventName").val(temp.Name)
                    $("#UpdateEventLocation").val(temp.Location)
                    $("#UpdateEventDescription").val(temp.Description)
                    document.getElementById("UpdateEventEndDate").valueAsDate = new Date(Date.parse(temp.EndDate))




                });


                    //submit update button, sends the data to the database 

                    $("#SubmitUpdateEventButton").click(function () {
                       var httpUp = new XMLHttpRequest();
                        var name = $("#UpdateEventName").val();
                        var location = $("#UpdateEventLocation").val();
                        var description = $("#UpdateEventDescription").val();
                        var endDate = $("#UpdateEventEndDate").val();
                        var category = $("#UpdateEventCat option:selected").text();

                        console.log(name, location, description, endDate, category);
                        httpUp.open("GET", "updateEvent.php?Eventid=" + eventid + "&Name=" + name + "&location=" + location + "&description=" + description + "&endDate=" + endDate + "&category=" + category, true);
                        httpUp.onreadystatechange = function () {
                            if (httpUp.readyState == 4 && httpUp.status == 200) {
                                alert("success");
                                addUpdateCategories();
                                window.location.reload();
                            }
                        }
                        httpUp.send();




                    });




                });


            }


        }

    }

//delete event button deletes the button 

        $(document).ready(function () {



            $("#deleteEventButton").click(function () {
                var deleteHttp = new XMLHttpRequest();
                deleteHttp.open("GET", "deleteEvent.php?event_id="+eventid, true);
                deleteHttp.onreadystatechange = function (){
                    if(deleteHttp.readyState == 4 && deleteHttp.status == 200){
                        alert("success");
                       location.reload();

                    }
                }
                deleteHttp.send(null);



            });

        });

    http.send(null);




}

//add event button adds the event to the database

$(document).ready(function () {
    $("#addEventButton").click(function () {


       var eventName = $("#EventName").val();
       var category = $("#cat").val();
       var location = $("#EventLocation").val();
       var startDate = $("#startDate").val();
       var endDate = $("#endDate").val();
       var description = $("#description").val();
        if((eventName == "") || (category == "") || (location == "") || (startDate == "") || (endDate == "")){
            alert("Please fill out all the required forms");
        }else {
        var addHttp = new XMLHttpRequest();
        addHttp.onreadystatechange = function () {
            if(addHttp.readyState == 4 && addHttp.status == 200){
                alert("success");
                $("#addModal").on('hidden.bs.modal',function () {
                    $("#addEventButton").off("click");
                });
                window.location.reload();
            }
        }
        addHttp.open("GET", "addEvent.php?EventName="+eventName+"&Location="+location+"&categories="+category+"&startDate="+startDate+"&endDate="+endDate+"&description="+description);

        addHttp.send(null);
        }
    });

});

//add cat button adds categories to the database
$(document).ready(function () {
    $("#addCatButton").click(function () {



   var catName = $("#catName").val();

 var color = $("#colorPicker").val();
 //replaces the # in the color string to the correct code
color = color.replace("#", "%23");
console.log(color);

   if((catName == "")){
       alert("Please fill out all the required forms");
   }else {
       var addCatHttp = new XMLHttpRequest();
       addCatHttp.onreadystatechange = function () {
           if(addCatHttp.readyState == 4 && addCatHttp.status == 200){
               alert("success");
               console.log(color);

               window.location.reload();
           }
       }
       addCatHttp.open("GET", "addCategories.php?CatName="+catName+"&ColorName="+color.toString());
       addCatHttp.send(null);
   }

    });

});

//deletes the categories
function deleteCat(catid){

    var httpEvents = new XMLHttpRequest();

    var count = Number(0);
    httpEvents.open("GET", "getEvents.php", true);
    httpEvents.send();
    httpEvents.onreadystatechange = function () {
        if(httpEvents.readyState == 4 && httpEvents.status == 200){
            var myObjEvents = JSON.parse(this.responseText);
            for(var k = 0; k<myObjEvents.length; k++){

                if((myObjEvents[k].categorid) == catid) {
                    ++count;
                }
            }
            if(count > Number(0)){

                alert("This category is connected to one or more events. \nPlease remove them first before deleting this category.")

            }else{


                var deleteCatHttp = new XMLHttpRequest();
                deleteCatHttp.open("GET", "DeleteCat.php?catid="+catid, true);
                deleteCatHttp.onreadystatechange = function (){
                    if(deleteCatHttp.readyState == 4 && deleteCatHttp.status == 200){
                        alert("success");
                        location.reload();

                    }
                }
                deleteCatHttp.send(null);


            }
        }
    }





}

//edit category modal function which appends the edit category modal with all the categories in the database
$(document).ready(function () {
    $("#editCat").click(function () {
    $("#editCategoryModalBody").html("");

    var httpCat = new XMLHttpRequest();
    var myObjCat;
    httpCat.open("GET", "getCategories.php", true);
    httpCat.onreadystatechange = function(){
        if(httpCat.readyState == 4 && httpCat.status == 200){
            myObjCat = JSON.parse(this.responseText);
            for(var j=0; j< myObjCat.length; j++){

                var tempCat = myObjCat[j];


                    $("#editCategoryModalBody").append(



                        "<div id='viewCategories' class='row'> <div class='col-sm '> <p>"+ tempCat.category +"</p> </div> <div class='col-sm'> <button id='deleteCatButton' class='btn btn-success btn-sm' onclick='{deleteCat("+tempCat.categorid+")}'>Delete</button> </div></div>"

                    )



            }

        }


    }

    httpCat.send();

    })


});


//removing all the event handlers
$(document).ready(function () {
    $("#viewModal").on('hidden.bs.modal', function () {
        console.log("closed");
       // $("#viewPillButton").prop("onclick", null);
        $("#deleteEventButton").off("click");
        $("#updateEventButton").off("click");
        $("#SubmitUpdateEventButton").off("click");


    });


    $("#addCatModal").on('hidden.bs.modal', function () {
        $("#addCatButton").off("click");
    });

    $("#editCatModal").on('hidden.bs.modal', function () {
        $("#deleteCatButton").prop("onclick", null);

    })

});















