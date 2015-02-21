<! doctype html>
<!-- data_export.php
     Data Export page of the 'Pirro Nord: a WebGIS approach' project | PiNo -->

<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="data_export.css">
  <title>Pirro Nord: a WebGIS approach | Data Export</title>
  <meta charset="utf-8">
  <meta name="application-name" content="PiNo">
  <meta name="author" content="Domenico Giusti <dncgst@gnewarchaeology.it>">
  <meta name="description" content="PiNo Data Export">
  <meta name="generator" content="GNU Emacs 23.4.1" >
  <meta name="keywords" content="Pirro Nord, PiNo, Data Export">
  <meta http-equiv="Refresh" content="300">
</head>
<body>
  <!-- header -->
  <header>
    <!-- Logo -->
    <h1><a href="home.html"><img id="top" src="images/pirro.jpg" alt="Pirro Nord WebGIS" width="100%" height="150"></a></h1>
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
    <h2><em>PiNo</em> Data Export</h2>
    <!-- search form -->
    <p>Please, select the features of the records for which you want to export information in CSV format.</p>
    <form id="select" enctype="text/plain" action="data_export.php" method="REQUEST">
   <input type="hidden" name="redirect" value="data_export.php"/>
   <ul>
   <fieldset>
   <legend>Search records</legend>
   <!-- Data -->
   <li>
    <label for="data">Data:</label>
    <input type="text" name="data" id="data" value=""/>
   </li>
   <!-- Q -->
   <li>
    <label for="q">Q:</label>
    <input type="text" name="q" id="q" value=""/>
   </li>
   <!-- US -->
   <li>
    <label for="us">US:</label>
    <input type="text" name="us" id="us" value=""/>
   </li>
   <!-- Taglio -->
   <li>
    <label for="taglio">Taglio:</label>
    <input type="text" name="taglio" id="taglio" value=""/>
   </li>
   <!-- Descrizione -->
   <li>
   <label for="desc">Descrizione:</label>
    <select name="descrizione" id="desc"/>
     <option value="">Select type of record</option>
     <option value="OSSO">OSSO</option>
     <option value="DENTE">DENTE</option>
     <option value="SELCE">SELCE</option>
     <option value="PIETRA">PIETRA</option>
    </select>
   </li>
   </fieldset></br>
   <input type="submit" name="submit" value="Search"/><input type="submit" name="refresh" value="Refresh"/></br>
   </ul>
   </form>

   <!-- Dump button -->

<!-- direct button to data_dump_sql.php   
<p>Or dump the database structure and the full set of data in SQL format.</p>
   <a href="data_dump_sql.php"><button id="dump_sql" type="button" style="margin-left: 50px;">Dump SQL</button></a></br></br>
-->

   <!-- form button. if clicked write _tmp_pino_dump.sql → data_dump_sql.php 
   <form id="dump" enctype="text/plain" action="data_export.php" method="REQUEST">
   <input type="hidden" name="redirect" value="data_export.php"/>
   <ul>
   <input type="submit" name="sql_dump" value="SQL Dump"/></br>
   </ul>
   </form>

<!-- php section -->

<?php

// if click on submit	
if (isset($_REQUEST['submit'])) { 

// check if $_REQUEST is not NULL and write the query

// if Q
if (isset($_REQUEST['q']) and strlen($_REQUEST['q']) > 0) {
  $g_q = strtoupper($_REQUEST['q']);
  $query = "WHERE q LIKE '".$g_q."'";
}

// if US
if (isset($_REQUEST['us']) and strlen($_REQUEST['us']) > 0) {
  $g_us = strtoupper($_REQUEST['us']);
  if (strlen($query) > 0) {
      $query = $query.' AND ';
    } else {
    $query = $query.'WHERE ';
  }
  $query = $query."us LIKE '".$g_us."'";
}

// if Taglio
if (isset($_REQUEST['taglio']) and strlen($_REQUEST['taglio']) > 0) {
  $g_taglio = strtoupper($_REQUEST['taglio']);
  if (strlen($query) > 0) {
      $query = $query.' AND ';
    } else {
    $query = $query.'WHERE ';
  }
  $query = $query."taglio LIKE '".$g_taglio."'";
}

// if Descrizione
if (isset($_REQUEST['descrizione']) and strlen($_REQUEST['descrizione']) > 0) {
  $g_desc = $_REQUEST['descrizione'];
  if (strlen($query) > 0) {
      $query = $query.' AND ';
    } else {
    $query = $query.'WHERE ';
  }
  $query = $query."descrizione LIKE '".$g_desc."'";
}

// add if Data!
if (isset($_REQUEST['data']) and strlen($_REQUEST['data']) > 0) {
  $g_data = $_REQUEST['data'];
  if (strlen($query) > 0) {
      $query = $query.' AND ';
    } else {
    $query = $query.'WHERE ';
  }
  $query = $query."data LIKE '".$g_desc."'";
}

// if $query is not NULL do.. SQL query definition
if (isset($query)) {
    $select = "SELECT * FROM records $query ORDER BY codice;";
    $select2 = "SELECT * FROM records $query ORDER BY codice";

// connections string variables → sostituire con connect.php
$host = "localhost"; 
$user = "dncgst"; 
$pass = "gnewpost"; 
$db = "p13";

// database connection
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
  // if the connection could not be created the die() function terminates the script and prints an error message to the console
    or die ("Could not connect to server\n");

// pg_query 
$rs = pg_query($con, $select)
  or die("Cannot execute query: $select\n");

// The pg_affected_rows() function returns the number of rows affected by the last SQL statement
$ar = pg_affected_rows($rs);

if ($ar === 0) {
  echo "The selection doesn't exist. Please select correct fields.</br></br>";
} else {
echo <<<HTML
<p>The query has affected <em>$ar</em> rows for Q:<em>$g_q</em> US:<em>$g_us</em> Taglio:<em>$g_taglio</em> Descrizione:<em>$g_desc</em></p>
HTML;

// print query
echo "SQL query: $select";
echo "</br></br>";

// copy query definition
$con2 = pg_connect("host=$host dbname=$db user=$user password=$pass", PGSQL_CONNECT_FORCE_NEW);
$file = "/tmp/pino_export.csv";
$copy = "COPY ($select2) TO '$file' (FORMAT csv, DELIMITER ',', HEADER TRUE, ENCODING 'utf-8');";

// cp_query 
$cp = pg_query($con2, $copy)
  or die(pg_last_error($con2));

// export csv button
echo <<<HTML
<a href="data_export_download.php"><button id="download" type="button" style="margin-left: 50px;">Download</button></a></br></br>
HTML;

// html table open/thead
echo <<<HTML
<table id="records">
      <caption>Records</caption>
      <thead>
	<tr>
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

// export csv button
echo <<<HTML
<a href="data_export_download.php"><button id="download" type="button" style="margin-left: 50px;">Download</button></a>
HTML;

// top button
echo <<<HTML
<a href="#top" target="_top"><button type="button" style="float: right; margin-right: 60px;">Top</button></a></br></br>
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