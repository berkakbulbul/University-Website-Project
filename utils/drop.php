<?php
// Start session
session_start();

// Connection established to MySQL
include "connect.php";
include "helper.php";

// Get the related information from the table for updating database
$CourseCode = $_GET['CourseCode'];

// Related informations initliazed to variables for formatting query strings
$studentNumber = $_SESSION["StudentNumber"];

// Deleting related record from the database
$sql_delete = "DELETE FROM student WHERE student.CourseID='$CourseCode' AND student.StudentNumber=$studentNumber;";
$result_delete = mysqli_query($conn, $sql_delete);
if (!$result_delete) {
    console_log("Error:" . mysqli_error($conn));
    exit();
}

// Decrement student number for the related course by one
$sql_update = "UPDATE course SET NumberofStudents = NumberofStudents - 1 WHERE CourseCode='$CourseCode'";
$result_delete = mysqli_query($conn, $sql_update);

// After succsefully updated database redirect to the student course page again
header("Location: http://localhost/universitywebproject/student/studentCoursePage.php");
?>