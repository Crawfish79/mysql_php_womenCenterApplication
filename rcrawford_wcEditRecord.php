<!DOCTYPE html>
<html lang="en">
<head>
<title>WCDATABASE::EDIT</title>
<?php include "rcrawford_wcLib.php"; ?>
<meta charset="utf-8">
<link href="wcStyle.css" rel="stylesheet" type="text/css">
</head>
<body>


<?php

print head();

 $db = dbConnect();

$tableName = filter_input(INPUT_POST, "tableName");
$keyName = filter_input(INPUT_POST, "keyName");
$keyVal = filter_input(INPUT_POST, "keyVal");

$tableName = mysql_real_escape_string($tableName);
$keyName = mysql_real_escape_string($keyName);
$keyVal = mysql_real_escape_string($keyVal);

$query = "SELECT * FROM $tableName WHERE $keyName = $keyVal";

print rToEdit($query);

print foot();

?>



</body>
</html> 