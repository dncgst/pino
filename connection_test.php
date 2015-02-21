<?php

// connection
require './connection.php';

// SQL query definition
$query = "SELECT COUNT(*) FROM records";

// query
$rs = pg_exec($query)
  // visualizza record appena inserito
  // or die
or die("Cannot execute query: $query\n");

// result
// $fetch = pg_fetch_row($rs);
echo $rs;

// close connectioon
pg_close($con);

?>