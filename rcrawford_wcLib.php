<?php

//DECLARING VARIABLES FOR USE IN DATABASE CONNECTION======================================================================================================================================================
$dbhost = "host";//database host
$dbuser = "user";//user name.
$dbpassword = "psswd";//password.
$dbdatabase = "database";//database to be used  

function dbConnect(){ //MAKING DATABASE CONNECTION FUNCTION===========================================================================================================================================/
 global $dbhost, $dbuser, $dbpassword, $dbdatabase;
$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die (mysql_error());//connection to mysql environment.. using database host, user name, and password.. gives error mssg if fails
 mysql_select_db($dbdatabase, $db);//selecting the database from the connected environment
 return $db;
 }

 function head(){ //HEADER FOR ALL PAGES================================================================================================================================================================/
 
  $output = "";
  
$output .= <<<HERE

	<div id="container">
	<div id="nav">  
	<a href="rcrawford_wcIndex.php">Home</a><a href="rcrawford_wcProgramDetails.php">Program Details</a>  <a href="">Contact</a>       	   
	</div><!--end nav div-->
	<a href="rcrawford_wcIndex.php"><img id = "titlepic" src="northsidepic.png" /></a>
	<div id="header">
	<h1>Women's Center</h1>
	<img id = "kidpic" src="wcpic.png"/>
	</div> <!--end header div--><br><br>
	<div id = "content">
	<h3>Administrative Control Interface-General</h3><hr><br>

HERE;

return $output;
 
 }

 function foot(){//FOOTER FOR ALL PAGES==================================================================================================================================================================/
 
  $output = "";
  
$output .= <<<HERE

	</div><!--end content div-->
	<div id = "footer"><br><br>
	<center><label for = "help">Database Administrator Help</label><input id = "help" type = "submit" value = "?"></center>
	<h4>CRAWFISH<h4>
	</div><!--end foot div-->
	</div><!--end container div-->

HERE;

return $output; 
 
 }
 
function theTable($sql, $description){//FUNCTION TO DISPLAY QUERY RESULTS================================================================================================================================/

 global $db;
 $output = "";
		
		$results = mysql_query($sql,$db)  or die (mysql_error());//passing sql command through a connection to a database.. gives error mssg if fails
		//table is scrollable.-contains 3 tables and a div-fixed header and description width
		$output  .= "<table style = 'background-color:#1E90FF;border-radius:0px 0px 1px1px;box-shadow: 2px 2px 2px #686868;margin:auto;'>\n";//main table
		$output  .= "<caption>$description</caption>\n";				
		$output  .= "<tr><td>\n";
		$output  .= "<table  style= 'margin-right:18px;'><tr>\n";//header table
		$output  .= "<tr>\n";	
		while ($field = mysql_fetch_field($results)){//retrieving field information from query
			$output  .= "<th style = 'color:white;background-color:#1E90FF;width:100px;'>$field->name</th>\n";
		}//end while
		$output  .= "</tr></table></td></tr>\n";//header table closed
		$output  .= "<tr><td>\n";
		$output  .= "<div style= 'width:100%; max-height:200px; overflow:auto;background-color:white;'>\n";//div creates scrollable content for enclosed table
		$output  .= "<table>\n";//description table	
		$i=0;	//variable used for alternating row color	
		while ($row = mysql_fetch_assoc($results)){//retrieves each record from results and stores it in an associative array
					if ($description == 'Patients Checked In'){$roomID = $row['RoomID'];}
			$output  .= "<tr>\n";
			foreach($row as $col=>$val){
			         if ($i % 2 == 1)//alternating row colors
						 {$output  .= "<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'>$val</td>\n";}
				else
						{ $output  .= "<td style = 'width:100px;height:40px;background-color:#FAEBD7;'>$val</td>\n";}
			}//end foreach
			if ($description == 'Patients Checked In'){
				$color;
				if ($i % 2 == 1){$color = "#72A0C1";}else{$color = "#FAEBD7";}
$output .= <<< HERE
  <td style = 'width:75px;height:40px;background-color:$color;color:white;'>
    <form action = "rcrawford_wcPatNurse.php" method = "post" style="margin: 0; text-align: center;"> 
    <input type= "hidden" name = "roomID" value = "$roomID" />
    <button class = "submit2" type = "submit">NURSES </button>
  </form>
  </td>
HERE;
			
			
			}
			
			$i++;
			$output  .= "</tr>\n\n";
		}//end while
$output  .= "</table></div></td></tr><tr><td style= 'height:20px;'></td></tr></table>\n";//description table closed, div closed, main table closed
return $output;
}

function patNurseView($room){//DISPLAYS NURSES FOR EACH PATIENT CHECKED IN============================================================================================================================/

  global $db;
  $output = "";
  
  //process a query just to get field names
  $query = "SELECT n.NurseID, n.NurseName, na.RoomID, na.ShiftID,n.ManagerID FROM rcrawfordNurseAssignment na, rcrawfordNurse n WHERE n.NurseID = na.NurseID AND na.RoomID = $room";
  
   $output .= theTable($query, 'Nurses [Room ' . $room . ']');
   
   return $output;
}

function tToEdit($tableName){//INSERT, UPDATE, DELETE CONTROLS=========================================================================================================================================/
  //given a table name, generates HTML table including
  //add, delete and edit buttons
  
  $tableName = filter_input(INPUT_POST, "tableName");
  $tableName = mysql_real_escape_string($tableName);
  
  global $db;
  $output = "";
  $query = "SELECT * FROM $tableName";

  $result = mysql_query($query, $db);

		$output  .= "<table style = 'background-color:#1E90FF;border-radius:0px 0px 1px 1px;box-shadow: 2px 2px 2px #686868;margin:auto;'>\n";
		$output  .= "<caption>$tableName</caption>\n";		
		$output  .= "<tr><td>\n";
		$output  .= "<table  style= 'margin-right:18px;'><tr>\n";
		$output  .= "<tr>\n";	 

  //get field names
  while ($field = mysql_fetch_field($result)){
  if  ($tableName == 'RcrawfordStoredQueriesWC')//checking condition in order to adjust th wiidth to match td width for large queries to fit and for aesthetics
	  { $output .= "  <th style = 'color:white;background-color:#1E90FF;width:200px;'>$field->name</th>\n";}
  else
      { $output .= "  <th style = 'color:white;background-color:#1E90FF;width:100px;'>$field->name</th>\n";}
  } // end while

  //get name of index field (presuming it's first field)
  $keyField = mysql_fetch_field($result, 0);
  $keyName = $keyField->name;
  
  //add empty columns for add, edit, and delete
        $output .= "<th style = 'color:white;background-color:#1E90FF;width:75px;'>-</th><th style = 'color:white;background-color:#1E90FF;width:75px;'>-</th>\n";
		$output  .= "</tr></table></td></tr>\n";
		$output  .= "<tr><td>\n";
		$output  .= "<div style= 'width:100%; height:200px; overflow:auto;background-color:white;'>\n";
		$output  .= "<table>\n";	
		$i=0;		
  //get row data as an associative array
  while ($row = mysql_fetch_assoc($result)){
    $output .= "<tr>\n";
    //look at each field
    foreach ($row as $col=>$val){
			         if ($i % 2 == 1)//checking if rows are odd or even and using alternating colors
						 {
						   if  ($tableName == 'RcrawfordStoredQueriesWC')//have to adjust fixed width in order to fit large queries
							   {$output  .= "<td style = 'width:200px;height:40px;background-color:#72A0C1;color:white;'>$val</td>\n"; }
						   else
						       {$output  .= "<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'>$val</td>\n";}
							   }//end if
						 
				else
						{
						  if  ($tableName == 'RcrawfordStoredQueriesWC')
						      { $output  .= "<td style = 'width:200px;height:40px;background-color:#FAEBD7;'>$val</td>\n";}
						  else
							  { $output  .= "<td style = 'width:100px;height:40px;background-color:#FAEBD7;'>$val</td>\n";}
							  }	//end alt row if				
	} // end foreach
    //build little forms for add, delete and edit
    $keyVal = $row["$keyName"];
	$color;
	if ($i % 2 == 1){$color = "#72A0C1";}else{$color = "#FAEBD7";}	
    //update: won't update yet, but set up edit form
    $output .= <<< HERE
  <td style = 'width:75px;height:40px;background-color:$color;color:white;'>
    <form action = "rcrawford_wcEditRecord.php" method = "post" style="margin: 0; text-align: center;"> 
    <input type = "hidden" name = "tableName" value = "$tableName" />
    <input type= "hidden" name = "keyName" value = "$keyName" />
    <input type = "hidden" name = "keyVal" value = "$keyVal" />
    <button class = "submit2" type = "submit"><span><img src = "edit.png"></span> EDIT </button>
  </form>
  </td>

HERE;
    //delete = DELETE FROM <table> WHERE <key> = <keyval>
    $output .= <<< HERE
  <td style = 'width:75px;height:40px;background-color:$color;color:white;'>
    <form action = "rcrawford_wcDeleteRecord.php" method = "post" style="margin: 0; text-align: center;"> 
    <input type = "hidden" name = "tableName" value = "$tableName" />
    <input type= "hidden" name = "keyName" value = "$keyName" />
    <input type = "hidden" name = "keyVal" value = "$keyVal" />
    <button class = "submit2"  type =  "submit"><span><img src = "delete.png"></span> DEL </button>
    </form>
  </td>
HERE;
	$i++;
    $output .= "</tr>\n\n";    
  }// end while
$output  .= "</table></div></td></tr>";

    //add = INSERT INTO <table> {values}
    //set up insert form send table name
    $keyVal = $row["$keyName"];
    $output  .= "<tr>\n";
	if ($tableName == 'RcrawfordPatient') {

	//if condition is true, creating 3 controls a bottom of table	
    $output .= <<< HERE
  <td>
    <form action = "rcrawford_wcAddRecord.php" method = "post" style="margin: auto;float:left;">
    <input type = "hidden" name = "tableName" value = "$tableName" />
    <button class = "submit2" type = "submit"><span><img src = "add.png"></span>REGISTRATION</button>
    </form>
    <form action = "rcrawford_wcCheckIn.php" method = "post" style="margin: auto;float:left;">
    <input type = "hidden" name = "tableName" value = "$tableName" />
    <button class = "submit2" type = "submit">CHECK IN|OUT</button>
    </form>
	<form action = "rcrawford_wcRoomChange.php" method = "post" style="margin: auto;float:left;">
    <input type = "hidden" name = "tableName" value = "$tableName" />
    <button class = "submit2" type = "submit">ROOM ASSIGN</button>
    </form>
  </td>
  

HERE;

}else{
	//creating an add control at bottom of table
    $output .= <<< HERE
  <td>
    <form action = "rcrawford_wcAddRecord.php" method = "post" style="margin: auto; text-align: center;">
    <input type = "hidden" name = "tableName" value = "$tableName" />
    <button class = "submit2" type = "submit"><span><img src = "add.png"></span> ADD RECORD</button>
    </form>
  </td>

HERE;
}
$output  .= "</tr></table>\n";

  return $output;
} // end tToEdit

function tToAdd($tableName){//ADD-INSERT==============================================================================================================================================================/
  //given table name, generates HTML form to add an entry to the table
  
  global $db;
  $output = "";
  
  //process a query just to get field names
  $query = "SELECT * FROM $tableName";
  $result = mysql_query($query, $db) or die(mysql_error());
  
  if ($tableName == 'RcrawfordPatient')//checking condition to determine where to pass form
	{ 
	$output .=  "<form action = 'rcrawford_wcPatDocSelect.php' method = 'post'>";
	}
 else
   { $output .=  "<form action = 'rcrawford_wcProcessAdd.php' method = 'post'>";}

  $output .= <<<HERE

	<table style = 'background-color:#1E90FF;border-radius:2px;box-shadow: 2px 2px 2px #686868;margin:auto;'>
	<caption>Add Record</caption>						
		<tr>
    
HERE;

  $fieldNum = 0;
  while ($theField = mysql_fetch_field($result)){
    $fieldName = $theField->name;
    if ($fieldNum == 0){
      //it's the primary key field.  It'll be autoNumber
      $output .= <<<HERE
        <td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'><b>$fieldName</b></td>
        <td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'>AUTONUMBER<input type = "hidden" name = "$fieldName" value = "null"></td>

HERE;

    } else {
    //it's an ordinary field.  Print a text box
    $output .= <<<HERE
        <td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'><b>$fieldName</b></td>
        <td style = 'width:100px;height:40px;background-color:#72A0C1;'><input type = "text" name = "$fieldName" required = "required"  value = ""></td>

HERE;
    } // end if
	$output .= "</tr>";
    $fieldNum++;
  } // end while
  if ($tableName == 'RcrawfordPatient'){//checking condition to determine output

  $output .= <<<HERE
		<tr>       
		<td colspan = '2' style = "color:#FFFFFF;text-align:center;"><b>HIGH RISK?</b>
		<input type="radio" name="risk" value="yes">Yes
		<input type="radio" name="risk" value="no" checked="checked">No		
		</td>
		</tr>
		<tr>       
		<td colspan = '2' style = "text-align:center;">
        <input class = "submit2" type = "submit" value = "CONTINUE"><br>
		</td>
		</tr>
    </table>
        <input type = "hidden" name = "tableName" value = "$tableName">	
    </fieldset>
    </form>
	
HERE;
  
  }else {
  $output .= <<<HERE
		<tr>       
		<td colspan = '2' style = "text-align:center;">
        <input class = "submit2" type = "submit" value = "ADD RECORD"><br>
		</td>
		</tr>
    </table>
        <input type = "hidden" name = "tableName" value = "$tableName">	
    </fieldset>
    </form>

HERE;
}
  return $output;
      
} // end tToAdd

function rToEdit ($query){//EDIT-UPDATE=================================================================================================================================================================/
  //given a one-record query, creates a form to edit that record
  
  global $db;
  $output = "";
  $result = mysql_query($query, $db);
  $row = mysql_fetch_assoc($result);

  //get table name from field object
  $fieldObj = mysql_fetch_field($result, 0);
  $tableName = $fieldObj->table;

  $output .= <<< HERE
<form action = "rcrawford_wcUpdateRecord.php"
      method = "post">
      
      
  <input type = "hidden"
         name = "tableName"
         value = "$tableName" />

HERE;
		$output  .= "<table style = 'background-color:#1E90FF;border-radius:2px;box-shadow: 2px 2px 2px #686868;margin:auto;'>\n";
		$output  .= "<caption>Edit Record</caption>\n";						
	$fieldNum = 0;

  foreach ($row as $col=>$val){
  	if (  $fieldNum == 0){
    $output .= <<<HERE
	<tr>
		<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'><b>$col<b></td>
		<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'>$val<input type = "hidden"   name = "$col"  value = "$val" /></td>
	</tr>
HERE;
}
	else if (preg_match("/(.*)ID$/", $col, $match)) {

      
      $output .= <<<HERE
	<tr>
		<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'><b>$col<b></td>
		<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'>$val</td>
	</tr>
HERE;
	}else{
    $output .= <<<HERE
	<tr>
		<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'><b>$col<b></td>
		<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'> <input type = "text"   name = "$col"  value = "$val" /></td>
	</tr>

HERE;
	}
	$fieldNum++;
  } // end foreach
  $output .= <<< HERE
  <tr><td colspan = "2" style = "text-align:center;"><input class = "submit2" type = "submit" value = "UPDATE"> <br></td></tr> 
  </table>
</form>

HERE;
  return $output;
} // end rToEdit 

function docSel ($theTable,$tableName,$risk, $fields, $vals,$doctorID,$Query){//DOCTOR SELECTION FROM PATIENT REGISTRATION================================================================================/

  global $db;
  $output = "";
  
  if ((empty($doctorID)) AND (empty($Query))){
  
    $query = "INSERT into $theTable VALUES (";
  foreach ($vals as $theValue){
  if ($theValue == 'no' or $theValue == 'yes'){$query .= ""; }
   else {$query .= "'$theValue', ";}
  } // end foreach

  //trim off trailing space and comma
  $query = substr($query, 0, strlen($query) - 2);
  
  $query .= ")";
  $output  .= "<center><h5 style = 'color:red;'>**PLEASE SELECT A PHYSICIAN**</h5><center>\n";

  if ($risk == 'no')
	{$sql = "SELECT * FROM RcrawfordStoredQueriesWC WHERE Description = 'Delivery Doctors'";}
  else
   {$sql = "SELECT * FROM RcrawfordStoredQueriesWC WHERE Description = 'High Risk Specialist'";}
$result = mysql_query($sql,$db) or die (mysql_error());
$row = mysql_fetch_assoc($result);
$description = $row["Description"];
$theQuery = $row["Text"];

  $result = mysql_query($theQuery, $db);

		$output  .= "<table style = 'background-color:#1E90FF;border-radius:0px 0px 1px 1px;box-shadow: 2px 2px 2px #686868;margin:auto;'>\n";
		$output  .= "<caption>$description</caption>\n";		
		$output  .= "<tr><td>\n";
		$output  .= "<table  style= 'margin-right:18px;'><tr>\n";
		$output  .= "<tr>\n";	 

  //get field names
  while ($field = mysql_fetch_field($result)){
    $output .= "<th style = 'color:white;background-color:#1E90FF;width:100px;'>$field->name</th>\n";
   // end while
}
  //add empty columns for select
        $output  .= "<th style = 'color:white;background-color:#1E90FF;width:75px;'>-</th>\n";
		$output  .= "</tr></table></td></tr>\n";
		$output  .= "<tr><td>\n";
		$output  .= "<div style= 'width:100%; height:175px; overflow:auto;background-color:white;'>\n";
		$output  .= "<table>\n";	
		$i=0;
		$bcolor;
		$color;		
  //get row data as an associative array
  while ($row = mysql_fetch_assoc($result)){
  $DoctorID = $row["DoctorID"];
	if ($i % 2 == 1){$color = "#FFFFFF";$bcolor = "#72A0C1";}else{$color = "#000000";$bcolor = "#FAEBD7";}	
    $output .= "<tr>\n";
    //look at each field
    foreach ($row as $col=>$val){
						  $output  .= "<td style = 'width:100px;height:40px;background-color:$bcolor;color:$color;'>$val</td>\n";					 				
	} // end foreach
	
    //update: won't update yet, but set up edit form
    $output .= <<< HERE
  <td style = 'width:75px;height:40px;background-color:$bcolor;color:$color;'>
    <form action = "rcrawford_wcPatDocSelect.php" method = "post" style="margin: 0; text-align: center;"> 
    <input type = "hidden" name = "tableName" value = "$tableName" />
    <input type = "hidden" name = "DoctorID" value = "$DoctorID" />
    <input type = "hidden" name = "query" value = "$query" />		
    <button class = "submit2" type = "submit"> SELECT </button>
  </form>
  </td>

HERE;

	$i++;
    $output .= "</tr>\n\n";    
  }// end while
$output  .= "</table></div></td></tr>\n";
  $output  .= "<tr><td style = 'height:30px;'></td></tr>";
$output  .= "</table>\n";

  return $output;

}else{ 
  $output = "Proposed Query: $Query<br>\n";
  
  $result = mysql_query($Query, $db);
    $pid = mysql_insert_id();

  if ($result){
    $output .= "<h3>Record added</h3>Patient ID:$pid Doctor ID:$doctorID\n";
	  $sql = "INSERT INTO  RcrawfordPatientProcedure VALUES( null, $pid, 1, $doctorID, null )";
  $result2 = mysql_query($sql,$db);if ($result2){    $output .= "<h3>Patient procedure created-on standby</h3>\n";
 } else {(mysql_error());}
  } else {
    $output .= mysql_error() ."<h3>There was an error</h3>\n";
  } // end if

  return $output;
}//end main if

}//end docSel

function checkIn($keyN,$keyV,$room){//CHOOSE REGISTERED PATIENTS TO CHECK IN OR OUT-SELECT ROOM ON CHECK IN==========================================================================================/

  global $db;
  $output = "";
  if (!empty($keyN) AND !empty($keyV)){ 
				$query = "SELECT * FROM RcrawfordRoom WHERE RoomAvail IS NULL AND RoomDept = 'Delivery'";
				$result = mysql_query($query, $db);  
				
						$output  .= "<table style = 'background-color:#1E90FF;border-radius:0px 0px 1px1px;box-shadow: 2px 2px 2px #686868;margin:auto;'>\n";//main table
						$output  .= "<caption>Check In: Available Rooms</caption>\n";				
						$output  .= "<tr><td>\n";
						$output  .= "<table  style= 'margin-right:18px;'><tr>\n";//header table
						$output  .= "<tr>\n";	
		while ($field = mysql_fetch_field($result)){//retrieving field information from query
			            $output  .= "<th style = 'color:white;background-color:#1E90FF;width:100px;'>$field->name</th>\n";
		}//end while
						$output .= "<th style = 'color:white;background-color:#1E90FF;width:75px;'>-</th>";		
						$output  .= "</tr></table></td></tr>\n";//header table closed
						$output  .= "<tr><td>\n";
						$output  .= "<div style= 'width:100%; max-height:200px; overflow:auto;background-color:white;'>\n";//div creates scrollable content for enclosed table
						$output  .= "<table>\n";//description table	
		$i=0;	//variable used for alternating row color	
		while ($row = mysql_fetch_assoc($result)){//retrieves each record from results and stores it in an associative array
		$roomID = $row["RoomID"];
		
			          $output  .= "<tr>\n";
			foreach($row as $col=>$val){
			         if ($i % 2 == 1)//alternating row colors
						 {$output  .= "<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'>$val</td>\n";}
				else
						{ $output  .= "<td style = 'width:100px;height:40px;background-color:#FAEBD7;'>$val</td>\n";}
			}//end foreach
			if ($i % 2 == 1){$color = "#72A0C1";}else{$color = "#FAEBD7";}
					   $output .= <<< HERE
					   <td style = 'width:75px;height:40px;background-color:$color;color:white;'>
					   <form action = "rcrawford_wcProcessCheckIn.php" method = "post" style="margin: 0; text-align: center;"> 

					   <button class = 'submit2'  type =  'submit'>SELECT</button>
					    <input type= "hidden" name = "keyName" value = "$keyN" />
						<input type = "hidden" name = "keyVal" value = "$keyV" />
						<input type = "hidden" name = "roomID" value = "$roomID" />
					    </form></td></tr>
HERE;
						$i++;
						}//end while
					   $output  .= "</table></div></td></tr><tr><td style= 'height:20px;'></td></tr></table>\n";//description table closed, div closed, main table closed
  }else{
  
  $query = "SELECT p.PatientID, p.PatientName, pp.RoomID FROM RcrawfordPatientProcedure pp,RcrawfordPatient p WHERE p.PatientID = pp.PatientID";
  $result = mysql_query($query, $db);
  
		$output  .= "<table style = 'background-color:#1E90FF;border-radius:0px 0px 1px1px;box-shadow: 2px 2px 2px #686868;margin:auto;'>\n";//main table
		$output  .= "<caption>Check In|Out</caption>\n";				
		$output  .= "<tr><td>\n";
		$output  .= "<table  style= 'margin-right:18px;'><tr>\n";//header table
		$output  .= "<tr>\n";	
		while ($field = mysql_fetch_field($result)){//retrieving field information from query
			$output  .= "<th style = 'color:white;background-color:#1E90FF;width:100px;'>$field->name</th>\n";
		}//end while
		  //get name of index field (presuming it's first field)
		$keyField = mysql_fetch_field($result, 0);
		$keyName = $keyField->name;
		
        $output .= "<th style = 'color:white;background-color:#1E90FF;width:75px;'>-</th>";		
		$output  .= "</tr></table></td></tr>\n";//header table closed
		$output  .= "<tr><td>\n";
		$output  .= "<div style= 'width:100%; max-height:200px; overflow:auto;background-color:white;'>\n";//div creates scrollable content for enclosed table
		$output  .= "<table>\n";//description table	
		$i=0;	//variable used for alternating row color	
		while ($row = mysql_fetch_assoc($result)){//retrieves each record from results and stores it in an associative array
		$roomID = $row["RoomID"];
        $keyVal = $row["$keyName"];

			$output  .= "<tr>\n";
			foreach($row as $col=>$val){
			         if ($i % 2 == 1)//alternating row colors
						 {$output  .= "<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'>$val</td>\n";}
				else
						{ $output  .= "<td style = 'width:100px;height:40px;background-color:#FAEBD7;'>$val</td>\n";}
			}//end foreach
	$color;
	if ($i % 2 == 1){$color = "#72A0C1";}else{$color = "#FAEBD7";}


    $output .= <<< HERE
  <td style = 'width:75px;height:40px;background-color:$color;color:white;'>
HERE;

	if ($roomID == NULL)
	{      $output  .= "<form action = 'rcrawford_wcCheckIn.php' method = 'post' style='margin: 0; text-align: center;'>"; 
		   $output  .= "<button class = 'submit2'  type =  'submit'>IN</button>";
		   }
	else
	{  
			  $query2 = "SELECT * FROM RcrawfordRoom WHERE RoomDept = 'Recovery'";
			  $result2 = mysql_query($query2, $db);
			 while( $row2 = mysql_fetch_assoc($result2)){
			  $roomID2 = $row2["RoomID"];
					if ($roomID2 == $roomID)
					{		$output  .= "<form action = 'rcrawford_wcProcessCheckIn.php' method = 'post' style='margin: 0; text-align: center;'>"; 
							$output  .= "<button class = 'submit2'  type =  'submit'>OUT</button>";
							$output  .= "<input type= 'hidden' name = 'checkout' value = 'checkout' />";
							}					
					}
	       }
$output .= <<< HERE

<input type= "hidden" name = "keyName" value = "$keyName" />
<input type = "hidden" name = "keyVal" value = "$keyVal" />
<input type = "hidden" name = "roomID" value = "$roomID" />
</form>
</td>
</tr>

HERE;

	$i++;
	}//end while
$output  .= "</table></div></td></tr><tr><td style= 'height:20px;'></td></tr></table>\n";//description table closed, div closed, main table closed
}//end main if
return $output;

}//end checkIn

function procCheckIn($keyN,$keyV,$room, $checkout){//EXECUTE CHECK IN -OUT============================================================================================================================/ 
  
   global $db;
  $output = "";

  
   date_default_timezone_set('America/New_York');//creating a time for check in- check out
  $time = date("Y-m-d G:i:s");
  
  if(!empty($checkout)){//checking out-printing receipt
  
	$query = "UPDATE RcrawfordRoom SET RoomAvail = NULL WHERE RoomID = $room";
	$result = mysql_query($query, $db); 
	if($result){
		$query2 = "UPDATE RcrawfordCheckIn SET TimeOut = '$time' WHERE PatientID = $keyV";
		$result2 = mysql_query($query2, $db)or die ('CheckIn TimeOut error:' . '' . mysql_error());
		if ($result2){
			 $query3 = "SELECT p.PatientID, p.PatientName, p.Phone, p.Insurance, c.TimeIn, c.TimeOut
								FROM RcrawfordPatient p, RcrawfordCheckIn c
								WHERE p.PatientID = c.PatientID AND p.PatientID = $keyV";
			 $result3 = mysql_query($query3, $db)or die ('Selection for archive error:' . '' . mysql_error());
			 if ($result3){
				$row = mysql_fetch_assoc($result3);
				$pid = $row["PatientID"];$name = $row["PatientName"];$phone = $row["Phone"];$ins = $row["Insurance"];$in = $row["TimeIn"];$out = $row["TimeOut"];
				$query4 = "INSERT into RcrawfordPatientArchive VALUES(null,$pid,'$name','$in','$out',$phone,'$ins')";
				$result4 = mysql_query($query4, $db)or die ('Archive insertion error:' . '' . mysql_error());				
				if ($result4){
							 $query5 = "SELECT d.SpecialtyID
												FROM  RcrawfordDoctor d, RcrawfordPatientProcedure pp
												WHERE pp.DoctorID = d.DoctorID AND pp.PatientID = $pid";
							 $result5 = mysql_query($query5, $db)or die ('doctorID error:' . '' . mysql_error());
							if ($result5){
								$doctor = 0;
								$nurses = 0;
								$row2 = mysql_fetch_assoc($result5);$sid = $row2["SpecialtyID"];
								if($sid == 12){$doctor = 5000.57;$nurses = 2458.01;}else{$doctor = 7225.25;$nurses = 3505.27;}
								$rooms = 3400.13; $misc = 4005.96; $total = $doctor + $nurses + $rooms + $misc;$total2 = $total * .2;$total2 = round($total2, 2);
$output .= <<<HERE
<table style = "Background-color:#FFFFFF;width:650px;height:500px;margin:auto;text-align:left;">
<caption>Account Summary</caption>
<tr><td>Patient Name:</td><td>$name</td></tr>
<tr><td>Acct No:</td><td>$pid</td></tr>
<tr><td>Time/Days:</td><td>$in / $out</td></tr>
<tr><td colspan = '2'><hr></td></tr>
<tr><th><u>ChargeDesc</u></th><th><u>Amount</u></th></tr>
<tr><td>Doctor Charge:</td><td>$doctor</td></tr>
<tr><td>Nurse Charge:</td><td>$nurses</td></tr>
<tr><td>Room and board:</td><td>$rooms</td></tr>
<tr><td>Misc. Charges (Meds, Extra proc.):</td><td>$misc</td></tr>
<tr><td></td><td></td></tr>
<tr><td>Total Charges:</td><td>$total</td></tr>
<tr><td>Insurance:</td><td>$ins-c/p:20%</td></tr>
<tr><td>Amount Due:</td><td>$total2</td></tr>
</table>
<br><hr><br><br><br>

HERE;
					 $query6 = "DELETE FROM RcrawfordPatient WHERE PatientID = $keyV";
					 $result6 = mysql_query($query6, $db)or die ('Delete error:' . '' . mysql_error());
							$output .= "<h5>Actions performed for checkout</h5>";
							$output .= "<pre>-Patient room $room Availability set back to null-RcrawfordRoom</pre>";				
							$output .= "<pre>-Patient check out time set-RcrawfordCheckin</pre>";
							$output .= "<pre>-Info gathered for archive</pre>";				
							$output .= "<pre>-Archive data inserted-RcrawfordPatientArchive</pre>";											
							$output .= "<pre>-Patient deleted, cascaded to all relations-RcrawfordPatient</pre>";
						}	
					}
				}			
			}
		}else{$output .= "<h3>there was a problem...";} // end if
  
  }else{//checking in
  
  $query = "INSERT into RcrawfordCheckIn VALUES(null,$keyV,'$time',null)";
    $result = mysql_query($query, $db)or die ('Check in error:' . '' . mysql_error());
	  if ($result){
			$query = "SELECT * FROM RcrawfordCheckin WHERE $keyN = '$keyV'";
			$output .= "<h3>Patient checked in succesfully</h3>";
			$output .= theTable($query, 'CheckIn details');
			$query2 = "UPDATE RcrawfordRoom SET RoomAvail = 'Occupied' WHERE $room = RoomID";
			$result2 = mysql_query($query2, $db)or die ('Room update:' . '' . mysql_error());
				if ($result2){
							$output .= "<h3>Room $room has been updated: Occupied </h3>";				
							$query3 = "UPDATE RcrawfordPatientProcedure SET RoomID = $room WHERE PatientID = $keyV";
							$result3 = mysql_query($query3, $db)or die ('Patient Procedure update:' . '' . mysql_error());
								if ($result3){
											$output .= "<h3>Patient procedure has been set</h3>";
											}//end result3 if
							}//end result2 if				
			 } else {$output .= "<h3>there was a problem...</h3><pre>$query</pre>\n";} // end result if
					}//end main if
  return $output;
}//end ProCheckin

function procAdd($tableName, $fields, $vals){//EXECUTE INSERT============================================================================================================================================/
  //generates INSERT query, applies to database
  global $db;
  
  $output = "";
  $query = "INSERT into $tableName VALUES (";
  foreach ($vals as $theValue){
    $query .= "'$theValue', ";
  } // end foreach

  //trim off trailing space and comma
  $query = substr($query, 0, strlen($query) - 2);
  
  $query .= ")";
  $output = "Proposed Query: $query<br>\n";
  
  $result = mysql_query($query, $db);
  if ($result){
    $output .= "<h3>Record added</h3>\n";
  } else {
    $output .= mysql_error() ."<h3>There was an error</h3>\n";
  } // end if
  return $output;
} // end procAdd

function updateRec($tableName, $fields, $vals){//EXECUTE EDIT-UDATE======================================================================================================================================/
  //expects name of a record, fields array values array
  //updates database with new values
  
  global $db;
  
  $output = "";
  $keyName = $fields[0];
  $keyVal = $vals[0];
  $query = "";
  
  $query .= "UPDATE $tableName SET \n";
  for ($i = 1; $i < count($fields); $i++){
    $query .= $fields[$i];
    $query .= " = '";
    $query .= $vals[$i];
    $query .= "',\n";
  } // end for loop

  //remove last comma from output
  $query = substr($query, 0, strlen($query) - 2);
  
  $query .= "\nWHERE $keyName = '$keyVal'";

  $result = mysql_query($query, $db);
  if ($result){
    $query = "SELECT * FROM $tableName WHERE $keyName = '$keyVal'";
	
    $output .= "<br><h1>update successful</h1>\n";
    $output .= "<h2>new value of record:</h2>";
    $output .= theTable($query, 'Updated Record');
  } else {
    $output .= "<h3>there was a problem...</h3><pre>$query</pre>\n";
  } // end if
  return $output;
} // end updateRec

function roomChange($keyN,$keyV,$CRID){//SELECT PATIENT IN DELIVERY FOR ROOM CHANGE-DISPLAY AVAILABLE RECOVERY ROOMS=================================================================================/ 

  global $db;
  $output = "";
  
  if (!empty($keyN) AND !empty($keyV)){
  $query = "SELECT* FROM RcrawfordRoom WHERE RoomAvail IS NULL AND RoomDept = 'Recovery'";
  $result = mysql_query($query, $db) or die(mysql_error());
  
  }
  else{

  $query = "SELECT p.PatientID, p.PatientName,r.RoomID, r.RoomDept
				   FROM RcrawfordPatient p, RcrawfordPatientProcedure pp, RcrawfordRoom r
				   WHERE p.PatientID = pp.PatientID AND pp.RoomID = r.RoomID AND r.RoomDept = 'Delivery' ";
  $result = mysql_query($query, $db) or die(mysql_error()); 
  }
		$output  .= "<table style = 'background-color:#1E90FF;border-radius:0px 0px 1px1px;box-shadow: 2px 2px 2px #686868;margin:auto;'>\n";//main table
		  if (!empty($keyN) AND !empty($keyV)){$output  .= "<caption>Recovery Rooms Available</caption>\n";}
		  else{$output  .= "<caption>Patients In Delivery[move to recovery]</caption>\n"; }			
		$output  .= "<tr><td>\n";
		$output  .= "<table  style= 'margin-right:18px;'><tr>\n";//header table
		$output  .= "<tr>\n";	
		while ($field = mysql_fetch_field($result)){//retrieving field information from query
			$output  .= "<th style = 'color:white;background-color:#1E90FF;width:100px;'>$field->name</th>\n";
		}//end while
		  //get name of index field (presuming it's first field)
  $keyField = mysql_fetch_field($result, 0);
  $keyName = $keyField->name;
		$output .= "<th style = 'color:white;background-color:#1E90FF;width:75px;'>-</th>";
		$output  .= "</tr></table></td></tr>\n";//header table closed
		$output  .= "<tr><td>\n";
		$output  .= "<div style= 'width:100%; max-height:200px; overflow:auto;background-color:white;'>\n";//div creates scrollable content for enclosed table
		$output  .= "<table>\n";//description table	
		$i=0;	//variable used for alternating row color	
		while ($row = mysql_fetch_assoc($result)){//retrieves each record from results and stores it in an associative array
		$roomID = $row['RoomID'];
			$output  .= "<tr>\n";
			foreach($row as $col=>$val){
			         if ($i % 2 == 1)//alternating row colors
						 {$output  .= "<td style = 'width:100px;height:40px;background-color:#72A0C1;color:white;'>$val</td>\n";}
				else
						{ $output  .= "<td style = 'width:100px;height:40px;background-color:#FAEBD7;'>$val</td>\n";}
			}//end foreach
	$keyVal = $row["$keyName"];
	$color;
	$color;
	if ($i % 2 == 1){$color = "#72A0C1";}else{$color = "#FAEBD7";}	
	
$output .= "<td style = 'width:75px;height:40px;background-color:$color;color:white;'>";
if (!empty($keyN) AND !empty($keyV)){     
$output .= <<<HERE

	<form action = 'rcrawford_wcProcessRoomChange.php' method = 'post' style='margin: 0; text-align: center;'>
	<input type= "hidden" name = "keyNameR" value = "$keyName" /><!--RoomID-->
	<input type = "hidden" name = "keyValR" value = "$keyVal" /><!--RoomID value-->
	<input type= "hidden" name = "keyNameP" value = "$keyN" /><!--PatientID-->
	<input type = "hidden" name = "keyValP" value = "$keyV" /><!--PatientID value-->
	<input type = "hidden" name = "currentRoomID" value = "$CRID" /><!--PatientID value-->
    <button class = "submit2" type = "submit">SELECT</button>
    </form>
	</td>
  
HERE;
}else{
$output .= <<<HERE

    <form action = "rcrawford_wcRoomChange.php" method = "post" style="margin: 0; text-align: center;"> 
    <input type= "hidden" name = "keyName" value = "$keyName" /><!--PatientID-->
    <input type = "hidden" name = "keyVal" value = "$keyVal" /><!--PatientID value-->
	<input type = "hidden" name = "roomID" value = "$roomID" /><!--PatientID value-->

    <button class = "submit2" type = "submit">MOVE</button>
  </form>
  </td>
  
HERE;
}
			$i++;
			$output  .= "</tr>\n\n";
		}//end while
$output  .= "</table></div></td></tr><tr><td style= 'height:20px;'></td></tr></table>\n";//description table closed, div closed, main table closed
	
return $output;
}

function procRoomChange($keyNR,$keyVR,$keyNP,$keyVP,$currentRID){//EXECUTE ROOM CHANGE===========================================================================================================/ 

  global $db;
  
  $output = "";
  
    $query = "UPDATE RcrawfordRoom SET RoomAvail = NULL WHERE $keyNR = $currentRID";
	$result = mysql_query($query, $db) or die('current room update error: ' . mysql_error());
		if ($result){
				$output .= "<h3>Room $currentRID updated: Empty<h3>";
				$query2 = "UPDATE RcrawfordRoom SET RoomAvail = 'Occupied' WHERE $keyNR = $keyVR";
				$result2 = mysql_query($query2, $db) or die('assigned room update error: ' . mysql_error());
					if ($result2){
							$output .= "<h3>Room $keyVR updated: Occupied<h3>";
							$query3 = "UPDATE RcrawfordPatientProcedure SET RoomID = $keyVR, ProcedureID = 2 WHERE $keyNP = $keyVP";
							$result3 = mysql_query($query3, $db) or die('Patient procedure update error: ' . mysql_error());
								if ($result3){
										$output .= "<h3>Patient procedure updated: Patient $keyVP moved from  room $currentRID to room $keyVR<h3>";
		
		}}}else{ $output .= "<h3>There was a problem...<h3>";}
  
return $output;
  


}

function delRec ($table, $keyName, $keyVal){//EXECUTE DELETE============================================================================================================================================/
  //deletes $keyVal record from $table
  global $db;
  $output = "";
  $query = "DELETE from $table WHERE $keyName = '$keyVal'";
  //print "query is $query<br>\n";
  $result = mysql_query($query, $db);
  if ($result){
    $output = "<h3>Record sucessfully deleted</h3>\n";
  } else {
    $output = "<h3>Error deleting record</h3>\n";
  } //end if
  return $output;
} // end delRec