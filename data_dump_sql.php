<?php

// connections string variables → sostituire con connect.php
$host = "localhost"; 
$user = "dncgst"; 
$pass = "gnewpost"; 
$db = "p13";

// database connection test
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
  // if the connection could not be created the die() function terminates the script and prints an error message to the console
    or die ("Could not connect to server\n");

// file dumped
$file = "/tmp/pino_dump.sql";

// dump command definition
$dump = "pg_dump --host=$host --username=$user --password=$pass --file=$file --oids $db";

// exec dump
exec($dump);
//or die(pg_last_error($dump));

// headers
header("Content-type: application");
header("Content-Disposition: attachment; filename=$file");
header("Pragma: no-cache");
header("Expires: 0");

//
readfile($file);

?>