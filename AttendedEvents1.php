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
    $active = $_SESSION['active'];
    $firstName = $_SESSION['First_Name'];
    $lastName = $_SESSION['Last_name'];
    $logg = "Logged in as " . $email;
    // Query to take the Event information
    $eventsquery = ("SELECT * FROM Careerevents JOIN Tickets ON Careerevents.Event_ID=Tickets.Event_ID JOIN Potential_Employee ON Tickets.User_ID=Potential_Employee.User_ID WHERE Email = '$email' AND Start_Date < NOW();");
    $result = mysqli_query($connection, $eventsquery);
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
        // Storing the events as an array for output later
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Attended Events</title>
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
                    <h3> Welcome <?php echo $firstName ?>!</h3>
                    <h1> Your Attended Events </h1>
                    <div id="lineup"> 
                        <p> <?php
// This is the accessed Event Array
foreach ($events as $event) {

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
    echo "Description: " . $event['Event_Description'];
    echo "<br>";
    echo "Category: " . $event['Category'];
    echo "<br></br>";
    echo "<button><a href='ViewReview1.php?EID=" . $event['Event_ID'] . "'> View Reviews </a></button>";
    echo "</div>";
}
?>
                        </p>
                    </div>
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



        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    </body>
</html>