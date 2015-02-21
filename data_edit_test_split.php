<?php

// if click on update	
if (isset($_REQUEST[update])) {

  // _SERVER["HTTP_REFERER"]
  // http://localhost/~dncgst/pino/data_edit_test.php?redirect=data_edit_test.php&code=A09B6S02&submit=Search

  // debug
  echo data_edit_test.php?redirect=data_edit_test.php&code=$_GET['code'];

// set $_GET[code]
//  $code = strtoupper(data_edit_test.php?code=$_GET['code']);
//  $code = strtoupper(data_edit_test.php?redirect=data_edit_test.php&code=$_GET[code]);

// ampliare l'array REQUEST
//  $_REQUEST['code'] === $_GET['code'];
//  $codex = strtoupper($_REQUEST['code']);

// set request variables

  //  $codice = strtoupper($_REQUEST['codice']); not required!
  $data = strtoupper($_REQUEST['data']);
  $taglio = strtoupper($_REQUEST['taglio']);
  $q = strtoupper($_REQUEST['q']);
  //  $us = strtoupper($_REQUEST['us']); not required!
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
  echo $codex;
  echo "</br>";
echo phpinfo();

	// sample working query
	//UPDATE records SET (codice, data, q, us, taglio, n, descrizione, o, p, l_max, l_med, s_min, oss) = ('A09B6S02', '2012/11/24', 'B6', 'A', 'A09', 'S02', 'OSSO', 'NE/SW', 'SW', '34', '21', '18', 'ASTRAGALO') WHERE codice = 'A09B6S02';
				  
// SQL query definition (UPDATE)
$update = "UPDATE records SET (codice, data, q, us, taglio, n, descrizione, o, p, l_max, l_med, s_min, oss) = ('$codice', '$data', '$q', '$us', '$taglio', '$n', '$desc', '$o', '$p', '$l_max', '$l_med', '$s_min', '$oss') WHERE codice = '$code';";

// debug
echo $update;

/*
// connections string variables → sostituire con connect.php!
$host = "localhost"; 
$user = "dncgst"; 
$pass = "gnewpost"; 
$db = "p13";

// database connection
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
  // if the connection could not be created the die() function terminates the script and prints an error message to the console
    or die ("Could not connect to server\n");

// pg_query (UPDATE table records) 
$up = pg_query($con, $update)
  or die(pg_last_error($con));

// The pg_affected_rows() function returns the number of rows affected by the last SQL statement
//$ar = pg_affected_rows($rs);

// if error
  if (!$up) {
    echo "Update failed!";
  } else {
    echo "Update successfull!";
  }
*/
  
}

?>