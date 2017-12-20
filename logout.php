<?php

session_start();
session_destroy();
setcookie("Email", "", time() - 3600);
setcookie("logged_in", "", time() - 3600);
setcookie("First_Name", "", time() - 3600);
setcookie("Last_name", "", time() - 3600);
header("Location:LoginPage.php");
?>