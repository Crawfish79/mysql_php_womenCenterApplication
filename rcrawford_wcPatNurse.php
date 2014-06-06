<!DOCTYPE html>
<html lang="en">
<head>
<title>WCDATABASE::ASSIGNED NURSES</title>
<?php include "rcrawford_wcLib.php"; ?>
<meta charset="utf-8">
<link href="wcStyle.css" rel="stylesheet" type="text/css">
</head>
<body>


<?php

print head(); 

 $db = dbConnect();
 
$roomID = filter_input(INPUT_POST, "roomID");
$roomID = mysql_real_escape_string($roomID);

  print patNurseView("$roomID");


print foot();

?>


</body>
</html> 