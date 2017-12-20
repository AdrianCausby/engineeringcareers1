<?php
session_start();
error_reporting(E_ALL); ini_set('display_errors', 'On');
include 'dbconnect.php';

//print_r($_SESSION);
if ($_SESSION['logged_in'] != true) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("Location:LoginPage.php");
}
else {
 
    $email = $_SESSION['Email'];
    //$active = $_SESSION['active'];
    $firstName = $_SESSION['First_Name'];
    $lastName = $_SESSION['Last_name'];
    $logg = "Logged in as " . $email;
    $EID = $_GET['EID'];

    
    $ticketerror= "";
    //Get User Information
    $userinfo = "SELECT * FROM Potential_Employee WHERE Email = '$email'";
    $result = mysqli_query($connection, $userinfo);
    $row = mysqli_fetch_assoc($result);
    $userid = $row['User_ID'];
          
    //Getting Event information for later use 
    $eventinfo = "SELECT * FROM Careerevents WHERE Event_ID = '$EID'";
    $eventresult = mysqli_query($connection, $eventinfo);
    $row2 = mysqli_fetch_assoc($eventresult);
    $maxcap = $row2['Max_Capacity'];
    $eventname = $row2['Event_Name'];

    
    
    
    //Check if user alr booked this event by checking for tickets with his/her userId and event id.
    $querycheck = "SELECT * FROM Tickets WHERE User_ID = '$userid' AND Event_ID = '$EID'";
    $result1 = mysqli_query($connection, $querycheck);
    $rownumtix = mysqli_num_rows($result1);
    
    
    //Check if Event is sold out by counting number of tickets for that event 
    $ticknum = "SELECT * FROM Tickets WHERE Event_ID = '$EID'";
    $result2 = mysqli_query($connection, $ticknum);
    $rownumtix2 = mysqli_num_rows($result2);
    
    // Check if the Event has already passed
    $eventpast = "SELECT * FROM Careerevents WHERE Event_ID = '$EID' AND Last_available_purchase_day_n_time > NOW()";
    $eventresultpast = mysqli_query($connection, $eventpast);
    $rownumeventspast = mysqli_num_rows($eventresultpast);

    

    
    if($rownumeventspast == 0 ){
        $ticketerror = "Sorry, unfortunately this events Last booking date has already passed.";
        echo "<script> alert('".$ticketerror."!');</script>";
        echo "<script>document.location='UpcomingEvents.php';</script>";
        
    }
    elseif($rownumtix != 0 ){
        $ticketerror = "You have already booked a ticket for this event!";
        echo "<script> alert('".$ticketerror."!');</script>";
        echo "<script>document.location='UpcomingEvents.php';</script>";
        
    }
    elseif($rownumtix2 > $maxcap -1 ){
        $ticketerror = "Sorry, Event is sold out!";
        echo "<script> alert('".$ticketerror."!');</script>";
        echo "<script>document.location='UpcomingEvents.php';</script>";
        

    }
    elseif(empty($ticketerror) ){
        echo "<script> alert('Event Booked! Get your eticket from the dashboard');</script>";
        $insertticketquery= "INSERT INTO Tickets(Event_ID, User_ID, Purchase_timedate) VALUES('$EID', '$userid', NOW())";
        $insertact = mysqli_query($connection, $insertticketquery);
        
        
       //echo "<script> alert('Congratulations! You've booked your place at this event! For your ticket, please click Print or Save ticket of the event on your dashboard.');</script>";
        echo "<script>document.location='EmployeeDashboard.php';</script>";
        
    }

   

}
?>


