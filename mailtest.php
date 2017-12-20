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
    $EID = $_GET['EID'];


    $participantlist = ("SELECT * FROM Potential_Employee JOIN Tickets ON Potential_Employee.User_ID=Tickets.User_ID JOIN Careerevents ON Tickets.Event_ID=Careerevents.Event_ID WHERE Event_ID = '$EID'");
    $result4 = mysqli_query($connection, $participantlist);
    $rownumbersf = mysqli_num_rows($result4);
    while ($rowprty = mysqli_fetch_assoc($result4)) {
        $participants[] = $rowprty;
    }
    foreach ($participants as $participant) {
        $email = $participant['Email'];

//Email Trigger when book ticket is clicked
        $to = "$email";
        $subject = "Reminder";

        $message = "
<html>
<head>
<title>Event reminder for" . $eventname . "</title>
</head>
<body>
<p>This is a reminder email that your event is coming up soon!</p>
</body>
</html>
";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
        $headers .= 'From: admin@engineeringcareers.rf.gd' . "\r\n";


        mail($to, $subject, $message, $headers);




//Although since we it is not required to send the emails, we just show the email trigger, and so the server would check the start date of each event and send a reminder for imminent events."    
    }
    $popup = "Hi " . $firstName . "! We have sent your mail to all the participants. Have a great Event!.";
    echo "<script type='text/javascript'>alert('$popup');</script>";
    //header("Location:loginpaget.php");
    echo "<script>document.location='HostDashboard.php';</script>";
}
?>