<?php
session_start();
//error_reporting(E_ALL); ini_set('display_errors', 'On');
include 'dbconnect.php';
$EID = $_GET['EID'];
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


    $reviewquery = ("SELECT Review_ID, Description, Rating, bywhom FROM Reviews R WHERE R.Event_ID= $EID");
    $result = mysqli_query($connection, $reviewquery);
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;

        $eventname = $reviewquery = ("SELECT * FROM Careerevents WHERE Event_ID = '$EID'");
        $result1 = mysqli_query($connection, $reviewquery);
        $row1 = mysqli_fetch_assoc($result1);
        $eventname = $row1['Event_Name'];
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>View Review</title>
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
                    <h1> View Reviews for <?php echo $eventname ?> </h1> <?php echo "<button><a href='AddReview1.php?EID=" . $EID . "'>Add your own Review for this Event</a></button>"; ?>

                    <div id="lineup">  
<?php
foreach ($reviews as $review) {

    echo "<div id='eventoutput'>";

    echo "Review ID " . $review['Review_ID'];
    echo "<br>";
    echo "Rating: " . $review['Rating'];
    echo "<br>";
    echo "Review:";
    echo "<div id='eventoutput'>";
    echo $review['Description'];
    echo "</div>";
    echo "<br>";
    echo "By: " . $review['bywhom'];
    echo "<br></br>";
    echo "</div>";
}
?>
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