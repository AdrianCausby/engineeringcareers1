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


    //print_r($_SESSION);
    // This defines errors as empty, if it is filled then an error will result. 
    $ratingerror = $reviewerror = '';

    if (isset($_POST['submit'])) {

        $rating = $_POST["rating"];
        $review = $_POST["review"];



        if (empty($rating)) {
            $ratingerror = "You haven't rated the event";
        } elseif (empty($ratingerror) && empty($reviewerror)) {


            // Inserting into the database query
            $insertQuery = "INSERT INTO Reviews(Rating, Description, Event_ID, bywhom) VALUES ('$rating', '$review', '$EID', '$firstName') ";


            mysqli_query($connection, $insertQuery);

            //Redirect to the view review for that event page
            echo "<script>document.location='ViewReview1.php?EID=" . $EID . "';</script>";

            //$row = mysqli_fetch_assoc($result2);
            //$reviewid = $row['Review_ID'];

            /* if (!empty($rating) && !empty($review)) {
              $insertreviewquery = "INSERT INTO Reviews(Rating, Description) VALUES ('$rating', '$review') ";
              $resultcomp = mysqli_query($connection, $insertreviewquery);
              } */
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Add Your Review</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"
              >    
        <!-- Below is the Bootstrap style sheet link -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
        <!-- CSS for the Dashboard Template -->
        <link rel="stylesheet" href="CSS/DashboardTemplate.css"> 

        <!-- Below is the style specifically for this page-->
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
        <!-- Top navigation bar (Adapted from a bootstrap framework) -->    
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
        <!-- End of Nav Bar-->

        <!-- Header for Title Page [Header adapted from Bootstrap-->

        <div class="card">
            <div class="card-header">
                <h2> My Dashboard  </h2>   <!-- Title of page IE my DASHBOARD -->
            </div>
        </div>
        <!-- Main Information part of the page WHERE MOST PAGE CONTENT WILL GO, Container Classes adapted from Bootstrap Framework -->
        <div class="container-fluid">
            <div class="row">   
                <div class="col-lg-9">   

                    <h3> Welcome <?php echo $firstName ?>!</h3>
                    <h1> Add your own review for this event.</h1>
                    <div id="lineup">        

                        <div>Your Review</div> <!--Your review Form-->
                        <form action="" method="post" accept-charset="utf-8">
                            <fieldset><legend>Review </legend>	
                                <p>
                                    <label for="rating">Rating</label>
                                    <input type="radio" name="rating" value="5" /> 5 
                                    <input type="radio" name="rating" value="4" /> 4
                                    <input type="radio" name="rating" value="3" /> 3 
                                    <input type="radio"name="rating" value="2" /> 2 
                                    <input type="radio" name="rating" value="1" /> 1
                                </p>
                                <p><label for="review"></label><textarea name="review" rows="8" cols="40">
       </textarea></p>
    <p><input type="submit"name="submit" value="Submit Review"></p>
    
</fieldset>
</form>
        </div>
    </div>
      
      
      <!-- Side Bar (Stylesheet Adapted from Bootstrap) -->
    <div class="col-lg-3">
        <!--Links in side bar-->
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