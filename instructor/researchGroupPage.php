<!DOCTYPE html>

<?php
// Starting session
session_start();

// Connection established to MySQL
include "../utils/connect.php";

$instructorID = $_SESSION["instructorID"];
$Username = $_SESSION["Username"];
$Password =  $_SESSION["Password"];
$FName  = $_SESSION["FName"];
$LName =  $_SESSION["LName"];
$RGName = $_SESSION["RGName"];

$sql = "
SELECT DISTINCT Class,stdID,FName,LName,GPA  FROM rg JOIN student WHERE student.StudentNumber = rg.stdID and rg.instID = $instructorID;
";
$rg_stud = mysqli_query($conn, $sql);

$sql_jr = "
select Distinct r.note, r.resume, r.insID, r.stdID, s.FName, s.LName,s.GPA 
from rg_requests as r, student as s 
where r.stdID = s.StudentNumber and r.insID = $instructorID;
";
$rg_jr = mysqli_query($conn, $sql_jr);

// $sql_resume_note = "select rg_requests.resume, rg_requests.name from rg_requests, student
// where rg_requests.stdID=student.StudentNumber and rg_requests.insID='$instructorID';";
// $rg_resume_note = mysqli_query($conn, $sql_resume_note);

?>

<html>

<head>
    <link rel="stylesheet" href="researchGroupPage.css">
    <script src="researchGroupPage.js"></script>
    <title>Research Group Page</title>
</head>

<body>
    <div class="sidenav">
        <img class="profilephoto" src="../Icons/user.svg" width="100" height="100">
        <div class="navTextDiv">
            <label class="user"> <?php echo $Username;
                                    echo (" " . $LName); ?> </label>
            <br>
            <label class="user">Instructor</label>
            <hr>
        </div>
        <div class="navTextDiv">
            <a href="instructorCoursePage.php">Course Page</a>
        </div>
        <hr>
        <div class="navTextDiv">
            <a href="researchGroupPage.php">Research Group Page</a>
        </div>
        <hr>
        <div class="navTextDiv1" style=" position: absolute; width: 100%; bottom: 3%; text-align: center; ">
            <hr>
            <a href="../unsetsession.php">Logout</a>
            <hr>
        </div>
    </div>

    <div class="content">
        <?php echo "<h3> $RGName Research Group </h3>"; ?>
        <div class="tableclass">
            <table style="width:100%" align="center">

                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>GPA</th>
                    <th>Class</th>
                    <th>Taken Course</th>
                </tr>
                <tr>
                    <?php while ($row1 = mysqli_fetch_array($rg_stud)) :; ?>
                        <td><?php echo $row1["stdID"]; ?></td>
                        <td><?php echo $row1["FName"]; ?></td>
                        <td><?php echo $row1["LName"]; ?></td>
                        <td><?php echo $row1["GPA"]; ?></td>
                        <td><?php echo $row1["Class"]; ?></td>
                        <td>
                            <?php
                            $ID = $row1["stdID"];
                            $qry = "select name from course,student where student.StudentNumber =$ID and course.CourseCode = student.CourseID;";
                            $abc = mysqli_query($conn, $qry);

                            while ($row2 = mysqli_fetch_array($abc)) {
                                echo $row2["name"] . "<br>";
                            };


                            ?>
                        </td>

                </tr>
            <?php endwhile; ?>
            </table>
        </div>
    </div>

    <div class="content">
        <h3>RESEARCH GROUP JOIN REQUESTS</h3>
        <div class="tableclass">
            <table style="width:100%" align="center">
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>GPA</th>
                    <th>Note</th>
                    <th>Resume</th>
                    <th>Approve/Refect</th>
                    <th></th>
                </tr>
                <tr>
                    <?php while ($row1 = mysqli_fetch_array($rg_jr)) :
                        $insID = $row1["insID"]; ?>
                        <td><?php echo $row1["stdID"]; ?></td>
                        <td><?php echo $row1["FName"]; ?></td>
                        <td><?php echo $row1["LName"]; ?></td>
                        <td><?php echo $row1["GPA"]; ?></td>
                        <td><?php echo $row1["note"]; ?></td>
                        <td><?php echo $row1["resume"];?></td>
                        <td>
                        <a href="../utils/download-resume.php?resume=<?php echo $row1['resume']; ?>"> 
                        <img src="../Icons/download-file.svg" width="35" height="35"> 
                        </a>
                        </td>
                        <td>
                            <button onclick="showAlertApprove()">
                                <a href="../utils/approve.php?stdID=<?php echo $row1['stdID']; ?>&insID=<?php echo $insID; ?>&RGName=<?php echo $RGName ?>">Approve</a></button>
                            <button><a href="../utils/reject.php?stdID=<?php echo $row1['stdID']; ?>&insID=<?php echo $insID; ?>">Reject</a></button>
                        </td>
                </tr>
            <?php endwhile; ?>
            </table>
        </div>

    </div>
    <div class="main">
    </div>
</body>

</html>