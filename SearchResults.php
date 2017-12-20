<?php
session_start();
//error_reporting(E_ALL); ini_set('display_errors', 'On');
include 'dbconnect.php';

//print_r($_SESSION);


if ($_SESSION['logged_in'] != true) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("Location:LoginPage.php");
} else {
    $email = $_SESSION['Email'];
    //$active = $_SESSION['active'];
    $firstName = $_SESSION['First_Name'];
    $lastName = $_SESSION['Last_name'];
    $logg = "Logged in as " . $email;

    if (isset($_POST['submit1'])) {
        //   echo "hello";
        // note: To prevent SQL injection hacking mysql real escape string is used.

        $eventname1 = $_POST["eventname1"];
        $Noresult = "";



        //Bunch of errors
        //if (empty($emailerror) && empty($firsterror) && empty($lastnameerror) && empty($passworderror) && empty($passwordmatcherror) && empty($titleerror) && empty($checkboxerror)) {
        //echo "hello";
        //SELECT * FROM Careerevents WHERE Start_Date > '2017-10-15' AND Start_Date < '2017-11-15' AND Event_Name = 'Petro' AND Start > '08:00:00' AND Start < '10:00:00'
        //$insertQuery= "SELECT * FROM Careerevents ";
        //$result2 = mysqli_query($connection, $insertQuery);
        // should be ORDERED
        $searchQuery2 = "SELECT * FROM Careerevents WHERE Event_Name LIKE '%$eventname1%' AND Start_Date > NOW()";
        $result3 = mysqli_query($connection, $searchQuery2);
        while ($row = mysqli_fetch_assoc($result3)) {
            $events[] = $row;
        }
        if (mysqli_num_rows($result3) == 0) {
            $Noresult = "Sorry, there are no results matching that name and/or that Time period";
        }
    } elseif (isset($_POST['submit2'])) {
        $strtdate = $_POST["strtdate"];
        $strtdate2 = $_POST["strtdate2"];
        $starttime = $_POST["starttime"];
        $starttime2 = $_POST["starttime2"];
        $Noresult = "";
        $searchQuery2 = "SELECT * FROM Careerevents WHERE Start_Date > '$strtdate' AND Start_Date < '$strtdate2' AND  Start > '$starttime' AND Start < '$starttime2' AND Start_Date > NOW()";
        $result3 = mysqli_query($connection, $searchQuery2);
        while ($row = mysqli_fetch_assoc($result3)) {
            $events[] = $row;
        }
        if (mysqli_num_rows($result3) == 0) {
            $Noresult = "Sorry, there are no results matching that name.";
        }
    } elseif (isset($_POST['submit3'])) {
        if (empty($_POST['categ'])) {
            $category = $_POST['othercat'];
            $searchQuery2 = "SELECT * FROM Careerevents WHERE Category LIKE '%$category%' AND Start_Date > NOW()";
            $result3 = mysqli_query($connection, $searchQuery2);
            while ($row = mysqli_fetch_assoc($result3)) {
                $events[] = $row;
            }
        } elseif (empty($_POST['othercat'])) {

            foreach ($_POST['categ'] as $category) {
                $Noresult = "";

                $searchQuery2 = "SELECT * FROM Careerevents WHERE Category = '$category' AND Start_Date > NOW() ";
                $result3 = mysqli_query($connection, $searchQuery2);
                while ($row = mysqli_fetch_assoc($result3)) {
                    $events[] = $row;
                }
                if (mysqli_num_rows($result3) == 0) {
                    $Noresult = "Sorry, there are no results matching " . $category;
                }
            }
        } else {
            $error = "Only Selected fields or Other field can be filled in, not both";
            $mainerror = "There was an error in your category search Please open the category tab to see why.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Search Results</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"
              >    
        <!-- Below is the Bootstrap style sheet link -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
        <!-- CSS for the Dashboard Template -->
        <link rel="stylesheet" href="CSS/DashboardTemplate.css"> 
        <style>

            #lineup {
                border: solid 1px;
                margin: 10px;
                padding: 10px;
            }
            #eventoutput{
                border: solid 1px;
                margin: 10px;
                padding: 10px;
                background-color: rgba(200,200,200,0.6);

            }
            .errors{
                color: red;
            }
            .adform input, select{
                margin:10px;
            }
            #companyname{
                text-decoration: underline;
            }
        </style>
    </head>

    <body>   
        <!-- Top navigation bar bar (adapted from bootstrap) -->    
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <img id="logo" src="logo.png">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="EmployeeDashboard.php">My Dashboard<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="AttendedEvents1.php">Attended Events</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            My Account
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="logout.php">Log out</a>
                            <a class="dropdown-item" href="EditAccount.php">Edit account</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <p class="nav-link" id="logindisp"> <?php echo $logg ?>  
                    </li>

                </ul>

            </div>
        </nav>


        <!-- Header for Title Page -->

        <div class="card">
            <div class="card-header">
                <h2> My Dashboard  </h2>   <!-- Title of page goes here -->
            </div>
        </div>



        <div class="container-fluid">
            <div class="row">

                <!-- Main Information part of the page WHERE MOST PAGE CONTENT WILL GO -->
                <div class="col-lg-9">   
                    <p class='errors'> <?php echo $mainerror ?> </p>
                    <form action="SearchResults.php" method="POST" class="form-inline my-2 my-lg-0">
                        <input name='eventname1'class="form-control mr-sm-2" type="search" placeholder="Search Events" aria-label="Search" required>
                        <button class="btn btn-outline-success my-2 my-sm-0" name='submit1' type="submit1">Search</button>
                    </form>
                    <br>       
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">Time based search</a>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">See Events by Category</button>

                    </p>
                    <div class="row">
                        <div class="col">
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card card-body">
                                    <h2> Time Search of Event and Time</h2>
                                    <p>*Please Note that all fields below with an Asterix has to be entered in order to conduct an advanced search.</p>
                                    <div class="bootstrap-iso">
                                        <form action="SearchResults.php" method="POST" class='adform'>

                                            <!--<div class="form-group row">
                                            
                                            <label for="event_name" class="col-sm-2 col-form-label">Event Name</label>
                                            <!--<div class="col-sm-10">
                                            <input type="text" name='eventname'  id="event_name" placeholder="Event Name">
                                            <!--</div>
                                            
                                            </div>-->
                                            <P> Events between Dates: </p> 
                                            <div class="form-group row"> 
                                                <!--<label for="strtdate" class="col-sm-2 col-form-label">Between Start Date </label>-->
                                                <input type="text" name="strtdate" placeholder="YYYY-MM-DD" required>
                                                <p>*</p>
                                            </div>
                                            <p> and </p>
                                            <div class="form-group row">
                                                <!--<label for="strtdate2" class="col-sm-2 col-form-label">Start Date</label>-->
                                                <input type="text" name="strtdate2" placeholder="YYYY-MM-DD"required>
                                                <p>*</p>
                                            </div>
                                            <p> Events start times Between:</p>
                                            <div class="form-group row">
                                                <!--<label for="starttime" class="col-sm-2 col-form-label">Start Time</label>-->
                                                <select class="custom-select" name='starttime'>
                                                    <option value="07:59:00">08:00:00</option>
                                                    <option value="09:00:00">09:00:00</option>
                                                    <option value="10:00:00">10:00:00</option>
                                                    <option value="11:00:00">11:00:00</option>
                                                    <option value="12:00:00">12:00:00</option>
                                                    <option value="13:00:00">13:00:00</option>
                                                    <option value="14:00:00">14:00:00</option>
                                                    <option value="15:00:00">15:00:00</option>
                                                    <option value="16:00:00">16:00:00</option>
                                                    <option value="17:00:00">17:00:00</option>
                                                    <option value="18:00:00">18:00:00</option>
                                                    <option value="19:00:00">19:00:00</option>
                                                </select>
                                                <p>*</p>
                                            </div>

                                            <p> And</p>
                                            <div class="form-group row">

                                                <!--<label for="starttime" class="col-sm-2 col-form-label">Start Time</label>-->
                                                <select class="custom-select" name='starttime2'>
                                                <!--<selected value="<?php echo $starttime ?>"><?php echo $starttime ?></selected>-->
                                                    <option value="07:59:00">08:00:00</option>
                                                    <option value="09:00:00">09:00:00</option>
                                                    <option value="10:00:00">10:00:00</option>
                                                    <option value="11:00:00">11:00:00</option>
                                                    <option value="12:00:00">12:00:00</option>
                                                    <option value="13:00:00">13:00:00</option>
                                                    <option value="14:00:00">14:00:00</option>
                                                    <option value="15:00:00">15:00:00</option>
                                                    <option value="16:00:00">16:00:00</option>
                                                    <option value="17:00:00">17:00:00</option>
                                                    <option value="18:00:00">18:00:00</option>
                                                    <option value="19:00:00">19:00:00</option>
                                                </select>
                                                <p>*</p>
                                            </div>

                                            <!--<label for="category" >Category</label><br>
                                            <div class="form-group row">
                                                
                                            <!--<div class="col-sm-10">
                                            <input type="text" name='categoryadvanced'  id="category" placeholder="Category">
                                            <!--</div>
                                            </div>-->

                                            <button type="submit" class="btn btn-primary" id="submitevent" name="submit2">Search</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="collapse multi-collapse" id="multiCollapseExample2">
                                <div class="card card-body">
                                    <h2> Category Search</h2>
                                    <p> The categories are in the list below. To select multiple categories hold control (Windows) or Command (Mac) to select the multiple categories. </p>
                                    <p> Note: Do not select Categories and Input in the search bar as the search bar is a search for categories outside our default.</p>
                                    <p class = 'errors'> <?php echo $error; ?>
                                    <form action='SearchResults.php' method="POST">
                                        <p> Categories: </p>       
                                        <!--<label for="categ[]" class="col-sm-2 col-form-label">Categories</label>-->
                                        <select class="custom-select" name='categ[]' Multiple>
                                            <option value="Chemical Engineering">Chemical Engineering</option>
                                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                                            <option value="Electrical Engineering">Electrical Engineering</option>
                                            <option value="Environmental Engineering">Environmental Engineering</option>
                                            <option value="Computer Science">Computer Science</option>
                                            <option value="Civil Engineering">Civil Engineering</option>
                                            <option value="No Category">No Category</option>
                                        </select>
                                        <br>
                                        <p>OR</p>
                                        <br>
                                        <p> Cant find what you're looking for? Maybe the host's Category is not in our default list, please enter into the field below to search our events for your category.</p>
                                        <div class="form-group row">
                                            <label for="othercat" class="col-sm-2 col-form-label">Other</label>
                                            <!--<div class="col-sm-10">-->
                                            <input type="text" name='othercat'  placeholder="Enter your category">
                                            <!--</div>-->
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="submitevent" name="submit3" >Search</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1> Search Results</h1>
                    <p> Please Note, only results with a start date greater than now will be displayed. Past events will no longer be displayed.</p>
                    <p>

<?php
echo $Noresult;
foreach ($events as $event) {
    $eventid = $event['Event_ID'];
    $eventname = $event['Event_Name'];
    echo "<div id='eventoutput'>";
    echo "<h3 style='color:red;'>Event Name: " . $event['Event_Name'] . "</h3>";
    //echo "Name: ".$event['Event_Name'];
    //echo "<br>";
    echo "Start Date: " . $event['Start_Date'];
    echo "<br>";
    echo "End Date: " . $event['End_date'];
    echo "<br>";
    echo "Start Time: " . $event['Start'];
    echo "<br>";
    echo "End Time:" . $event['End'];
    echo "<br>";
    echo "Last available purchase day and time: ".$event['Last_available_purchase_day_n_time'];
    echo "<br>";
    echo "Description: " . $event['Event_Description'];
    echo "<br>";
    echo "Category: " . $event['Category'];
    echo "<br>";
    $venuequery = "SELECT * FROM Careerevents JOIN Venue ON Careerevents.Venue_ID=Venue.Venue_ID WHERE Event_Name = '$eventname'";
    $queryvenueresult = mysqli_query($connection, $venuequery);
    $rowvenue = mysqli_fetch_assoc($queryvenueresult);

    echo "Venue: " . $rowvenue['AddressLine1'] . ", " . $rowvenue['City'] . ", " . $rowvenue['Country'] . ", " . $rowvenue['Postal_Code'];


    echo "<br></br>";
    echo "<button id = 'booktick'><a href='book_ticket.php?EID=" . $eventid . "'>Book Ticket</a></button>";


    echo "<br></br>";

    echo "<a class='btn btn-primary' data-toggle='collapse' href='#multiCollapse" . $event['Event_ID'] . "' aria-expanded='false' aria-controls='multiCollapseExample1'>Company List</a>";
    echo "<div class='collapse multi-collapse' id='multiCollapse" . $event['Event_ID'] . "'><div class='card card-body'>";
    $companylist = ("SELECT * FROM Companies JOIN Careerevents ON Companies.Event_ID=Careerevents.Event_ID WHERE Event_Name = '$eventname'");
    $result5 = mysqli_query($connection, $companylist);
    $rownumbers = mysqli_num_rows($result5);
    while ($rowcomp = mysqli_fetch_assoc($result5)) {

        $companyname = $rowcomp['Company_Name'];
        $companyrep = $rowcomp['Representative_Name'];
        $companyrepemail = $rowcomp['Representative_Email'];
        echo "<h5 id = 'companyname' >Company Name: " . $companyname . "</h5>";
        echo "<p>Representative Name: " . $companyrep . "</p>";
        echo "<p>Representative Email: " . $companyrepemail . "</p>";
        //echo "<br>";
    }

    echo "</div>";
    echo "</div>";
    echo "</div>";
}
?>
                    </p>

                </div>
                <!-- Side Bar (Stylesheet linked to bootsrap) -->
                <div class="col-lg-3">
                    <h4 class='sidetext'> Want to Book a ticket? Click Search Events below</h4>
                    <button class="btn btn-outline-success my-2 my-sm-0"><a href='SearchResults.php'>Search Events</a></button>
                    <br>
                    <h4 class='sidetext'> Dont know what to look for? Click Below to browse upcoming events </h4>
                    <button class="btn btn-outline-success my-2 my-sm-0"><a href='UpcomingEvents.php'>Upcoming Events</a></button>
                    <br></br>
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="Images/Career_Fair-1.jpg" alt="First slide">
                                <!--Image file taken from https://www.luc.edu/career/careerfairsandevents/-->
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="Images/C.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="Images/B.jpg" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>    
        <script>

            $(document).ready(function () {
                var date_input = $('input[name="strtdate"]');
                var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
                var options = {
                    format: 'yyyy/mm/dd',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                };
                date_input.datepicker(options);
            })
            $(document).ready(function () {
                var date_input = $('input[name="strtdate2"]');
                var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
                var options = {
                    format: 'yyyy/mm/dd',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                };
                date_input.datepicker(options);
            })

        </script>    

    </body>
</html>

