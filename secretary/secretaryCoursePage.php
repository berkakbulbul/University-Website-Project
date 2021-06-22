<!DOCTYPE html>
<html>
<?php
session_start();
// Connecting to database
include "../utils/connect.php";
include "../utils/helper.php";

// Query for all courses
$sql = "select CourseCode, Name, Type, FName, Time from instructor, course where course.CourseCode=instructor.CourseID;";
$result_courses = mysqli_query($conn, $sql);
trigger_error(mysqli_error($conn));

// First check if user exist in the database or not after deleting actions 
// If user do not exists due to deleting actions then add a new user with
// Same credentials to the database but with the deleted information preserved
$Username = $_GET["Username"];
$Password = $_GET["Password"];
$InstructorNumber = $_GET["InstructorNumber"];
$Password = $_GET["Password"];
$FName = $_GET["FName"];
$LName = $_GET["LName"];   
$RGName = $_GET["RGName"]; 

// If username is not null then query formatted with the Username
// Checked if user exists if not then with the credentials preserves
// with the $_GET methods formatted with the query string to INSERT 
// user again to the DB
if ($Username != null) {
    $sql_check = "SELECT * FROM instructor WHERE Username='$Username'";
    $result = mysqli_query($conn, $sql_check);
    $row = mysqli_fetch_array($result);
    trigger_error(mysqli_error($conn));
    if (!($result->num_rows > 0)) {
        $sql_insert = "INSERT INTO `instructor`
                        (`InstructorNumber`,`Username`,`Password`,`FName`,`LName`,`RGName`) 
                        VALUES 
                        ($InstructorNumber,'$Username','$Password','$FName','$LName','$RGName');";
        $result_insert = mysqli_query($conn, $sql_insert);
        trigger_error(mysqli_error($conn));
        if (!$result_insert) {
            console_log("Error:" . mysqli_error($conn));
            exit();
        }
    }
}
?>

<head>
    <link rel="stylesheet" href="secretaryCoursePage.css">
    <script src="secretaryCoursePage.js"></script>
    <title>Secretary Course Page</title>

</head>

<body>
    <div class="sidenav">
        <img class="profilephoto" src="../Icons/user.svg" width="100" height="100">
        <div class="navTextDiv">
            <label class="user"><?php echo($_SESSION["Username"]);?></label>
            <br>
            <label class="user">Secretary</label>
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

    <div class="content">
        <div style="margin-bottom: 10px; margin-left: 10px">
            <div class="createCourseLabel">
                <label>Create Course</label>
            </div>
            <a href="secretaryCreateClass.php"><img title="Create a class" src="../Icons/add.svg" height="35" width="35"></a>
        </div>

        <div class="tableclass">
            <table style="width:100%">
                <tr>
                    <th>Course Code</th>
                    <th>Course name</th>
                    <th>Course type</th>
                    <th>Course instructor</th>
                    <th>Course time</th>
                    <th>Delete Course</th>
                </tr>
                <?php while ($row = mysqli_fetch_array($result_courses)) :; ?>
                    <tr>
                        <td><?php echo $row["CourseCode"]; ?></td>
                        <td><?php echo $row["Name"]; ?></td>
                        <td><?php echo $row["Type"]; ?></td>
                        <td><?php echo $row["FName"]; ?></td>
                        <td><?php echo $row["Time"]; ?></td>
                        <td><a href="../utils/delete.php?CourseCode=<?php echo $row['CourseCode']; ?>">Delete</a></td>
                    </tr>
                <?php endwhile; ?>
                <tr style="background-color: #ffe2e2">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Download the Current Semester</td>
                    <td title="Download the Current Semester"><a href="../utils/exceldownload.php?AccType=secretary"><img src="../Icons/download-file.svg" width="35" height="35"></a></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="main">
    </div>
</body>
</html>