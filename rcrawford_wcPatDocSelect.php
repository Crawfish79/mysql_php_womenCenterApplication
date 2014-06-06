<!DOCTYPE html>
<html lang="en">
<head>
<title>WCDATABASE::REGISTRATION</title>
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
$risk = filter_input(INPUT_POST, "risk");
$risk = mysql_real_escape_string($risk);
$doctorID = filter_input(INPUT_POST, "DoctorID");
$doctorID = mysql_real_escape_string($doctorID);
$Query = filter_input(INPUT_POST, "query");
 $fieldNames = "";
$fieldValues = "";

foreach ($_REQUEST as $fieldName => $value){
  if ($fieldName == "tableName"){
    $theTable = $value;
  } else {
    
    $fieldName = mysql_real_escape_string($fieldName);
    $value = mysql_real_escape_string($value);
    
    $fields[] = $fieldName;
    $values[] = $value;
  } // end if
} // end foreach

//retrieve data
$tableName = filter_input(INPUT_POST, "tableName");
$tableName = mysql_real_escape_string($tableName);
$risk = filter_input(INPUT_POST, "risk");
$risk = mysql_real_escape_string($risk);



print docSel ($theTable,$tableName,$risk, $fields, $values,$doctorID,$Query);

print foot();

?>

</body>
</html> 