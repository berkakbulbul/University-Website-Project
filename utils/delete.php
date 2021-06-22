<?php
// Start session
session_start();

// Connection established to MySQL
include "connect.php";
include "helper.php";

// Get the related information from the table for updating database
$CourseCode = $_GET['CourseCode'];

// Get the instructor FName for further operations
$sql = "SELECT * FROM instructor WHERE instructor.CourseID='$CourseCode'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$Username = $row["Username"];
$InstructorNumber = $row["InstructorNumber"];
$Password = $row["Password"];
$FName = $row["FName"];
$LName = $row["LName"];   
$RGName = $row["RGName"];       

// Deleting related record from the database
$sql_delete = "DELETE FROM instructor WHERE instructor.CourseID='$CourseCode'";
$result_delete = mysqli_query($conn, $sql_delete);

// Delete related course from the course table as well
$sql_delete = "DELETE FROM course WHERE course.CourseCode='$CourseCode'";
$result_delete = mysqli_query($conn, $sql_delete);

// After succsefully updated database redirect to the student course page again
header("Location: http://localhost/universitywebproject/secretary/secretaryCoursePage.php?InstructorNumber=$InstructorNumber&Username=$Username&Password=$Password&FName=$FName&LName=$LName&RGName=$RGName");
?>