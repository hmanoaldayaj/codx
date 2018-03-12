<?php

//Local computer parameters
$servername = "localhost";
$dbusername = "root";
$password = "";
$dbname = "POI";


//Live parameters
/* $servername = "";
$dbusername = "";
$password = "";
$dbname = ""; */

// Create connection
$connection = mysqli_connect($servername, $dbusername, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

?>