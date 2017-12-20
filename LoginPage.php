<?php
session_start();
//error_reporting(E_ALL); ini_set('display_errors', 'On'); 
include 'dbconnect.php';
$emailerror = $passworderror = "";
//print_r($_COOKIE);
//if ($_SESSION['logged_in'] = true) {
//$_SESSION['message'] = "You're already logged in! ";
//header("Location:EmployeeDashboard.php"); }


if (isset($_POST['submit'])) {


    // note: To prevent SQL injection hacking mysql real escape string is used.

    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $checkbox = isset($_POST["keep"]);

    if (empty($email)) {
        $emailerror = "*Email must be entered";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailerror = "*Invalid email address Entered";
    }

    // To check if email exists
    // Assuming a host cannot be a potential employee
    else {
        $userdata = ("SELECT * FROM `Potential_Employee` WHERE `Email` = '$email'");
        $userdataresult = mysqli_query($connection, $userdata);
        $hostuserdata = ("SELECT * FROM `Host_Organizer` WHERE `Email` = '$email'");
        $hostuserdataresult = mysqli_query($connection, $hostuserdata);

        if (mysqli_num_rows($userdataresult) == 1) {
            $row = mysqli_fetch_assoc($userdataresult);

            if (!password_verify($password, $row['Password'])) {
                $passworderror = "*Password is incorrect!";
            } else {

                $_SESSION['Email'] = $email;
                $_SESSION['First_Name'] = $row['First_Name'];
                $_SESSION['Last_name'] = $row['Last_name'];
                $_SESSION['logged_in'] = true;

                header("Location:EmployeeDashboard.php");
                exit();
                //error_reporting(E_ALL); ini_set('display_errors', 'On'); 
            }
        } elseif (mysqli_num_rows($hostuserdataresult) == 1) {
            $row = mysqli_fetch_assoc($hostuserdataresult);

            if (!password_verify($password, $row['Password'])) {
                $passworderror = "*Password is incorrect!";
            } else {

                $_SESSION['Email'] = $email;
                $_SESSION['First_Name'] = $row['First_Name'];
                $_SESSION['Last_Name'] = $row['Last_Name'];
                $_SESSION['logged_in'] = true;
                //print_r($_SESSION); 
                //Setting a cookie to remember the user. but only for an hour.
                if ($checkbox == "on") {
                    setcookie("Email", $email, time() + 3600);
                    setcookie("logged_in", true, time() + 3600);
                }

                header("Location:HostDashboard.php");
                exit();
                //error_reporting(E_ALL); ini_set('display_errors', 'On'); 
            }
        }
        /* elseif(mysqli_num_rows($hostuserdataresult) == 1){            
          $row=mysqli_fetch_assoc($hostuserdataresult);

          if (!password_verify($password, $row['Password'])){
          $passworderror = "*Password is incorrect!";
          }
          else{

          $_SESSION['Email'] = $email;
          $_SESSION['First_Name'] = $row['First_Name'];
          $_SESSION['Last_Name'] = $row['Last_Name'];
          $_SESSION['logged_in'] = true;
          //print_r($_SESSION);

          //Setting a cookie to remember the user. but only for an hour.
          // if($checkbox =="on"){
          //     setcookie("Email",$email, time()+3600);
          //     setcookie("logged_in", true , time()+3600);
          //}

          header("Location:admin.php");
          exit();
          //error_reporting(E_ALL); ini_set('display_errors', 'On');
          }
          } */ else {
            $emailerror = "*Email does not exist";
        }
    }

    if (empty($password)) {
        $passworderror = "*Password must be entered";
    } elseif (strlen($password) < 8) {
        $passworderror = "*Password Has to be greater than 8 Characters";
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Log in</title>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" >


        <link rel="stylesheet" href="CSS/no_dashboard_css_template.css"> 
        <link rel="stylesheet" href= "CSS/LoginSpecifics.css">


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
            <h3>Log in</h3>    

            <p> Please fill out all the fields to enter your dashboard </p>

            <br> </br>
            <div class="row">

                <!-- EMPLOYEE Login AREA -->

                <div class="col-lg-4">  

                    <!-- EMPLOYEE Login FORM -->
                    <form action="LoginPage.php" method="POST" >


                        <!-- Email and Password-->
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" value="<?php echo $email; ?>">
                            <span class='error' ><?php echo $emailerror ?></span> 
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password:</label>
                            <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" >
                            <span class='error'><?php echo $passworderror ?></span> 
                            <br>
                        </div>


                        <!-- End Button to submit -->
                        <button type="submit" class="btn btn-primary" id="submitemployee" name="submit" >Log in!</button>


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
    </div>
    <!-- EMPLOYEE SIGN UP AREA END -->
    <script>

    </script>
    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" ></script>

</body>
</html>