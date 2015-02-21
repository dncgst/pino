<?php

// csv file export from data_export.php
$file = "/tmp/pino_export.csv";

// headers
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$file");
header("Pragma: no-cache");
header("Expires: 0");

//
readfile($file);

?>