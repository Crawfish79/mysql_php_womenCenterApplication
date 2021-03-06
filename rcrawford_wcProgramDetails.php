<!DOCTYPE html>
<html lang="en">
<head>
<title>WCDATABASE::PROGRAM DETAILS</title>
<?php include "rcrawford_wcLib.php"; ?>
<meta charset="utf-8">
<link href="wcStyle.css" rel="stylesheet" type="text/css">
</head>
<body>


<?php

print head(); 

?>

<h2>PROGRAM DETAILS</h2>
<dfn><b>Internal Quick Views</b></dfn><hr>
<p>-Shows views for quick access to information associated with patients,nurses, doctors and hospital operations</p>
<p>-Nurses assigned to a particular patients room are displayed in the 'Patients Checked In' view</p>
<dfn><b>Internal Operations</b></dfn><hr>
<p>-Performs create, update, and delete functionalities for patients, nurses, doctors, and other administrator operations</p>
<p><u>Patient Operations:</u></p>
<p>-During patient registration, either a regular or high risk doctor has to be chosen.</p>
<p>-Once a patient is registered, the patient procedure process is started</p>
<p>-Once a patient checks in, the delivery procedure is assumed, the check in process is started, the patient procedure<br>is updated, and a delivery room is assigned and updated to occupied</p>
<p>-The nurse assumes resposibility for reporting delivery status, which in turn leads to a room change. Once room is changed,<br> patient procedure is updated, delivery room is set to null, and chosen recovery room is set to occupied</p>
<p>-Once a patient checks out, current room is updated to null, the checkin process is updated and checkout time is set,<br> information is gathered and inserted in to archive, bill is produced(amount depends on if patient is high risk or not),<br> and patient is deleted and cascaded to all relations</p>



<?php

print foot();

?>


</body>
</html> 