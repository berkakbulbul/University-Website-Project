<?php

include "helper.php";

$conn = new mysqli("localhost", "root", ""); //Root

// Check connection
if ($conn->connect_errno) {
    console_log("Not connected");
    console_log($conn->connect_error);
    exit();
} else {
    console_log("Connected");
}
trigger_error(mysqli_error($conn));

// Create database
$sql = "CREATE DATABASE universitywebproject;";
if ($conn->query($sql) === TRUE) {
    console_log("Database created successfully");
} else {
    console_log("Error creating database: " . $conn->error);
}

$sql = "use universitywebproject;";
if ($conn->query($sql) === TRUE) {
    console_log("Using universitywebproject");
} else {
    console_log("Error: " . $conn->error);
}

$sql = "
CREATE TABLE course(
    CourseCode VARCHAR(100),
    Name VARCHAR(100),
    Type VARCHAR(100),
    Time VARCHAR(100),
    NumberofStudents INTEGER,
    PRIMARY KEY(CourseCode));
	
INSERT INTO `course`(`CourseCode`, `Name`, `Type`, `Time`, `NumberofStudents`) VALUES ('COE3210763','Web Design','Elective','Wednesday / 10:00 AM',50);
INSERT INTO `course`(`CourseCode`, `Name`, `Type`, `Time`, `NumberofStudents`) VALUES ('COE3268010','Computer Organization','Elective','Thursday / 06:00 AM',30);
INSERT INTO `course`(`CourseCode`, `Name`, `Type`, `Time`, `NumberofStudents`) VALUES ('COE3167980','Python Programming','Elective','Thursday / 06:00 AM',30);
INSERT INTO `course`(`CourseCode`, `Name`, `Type`, `Time`, `NumberofStudents`) VALUES ('COE3249650','Data Base','Mandatory','Wednesday / 10:00 AM',70);
INSERT INTO `course`(`CourseCode`, `Name`, `Type`, `Time`, `NumberofStudents`) VALUES ('COE3233890','Algorithm Analysis','Mandatory','Thursday / 13:30 PM',90);
INSERT INTO `course`(`CourseCode`, `Name`, `Type`, `Time`, `NumberofStudents`) VALUES ('COE3167930','Programming For Engineers','Mandatory','Monday / 13:30 PM',110);

CREATE TABLE student(
	CourseID VARCHAR(100),
    Username VARCHAR(100),
    Password VARCHAR(100),
    FName VARCHAR(100),
    LName VARCHAR(100),
    GPA Float,
    StudentNumber INTEGER,
    Class INTEGER); 

INSERT INTO `student`(`CourseID`,`Username`,`Password`,`FName`, `LName`, `GPA`, `StudentNumber`, `Class`) VALUES ('COE3210763','Yigit','123','Yigit','Hakverdi',3.20,64170013,1);
INSERT INTO `student`(`CourseID`,`Username`,`Password`,`FName`, `LName`, `GPA`, `StudentNumber`, `Class`) VALUES ('COE3268010','Yigit','123','Yigit','Hakverdi',3.20,64170013,1);
INSERT INTO `student`(`CourseID`,`Username`,`Password`,`FName`, `LName`, `GPA`, `StudentNumber`, `Class`) VALUES ('COE3249650','Yigit','123','Yigit','Hakverdi',3.20,64170013,1);
INSERT INTO `student`(`CourseID`,`Username`,`Password`,`FName`, `LName`, `GPA`, `StudentNumber`, `Class`) VALUES ('COE3210763','Berk','123','Berk','Akbulbul',2.98, 64160017,3);
INSERT INTO `student`(`CourseID`,`Username`,`Password`,`FName`, `LName`, `GPA`, `StudentNumber`, `Class`) VALUES ('COE3268010','Berk','123','Berk','Akbulbul',2.98, 64160017,3);
INSERT INTO `student`(`CourseID`,`Username`,`Password`,`FName`, `LName`, `GPA`, `StudentNumber`, `Class`) VALUES ('COE3210763','Melih','123','Melih','Urve Gumus',3.30,64170009,2);
INSERT INTO `student`(`CourseID`,`Username`,`Password`,`FName`, `LName`, `GPA`, `StudentNumber`, `Class`) VALUES ('COE3249650','Melih','123','Melih','Urve Gumus',3.30,64170009,2);


CREATE TABLE instructor(
	InstructorNumber INTEGER,
    CourseID VARCHAR(100),
	Username VARCHAR(100),
	Password VARCHAR(100),
    FName VARCHAR(100),
    LName VARCHAR(100),
    RGName VARCHAR(100));
	
INSERT INTO `instructor`(`InstructorNumber`,`CourseID`,`Username`,`Password`,`FName`, `LName`, `RGName`) VALUES (53215, 'COE3249650','Reda','123','Reda','Alhaj','Social Network Analysis');
INSERT INTO `instructor`(`InstructorNumber`,`CourseID`,`Username`,`Password`,`FName`, `LName`, `RGName`) VALUES (53215, 'COE3233890','Reda','123','Reda','Alhaj','Social Network Analysis');
INSERT INTO `instructor`(`InstructorNumber`,`CourseID`,`Username`,`Password`,`FName`, `LName`, `RGName`) VALUES (53215, 'COE3167930','Reda','123','Reda','Alhaj','Social Network Analysis');
INSERT INTO `instructor`(`InstructorNumber`,`CourseID`,`Username`,`Password`,`FName`, `LName`, `RGName`) VALUES (12452, 'COE3210763','Muhsin','123','Muhsin','Ugur','Intergating Mobile Psychometrics');
INSERT INTO `instructor`(`InstructorNumber`,`CourseID`,`Username`,`Password`,`FName`, `LName`, `RGName`) VALUES (14351, 'COE3268010','Tuncer','123','Tuncer','Baykas','Anomaly Detection');
INSERT INTO `instructor`(`InstructorNumber`,`CourseID`,`Username`,`Password`,`FName`, `LName`, `RGName`) VALUES (14351, 'COE3167980','Tuncer','123','Tuncer','Baykas','Anomaly Detection');

CREATE TABLE secretary( 
   Username VARCHAR(100),
   Password VARCHAR(100),
   FName VARCHAR(100) , 
   LName VARCHAR(100));

INSERT INTO `secretary`(`Username`,`Password`,`FName`,`LName`) VALUES ('Kemal','123','Mehmet','Kemal');   

CREATE TABLE rg(	
    Name VARCHAR(100),
    stdID INTEGER,
    instID INTEGER);
 
INSERT INTO `rg`(`Name`,`stdID`,`instID`) VALUES ('Anomaly Detection',64170013, 14351);
INSERT INTO `rg`(`Name`,`stdID`,`instID`) VALUES ('Social Network Analysis',64160017, 53215);
INSERT INTO `rg`(`Name`,`stdID`,`instID`) VALUES ('Social Network Analysis',64170009, 53215);

CREATE TABLE upload(
    stdID VARCHAR(200),
    Name VARCHAR(200));

CREATE TABLE rg_requests(
    insID INTEGER NOT NULL,
    stdID INTEGER NOT NULL,
    note VARCHAR(200),
    resume VARCHAR(200),
    PRIMARY KEY (insID,stdID));
";
if ($conn->multi_query($sql) === TRUE) {
    console_log("Queries successfully executed");
} else {
    console_log("Error creating database: " . $conn->error);
}
$conn->close();
console_log("Connection closed");
