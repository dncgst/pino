<?php
       // l'array superglobale chiamato $_FILES contiene un elemento con la chiave con lo stesso nome del campo <input> del file HTML (points). Il suo valore è di per sè un array contenente le informazioni sul file caricato: <name>, <type>, <tmp_name>, <error>, <size>.

if ($_FILES['points']['type'] != 'text/csv') {
  echo "Check the format of the file! Please upload <em>CSV</em> file.</br>\n";
} else {

if ($_FILES['points']['error'] == 'UPLOAD_ERR_OK') {

	 /* codici di error per i file caricati:
	    UPLOAD_ERR_OK,
	    UPLOAD_ERR_INI_SIZE,
	    UPLOAD_ERR_FORM_SIZE,
	    UPLOAD_ERR_PARTIAL,
	    UPLOAD_ERR_NO_FILE,
	    UPLOAD_ERR_NO_TMP_DIR
	 */

	   $ext = strtolower(pathinfo($_FILES['points']['name'], PATHINFO_EXTENSION));
	   switch($ext)
	     {
	     case 'csv':
	       break;
	     default:
	       throw new InvalidFileTypeException($ext);
	     }

	   $destfile = "/home/dncgst/public_html/pino/upload/" . basename($_FILES['points']['name']);
	   $ret = move_uploaded_file($_FILES['points']['tmp_name'], $destfile);
	   
	   if ($ret === FALSE) {
	     echo "Unable to move CSV file! Please try again and report this error to the Webmaster.<br/>\n";	     
	   } else {
	     //	       echo "Moved CSV file to upload directory!<br/>\n";
	   }

} else {

	   switch($_FILES['points']['error'])
	     {
	     case UPLOAD_ERR_INI_SIZE:
	     case UPLOAD_ERR_FORM_SIZE:
	       throw new FileSizeException();
	       break;

	     case UPLOAD_ERR_PARTIAL:
	       throw new IncompleteUploadException();
	       break;

	     case UPLOAD_ERR_NO_FILE:
	       throw new NoFileReceivedException();
	       break;

	     case UPLOAD_ERR_NO_TMP_DIR:
	       throw new InternalError('No upload directory');
	       break;

	     default:
	       echo "<em>WARNING!</em> Don't known error code! Please, contact webmaster at <a href='mailto:info@gnewarchaeology.it'>info@gnewarchaeology.it</a>";
	       break;
	     }
	 }
};

// connections string variables
$host = "localhost"; 
$user = "dncgst"; 
$pass = "gnewpost"; 
$db = "p13"; 

// database connection
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
  // if the connection could not be created the die() function terminates the script and prints an error message to the console
    or die ("Could not connect to server\n"); 

// SQL query definition
$upload = "COPY points (codice,x,y,z) FROM '$destfile' WITH DELIMITER AS ',' CSV HEADER ENCODING 'utf-8';";

// pg_query 
$results = pg_query($con, $upload)
  or die("Cannot execute query: $upload\n");

// conferma query
//echo "Uploaded points!</br>\n";

// SQL update geometry
$update = "UPDATE points SET geom = ST_SetSRID(ST_MakePoint(x,y,z), -1);";

// pg_update_query
$con2 = pg_connect("host=$host dbname=$db user=$user password=$pass", PGSQL_CONNECT_FORCE_NEW);
$rs = pg_query($con2, $update)
  or die("Cannot execute query: $update\n");

// if it's all OK, go back to data entry page!
echo <<<HTML

<head>
<title>Pirro Nord: a WebGIS approach | Successfully update points!</title>
</head>
<body style="text-align: center;">
<h2>Success update query for points. Now you can properly entry data for new records.</br>Click the button to go back to Data Entry page and go on...</h2>
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