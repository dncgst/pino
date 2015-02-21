<?php

// connections string variables
$host = "localhost"; 
$user = "dncgst"; 
$pass = "gnewpost"; 
$db = "p13"; 

// database connection
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
  // if the connection could not be created the die() function terminates the script and prints an error message to the console
  or die ("Could not connect to server\n" . pg_last_error($con));

?>