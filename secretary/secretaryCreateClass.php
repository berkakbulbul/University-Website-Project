<!DOCTYPE html>
<?php
// Starting session
session_start();
// Connection established to MySQL
include "../utils/connect.php";
include "../utils/helper.php";

// Query for research group information
$sql = "SELECT DISTINCT instructor.FName, instructor.LName FROM instructor;";
?>
<html>

<head>
    <link rel="stylesheet" href="secretaryCreateClass.css">
    <title>Secretary Create Class</title>

</head>

<body>
    <div class="sidenav">
        <img class="profilephoto" src="../Icons/user.svg" width="100" height="100">
        <div class="navTextDiv">
            <label class="user">Username</label>
            <br>
            <label class="user">Student</label>
            <hr>
        </div>
        <div class="navTextDiv">
            <a href="secretaryCoursePage.php">Dashboard</a>
        </div>
        <hr>
        <div class="navTextDiv1" style=" position: absolute; width: 100%; bottom: 3%; text-align: center; ">
            <hr>
            <a href="../unsetsession.php">Logout</a>
            <hr>
        </div>

    </div>

    <div class="container">
        <a href="secretaryCoursePage.php"><img src="../Icons/cancel.svg" width="30" height="30" style="margin-left: 400px;"></a>
        <div class="text" margin="auto">
            Create Class</div>
        <form action="" method="post">
            <div class="data">
                <label>Course Code</label>
                <input type="text" name="CourseCode" required>
            </div>
            <div class="data">
                <label>Course Name</label>
                <input type="text" name="CourseName" required>
            </div>
            <div>
                <label>Course Type</label> <br>
                <input type="radio" name="CourseType" value="Mandatory"> Mandatory<br>
                <input type="radio" name="CourseType" value="Elective"> Elective
            </div>
            <div class="data">
                <label>Course Instructor</label>
                <select name="InstructorName" class="dropdown" size="1">
                    <?php
                    $sql = mysqli_query($conn, $sql);
                    while ($row = $sql->fetch_assoc()) {
                        echo "<option value=" . $row["LName"] . ">" . $row['FName'] . ' ' . $row['LName'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="data">
                <label>Course Time</label>
                <input type="datetime-local" date="{{date}}" timezone="[[timezone]]" name="CourseTime" required>
            </div>
            <div class="btn">
                <button type="submit">Create</button>
            </div>
        </form>
    </div>

</body>
<?php
// $_POST intiliazed to obtain FORM data
$CourseCode = $_POST["CourseCode"];
$CourseName = $_POST["CourseName"];
$CourseType = $_POST["CourseType"];
$InstructorName = $_POST["InstructorName"];
$CourseTime = $_POST["CourseTime"];

// SELECT FROM INSTRUCTOR FOR RETRIEVING INSTRUCTOR INFO
$sql_get_instructor_info = "SELECT * FROM instructor WHERE instructor.LName='$InstructorName'";
$result = mysqli_query($conn, $sql_get_instructor_info);
$row = mysqli_fetch_array($result);

// INSERT INTO INSTRUCTOR WITH THE RETRIEVED INFO AND NEW COURSE ASSIGNED BY SECRETARY
$sql_insert_instructor = "INSERT INTO `instructor`
(`CourseID`,`InstructorNumber`,`Username`,`Password`,`FName`,`LName`,`RGName`) 
VALUES 
('$CourseCode', %s,'%s','%s','%s','%s','%s');";
$sql_insert_instructor = sprintf(
    $sql_insert_instructor,
    $row['InstructorNumber'],
    $row['Username'],
    $row['Password'],
    $row['FName'],
    $row['LName'],
    $row['RGName']
);
$result_insert = mysqli_query($conn, $sql_insert_instructor);

// INSERTING NEW COURSE TO THE COURSE TABLE 
$sql_insert_course = $sql_insert_instructor = "INSERT INTO `course`
(`CourseCode`,`Name`,`Type`,`Time`,`NumberofStudents`) 
VALUES 
('$CourseCode', '$CourseName', '$CourseType', '$CourseTime', 0);";
// $result_insert = mysqli_query($conn, $sql_insert_course);

// IF COURSE INSERTED SUCCESSFULLY REDIRECT TO MAIN PAGE
if ($conn->query($sql_insert_course) == TRUE and $_POST["CourseTime"] != null) {
    echo "<script type='text/javascript'>window.top.location='http://localhost/universitywebproject/secretary/secretaryCoursePage.php';</script>";
} else {
    console_log($conn->error);
}

// Olusturulan bos kayit silinidi
$sql_delete = "DELETE FROM course WHERE course.Name='';";
$result_insert = mysqli_query($conn, $sql_delete);
?>
</html>