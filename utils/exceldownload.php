<?php
// Starting session for related credentails of the user to format query string
session_start();

// Including connection and utils for further operations
include "helper.php";
include "connect.php";

// Obtaining Accout Type via URL 
$AccType = $_GET["AccType"];

// According to user type table format changes thus each user must be handeled differently

// STUDENT
if ($AccType == "student") {
    $studentNumber = $_SESSION["StudentNumber"];
    $output = "";
    $sql = "SELECT CourseCode, Name, Type, FName FROM course, student 
    WHERE student.StudentNumber=$studentNumber and student.courseID=course.CourseCode;";
    $result = mysqli_query($conn, $sql);
    $output .= '
<table>
    <tr>
        <td>Course Code</td>
        <td>Course Name</td>
        <td>Course Type</td>
    </tr>
';

    while ($row = mysqli_fetch_array($result)) {
        $output .= '
        <tr>
            <td>' . $row["CourseCode"] . '</td>
            <td>' . $row["Name"] . '</td>
            <td>' . $row["Type"] . '</td>
        </tr>
    ';
    }

    $output .= '</table>';
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=Taken Courses.xls');
    echo $output;
}

// INSTRUCTOR
if ($AccType == "instructor") {
    $instructorID = $_SESSION["instructorID"];
    $output = "";
    $sql = "SELECT * FROM course JOIN instructor ON instructor.CourseID = course.CourseCode 
    WHERE instructor.InstructorNumber= $instructorID ;";
    $result = mysqli_query($conn, $sql);
    $output .= '
<table>
    <tr>
        <td>Course Code</td>
        <td>Course Name</td>
        <td>Course Type</td>
        <td>Student#</td>
        <td>Course Time</td>
    </tr>
';

    while ($row = mysqli_fetch_array($result)) {
        $output .= '
        <tr>
            <td>' . $row["CourseCode"] . '</td>
            <td>' . $row["Name"] . '</td>
            <td>' . $row["Type"] . '</td>
            <td>' . $row["NumberofStudents"] . '</td>
            <td>' . $row["Time"] . '</td>
        </tr>
    ';
    }

    $output .= '</table>';
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=Given Courses.xls');
    echo $output;
}

// SECRETARY
if ($AccType == "secretary") {
    $output = "";
    $sql = "select CourseCode, Name, Type, FName, Time from instructor, course where course.CourseCode=instructor.CourseID;";
    $result = mysqli_query($conn, $sql);
    $output .= '
<table>
    <tr>
        <td>Course Code</td>
        <td>Course Name</td>
        <td>Course Type</td>
        <td>Course Instructor</td>
        <td>Course Time</td>
    </tr>
';

    while ($row = mysqli_fetch_array($result)) {
        $output .= '
        <tr>
            <td>' . $row["CourseCode"] . '</td>
            <td>' . $row["Name"] . '</td>
            <td>' . $row["Type"] . '</td>
            <td>' . $row["FName"] . '</td>
            <td>' . $row["Time"] . '</td>
        </tr>
    ';
    }

    $output .= '</table>';
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=Semester Courses.xls');
    echo $output;
}
