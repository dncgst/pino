<?php

//set us, q, n
$taglio = "c5";
$q = "a1";
$n = "s01";

// build codice
$codice = $taglio . $q . $n;

// echo codice
echo $codice;
echo "</br>";

// build us
$us = substr($taglio, 0, 1);

// echo us
echo $us;

?>