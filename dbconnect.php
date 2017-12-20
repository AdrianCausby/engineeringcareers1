<?php

$dbuser = 'epiz_21240545';
$dbpass = 'VMGQDPaKREHH';
$dbname = 'epiz_21240545_Engineeringcareers';
$dbhost = 'sql203.epizy.com';

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$connection) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

return $connection;
//This session start is put in the db connect as all pages will be according to this.
?>