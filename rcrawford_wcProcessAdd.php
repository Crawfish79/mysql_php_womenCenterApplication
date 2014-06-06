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

 $db = dbConnect();

print head();

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

print procAdd($theTable, $fields, $values);

print foot();

?>



</body>
</html> 