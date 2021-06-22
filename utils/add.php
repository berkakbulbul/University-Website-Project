<?php
// Start session
session_start();

// Connection established to MySQL
include "connect.php";
include "helper.php";

// Get the related information from the table for updating database
$CourseCode = $_GET['CourseCode'];

// Initialize $_SESSION variables and course ID obtained for formatting query strings
$studentNumber = $_SESSION["StudentNumber"];
$username = $_SESSION["Username"];
$password = $_SESSION["Password"];
$FName = $_SESSION["FName"];
$LName = $_SESSION["LName"];
$GPA = $_SESSION["GPA"];
$Class = $_SESSION["Class"];
// Insert related course to the student table with the course ID
$sql_insert = "INSERT INTO `student`(`CourseID`,`Username`,`Password`,`FName`, `LName`, `GPA`, `StudentNumber`,`Class`) VALUES ('$CourseCode', '$username', '$password', '$FName', '$LName', $GPA, $studentNumber, $Class);";
$result_insert = mysqli_query($conn, $sql_insert);
if (!$result_insert) {
    console_log("Error:" . mysqli_error($conn));
    exit();
}

// Increment student number for the related course by one
$sql_update = "UPDATE course SET NumberofStudents = NumberofStudents + 1 WHERE CourseCode='$CourseCode'";
$result_delete = mysqli_query($conn, $sql_update);

// Return to the student course page
header("Location: http://localhost/universitywebproject/student/studentCoursePage.php");
?>