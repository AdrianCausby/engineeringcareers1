<?php
session_start();
//error_reporting(E_ALL); ini_set('display_errors', 'On');
include 'dbconnect.php';
$firsterror = $errormessage = $lastnameerror = $emailerror = $passworderror = $passwordmatcherror = $titleerror = $checkboxerror = '';
if (isset($_POST['submit'])) {
    // note: To prevent SQL injection hacking mysql real escape string is used.
    $title = mysqli_real_escape_string($connection, $_POST["title"]);
    $firstName = mysqli_real_escape_string($connection, $_POST["firstname"]);
    $lastName = mysqli_real_escape_string($connection, $_POST["lastname"]);
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password1 = mysqli_real_escape_string($connection, $_POST["password1"]);
    $password2 = mysqli_real_escape_string($connection, $_POST["password2"]);
    $checkbox = $_POST["checkbox"];
    $degreetype = mysqli_real_escape_string($connection, $_POST["degtype"]);
    $university = mysqli_real_escape_string($connection, $_POST["uni"]);

    // To keep consistent, instead of put the input fields as 'required' we put all errors as an asterix that will appear if not filled.

    if ($title == "Choose...") {
        $titleerror = "*Title must be chosen";
    }
    if (empty($firstName)) {
        $firsterror = "*First Name must be entered";
    } 
    elseif (strlen($firstName) < 2) {
        $firsterror = "*First Name is too short";
    }

    if (empty($lastName)) {
        $lastnameerror = "*Last name must be entered";
    } elseif (strlen($lastName) < 2) {
        $lastnameerror = "*Last name is too short";
    }

    if (empty($email)) {
        $emailerror = "*Email must be entered";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailerror = "*Invalid email address Entered";
    }

    // To check if email has already been used or if another account with the same email exists
    else {
        $emailquery = ("SELECT `Email` FROM `Potential_Employee` WHERE `Email` = '$email'");
        $emailcheckresult = mysqli_query($connection, $emailquery);
        $row = mysqli_fetch_array($emailcheckresult);

        if (mysqli_num_rows($emailcheckresult) !== 0) {
            $emailerror = "*Sorry, this email has already been used.";
        }
    }

    if (empty($password1)) {
        $passworderror = "*Password must be entered";
    } elseif (strlen($password1) < 8) {
        $passworderror = "*Password Has to be greater than 8 Characters";
    }

    if ($password1 !== $password2) {
        $passwordmatcherror = "*Passwords do not match";
    }

    if ($checkbox == false) {
        $checkboxerror = "*Terms and Conditions must be read and agreed upon";
    }



    if (empty($emailerror) && empty($firsterror) && empty($lastnameerror) && empty($passworderror) && empty($passwordmatcherror) && empty($titleerror) && empty($checkboxerror)) {


        $password1 = password_hash($password1, PASSWORD_DEFAULT); // for safety, encryption of password before being saved into the database and the data type will be text to accomodate for hashing space.
        $insertQuery = "INSERT INTO Potential_Employee(Title, First_Name, Last_name, Password, Email) VALUES ('$title', '$firstName', '$lastName', '$password1', '$email') ";
        $result = mysqli_query($connection, $insertQuery);


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


        $popup = "Welcome " . $firstName . "! You are now registered as a Potential Employee! You will now be redirected to the login page. Please log in.";
        echo "<script type='text/javascript'>alert('$popup');</script>";
        //header("Location:loginpaget.php");
        echo "<script>document.location='LoginPage.php';</script>";
    } else {
        $errormessage = '*There were errors in your submission, please fill out all fields marked with the asterix* below and reenter your password.';
    }
}

//NEXT IS TO ADD UNIVERSITY INTO DATABASE, AND IF COMBINATION OF SUCH EXISTS THEN NO NEED TO CREATE NEW.   
//Basically, first check if existing university is there, if it is not, then a new university is added. so like if(university is present then grab the ID of that university with select and insert that ID. If not present then Insert into then select education id and enter into user table.
// Add a " Your profile" on the side bar, that would be cool.
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Create Employee Account</title>


        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" >


        <link rel="stylesheet" href="CSS/no_dashboard_css_template.css"> 
        <link rel="stylesheet" href= "">


        <style>
            .container-fluid{
                padding: 30px;
                background: rgba(200, 200, 200, 0.8);
            }
            .error
            {
                color: red;
            }


        </style>

    </head>

    <body>




        <!-- NAVIGATION BAR -->     



        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <img id="logo" src="logo.png">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a> 
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="LoginPage.php">Log in</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Main CONTAINER part of the page WHERE MOST PAGE CONTENT WILL GO -->
        <div class="container-fluid">
            <h3>Potential Employee Sign Up</h3>    

            <p> Please fill out all the fields and you can begin onto your Journey of Opportunity. </p>
            <span class='error'> <?php echo $errormessage ?> </span>
            <br> </br>
            <div class="row">

                <!-- EMPLOYEE SIGN UP AREA -->

                <div class="col-lg-5">  

                    <!-- EMPLOYEE SIGN UP FORM -->
                    <form action="CreatePotentialEmployee.php" method="POST" id = 'myform'>

                        <!-- Title (Mr Mrs etc. HOW TO KEEP TITLE IN AFTER SIGNUP --> 
                        <label class="mr-sm-2" for="inlineFormCustomSelectPref">Title</label>
                        <select name="title" class="custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelectPref" value="<?php echo $title; ?>"  >
                            <option selected>Choose...</option>
                            <option value="1" <?php if ($title == '1') { ?> selected <?php } ?>>Mr</option>
                            <option value="2" <?php if ($title == '2') { ?> selected <?php } ?>>Ms</option>
                            <option value="3" <?php if ($title == '3') { ?> selected <?php } ?>>Mrs</option>
                        </select>
                        <span class='error'> <?php echo $titleerror ?> </span>

                        <br></br>

                        <!-- NAMES -->
                        <label for="firstname" >Name</label>                   
                        <div class="row">
                            <!-- First Name -->
                            <div class="col">

                                <input type="text" id='firstname' class="form-control" 
                                       name="firstname" placeholder="First name" value="<?php echo $firstName; ?>"> <!--Retaining Values after submit--> 
                                <span class='error'> <?php echo $firsterror ?> </span>
                            </div>

                            <!-- Last Name -->
                            <div class="col">
                                <input type="text" class="form-control" name="lastname" placeholder="Last name" value="<?php echo $lastName; ?>">
                                <span class='error'> <?php echo $lastnameerror ?></span>
                            </div>
                        </div>
                        <br>

                        <!-- Email and Password-->
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" value="<?php echo $email; ?>">
                            <span class='error' > <?php echo $emailerror ?></span> 
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password:</label>
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


                        <!-- Education -->
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
                        <!-- Terms and Conditions-->
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" name='checkbox' class="form-check-input">
                                I have agreed and read the <a  href="Javascript:onclick=tncpopup" > Terms and conditions</a>
                            </label>
                            <span class='error'> <?php echo $checkboxerror ?></span> 
                        </div>

                        <!-- End Button to submit -->
                        <button type="submit" class="btn btn-primary" id="submitemployee" name="submit" >Sign Up!</button>


                    </form>

                </div>
                <div class="col-lg-6" >  
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

        <!-- EMPLOYEE SIGN UP AREA END -->
        <script>
            function tncpopup() {
                alert("I agree that: 1)My data will not be used or shared to/by any third parties. 2) Review events constructively 3) Contact Hosts and company representatives in a respectful manner");
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <!-- get the function -->
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