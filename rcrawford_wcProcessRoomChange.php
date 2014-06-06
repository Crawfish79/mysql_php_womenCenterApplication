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

$keyNameR = filter_input(INPUT_POST, "keyNameR");
$keyNameR = mysql_real_escape_string($keyNameR);
$keyValR = filter_input(INPUT_POST, "keyValR");
$keyValR = mysql_real_escape_string($keyValR);
$keyNameP = filter_input(INPUT_POST, "keyNameP");
$keyNameP = mysql_real_escape_string($keyNameP);
$keyValP = filter_input(INPUT_POST, "keyValP");
$keyValP = mysql_real_escape_string($keyValP);
$currentRoomID = filter_input(INPUT_POST, "currentRoomID");
$currentRoomID = mysql_real_escape_string($currentRoomID);

print procRoomChange($keyNameR,$keyValR,$keyNameP,$keyValP,$currentRoomID);

print foot();

?>