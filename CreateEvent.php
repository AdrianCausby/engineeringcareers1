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
    // $active = $_SESSION['active'];
    $firstName = $_SESSION['First_Name'];
    $lastName = $_SESSION['Last_Name'];
    $logg = "Logged in as " . $email;

    //Taking the Hosts Organizer ID for later use. 
    $organizeridquery = "SELECT * FROM Host_Organizer WHERE Email= '$email'";
    $result1 = mysqli_query($connection, $organizeridquery);
    $row = mysqli_fetch_assoc($result1);
    $organizerid = $row['Organizer_ID'];
    //echo $organizerid;




    if (isset($_POST['submit'])) {

        // note: To prevent SQL injection hacking mysql real escape string is used for the impotant information such as Rep name and email name
        $eventname = $_POST["eventname"];
        $strtdate = $_POST["strtdate"];
        $enddate = $_POST["enddate"];
        $starttime = $_POST["starttime"];
        $endtime = $_POST["endtime"];
        $lastpdate = $_POST["lastpdate"];
        $lastptime = $_POST["lastptime"];
        $lastpdt = $lastpdate . " " . $lastptime;
        $checkbox = $_POST["checkbox"];
        $maxcap = $_POST["maxcap"];
        $description = $_POST["description"];
        $category = $_POST["categ"];

        $companyname1 = $_POST["Company1"];
        $company1rep = mysqli_real_escape_string($connection, $_POST["Company1Org"]);
        $company1repem = mysqli_real_escape_string($connection, $_POST["Company1OrgEmail"]);
        $companyname2 = $_POST["Company2"];
        $company2rep = mysqli_real_escape_string($connection, $_POST["Company2Org"]);
        $company2repem = mysqli_real_escape_string($connection, $_POST["Company2OrgEmail"]);
        $companyname3 = $_POST["Company3"];
        $company3rep = mysqli_real_escape_string($connection, $_POST["Company3Org"]);
        $company3repem = mysqli_real_escape_string($connection, $_POST["Company3OrgEmail"]);
        $companyname4 = $_POST["Company4"];
        $company4rep = mysqli_real_escape_string($connection, $_POST["Company4Org"]);
        $company4repem = mysqli_real_escape_string($connection, $_POST["Company4OrgEmail"]);
        $companyname5 = $_POST["Company5"];
        $company5rep = mysqli_real_escape_string($connection, $_POST["Company5Org"]);
        $company5repem = mysqli_real_escape_string($connection, $_POST["Company5OrgEmail"]);

        $address = $_POST["address"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $postcode = $_POST["postcode"];

        $categoryerror = "";
        $eventnameerror = $maxcaperror = $checkboxerror = "";

        $insertQuery5 = "SELECT * FROM Careerevents WHERE Event_Name = '$eventname'";
        $result5 = mysqli_query($connection, $insertQuery5);
        
        //Checking if the Event with the same name already exists. 

        if (mysqli_num_rows($result5) == 1) {
            $eventnameerror = "*An event name with this name already exists!";
        }

        if ($maxcap == "Click to Select") {
            $maxcaperror = "*You must select a maximum capacity for your event so this number of tickets can be generated";
        }


        //If category value is other then the value will be overwritten with another value.
        
        if ($category === "Other") {
            $category = $_POST["othercat"];
            //echo $category;
            if (empty($category)) {
                $categoryerror = "*You Selected Other as your category but did not fill in anything";
            }
        }

        if ($checkbox == false) {
            $checkboxerror = "*Terms and Conditions must be read and agreed upon";
        }

        //Bunch of errors

        if (empty($categoryerror) && empty($eventnameerror) && empty($$maxcaperror) && empty($checkboxerror)) {

            $insertQuery = "INSERT INTO Careerevents(Organizer_ID, Event_Name, Start_Date, End_date, Start, End, Last_available_purchase_day_n_time, Max_Capacity, Event_Description, Category) VALUES ('$organizerid', '$eventname', '$strtdate', '$enddate', '$starttime', '$endtime', '$lastpdt', '$maxcap', '$description', '$category') ";
            $result2 = mysqli_query($connection, $insertQuery);
            $insertQuery2 = "SELECT * FROM Careerevents WHERE Event_Name = '$eventname'";
            $result3 = mysqli_query($connection, $insertQuery2);
            $row = mysqli_fetch_assoc($result3);
            $eventid = $row['Event_ID'];

            // the following are for the companies, but if a company is not submitted ie, the field is empty then it will not be inserted into the database
            if (!empty($companyname1) && !empty($company1rep) && !empty($company1repem)) {
                $insertCompanyquery1 = "INSERT INTO Companies(Company_Name, Event_ID, Representative_Name, Representative_Email) VALUES ('$companyname1', '$eventid', '$company1rep', '$company1repem') ";
                $resultcomp1 = mysqli_query($connection, $insertCompanyquery1);
            }
            if (!empty($companyname2) && !empty($company2rep) && !empty($company2repem)) {
                $insertCompanyquery2 = "INSERT INTO Companies(Company_Name, Event_ID, Representative_Name, Representative_Email) VALUES ('$companyname2', '$eventid', '$company2rep', '$company2repem') ";
                $resultcomp2 = mysqli_query($connection, $insertCompanyquery2);
            }
            if (!empty($companyname3) && !empty($company3rep) && !empty($company3repem)) {
                $insertCompanyquery3 = "INSERT INTO Companies(Company_Name, Event_ID, Representative_Name, Representative_Email) VALUES ('$companyname3', '$eventid', '$company3rep', '$company3repem') ";
                $resultcomp3 = mysqli_query($connection, $insertCompanyquery3);
            }
            if (!empty($companyname4) && !empty($company4rep) && !empty($company4repem)) {
                $insertCompanyquery4 = "INSERT INTO Companies(Company_Name, Event_ID, Representative_Name, Representative_Email) VALUES ('$companyname4', '$eventid', '$company4rep', '$company4repem') ";
                $resultcomp4 = mysqli_query($connection, $insertCompanyquery4);
            }
            if (!empty($companyname5) && !empty($company5rep) && !empty($company5repem)) {
                $insertCompanyquery5 = "INSERT INTO Companies(Company_Name, Event_ID, Representative_Name, Representative_Email) VALUES ('$companyname5', '$eventid', '$company5rep', '$company5repem') ";
                $resultcomp5 = mysqli_query($connection, $insertCompanyquery5);
            }

            //To avoid overclustering of Data, checking first if address Exists, if it doesnt then it will create a venue ID and register it. Assuming postal codes are unique ie no events, then the system will use postal codes to check if it already exists.
            $checkvenuequery = "SELECT * FROM Venue WHERE Postal_Code ='$postcode'";
            $resultvenue = mysqli_query($connection, $checkvenuequery);
            //If a venue with that post code exists, then the event in the events table will be updated to have the existing venue ID
            if (mysqli_num_rows($resultvenue) == 1) {
                $row3 = mysqli_fetch_assoc($resultvenue);
                $venueid = $row3['Venue_ID'];
                $insertvenuequery = "UPDATE Careerevents SET Venue_ID = '$venueid' WHERE Event_ID = '$eventid'";
                $resultvenue1 = mysqli_query($connection, $insertvenuequery);
            } elseif (mysqli_num_rows($resultvenue) == 0) {
                $insertvenuequery2 = "INSERT INTO Venue(AddressLine1, City, Country, Postal_Code) VALUES('$address', '$city', '$country', '$postcode')";
                $resultvenue2 = mysqli_query($connection, $insertvenuequery2);
                $checkvenuequery3 = "SELECT * FROM Venue WHERE Postal_Code = '$postcode'";
                $resultvenue3 = mysqli_query($connection, $checkvenuequery3);
                $row4 = mysqli_fetch_assoc($resultvenue3);
                $venueid2 = $row4['Venue_ID'];
                $insertvenuequery3 = "UPDATE Careerevents SET Venue_ID = '$venueid2' WHERE Event_ID = '$eventid'";
                $resultvenue4 = mysqli_query($connection, $insertvenuequery3);
            }

            echo "<script> alert('Congratulations! You have created an Event');</script>";
            echo "<script>document.location='HostDashboard.php';</script>";
            //$insertEducationquery = "INSERT INTO Education(University, DegreeType) VALUES ('$university', '$degreetype')";
            //$result2 = mysqli_query($connection, insertEducationquery);
        } else {
            $generalerror = "*There were errors in your submission, check below for details. And retick terms and conditions.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Create Event</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
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
            .companies{
                padding:10px;
                border: solid 1px;
            }
            .form-check-input{
                margin:10px;
            }
            .errors{
                color: red;
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
                        <a class="nav-link" href="HostDashboard.php">My Dashboard<span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            My Account
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="logout.php">Log out</a>
        
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
                <!-- If any errors occur, then the values will stay-->
                <div class="col-lg-9">     
                    <h3> Welcome <?php echo $firstName ?>!</h3>
                    <h1> Create Event</h1>
                    <p class = "errors"> <?php echo $generalerror ?></p>
                    <div id="lineup">        
                        <div class="bootstrap-iso">
                            <form action="CreateEvent.php" method="POST">
                                <div class="form-group row">
                                    <label for="event_name" class="col-sm-2 col-form-label">Event Name</label>
                                    <!--<div class="col-sm-10">-->
                                    <input type="text" name='eventname' value="<?php echo $eventname ?>" id="event_name" placeholder="Event Name" required>
                                    <p class = 'errors'> <?php echo $eventnameerror ?>
                                        <!--</div>-->
                                </div>
                                <div class="form-group row">
                                    <label for="strtdate" class="col-sm-2 col-form-label">Start Date</label>
                                    <input type="text" name="strtdate" value="<?php echo $strtdate ?>" placeholder="YYYY-MM-DD" required>
                                </div>
                                <div class="form-group row">
                                    <label for="enddate" class="col-sm-2 col-form-label">End Date</label>
                                    <input type="text" name="enddate" value="<?php echo $enddate ?>" placeholder="YYYY-MM-DD" required>
                                </div>
                                <p> Time - For safety purposes and suitable times, events can only start from 8AM until 7PM. And can end from 9AM to 11PM to ensure events run for at least 1 hour.</p>    
                                <div class="form-group row">
                                    <label for="starttime" class="col-sm-2 col-form-label">Start Time</label>
                                    <select class="custom-select" name='starttime'>

                                        <option value="08:00:00"<?php if ($starttime == '08:00:00') { ?> selected <?php } ?>>08:00:00</option>
                                        <option value="09:00:00"<?php if ($starttime == '09:00:00') { ?> selected <?php } ?>>09:00:00</option>
                                        <option value="10:00:00"<?php if ($starttime == '10:00:00') { ?> selected <?php } ?>>10:00:00</option>
                                        <option value="11:00:00"<?php if ($starttime == '11:00:00') { ?> selected <?php } ?>>11:00:00</option>
                                        <option value="12:00:00"<?php if ($starttime == '12:00:00') { ?> selected <?php } ?>>12:00:00</option>
                                        <option value="13:00:00"<?php if ($starttime == '13:00:00') { ?> selected <?php } ?>>13:00:00</option>
                                        <option value="14:00:00"<?php if ($starttime == '14:00:00') { ?> selected <?php } ?>>14:00:00</option>
                                        <option value="15:00:00"<?php if ($starttime == '15:00:00') { ?> selected <?php } ?>>15:00:00</option>
                                        <option value="16:00:00"<?php if ($starttime == '16:00:00') { ?> selected <?php } ?>>16:00:00</option>
                                        <option value="17:00:00"<?php if ($starttime == '17:00:00') { ?> selected <?php } ?>>17:00:00</option>
                                        <option value="18:00:00"<?php if ($starttime == '18:00:00') { ?> selected <?php } ?>>18:00:00</option>
                                        <option value="19:00:00"<?php if ($starttime == '19:00:00') { ?> selected <?php } ?>>19:00:00</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="endtime" class="col-sm-2 col-form-label">End Time</label>
                                    <select class="custom-select" name='endtime' value="<?php $endtime ?>">
                                        <option value="09:00:00"<?php if ($endtime == '09:00:00') { ?> selected <?php } ?>>09:00:00</option>
                                        <option value="10:00:00"<?php if ($endtime == '10:00:00') { ?> selected <?php } ?>>10:00:00</option>
                                        <option value="11:00:00"<?php if ($endtime == '11:00:00') { ?> selected <?php } ?>>11:00:00</option>
                                        <option value="12:00:00"<?php if ($endtime == '12:00:00') { ?> selected <?php } ?>>12:00:00</option>
                                        <option value="13:00:00"<?php if ($endtime == '13:00:00') { ?> selected <?php } ?>>13:00:00</option>
                                        <option value="14:00:00"<?php if ($endtime == '14:00:00') { ?> selected <?php } ?>>14:00:00</option>
                                        <option value="15:00:00"<?php if ($endtime == '15:00:00') { ?> selected <?php } ?>>15:00:00</option>
                                        <option value="16:00:00"<?php if ($endtime == '16:00:00') { ?> selected <?php } ?>>16:00:00</option>
                                        <option value="17:00:00"<?php if ($endtime == '17:00:00') { ?> selected <?php } ?>>17:00:00</option>
                                        <option value="18:00:00"<?php if ($endtime == '18:00:00') { ?> selected <?php } ?>>18:00:00</option>
                                        <option value="19:00:00"<?php if ($endtime == '19:00:00') { ?> selected <?php } ?>>19:00:00</option>
                                        <option value="20:00:00"<?php if ($endtime == '20:00:00') { ?> selected <?php } ?>>20:00:00</option>
                                        <option value="21:00:00"<?php if ($endtime == '21:00:00') { ?> selected <?php } ?>>21:00:00</option>
                                        <option value="22:00:00"<?php if ($endtime == '22:00:00') { ?> selected <?php } ?>>22:00:00</option>
                                        <option value="23:00:00"<?php if ($endtime == '23:00:00') { ?> selected <?php } ?>>23:00:00</option>
                                    </select>
                                </div>
                                <p> The last Purchase date and time is the last available date and time at which a potential employee can book a ticket. The time can be any time between 9AM to 11PM to ensure that users can make last minute bookings in the morning. </p>
                                <div class="form-group row">
                                    <label for="lastpdate" class="col-sm-2 col-form-label">Last purchase Date</label>
                                    <input type="text" value="<?php echo $lastpdate?>" id="datetimepicker1" name="lastpdate" placeholder="YYYY-MM-DD" required>
                                </div>
                                <div class="form-group row">
                                    <label for="lastptime" class="col-sm-2 col-form-label">Last Purchase Time</label>
                                    <select class="custom-select"  name='lastptime' >
                                        <option value="09:00:00"<?php if ($lastptime == '09:00:00') { ?> selected <?php } ?>>09:00:00</option>
                                        <option value="10:00:00"<?php if ($lastptime == '10:00:00') { ?> selected <?php } ?>>10:00:00</option>
                                        <option value="11:00:00"<?php if ($lastptime == '11:00:00') { ?> selected <?php } ?>>11:00:00</option>
                                        <option value="12:00:00"<?php if ($lastptime == '12:00:00') { ?> selected <?php } ?>>12:00:00</option>
                                        <option value="13:00:00"<?php if ($lastptime == '13:00:00') { ?> selected <?php } ?>>13:00:00</option>
                                        <option value="14:00:00"<?php if ($lastptime == '14:00:00') { ?> selected <?php } ?>>14:00:00</option>
                                        <option value="15:00:00"<?php if ($lastptime == '15:00:00') { ?> selected <?php } ?>>15:00:00</option>
                                        <option value="16:00:00"<?php if ($lastptime == '16:00:00') { ?> selected <?php } ?>>16:00:00</option>
                                        <option value="17:00:00"<?php if ($lastptime == '17:00:00') { ?> selected <?php } ?>>17:00:00</option>
                                        <option value="18:00:00"<?php if ($lastptime == '18:00:00') { ?> selected <?php } ?>>18:00:00</option>
                                        <option value="19:00:00"<?php if ($lastptime == '19:00:00') { ?> selected <?php } ?>>19:00:00</option>
                                        <option value="20:00:00"<?php if ($lastptime == '20:00:00') { ?> selected <?php } ?>>20:00:00</option>
                                        <option value="21:00:00"<?php if ($lastptime == '21:00:00') { ?> selected <?php } ?>>21:00:00</option>
                                        <option value="22:00:00"<?php if ($lastptime == '22:00:00') { ?> selected <?php } ?>>22:00:00</option>
                                        <option value="23:00:00"<?php if ($lastptime == '23:00:00') { ?> selected <?php } ?>>23:00:00</option>
                                    </select>
                                </div>
                                <p> Maximum Capacity of Events is the maximum capacity and number of tickets that will be generated, only a maximum of 10 participants are allowed per event to allow for 2 Potential Employees per company stall at any time, and to keep events small and personal.</p>
                                <div class="form-group row">
                                    <label for="maxcap" class="col-sm-2 col-form-label">Maximum Capacity of event:</label>
                                    <select class="custom-select" name='maxcap' required value="<?php $maxcap ?>">
                                        <option selected>Click to Select</option>
                                        <option value="1" <?php if ($maxcap == '1') { ?> selected <?php } ?>>1</option>
                                        <option value="2" <?php if ($maxcap == '2') { ?> selected <?php } ?>>2</option>
                                        <option value="3"<?php if ($maxcap == '3') { ?> selected <?php } ?>>3</option>
                                        <option value="4"<?php if ($maxcap == '4') { ?> selected <?php } ?>>4</option>
                                        <option value="5"<?php if ($maxcap == '5') { ?> selected <?php } ?>>5</option>
                                        <option value="6"<?php if ($maxcap == '6') { ?> selected <?php } ?>>6</option>
                                        <option value="7"<?php if ($maxcap == '7') { ?> selected <?php } ?>>7</option>
                                        <option value="8"<?php if ($maxcap == '8') { ?> selected <?php } ?>>8</option>
                                        <option value="9"<?php if ($maxcap == '9') { ?> selected <?php } ?>>9</option>
                                        <option value="10"<?php if ($maxcap == '10') { ?> selected <?php } ?>>10</option>
                                    </select>
                                </div>



                                <div class="form-group">
                                    <label for="textarea">Description of Event (Provide general description of the purpose of the event)</label>
                                    <textarea class="form-control" name='description' id="textarea" rows="3" placeholder="Max 2000 Characters" value="<?php $description ?>"></textarea>
                                </div>
                                <p> Provide a category for which most suits the field in which the companies work in</p>
                                <div class="form-group">
                                    <label for="categ" class="col-sm-2 col-form-label">Categories</label>
                                    <select class="custom-select" name='categ' value="<?php $category ?>">
                                        <option value="Chemical Engineering" <?php if ($category == 'Chemical Engineering') { ?> selected <?php } ?>>Chemical Engineering</option>
                                        <option value="Mechanical Engineering"<?php if ($category == 'Mechanical Engineering') { ?> selected <?php } ?>>Mechanical Engineering</option>
                                        <option value="Electrical Engineering"<?php if ($category == 'Electrical Engineering') { ?> selected <?php } ?>>Electrical Engineering</option>
                                        <option value="Environmental Engineering"<?php if ($category == 'Environmental Engineering') { ?> selected <?php } ?>>Environmental Engineering</option>
                                        <option value="Computer Science"<?php if ($category == 'Computer Science') { ?> selected <?php } ?>>Computer Science</option>
                                        <option value="Civil Engineering"<?php if ($category == 'Civil Engineering') { ?> selected <?php } ?>>Civil Engineering</option>
                                        <option value="No Category"<?php if ($category == 'No Category') { ?> selected <?php } ?>>No Category</option>
                                        <option value="Other"<?php if ($category == 'Other') { ?> selected <?php } ?>>Other</option>
                                    </select>
                                </div>
                                <p> OR if your event does not fit any default categories, then please select "No category" or "Other". If other is selected, then please Enter one below. </p>
                                <div class="form-group row">
                                    <label for="othercat" class="col-sm-2 col-form-label">Other Category</label>
                                    <input type="text" name='othercat' id="othercat" placeholder="Insert Category Name" >
                                    <p class = 'errors'> <?php echo $categoryerror ?> </p>
                                </div>
                                <p> Venue Details: Please provide Venue details below </p>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"for="inputAddress">Address</label>
                                    <input type="text"  id="inputAddress" name='address' placeholder="1234 Main St" required value="<?php echo $address ?>">
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"for="inputCity">City</label>
                                    <input type="text"  name='city' id="inputCity" required value="<?php echo $city ?>">
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"for="inputCity">Country</label>
                                    <input type="text" name='country'  id="inputCity" required value="<?php echo $country ?>">
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"for="inputZip">Postal Code</label>
                                    <input type="text" name='postcode'  id="inputZip" required value="<?php echo $postcode ?>">
                                </div>
                                <p> Please Enter a company list and their respective Organizer names and emails. Note each event can have no more than 5 Companies. </p>
                                <p> You must have at least one company in an event and so the fields for Company 1 are required fields</p> 
                                <div class='companies'</div>
                                <div class="form-group row">
                                    <label for="Company1" class="col-sm-2 col-form-label">Company 1</label>
                                    <input type="text" name='Company1' id="othercat" placeholder="Insert Company Name" required value="<?php echo $companyname1 ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company1Org" class="col-sm-2 col-form-label">Representative Name</label>
                                    <input type="text" name='Company1Org' id="othercat" placeholder="Insert Organizers name" required value="<?php echo $company1rep ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company1OrgEmail" class="col-sm-2 col-form-label">Representative Email</label>
                                    <input type="email" name='Company1OrgEmail' id="othercat" placeholder="Insert Organizers email" required value="<?php echo $company1repem ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company2" class="col-sm-2 col-form-label">Company 2</label>
                                    <input type="text" name='Company2' id="othercat" placeholder="Insert Company Name" value="<?php echo $companyname2 ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company2Org" class="col-sm-2 col-form-label">Representative Name</label>
                                    <input type="text" name='Company2Org' id="othercat" placeholder="Insert Organizers name" value="<?php echo $company2rep ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company2OrgEmail" class="col-sm-2 col-form-label">Representative Email</label>
                                    <input type="email" name='Company2OrgEmail' id="othercat" placeholder="Insert Organizers email" value="<?php echo $company2repem ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company3" class="col-sm-2 col-form-label">Company 3</label>
                                    <input type="text" name='Company3' id="othercat" placeholder="Insert Company Name" value="<?php echo $companyname3 ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company3Org" class="col-sm-2 col-form-label">Representative Name</label>
                                    <input type="text" name='Company3Org' id="othercat" placeholder="Insert Representative name"value="<?php echo $company3rep ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company3OrgEmail" class="col-sm-2 col-form-label">Representative Email</label>
                                    <input type="email" name='Company3OrgEmail' id="othercat" placeholder="Insert Representative email" value="<?php echo $company3repem ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company4" class="col-sm-2 col-form-label">Company 4</label>
                                    <input type="text" name='Company4' id="othercat" placeholder="Insert Company Name" value="<?php echo $companyname4 ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company4Org" class="col-sm-2 col-form-label">Representative Name</label>
                                    <input type="text" name='Company4Org' id="othercat" placeholder="Insert Representative name" value="<?php echo $company4rep ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company4OrgEmail" class="col-sm-2 col-form-label">Representative Email</label>
                                    <input type="email" name='Company4OrgEmail' id="othercat" placeholder="Insert Representative email" value="<?php echo $company4repem ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company5" class="col-sm-2 col-form-label">Company 5</label>
                                    <input type="text" name='Company5' id="othercat" placeholder="Insert Company Name" value="<?php echo $companyname5 ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company5Org" class="col-sm-2 col-form-label">Representative Name</label>
                                    <input type="text" name='Company5Org' id="othercat" placeholder="Insert Representative name" value="<?php echo $company5rep ?>">
                                </div>
                                <div class="form-group row">
                                    <label for="Company5OrgEmail" class="col-sm-2 col-form-label">Representative Email</label>
                                    <input type="email" name='Company5OrgEmail' id="othercat" placeholder="Insert Representative email" value="<?php echo $company5repem ?>">
                                </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name='checkbox'> 
                                    <br>
                                    <p> I agree with the <a href="javascript:onclick=tncpopup()" >Terms and conditions</a></p>
                                </label>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" id="submitevent" name="submit">Create Event</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Side Bar (Stylesheet linked to bootsrap) -->
            <div class="col-lg-3">
                <h4 class='sidetext'>Are you ready to create your own event? Click the link Below</h4>
                <button class="btn btn-outline-success my-2 my-sm-0"><a href='CreateEvent.php'>Create an Event!</a></button>
                <br>
                <h4 class='sidetext'> Not sure what to host? Browse some of the Upcoming events to get some inspiration </h4>
                <button class="btn btn-outline-success my-2 my-sm-0"><a href='UpcomingEventsForHost.php'>Upcoming Events</a></button>
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
    <script>
        function tncpopup() {
            alert("I agree that: 1)All the information I entered above is correct. 2)Data shared by you will not be shared to any third party companies. 3) Events only have a maximum of 5 companies and 10 participants to match 2 participants per stall. ");
        }
    </script>      

    <!--  jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>    
        <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            var date_input = $('input[name="strtdate"]'); //our date input has the name "date"
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
            var date_input = $('input[name="enddate"]'); //our date input has the name "date"
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
            var date_input = $('input[name="lastpdate"]'); //our date input has the name "date"
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