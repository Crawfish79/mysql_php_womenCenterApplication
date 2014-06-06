<!DOCTYPE html>
<html lang="en">
<head>
<title>WCDATABASE::OPERATIONS</title>
<?php include "rcrawford_wcLib.php"; ?>
<meta charset="utf-8">
<link href="wcStyle.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php 

print head();

$db = dbConnect();

$tableName = filter_input(INPUT_POST, "tableName");
$tableName = mysql_real_escape_string($tableName);
  
  print tToEdit("$tableName");

print foot();

?>

