USE rcrawford_database2; 

DROP TABLE IF EXISTS RcrawfordPatientArchive;
DROP TABLE IF EXISTS RcrawfordCheckIn;
DROP TABLE IF EXISTS RcrawfordPatientProcedure;
DROP TABLE IF EXISTS RcrawfordNurseAssignment;
DROP TABLE IF EXISTS RcrawfordNurse;
DROP TABLE IF EXISTS RcrawfordDoctor;
DROP TABLE IF EXISTS RcrawfordPatient;
DROP TABLE IF EXISTS RcrawfordShift;
DROP TABLE IF EXISTS RcrawfordProcedure;
DROP TABLE IF EXISTS RcrawfordRoom;
DROP TABLE IF EXISTS RcrawfordSpecialty;


CREATE TABLE RcrawfordSpecialty(
				SpecialtyID											 INT(2)			NOT NULL,
				SpecialtyName					VARCHAR(22),
CONSTRAINT Specialty_PK PRIMARY KEY (SpecialtyID)				
)ENGINE=INNODB;

INSERT INTO  RcrawfordSpecialty 
VALUES    (10, 'Labor Delivery'),
				 (11, 'Acute Care'),
				 (12, 'Obstetrics Gynecology'),
				 (13, 'Post Labor Care'),
				 (14, 'perinatology High Risk');
				 
CREATE TABLE RcrawfordRoom(
				RoomID												 INT(3)			NOT NULL,
				RoomDept						VARCHAR(13),
				RoomAvail						VARCHAR(8),				
CONSTRAINT Room_PK PRIMARY KEY (RoomID)
)ENGINE=INNODB;

INSERT INTO  RcrawfordRoom 
VALUES    (299, 'Delivery/Mngr','N/A'),(300, 'Delivery','Occupied'),(301, 'Delivery','Occupied'),(302, 'Delivery','Occupied'),(303, 'Delivery','Occupied'),
				 (304, 'Delivery','Occupied'),(305, 'Delivery',NULL),(306, 'Delivery',NULL),(307, 'Delivery',NULL),(308, 'Delivery',NULL),(309, 'Delivery',NULL),
				 (310, 'Recovery','Occupied'),(311, 'Recovery','Occupied'),(312, 'Recovery','Occupied'),(313, 'Recovery','Occupied'),(314, 'Recovery','Occupied'),
				 (315, 'Recovery',NULL),(316, 'Recovery',NULL),(317, 'Recovery',NULL),(318, 'Recovery',NULL),(319, 'Recovery',NULL),(320, 'Recovery/Mngr','N/A');

CREATE TABLE RcrawfordProcedure(
				ProcedureID											 INT(1)			NOT NULL,
				ProcedureName				VARCHAR(8),
CONSTRAINT Procedure_PK PRIMARY KEY (ProcedureID)
)ENGINE=INNODB;

INSERT INTO  RcrawfordProcedure 
VALUES	 (1, 'Delivery'), (2, 'Recovery'); 

CREATE TABLE RcrawfordShift(
				ShiftID													 INT(1)			NOT NULL,
				Hours										VARCHAR(14)			NOT NULL,				
CONSTRAINT Shift_PK PRIMARY KEY (ShiftID)		
)ENGINE=INNODB;

INSERT INTO  RcrawfordShift 
VALUES	(1,'8:00AM-4:00PM' ),(2,'4:00PM-12:00AM' ),(3,'12:00AM-8:00AM');


CREATE TABLE RcrawfordPatient(
				PatientID												 INT(5)			NOT NULL AUTO_INCREMENT,
				PatientName								VARCHAR(17)			NOT NULL,
				Street										VARCHAR(17),
				City											VARCHAR(10),
				State										  VARCHAR(2),				
				Zip														 INT(5),
				Phone										VARCHAR(10),
				Insurance									VARCHAR(10),
CONSTRAINT Patient_PK PRIMARY KEY (PatientID)				
)ENGINE=INNODB;

INSERT INTO  RcrawfordPatient 
VALUES    (10001, 'Lucy Davis', '10 High St.', 'Stone Mtn.', 'GA', 30087, 6784897723, 'Kaiser'),
				 (10002, 'Marilyn Judd', '1515 Crescent Sq.', 'Marietta', 'GA', 30060, 7704339723, 'Blue Cross'),
				 (10003, 'Jenny Paige', '2300 Holly Cove', 'Smyrna', 'GA', 30080, 7709436374, 'Cobra'),
				 (10004, 'Carla Rose', '2130 Tulip St.', 'Marietta', 'GA', 30060, 4045679873, 'Medicaid'),
				 (10005, 'Nicole Crinkle', '7562 Indian Trail', 'Powder Springs', 'GA', 30127, 7704125796, 'United Health'),
				 (10006, 'Carol Newsome', '2088 Holy way', 'Doraville', 'GA', 30268, 4043588532, 'Blue Cross'),
				 (10007, 'Jodi Watley', '5468 Murky Lake', 'Kennesaw', 'GA', 30088, 7704369489, 'Wellpoint'),
				 (10008, 'Kim Cook', '4025 Spooky Woods', 'Atlanta', 'GA', 30147, 7707654321, 'Blue Cross'),
				 (10009, 'Sarah Joseph', '1009 Bush Ln.', 'Marietta', 'GA', 30060, 7704358093, 'Cigna'),
				 (10010, 'Demi Gober', '3051 Cully Cove', 'Austell', 'GA', 30063, 6785994123, 'Aetna'),
				 (10011, 'Fran Harris', '22 Zoom St.', 'Clarkston', 'GA', 30043, 7707218522, 'Cobra'),
				 (10012, 'Keisha Dean', '9061 Happy Ter.', 'Atlanta', 'GA', 30147, 4041961654, 'Medicaid'),
				 (10013, 'Sally Drummond', '154 Geronimo Dr.', 'Austell', 'GA', 30063, 4043338888, 'Kaiser'),
				 (10014, 'Kelly Coleman', '7565 Elm St.', 'Smyrna', 'GA', 30080, 6786985225, 'Wellpoint'),
				 (10015, 'Molly Capers', '7468 Curvy Rd.', 'Marietta', 'GA', 30060, 4047413685, 'Aetna');

CREATE TABLE RcrawfordDoctor(
				DoctorID												 INT(5)			NOT NULL AUTO_INCREMENT,
				DoctorName								VARCHAR(17)			NOT NULL,
				Credential									  VARCHAR(8),
				Street										VARCHAR(17),
				City											VARCHAR(10),
				State										  VARCHAR(2),				
				Zip														 INT(5),
				Phone										VARCHAR(10),
				SpecialtyID							                  INT(2),				
CONSTRAINT Doctor_PK PRIMARY KEY (DoctorID),
CONSTRAINT Doctor_FK FOREIGN KEY (SpecialtyID) REFERENCES RcrawfordSpecialty(SpecialtyID) ON DELETE SET NULL ON UPDATE CASCADE	
)ENGINE=INNODB;

INSERT INTO  RcrawfordDoctor 
VALUES    (30001, 'James Johnson', 'MD/MFM', '1234 Main St.', 'Marietta', 'GA', 30060, 6784047701, 14),
				 (30002, 'Sandy Lumpkin', 'MD/OBGYN', '1579 Treehill Ter.', 'Smyrna', 'GA', 30068, 4049787712, 12),
				 (30003, 'Jenny Jenkins', 'MD/OBGYN', '2649 Bumpy Rd.', 'Powder Springs', 'GA', 30127, 4045621234, 12),
				 (30004, 'Rocky Watkins', 'MD/OBGYN', '7864 Dirt Trail', 'Austell', 'GA', 30063,7702225689, 12),
				 (30005, 'Kent Clarke', 'MD/MFM', '1359 Metro Square', 'Marietta', 'GA', 30060,7701234567, 14),
				 (30006, 'Roger Lakely', 'MD/MFM', '1456 Sea Way', 'Clarkston', 'GA', 30043,6782051313, 14),
				 (30007, 'Donald Kramer', 'MD/OBGYN', '21 Jump St.', 'Atlanta', 'GA', 300147,4043679466, 12),
				 (30008, 'Richard Crawford', 'MD/OBGYN', '7885 Valley Overlook', 'Lilburn', 'GA', 30047,7708719346, 12),
				 (30009, 'Gary Toms', 'MD/OBGYN', '1000 Deserted Rd.', 'Kennesaw', 'GA', 30088,7706641198, 12),
				 (30010, 'Harold Sheems', 'MD/MFM', '10 Gresham Park', 'Marietta', 'GA', 30060,4045768765, 14);				 
				 
CREATE TABLE RcrawfordNurse(
				NurseID												 INT(5)			NOT NULL AUTO_INCREMENT,
				NurseName								VARCHAR(17)			NOT NULL,
				Credential									  VARCHAR(10),
				Street										VARCHAR(17),
				City											VARCHAR(10),
				State										  VARCHAR(2),				
				Zip														 INT(5),
				Phone										VARCHAR(10),				
				SpecialtyID									 INT(2),
				ManagerID									 INT(5),				
CONSTRAINT Nurse_PK PRIMARY KEY (NurseID),
CONSTRAINT Nurse_FK FOREIGN KEY (SpecialtyID) REFERENCES RcrawfordSpecialty(SpecialtyID) ON DELETE SET NULL ON UPDATE CASCADE,	
CONSTRAINT Nurse_FK2 FOREIGN KEY (ManagerID) REFERENCES RcrawfordNurse(NurseID) ON DELETE SET NULL ON UPDATE CASCADE	
)ENGINE=INNODB;

INSERT INTO  RcrawfordNurse 
VALUES    (20001, 'Cindy Jones', 'CNM/APRN', 'North Ave.', 'Marietta', 'GA', 30060, 6785654444, 12, NULL),
				 (20002, 'Susan Strong', 'CNL/RN/MSN', 'Hopkins Way', 'Lithia Springs', 'GA', 30163, 4045114988, 13, NULL),
				 (20003, 'Kelly Lock', 'CNML/CM', 'Green Dr.', 'Marietta', 'GA', 30060, 7702546588, 12, NULL),
				 (20004, 'Justine Staley', 'CNS/RN', 'Sun St.', 'Atlanta', 'GA', 30148, 7706985511, 11, NULL),
				 (20005, 'Maria Lopez', 'CNS', 'Plato Pl.', 'Powder Springs', 'GA', 30127, 4048521346, 13, NULL),
				 (20006, 'Wenny Richie', 'CNM/MSN', 'David Cir.', 'Norcross', 'GA', 30071, 6789783251, 12, NULL),
				 (20007, 'Joanie Webb', 'RN', 'Terrance Trace', 'Marietta', 'GA', 30060, 4044116663, 10, 20001),
				 (20008, 'Craig Jones', 'RN', 'Tree Ter.', 'Chamblee', 'GA', 30168, 6783597465, 10, 20001),
				 (20009, 'Heidi Johnson', 'APRN', 'Clover Chase', 'Lilburn', 'GA', 30047, 7702339876, 13, 20002),
				 (20010, 'Wanda Pouncey', 'CCRN', '4th St.', 'Decatur', 'GA', 30064, 4049225674, NULL, 20002),
				 (20011, 'Vanessa Good', 'RN', 'Colonial Ave.', 'Marietta', 'GA', 30060, 7703254899, 10, 20003),
				 (20012, 'Nina Willis', 'RN', 'Tucson Ct.', 'Atlanta', 'GA', 30148, 4045446921, 10, 20003),
				 (20013, 'Bobby Flake', 'CCRN', 'Midland Heights', 'Tucker', 'GA', 30084, 6784653177, NULL, 20004),
				 (20014, 'Dianne Jobs', 'RN', 'Vikings Ferry', 'Marietta', 'GA', 30060, 7706546549, 13, 20004),
				 (20015, 'Valerie Conley', 'CCNS', 'Mountain Rd.', 'Powder Springs', 'GA', 30127, 4049873652, 11, 20005),
				 (20016, 'Tony Lewis', 'RN', 'Metro Ln.', 'Atlanta', 'GA', 30148, 7702555687, 13, 20005),
				 (20017, 'Judy Bloom', 'RN', 'Main St.', 'Roswell', 'GA', 30169, 4041234567, 10, 20006),
				 (20018, 'Tracey Gold', 'RN', 'Bonnie Dr.', 'Smyrna', 'GA', 30068, 6786123456, 10, 20006);

CREATE TABLE RcrawfordNurseAssignment(
				NurseID												 INT(5)			NOT NULL,
				RoomID												 INT(3)			NOT NULL,
				ShiftID													 INT(1),
CONSTRAINT NurseAssignment_PK PRIMARY KEY (NurseID, RoomID),
CONSTRAINT NurseAssignment_FK FOREIGN KEY (NurseID) REFERENCES RcrawfordNurse(NurseID) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT NurseAssignment_FK2 FOREIGN KEY (RoomID) REFERENCES RcrawfordRoom(RoomID) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT NurseAssignment_FK3 FOREIGN KEY (ShiftID) REFERENCES RcrawfordShift(ShiftID) ON DELETE CASCADE ON UPDATE CASCADE				
)ENGINE=INNODB;

INSERT INTO  RcrawfordNurseAssignment 
VALUES    (20001,299,1),
				 (20007,300,1),(20007,301,1),(20007,302,1),(20007,303,1),(20007,304,1),(20008,305,1),(20008,306,1),(20008,307,1),(20008,308,1),(20008,309,1),
				 (20002,320,1),
				 (20009,310,1),(20009,311,1),(20009,312,1),(20009,313,1),(20009,314,1),(20010,315,1),(20010,316,1),(20010,317,1),(20010,318,1),(20010,319,1),
				 (20003,299,2),
				 (20011,300,2),(20011,301,2),(20011,302,2),(20011,303,2),(20011,304,2),(20012,305,2),(20012,306,2),(20012,307,2),(20012,308,2),(20012,309,2),
				 (20004,320,2),
				 (20013,310,2),(20013,311,2),(20013,312,2),(20013,313,2),(20013,314,2), (20014,315,2),(20014,316,2),(20014,317,2),(20014,318,2),(20014,319,2),
				 (20006,299,3),
				 (20017,300,3),(20017,301,3),(20017,302,3),(20017,303,3),(20017,304,3),(20018,305,3),(20018,306,3),(20018,307,3),(20018,308,3),(20018,309,3),
				 (20005,320,3),
				 (20015,310,3),(20015,311,3),(20015,312,3),(20015,313,3),(20015,314,3),(20016,315,3),(20016,316,3),(20016,317,3),(20016,318,3),(20016,319,3);

CREATE TABLE RcrawfordPatientProcedure(
				PatientProID											 INT(4)          NOT NULL AUTO_INCREMENT,
				PatientID												 INT(5)			NOT NULL,
				ProcedureID											 INT(1),
				DoctorID												 INT(5),
				RoomID												 INT(3),				
				
CONSTRAINT PatientProcedure_PK PRIMARY KEY (PatientProID),
CONSTRAINT PatientProcedure_FK1 FOREIGN KEY (PatientID) REFERENCES  RcrawfordPatient (PatientID) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT PatientProcedure_FK2 FOREIGN KEY (ProcedureID) REFERENCES  RcrawfordProcedure (ProcedureID) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT PatientProcedure_FK3 FOREIGN KEY (DoctorID) REFERENCES  RcrawfordDoctor (DoctorID) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT PatientProcedure_FK4 FOREIGN KEY (RoomID) REFERENCES  RcrawfordRoom (RoomID) ON DELETE CASCADE ON UPDATE CASCADE				
)ENGINE=INNODB;

INSERT INTO  RcrawfordPatientProcedure 
VALUES		 (8010,10001,1,30004,300),(8011,10002,1,30002,301),(8012,10003,1,30005,302),(8013,10004,1,30002,303),(8014,10005,1,30007,304),
					 (8015,10006,2,30003,310),(8016,10007,2,30001,311),(8017,10008,2,30003,312),(8018,10009,2,30001,313),(8019,10010,2,30005,314),
					 (8020,10011,1,30008,NULL),(8021,10012,1,30001,NULL),(8022,10013,1,30004,NULL),(8023,10014,1,30009,NULL),(8024,10015,1,30010,NULL);

CREATE TABLE RcrawfordCheckIn(
				CheckInID											 INT(4)          NOT NULL AUTO_INCREMENT,
				PatientID												 INT(5)			NOT NULL,
				TimeIN										 VARCHAR(19)         NOT NULL, 
				TimeOut									 VARCHAR(19),
CONSTRAINT CheckIn_PK PRIMARY KEY (CheckInID),
CONSTRAINT CheckIn_FK1 FOREIGN KEY (PatientID) REFERENCES  RcrawfordPatient (PatientID) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=INNODB;

INSERT INTO  RcrawfordCheckIn 
VALUES			 (1001,10001,'2013-11-10 12:30:48',NULL),(1002,10002,'2013-11-10 21:27:44',NULL),(1003,10003,'2013-11-11 06:05:13',NULL),(1004,10004,'2013-11-11 10:15:10',NULL),
						 (1005,10005,'2013-11-11 01:50:29',NULL),(1006,10006,'2013-11-12 12:01:04',NULL),(1007,10007,'2013-11-13 04:22:12',NULL),(1008,10008,'2013-11-13 11:20:05',NULL),
						 (1009,10009,'2013-11-13 12:25:39',NULL),(1010,10010,'2013-11-13 16:30:25',NULL);

DROP TABLE IF EXISTS RcrawfordStoredQueriesWC;
CREATE TABLE RcrawfordStoredQueriesWC (
				StoredQueryID 									INT(11) 				NOT NULL AUTO_INCREMENT,
				Description 										VARCHAR(30),
				Text 													TEXT,
CONSTRAINT Queries_PK  PRIMARY KEY (StoredQueryID)
)ENGINE=INNODB;

INSERT INTO RcrawfordStoredQueriesWC
VALUES	 (NULL, 'Registered Patients', 'SELECT* FROM RcrawfordPatient ORDER BY PatientName'),
				 (NULL, 'Patients Checked In', 'SELECT p.PatientID, p.PatientName, c.TimeIn, c.TimeOut, pp.RoomID FROM RcrawfordPatient p, RcrawfordCheckIn c, RcrawfordPatientProcedure pp WHERE p.PatientID = c.PatientID AND p.PatientID = pp.patientID ORDER BY p.PatientName'),
				 (NULL, 'Nurses', 'SELECT * FROM RcrawfordNurse ORDER BY NurseName'),
				 (NULL, 'Nurse Room & Shift Assignments', 'SELECT r.RoomID, r.RoomDept, s.Hours, n.NurseID, n.NurseName, n.ManagerID FROM RcrawfordNurse n, RcrawfordNurseAssignment na, RcrawfordRoom r, RcrawfordShift s WHERE r.RoomID = na.RoomID AND n.NurseID = na.NurseID AND s.ShiftID = na.ShiftID ORDER BY r.RoomID'),
				 (NULL, 'Doctors', 'SELECT * FROM RcrawfordDoctor ORDER BY DoctorName'),
				 (NULL, 'Delivery Doctors', 'SELECT d.DoctorID, d.DoctorName, d.Credential, d.Street, d.City, d.State, d.Zip, d.Phone, s.SpecialtyName AS Specialty FROM RcrawfordDoctor d, RcrawfordSpecialty s WHERE d.SpecialtyID = s.SpecialtyID AND s.SpecialtyID = 12'),				 
				 (NULL, 'High Risk Specialist', 'SELECT d.DoctorID, d.DoctorName, d.Credential, d.Street, d.City, d.State, d.Zip, d.Phone, s.SpecialtyName AS Specialty FROM RcrawfordDoctor d, RcrawfordSpecialty s WHERE d.SpecialtyID = s.SpecialtyID AND s.SpecialtyID = 14'),				 
				 (NULL, 'Rooms & Availability', 'SELECT * FROM RcrawfordRoom'),
				 (NULL, 'Patient Procedures', 'SELECT * FROM RcrawfordPatientProcedure'),
				 (NULL, 'Procedures', 'SELECT * FROM RcrawfordProcedure'),
				 (NULL, 'Shifts', 'SELECT * FROM RcrawfordShift'),				 
				 (NULL, 'Patient Archive Records', 'SELECT * FROM RcrawfordPatientArchive');			 
				 
				 
CREATE TABLE RcrawfordPatientArchive (
				ArchiveID 									INT(6) 				NOT NULL AUTO_INCREMENT,
				PatientID 									INT(5),
				Name 											VARCHAR(17),
				TimeIn											VARCHAR(19),
				TimeOut										VARCHAR(19),
				Phone											VARCHAR(10),
				Insurance									VARCHAR(10),
CONSTRAINT Archive_PK  PRIMARY KEY (ArchiveID)
)ENGINE=INNODB;

INSERT INTO RcrawfordPatientArchive
VALUES	 (NULL,10056, 'Greta Hanks','2013-08-13 16:30:25', '2013-08-15 10:00:19', 4041598522, 'Easy Med'),
				(NULL,10061, 'Ruby Lewis','2013-08-07 02:11:58', '2013-08-18 07:06:10', 7706639542, 'Blue Cross'),
				(NULL,10078, 'Tara Hinkle','2013-08-19 10:20:52', '2013-08-25 08:16:23', 4047531596, 'Heart Health'),
				(NULL,10071, 'Jill Feldman','2013-09-05 14:01:03', '2013-09-10 11:45:41', 6787785525, 'Kaiser'),
				(NULL,10054, 'Connie Young','2013-10-26 09:27:21', '2013-11-03 10:52:30', 7704268532, 'Cigna');
				 
DESCRIBE RcrawfordSpecialty;				DESCRIBE RcrawfordRoom;						DESCRIBE RcrawfordProcedure; 		     DESCRIBE RcrawfordShift;
DESCRIBE RcrawfordPatient;					DESCRIBE RcrawfordDoctor;					DESCRIBE RcrawfordNurse;
DESCRIBE RcrawfordNurseAssignment;	DESCRIBE RcrawfordPatientProcedure;	DESCRIBE RcrawfordCheckIn; 
			 
SELECT * FROM RcrawfordSpecialty;SELECT * FROM RcrawfordRoom;  SELECT * FROM RcrawfordProcedure; SELECT * FROM RcrawfordShift;
SELECT * FROM RcrawfordPatient;   SELECT * FROM RcrawfordDoctor; SELECT * FROM RcrawfordNurse;        SELECT * FROM RcrawfordNurseAssignment;	
SELECT * FROM RcrawfordPatientProcedure;	 SELECT * FROM RcrawfordCheckIn;	     					 