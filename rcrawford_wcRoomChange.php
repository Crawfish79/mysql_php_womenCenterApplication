<!DOCTYPE html>
<html lang="en">
<head>
<title>WCDATABASE::ROOM CHANGE</title>
<?php include "rcrawford_wcLib.php"; ?>
<meta charset="utf-8">
<link href="wcStyle.css" rel="stylesheet" type="text/css">
</head>
<body>


<?php
print head(); 

 $db = dbConnect();
 
 $keyName = filter_input(INPUT_POST, "keyName");
$keyName = mysql_real_escape_string($keyName);
$keyValue = filter_input(INPUT_POST, "keyVal");
$keyValue = mysql_real_escape_string($keyValue);
$roomID = filter_input(INPUT_POST, "roomID");
$roomID = mysql_real_escape_string($roomID);

print roomChange($keyName, $keyValue,$roomID); 

print foot();

?>


</body>
</html> 
