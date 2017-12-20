<?php
session_start();
//error_reporting(E_ALL); ini_set('display_errors', 'On');
include 'dbconnect.php';

//print_r($_SESSION);
if ($_SESSION['logged_in'] != true) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("Location:LoginPage.php");
}else {
    $email = $_SESSION['Email'];
    //$active = $_SESSION['active'];
    $firstName = $_SESSION['First_Name'];
    $lastName = $_SESSION['Last_name'];
    $logg = "Logged in as " . $email;
    $EID = $_GET['EID'];

}
?>

<?php

//$eventdetails = "SELECT * FROM careerevents JOIN venue ON careerevents.Venue_ID=venue.Venue_ID WHERE Event_ID = '$EID'";
$eventdetails="SELECT * FROM Careerevents WHERE Event_ID = '$EID'";
$result1 = mysqli_query($connection,$eventdetails) or die('Error making select event details query'.mysql_error());
$row2 = mysqli_fetch_array($result1);

//Get User Information
    $userinfo = "SELECT * FROM Potential_Employee WHERE Email = '$email'";
    $result = mysqli_query($connection, $userinfo);
    $row = mysqli_fetch_assoc($result);
    $userid = $row['User_ID'];
    
//Get ticket ID
$ticketdetails= "SELECT * FROM Tickets WHERE Event_ID = '$EID' AND User_ID = '$userid'";
$result3 = mysqli_query($connection,$ticketdetails) or die('Error making select event details query'.mysql_error());
$row3 = mysqli_fetch_array($result3);
$ticketid = $row3['Ticket_ID'];


$eventname = $row2['Event_Name'];
$startdate = $row2['Start_Date'];
$enddate = $row2['End_date'];
$starttime = $row2['Start'];
$endtime = $row2['End'];
$eventdescription = $row2['Event_Description'];

$maxcapacity = $row2['Max_Capacity'];



$eventaddress = "SELECT AddressLine1, City, Country, Postal_Code FROM Careerevents ce JOIN Venue ON Venue.Venue_ID = ce.Venue_ID WHERE Event_ID = '$EID' ";
$result2 = mysqli_query($connection,$eventaddress) or die('Error making select event address query'.mysql_error());
$row1 = mysqli_fetch_array($result2);


$eventcategory = $row1['Category'];
$eventstarttime = $row1['Start'];
$eventendtime = $row1['End'];
$eventvenue = "{$row1['AddressLine1']}, {$row1['City']}, {$row1['Country']}, {$row1['Postal_Code']}";
$ticket_ID = $row1['Ticket_ID'];

?>

<!DOCTYPE html>
<html>
<head>
    <script>
        function printPage() {
            window.print();
        }
    </script>
    <style> div {border-style: solid;
        }
    </style>
    <title> E_Ticket </title>
    <style>
        #logo{
            float:right;
            width: 20%;
        }
    </style>
</head>
<body>

<div>
    <br>
    This is your e-ticket! Please save/print it! <br>
    <br>
    <img id="logo" src="logo.png">
    Ticket ID: <?php echo $ticketid ?><br>
    Event Name: <?php echo $eventname ?> <br>
    Event Start Date: <?php echo $startdate ?> <br>
    Event End Date: <?php echo $enddate ?> <br>
    Event Start Time: <?php echo $starttime ?> <br>
    Event End Time: <?php echo $endtime ?> <br>
    Event Location: <?php echo $eventvenue ?> <br>
    Event Description: <?php echo $eventdescription ?> <br>
        
    <br>


</div>

<br>

<input type="button" value="Print Ticket" onclick="printPage()" />
</body>
</html>
