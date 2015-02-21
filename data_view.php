<! doctype html>
<!-- data_view.html
     Data View page of the 'Pirro Nord: a WebGIS approach' project | PiNo -->

<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="data_view.css">
  <title>Pirro Nord: a WebGIS approach | Data View</title>
  <meta charset="utf-8">
  <meta name="application-name" content="PiNo">
  <meta name="author" content="Domenico Giusti <dncgst@gnewarchaeology.it>">
  <meta name="description" content="PiNo Data View">
  <meta name="generator" content="GNU Emacs 23.4.1" >
  <meta name="keywords" content="Pirro Nord, PiNo, Data View">
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
    <h2><em>PiNo</em> Data View</h2>
    <!-- search form -->
    <p>Please, type the code of the record for which you want to display information. Test: A09B6S02</p>
    <form id="view" enctype="text/plain" action="data_view.php" method="REQUEST">
      <input type="hidden" name="redirect" value="data_view.php"/>
      <ul>
	<fieldset>
	  <legend>Search record</legend>
	  <li>
	    <label for="codice">Codice:</label>
	    <input type="text" name="codice" id="codice" value=""/>
	  </li>
	</fieldset></br>
	<input type="submit" name="submit" value="Search"/><input type="submit" name="refresh" value="Refresh"/></br>
      </ul>
    </form>

<!-- php section -->

<?php

// if click on submit	
if (isset($_REQUEST['submit'])) {

// check if $_REQUEST is not NULL and write the query
if (isset($_REQUEST['codice']) and strlen($_REQUEST['codice']) > 0) {
  $codice = strtoupper($_REQUEST['codice']);

// SQL query definition (records JOIN points)
  $join = "SELECT p.x, p.y, p.z, r.* FROM records r JOIN points p USING (codice) WHERE codice LIKE '$codice'";

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
  echo "Information for record: <em>$codice</em></br></br>";

// copy query definition
$con2 = pg_connect("host=$host dbname=$db user=$user password=$pass", PGSQL_CONNECT_FORCE_NEW);
$file = "/tmp/pino_view.csv";
$copy = "COPY ($join) TO '$file' (FORMAT csv, DELIMITER ',', HEADER TRUE, ENCODING 'utf-8');";

// cp_query 
$cp = pg_query($con2, $copy)
  or die(pg_last_error($con2));

// export csv button
echo <<<HTML
<a href="data_view_download.php"><button id="download" type="button" style="margin-left: 50px;">Download</button></a></br></br>
HTML;

// html table open/thead
echo <<<HTML
<table id="record">
      <caption>Record</caption>
      <thead>
	<tr>
	  <th scope="col">X</th>
	  <th scope="col">Y</th>
	  <th scope="col">Z</th>
	  <th scope="col">Codice</th>
	  <th scope="col">Data</th>
	  <th scope="col">Q</th>
	  <th scope="col">US</th>
	  <th scope="col">Taglio</th>
	  <th scope="col">N</th>
	  <th scope="col">Descrizione</th>
	  <th scope="col">O</th>
	  <th scope="col">P</th>
	  <th scope="col">L</th>
	  <th scope="col">l</th>
	  <th scope="col">s</th>
	  <th scope="col">Oss</th>
	</tr>
      </thead>
      <tbody>
HTML;

// The pg_fetch_assoc() function fetches a row as an associative array. The keys of the associative array are the column names
while ($row = pg_fetch_assoc($rs)) {

  echo "\t<tr>\n";
  foreach ($row as $col_value) {
    echo "\t\t<td>$col_value</td>\n";
  }
  echo "\t</tr>\n";

}

// html table close/tbody
echo <<<HTML
</tbody>
</table></br></br>
HTML;

// free resultset
pg_free_result($rs);

// close database connection
pg_close($con);

}

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