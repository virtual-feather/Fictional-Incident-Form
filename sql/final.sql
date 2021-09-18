
CREATE DATABASE CSRIT;

USE CSRIT;


CREATE TABLE INCIDENTTYPE
	(IncidentTypeID INT NOT NULL AUTO_INCREMENT, 
	IncidentType VARCHAR(100) NOT NULL,
	CONSTRAINT INCIDENT_TYPE_PK PRIMARY KEY(IncidentTypeID));

CREATE TABLE INCIDENT
	(IncidentID INT NOT NULL AUTO_INCREMENT, 
	IncidentTypeID INT NOT NULL, 
	DateOfEntry DATE NOT NULL, 
	IncidentState VARCHAR(10) NOT NULL, 
	CONSTRAINT INCIDENT_PK PRIMARY KEY(IncidentID),
	CONSTRAINT INCIDENT_FK FOREIGN KEY(IncidentTypeID) REFERENCES INCIDENTTYPE(IncidentTypeID),
	CHECK (IncidentState in  ('open', 'closed', 'stalled')));

CREATE TABLE PERSON 
	(emailAddress VARCHAR(50) NOT NULL, 
	lastname VARCHAR(25) NOT NULL, 
	firstname VARCHAR(25) NOT NULL, 
	job VARCHAR(25) NOT NULL, 
	title VARCHAR(25) NOT NULL,
	password VARCHAR(25) NOT NULL,
	CONSTRAINT PERSON_PK PRIMARY KEY(emailAddress));

CREATE TABLE COMMENTS 
	(CommentID INT NOT NULL AUTO_INCREMENT, 
	IncidentID INT NOT NULL, 
	Comment VARCHAR(100) NOT NULL, 
	DateOfEntry DATE NOT NULL,
	emailAddress VARCHAR(50),
	CONSTRAINT COMMENT_PK PRIMARY KEY(CommentID, IncidentID),
	CONSTRAINT COMMENT_FK FOREIGN KEY( IncidentID) REFERENCES INCIDENT(IncidentID),
	CONSTRAINT COMMENTPERSON_FK FOREIGN KEY( emailAddress) REFERENCES PERSON(emailAddress));

CREATE TABLE IPADDRESS
	(emailAddress VARCHAR(50) NOT NULL,
	IPaddress VARCHAR(50) NOT NULL, 
	CONSTRAINT IPaddress_PK PRIMARY KEY(IPaddress),
	CONSTRAINT IPaddress__FK FOREIGN KEY( emailAddress) REFERENCES PERSON(emailAddress));

INSERT INTO INCIDENTTYPE VALUES(null, "Unusual behavior");
INSERT INTO INCIDENTTYPE VALUES(null, "Unauthorized insiders");
INSERT INTO INCIDENTTYPE VALUES(null, "Traffic sent to or from unknown locations");
INSERT INTO INCIDENTTYPE VALUES(null, "Excessive consumption");
INSERT INTO INCIDENTTYPE VALUES(null, "Changes in configuration");
INSERT INTO INCIDENTTYPE VALUES(null, "Hidden file");
INSERT INTO INCIDENTTYPE VALUES(null, "Abnormal browsing behavior");
INSERT INTO INCIDENTTYPE VALUES(null, "Suspicious registry entries");
INSERT INTO INCIDENTTYPE VALUES(null, "Unexpected changes");
INSERT INTO INCIDENTTYPE VALUES(null, "Anomalies in outbound network Traffic");


INSERT INTO PERSON VALUES("johnsmith@gmail.com" , 'Smith' , 'John' , 'Network Engineer', 'Dr.', '1234' );
INSERT INTO PERSON VALUES('robbyS@yahoo.com', 'Shire', 'Robert', 'Network Adminstrator', 'Mr.' , '1234' );
INSERT INTO PERSON VALUES('DorisTierney729@msn.com', 'Tierney','Doris' , 'Database Administrator' , 'Ms.', '1234' );
INSERT INTO PERSON VALUES('svane90@gmail.com' , 'Svane', 'Jack' , 'Computer Security','Mr.','1234' );
INSERT INTO PERSON VALUES('roseandy@gmail.com', 'Anderson', 'Rose' , 'Software Engineer', 'Dr.','1234' );
INSERT INTO PERSON VALUES('AndersonDonna@yahoo.com' , 'Anderson', 'Donna', 'Telecom. Specialists', 'Mrs.' , '1234' );
INSERT INTO PERSON VALUES('ChrisJonhson@yahoo.com', 'Johnson' , 'Chris' , 'Network Adminstrator', 'Ms.' , '1234');
INSERT INTO PERSON VALUES('GraceEnquist@gmail.com', 'Enquist' , 'Grace' , 'Computer Security' , 'Ms.', '1234');
INSERT INTO PERSON VALUES('KathyFitz@gmail.com', 'Fitzgerald' , 'Katherine' , 'Software Engineer', "Dr.", '1234' );
INSERT INTO PERSON VALUES('NicoleWalsh@msn.com' , 'Walsh' , 'Nicole' , 'Doctor', 'Dr.' , '1234');

INSERT INTO IPADDRESS VALUES("johnsmith@gmail.com", '168.212.226.204');
INSERT INTO IPADDRESS VALUES("johnsmith@gmail.com", '168.212.226.205');
INSERT INTO IPADDRESS VALUES("johnsmith@gmail.com", '168.212.226.206');
INSERT INTO IPADDRESS VALUES("robbyS@yahoo.com", '168.212.106.105');
INSERT INTO IPADDRESS VALUES("robbyS@yahoo.com", '168.212.106.106');
INSERT INTO IPADDRESS VALUES("robbyS@yahoo.com", '168.212.106.107');
INSERT INTO IPADDRESS VALUES('DorisTierney729@msn.com', '120.212.106.110');
INSERT INTO IPADDRESS VALUES('svane90@gmail.com', '225.225.106.170');
INSERT INTO IPADDRESS VALUES('svane90@gmail.com', '225.225.106.171');
INSERT INTO IPADDRESS VALUES('svane90@gmail.com', '225.225.106.172');
INSERT INTO IPADDRESS VALUES('roseandy@gmail.com', '153.122.198.102');
INSERT INTO IPADDRESS VALUES('roseandy@gmail.com', '153.122.198.103');
INSERT INTO IPADDRESS VALUES('roseandy@gmail.com', '153.122.198.104');
INSERT INTO IPADDRESS VALUES('roseandy@gmail.com', '153.122.198.105');
INSERT INTO IPADDRESS VALUES('AndersonDonna@yahoo.com', '197.143.225.102');
INSERT INTO IPADDRESS VALUES('ChrisJonhson@yahoo.com', '199.198.205.205');
INSERT INTO IPADDRESS VALUES('ChrisJonhson@yahoo.com', '199.198.205.204');
INSERT INTO IPADDRESS VALUES('GraceEnquist@gmail.com', '199.100.104.252');
INSERT INTO IPADDRESS VALUES('GraceEnquist@gmail.com', '199.100.104.253');
INSERT INTO IPADDRESS VALUES('KathyFitz@gmail.com', '167.142.108.202');
INSERT INTO IPADDRESS VALUES('KathyFitz@gmail.com', '167.142.108.200');
INSERT INTO IPADDRESS VALUES('NicoleWalsh@msn.com', '160.192.109.204');