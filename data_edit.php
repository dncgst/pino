<! doctype html>
<!-- data_edit.php
     Data View page of the 'Pirro Nord: a WebGIS approach' project | PiNo -->

<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="data_edit.css">
  <title>Pirro Nord: a WebGIS approach | Data View</title>
  <meta charset="utf-8">
  <meta name="application-name" content="PiNo">
  <meta name="author" content="Domenico Giusti <dncgst@gnewarchaeology.it>">
  <meta name="description" content="PiNo Data Edit">
  <meta name="generator" content="GNU Emacs 23.4.1" >
  <meta name="keywords" content="Pirro Nord, PiNo, Data Edit">
  <meta http-equiv="Refresh" content="300">
</head>
<body>
  <!-- header -->
  <header>
    <!-- Logo -->
    <h1><a href="home.html"><img src="images/pirro.jpg" alt="Pirro Nord WebGIS" width="100%" height="150"></a></h1>
  </header>
  <!-- aside/nav-->
  <aside>
    <h2>Menu</h2>
    <nav>
      <ul>
	<li><a href="data_entry.html"> Data Entry</a></li>
	<li><a href="data_edit.php">Data Edit</a></li>
	<li><a href="data_view.php">Data View</a></li>
	<li><a href="data_export.php">Data Export</a></li>
      </ul>
    </nav>
  </aside>
  <!-- section/search&view -->
  <section>
    <h2><em>PiNo</em> Data Edit</h2>
    <!-- search form -->
    <p>Please, type the code of the record for which you want to edit information. Test: A09B6S02</p>
    <form id="view" enctype="text/plain" action="data_edit.php" method="GET">
      <input type="hidden" name="redirect" value="data_edit.php"/>
      <ul>
	<fieldset>
	  <legend>Search record</legend>
	  <li>
	    <label for="codice">Codice:</label>
	    <input type="text" name="code" id="codice" value=""/>
	  </li>
	</fieldset></br>
	<input type="submit" value="Search"/><input type="submit" value="Refresh"/></br>
      </ul>
    </form>

<!-- php section -->

<?php

// check if $_REQUEST is not NULL and write the query
if (isset($_GET['code']) and strlen($_GET['code']) > 0) {
  $code = strtoupper($_GET['code']);

// SQL query definition (records JOIN points)
  $join = "SELECT * FROM records WHERE codice LIKE '$code'";

// connections string variables → sostituire con connect.php!
$host = "localhost"; 
$user = "dncgst"; 
$pass = "gnewpost"; 
$db = "p13";

// database connection
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
  // if the connection could not be created the die() function terminates the script and prints an error message to the console
    or die ("Could not connect to server\n");

// pg_query (records JOIN points) 
$rs = pg_query($con, $join)
  or die("Cannot execute query: $join\n");

// The pg_affected_rows() function returns the number of rows affected by the last SQL statement
$ar = pg_affected_rows($rs);

if ($ar === 0) {
    echo "The selected code doesn't exist. Please select a correct code.";
  } else {
  echo "Information for record: <em>$code</em></br></br>";

// The pg_fetch_assoc() function fetches a row as an associative array. The keys of the associative array are the column names
while ($row = pg_fetch_assoc($rs)) {
  
  // record form
echo "<p>Now you can update information regarding the record.</p>
  <form id='edit' enctype='text/plain' action='data_edit.php' method='REQUEST'>
   <input type='hidden' name='redirect' value='data_edit.php'/>
    <ul>
        <fieldset>
         <legend>Base information</legend>
	  <li>
	    <label for='codice'>Codice:</label>
	    <input type='text' name='codice' id='codice' value='$row[codice]' required/>
	  </li>
	  <li>
	    <label for='data'>Data:</label>
	    <input type='date' name='data' id='data' value='$row[data]' required/>
	  </li>
	  <li>
	    <label for='q'>Q:</label>
	    <input type='text' name='q' id='q' value='$row[q]' required/>
	  </li>
	  <li>
	    <label for='us'>US:</label>
	    <input type='text' name='us' id='us' value='$row[us]' required/>
	  </li>
	  <li>
	    <label for='taglio'>Taglio:</label>
	    <input type='text' name='taglio' id='taglio' value='$row[taglio]' required/>
	  </li>
	  <li>
	    <label for='n'>N:</label>
	    <input type='text' name='n' id='n' value='$row[n]' required/>
	  </li
	  <li>
	     <label for='desc'>Descrizione:</label>
	     <select name='descrizione' id='desc' required/>
<--	     
<option value='$row[descrizione]'></option>
-->
	     <option value=''>Select new type of record</option>
	     <option value='OSSO'>OSSO</option>
	     <option value='DENTE'>DENTE</option>
	     <option value='SELCE'>SELCE</option>
	     <option value='PIETRA'>PIETRA</option>
             </select>
          </li>
        </fieldset></br>
        <fieldset>
	  <legend>Fabric information</legend>
          <li>O:
	    <table>
	      <tr>
		<td id='na' colspan='4'>
		  <label for='na'>[NA]</label> <input type='radio' name='o' id='na' value='NA' checked='checked'>
		</td>
	      </tr>
	      <tr>
		<td>
		  <label for='n/s'>N/S</label> <input type='radio' name='o' id='n/s' value='N/S'/>
		</td>
		<td>
		  <label for='ne/sw'>NE/SW</label> <input type='radio' name='o' id='ne/sw' value='NE/SW'/>
		</td>
		<td>
		  <label for='e/w'>E/W</label> <input type='radio' name='o' id='e/w' value='E/W'/>
		</td>
		<td>
		  <label for='nw/se'>NW/SE</label> <input type='radio' name='o' id='nw/se' value='NW/SE'/>
		</td>
	      </tr>
	  </li>
	  </table>
	  <li>P:
	    <table>
	      <tr>
		<td id='na' colspan='8'>
		  <label for='na'>[NA]</label> <input type='radio' name='p' id='na' value='NA' checked='checked'/>
		</td>
	      </tr>
	      <tr>
		<td>
		  <label for='n'>N</label> <input type='radio' name='p' id='n' value='N'/>
		</td>
		<td>
		  <label for='ne'>NE</label> <input type='radio' name='p' id='ne' value='NE'/>
		</td>
		<td>
		  <label for='e'>E</label> <input type='radio' name='p' id='e' value='E'/>
		</td>
		<td>
		  <label for='se'>SE</label> <input type='radio' name='p' id='se' value='SE'/>
		</td>
		<td>
		  <label for='s'>S</label> <input type='radio' name='p' id='s' value='S'/>
		</td>
		<td>
		  <label for='sw'>SW</label> <input type='radio' name='p' id='sw' value='SW'/>
		</td>
		<td>
		  <label for='w'>W</label> <input type='radio' name='p' id='w' value='W'/>
		</td>
		<td>
		  <label for='nw'>NW</label> <input type='radio' name='p' id='nw' value='NW'/></br>
		</td>
	      </tr>
	      <tr>
		<td>
		  <label for='p'>P</label> <input type='radio' name='p' id='p' value='P'/>
		</td>
		<td>
		  <label for='VL'>VL</label> <input type='radio' name='p' id='VL' value='VL'/>
		</td>
		<td>
		  <label for='Vl'>Vl</label> <input type='radio' name='p' id='Vl' value='Vl'/>
		</td>
		<td>
		  <label for='Vs'>Vs</label> <input type='radio' name='p' id='Vs' value='Vs'/>	  
		</td>
	      </tr>
	  </li>
	  </table>
	</fieldset></br>
	<fieldset>
	  <legend>Dimension information</legend>
	  <li>
	    <label for='l_max'>L:</label>
	    <input type='text' name='l_max' id='l_max' value='$row[l_max]' required/>
	  </li>
	  <li>
	    <label for='l_med'>l:</label>
	    <input type='text' name='l_med' id='l_med' value='$row[l_med]' required/>
	  </li>
	  <li>
	    <label for='s_min'>s:</label>
	    <input type='text' name='s_min' id='s_min' value='$row[s_min]' required/>
	  </li>
	</fieldset></br>
	<fieldset>
	  <legend>Observations</legend>
	  <label for='oss'>Osservazioni:</label>
	    <textarea name='oss' id='oss' cols='40' rows='2' pattern='[A-Z][0-9]' value='$row[oss]'></textarea>
	</fieldset></br>
	<input type='submit' name='update' value='Update'/>
</ul>
</form>
";

} if (isset($_REQUEST['update'])) {

  // set request variables
  $codice = strtoupper($_REQUEST['codice']);
  $data = strtoupper($_REQUEST['data']);
  $q = strtoupper($_REQUEST['q']);
  $us = strtoupper($_REQUEST['us']);
  $taglio = strtoupper($_REQUEST['taglio']);
  $n = strtoupper($_REQUEST['n']);
  $desc = strtoupper($_REQUEST['descrizione']);
  $o = strtoupper($_REQUEST['o']);
  $p = strtoupper($_REQUEST['p']);
  $l_max = strtoupper($_REQUEST['l_max']);
  $l_med = strtoupper($_REQUEST['l_med']);
  $s_min = strtoupper($_REQUEST['s_min']);
  $oss = strtoupper($_REQUEST['oss']); 

  // update query
  //$con2 = pg_connect("host=$host dbname=$db user=$user password=$pass", PGSQL_CONNECT_FORCE_NEW);
  $update = "UPDATE records SET (codice, data, q, us, taglio, n, descrizione, o, p, l_max, l_med, s_min, oss) = ('$codice', '$data', '$q', '$us', '$taglio', '$n', '$desc', '$o', '$p', '$l_max', '$l_med', '$s_min', '$oss') WHERE codice = '$code';";
  $up = pg_query($con, $update)
  or die(pg_last_error($con));
  
  // echo
  echo pg_last_error($con2);
    
  // if error
  if (!$up) {
    echo "Update failed!";
  } else {
    echo "Update successfull!";
  }
  
}

  // free resultset
  pg_free_result($rs);

  // close database connection
  pg_close($con);

  // top button
  echo "<a href='#top' target='_top'><button type='button' style='margin-left: 50px;'>Top</button></a></br></br>";

}

}

?>

  </section>

  <!-- footer -->
  <footer>
    <address>
      <p>To report a problem or to suggest improvements with <em>PiNo</em> e-mail <a href="mailto:info@gnewarchaeology.it">info@gnewarchaeology.it</a>. <em>PiNo</em> source code is copyleft available <a href="https://github.com/dncgst/pirronord.p13">here</a>.</p>
    </address>
    <nav>
      <p>
	<a href="about.html">About</a>
	<a href="credits.html">Credits</a>
	<a href="tos.html">Terms of Service</a>
      </p>
    </nav>
  </footer>
</body>
</html>