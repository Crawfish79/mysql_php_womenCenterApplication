mysql_php_womenCenterApplication
================================

PHP/MySQL internal Women's Center Application

<I>Designed as a mock women's center application with focus around maternity use case. Database script is preloaded(rcrawford_womenCenter.sql). Database variables are contained in the library of functions(rcrawford_wcLib).</I>
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
<dfn><b>Issues</b></dfn><hr>
<p>-Scrollable grid has some fixed attributes and due to the size of content on the grid, wrapper is forced to be fixed. Not optimal for some displays</p>
<p>-MySQL extensions need to be upgraded to MySQLi</p>
<p>-More object oriented structure needs to be incorporated</p>
<p>-Menu not functioning properly(style).. reduced to minimalist style</p>
<p>-Overall presentation needs to be ore modern/up to date</p>
<p>-A spare-time fixer-upper challenge for me!</p>
