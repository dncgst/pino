<?php

// if click on update	
if (isset($_REQUEST['update'])) {
  
  //  include('data_edit_test.php');
  echo data_edit_test.php?code=$_GET['code'];

// results + go back
echo <<<HTML

<head>
<title>Pirro Nord: a WebGIS approach | Successfully update records!</title>
</head>
<body style="text-align: center;">
<h2>Success update query for record <em>$code</em>.</br>Click the button to go back to Data Edit page and go on...</h2>
<a href="data_edit_test.php">
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

}

?>