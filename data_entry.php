<?php

// set request variables

//$codice = strtoupper($_REQUEST['codice']); not required!
$data = strtoupper($_REQUEST['data']);
$taglio = strtoupper($_REQUEST['taglio']);
$q = strtoupper($_REQUEST['q']);
//$us = strtoupper($_REQUEST['us']); not required!
$n = strtoupper($_REQUEST['n']);
$desc = strtoupper($_REQUEST['descrizione']);
$o = strtoupper($_REQUEST['o']);
$p = strtoupper($_REQUEST['p']);
$l_max = strtoupper($_REQUEST['l_max']);
$l_med = strtoupper($_REQUEST['l_med']);
$s_min = strtoupper($_REQUEST['s_min']);
$oss = strtoupper($_REQUEST['oss']);
// build secondary variables
$codice = $taglio . $q . $n;
$us = substr($taglio, 0, 1);

// debug
//echo phpinfo();

// SQL query definition
$insert = "INSERT INTO records VALUES ('$codice', '$data', '$q', '$us', '$taglio', '$n', '$desc', '$o', '$p', '$l_max', '$l_med', '$s_min', '$oss');";

// connections string variables
$host = "localhost"; 
$user = "dncgst"; 
$pass = "gnewpost"; 
$db = "p13"; 

// database connection
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
  // if the connection could not be created the die() function terminates the script and prints an error message to the console
    or die ("Could not connect to server\n"); 

// pg_query 
$results = pg_query($con, $insert)
  // visualizza record appena inserito
  // or die
or die("Cannot execute query: $insert\n");

// results + go back
echo <<<HTML

<head>
<title>Pirro Nord: a WebGIS approach | Successfully update records!</title>
</head>
<body style="text-align: center;">
<h2>Success insert query for record <em>$codice</em>.</br>Click the button to go back to Data Entry page and go on...</h2>
<a href="data_entry.html">
    <style>
      a:link, a:visited{
      color: #0000FF;
      text-decoration: none;
      }
      a:active, a:hover{
      color: #000000;
      text-decoration: none;
      }
    </style>
 <button type="button" style="font-size: 100%; margin-top: 100px;">Go Back!</button>
</a>
</body>

HTML;

// close databae connection
pg_close($con);

?>