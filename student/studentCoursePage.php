<!DOCTYPE html>
<html>
<?php
// Starting session
session_start();
unset($_SESSION["error"]);
// Connection established to MySQL
include "../utils/connect.php";
include "../utils/helper.php";

// Obtaining student ID from $_SESSION
$studentNumber = $_SESSION["StudentNumber"];
$courseID = $row_courseID["ID"];
$username = $_SESSION["Username"];
$password = $_SESSION["Password"];
$FName = $_SESSION["FName"];
$LName = $_SESSION["LName"];
$GPA = $_SESSION["GPA"];
$Class = $_SESSION["Class"];
// First check if user exist in the database or not after dropping actions
$sql_check = "SELECT * FROM student WHERE Username='$username' and Password='$password'";
$result = $conn->query($sql_check);
if (!($result->num_rows > 0)) {
    $sql_insert = "INSERT INTO `student`(`Username`,`Password`,`FName`, `LName`, `GPA`, `StudentNumber`,`Class`) 
                    VALUES ('$username', '$password', '$FName', '$LName', $GPA, $studentNumber,$Class);";
    $result_insert = mysqli_query($conn, $sql_insert);
    trigger_error(mysqli_error($conn));
    if (!$result_insert) {
        console_log("Error:" . mysqli_error($conn));
        exit();
    }
}

// Query for available courses
$sql = "
SELECT * FROM course WHERE course.CourseCode NOT IN
(
	SELECT student.courseID
	FROM student
	JOIN course
	ON course.CourseCode=student.courseID
	WHERE student.StudentNumber=$studentNumber
);";
$result_available_courses = mysqli_query($conn, $sql);

// Query for taken courses
$sql = "SELECT CourseCode, Name, Type, FName FROM course, student 
        WHERE student.StudentNumber=$studentNumber and student.courseID=course.CourseCode;";
$result_taken_courses = mysqli_query($conn, $sql);

// trigger_error(mysqli_error($conn));
?>


<head>
    <link rel="stylesheet" href="studentCoursePage.css?v=<?php echo time(); ?>">
    <script src="studentCoursePage.js"></script>
    <title>Student Course Page</title>
</head>

<body>
    <div class="sidenav">
        <img class="profilephoto" src="../Icons/user.svg" width="100" height="100">
        <div class="navTextDiv">
            <label class="user"><?php echo $_SESSION["FName"]; ?></label><br>
            <label class="user"><?php echo $_SESSION["StudentNumber"]; ?></label>
            <br>
            <label class="user">Student</label>
            <hr>
        </div>
        <div class="navTextDiv">
            <a href="studentCoursePage.php">Course Page</a>
        </div>
        <hr>
        <div class="navTextDiv">
            <a href="joinResearchGroup.php">Join a Research Group Page</a>
        </div>
        <hr>
        <div class="navTextDiv1" style=" position: absolute; width: 100%; bottom: 3%; text-align: center; ">
            <hr>
            <a href="../unsetsession.php">Logout</a>
            <hr>
        </div>
    </div>

    <div class="content">
        <h3>Available Courses</h3>
        <div class="tableclass">
            <table style="width:100%">
                <tr>
                    <th>Course Code</th>
                    <th>Course name</th>
                    <th>Course Type</th>
                    <th></th>
                </tr>
                <?php while ($row = mysqli_fetch_array($result_available_courses)) :; ?>
                    <tr>
                        <td><?php echo $row["CourseCode"]; ?></td>
                        <td><?php echo $row["Name"]; ?></td>
                        <td><?php echo $row["Type"]; ?></td>
                        <td><a href="../utils/add.php?CourseCode=<?php echo $row['CourseCode']; ?>">Add</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <div class="content">
        <h3>Taken Course</h3>
        <div class="tableclass">
            <table style="width:100%">
                <tr>
                    <th>Course Code</th>
                    <th>Course name</th>
                    <th>Course Type</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php while ($row1 = mysqli_fetch_array($result_taken_courses)) :; ?>
                    <tr>
                        <td><?php echo $row1["CourseCode"]; ?></td>
                        <td><?php echo $row1["Name"]; ?></td>
                        <td><?php echo $row1["Type"]; ?></td>
                        <td><a href="../utils/drop.php?CourseCode=<?php echo $row1['CourseCode']; ?>">Drop</a></td>
                        <td><a href="../utils/download.php?CourseCode=<?php echo $row1['CourseCode']; ?>"> <img src="../Icons/download-file.svg" width="35" height="35"> </a></td>
                    </tr>
                <?php endwhile; ?>
                <tr style="background-color: #ffe2e2">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Download taken courses</td>
                    <td title="Download Taken Courses"><a href="../utils/exceldownload.php?AccType=student"><img src="../Icons/download-file.svg" width="35" height="35"></a></td>
                </tr>
            </table>
            <?php
            if (isset($_SESSION["error_nofile"])) {
                $error = $_SESSION["error_nofile"];
                echo "<label class='error_message'>$error</label><br>";
                unset($_SESSION["error_nofile"]);
            }
            ?>
        </div>
    </div>
    <div class="main">
    </div>
</body>
</html>