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


    if (isset($_POST['submit'])) {
        // note: To prevent SQL injection hacking mysql real escape string is used.

        $emailup = $_POST["emailup"];
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];
        $degreetype = $_POST["degtype"];
        $university = $_POST["uni"];

        // To keep consistent, instead of put the input fields as 'required' we put all errors as an asterix that will appear if not filled.
//email cannot be changed


        if (!empty($degreetype) && !empty($university)) {
            $checkEducationqueryexist = "SELECT * FROM Education WHERE University ='$university' AND Degree_Type ='$degreetype'";
            $resultedu = mysqli_query($connection, $checkEducationqueryexist);

            //If a Education with that Education exists, then the event in the events table will be updated to have the existing venue ID
            if (mysqli_num_rows($resultedu) == 1) {
                $row3 = mysqli_fetch_assoc($resultedu);
                $educationid = $row3['Education_ID'];
                $inserteduquery = "UPDATE Potential_Employee SET Education_ID = '$educationid' WHERE Email = '$email'";
                $resultedu1 = mysqli_query($connection, $inserteduquery);
            } elseif (mysqli_num_rows($resultedu) == 0) {
                $inserteduquery2 = "INSERT INTO Education(University, Degree_Type) VALUES('$university', '$degreetype')";
                $resultedu2 = mysqli_query($connection, $inserteduquery2);
                $checkeduquery3 = "SELECT * FROM Education WHERE University ='$university' AND Degree_Type ='$degreetype'";
                $resultedu3 = mysqli_query($connection, $checkeduquery3);
                $row4 = mysqli_fetch_assoc($resultedu3);
                $educationid2 = $row4['Education_ID'];
                $inserteduquery3 = "UPDATE Potential_Employee SET Education_ID = '$educationid2' WHERE Email = '$email'";
                $resultedu4 = mysqli_query($connection, $inserteduquery3);
            }
        }

        if (!empty($password1)) {
            if (strlen($password1) < 8) {
                $passworderror = "*Password Has to be greater than 8 Characters";
            }

            if ($password1 !== $password2) {
                $passwordmatcherror = "*Passwords do not match";
            }

            if (empty($passworderror) && empty($passwordmatcherror)) {
                $password1 = password_hash($password1, PASSWORD_DEFAULT); // for safety, encryption of password before being saved into the database and the data type will be text to accomodate for hashing space.
                $updatepassword = "UPDATE Potential_Employee SET Password = '$password1' WHERE Email = '$email'";
                $resultpass = mysqli_query($connection, $updatepassword);
            }
        }

        if (!empty($emailup)) {

            if (!filter_var($emailup, FILTER_VALIDATE_EMAIL)) {
                $emailerror = "*Invalid email address Entered";
            } elseif (empty($emailerror)) {
                $emailquery = ("SELECT `Email` FROM `Potential_Employee` WHERE `Email` = '$emailup'");
                $emailcheckresult = mysqli_query($connection, $emailquery);
                $row = mysqli_fetch_array($emailcheckresult);

                if (mysqli_num_rows($emailcheckresult) !== 0) {
                    $emailerror = "*Sorry, this email has already been used.";
                }
            }


            if (empty($emailerror)) {
                $insertQuery = "UPDATE Potential_Employee SET Email = '$emailup' WHERE Email='$email'";
                $result = mysqli_query($connection, $insertQuery);
            }
        }


        //If a Education with that Education exists, then the event in the events table will be updated to have the existing venue ID


        if (empty($emailerror) && empty($passworderror) && empty($passwordmatcherror)) {
            $popup = "Hi! " . $firstName . " . You have changed your account details! Please login again with your New account changes to confirm your changes";
            echo "<script type='text/javascript'>alert('$popup');</script>";

            echo "<script>document.location='logout.php';</script>";
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>EditAccount</title>
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
                    <div class="container-fluid">
                        <h3>Edit account</h3>    

                        <p> To edit your account, just enter anything you'd like to change and you will be redirected to the login page to confirm it. </p>
                        <span class='error'> <?php echo $errormessage ?> </span>
                        <br> </br>
                        <div class="row">

                            <!-- EMPLOYEE SIGN UP FORM -->
                            <form action="EditAccount.php" method="POST" id = 'myform'>


                                <!-- Email and Password-->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Change Email</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="emailup" placeholder="Enter email" value="<?php echo $emailup; ?>">
                                    <span class='error' > <?php echo $emailerror ?></span> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Change Password:</label>
                                    <input type="password" class="form-control" name="password1" id="password" placeholder="Password" >
                                    <span class='error'> <?php echo $passworderror ?></span> 
                                    <br>
                                    <p>Password Strength</p>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated jak_pstrength" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p id="jak_pstrength_text" class="text-center"></p>
                                    <label for="exampleInputPassword2">Enter your Password again:</label>
                                    <input type="password" class="form-control" name="password2" id="exampleInputPassword1" placeholder="Password" >
                                    <span class='error'> <?php echo $passwordmatcherror ?></span> 
                                </div>


                                <!-- Education Not like you can lose education  -->
                                <!-- University -->
                                <p> Education - Not a required field </p>                 
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">University</label>
                                    <input type="text" class="form-control" name="uni" id="exampleFormControlInput1" placeholder="Please Type your University">
                                </div>
                                <!-- Degree Type -->
                                <label class="mr-sm-2" for="inlineFormCustomSelectPref">Degree Type</label>
                                <select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="degtype" id="inlineFormCustomSelectPref">
                                    <option selected>Choose...</option>
                                    <option value="BEng">BEng</option>
                                    <option value="MEng">MEng</option>
                                    <option value="MSc">MSc</option>
                                </select> 
                                <br>

                                <!-- End Button to submit -->
                                <button type="submit" class="btn btn-primary" id="submitemployee" name="submit" >Edit</button>


                            </form>

                        </div>
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
        <script src="jaktutorial.js"></script>

        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("#password").keyup(function () {
                    passwordStrength(jQuery(this).val());
                });
            });
        </script>
    </body>
</html>