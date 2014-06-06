<!DOCTYPE html>
<html lang="en">
<head>
<title>WCDATABASE::VIEWS</title>
<?php include "rcrawford_wcLib.php"; ?>
<meta charset="utf-8">
<link href="wcStyle.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php 


print head();

$db = dbConnect();
//get $queryID from previous form
$queryID = filter_input(INPUT_POST, "queryID");
$queryID = mysql_real_escape_string($queryID);
//use the queryID to get the requested query from the database
$sql = "SELECT * FROM RcrawfordStoredQueriesWC WHERE StoredQueryID = $queryID";
$result = mysql_query($sql,$db) or die (mysql_error());
$row = mysql_fetch_assoc($result);
$description = $row["Description"];
$theQuery = $row["Text"];
//print "Query: $theQuery";
print theTable($theQuery, $description);

print foot();

?>


</body>
</html> 
