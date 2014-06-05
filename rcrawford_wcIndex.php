<!DOCTYPE html>
<html lang="en">
<head>
<title>WCDATABASE::HOME</title>
<?php include "rcrawford_wcLib.php"; ?>
<meta charset="utf-8">
<link href="wcStyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php print head(); ?>
<p style = 'color:red;'>*view nurses for each patient from 'patients checked in' view*</p><br>
			<div id = "form1">
				<form method = "post" action = "rcrawford_wcEditTable.php">
					<fieldset>
						<legend>INTERNAL OPERATIONS</legend>
							<select name = "tableName"size = "4" required = "required">
								<option value = "RcrawfordPatient">Patient Operations</option>
								<option value = "RcrawfordDoctor">Doctors-C.U.D.</option>
								<option value = "RcrawfordNurse">Nurses-C.U.D.</option>
								<option value = "RcrawfordNurseAssignment">NurseAssign-C.U.D.</option>
								<option value = "RcrawfordStoredQueriesWC">Queries-C.U.D.</option>
							</select><br><br>   
						<input class = "submit" type = "submit" value = "GO>"> 
					</fieldset>
				</form>
			</div>	
			<div id = "form2">
				<form action = "rcrawford_wcViewQuery.php"method = "post">
					<fieldset>
						<legend>INTERNAL QUICK VIEWS</legend>
							<select name = "queryID" size = "4" required = "required">

<?php
 $db = dbConnect();

$sql = "SELECT * FROM RcrawfordStoredQueriesWC";
$result = mysql_query($sql,$db) or die (mysql_error());
while ($row = mysql_fetch_assoc($result)){
$selectedQuery = $row["StoredQueryID"];
$description = $row["Description"];
 print <<<HERE
      <option value = "$selectedQuery">$description</option> 
HERE;
  } // end while

?>
							</select><br><br>
						<input class = "submit" type = "submit" value = "GO>">
					</fieldset>
				</form>
			</div><!--end selection div-->
<?php print foot();?>

</body>
</html> 

