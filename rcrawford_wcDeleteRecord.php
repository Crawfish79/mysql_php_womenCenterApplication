<!DOCTYPE html>
<html lang="en">
<head>
<title>WCDATABASE::DELETE</title>
<?php include "rcrawford_wcLib.php"; ?>
<meta charset="utf-8">
<link href="wcStyle.css" rel="stylesheet" type="text/css">
</head>
<body>


<?php

print head();

 $db = dbConnect();

//retrieve data
$tableName = filter_input(INPUT_POST, "tableName");
$keyName = filter_input(INPUT_POST, "keyName");
$keyVal = filter_input(INPUT_POST, "keyVal");
$tableName = mysql_real_escape_string($tableName);
$keyName = mysql_real_escape_string($keyName);
$keyVal = mysql_real_escape_string($keyVal);


print delRec($tableName, $keyName, $keyVal);

print foot();

?>


</body>
</html> 
