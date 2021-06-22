<!DOCTYPE html>
<html>
<?php
session_start();

include "../utils/connect.php";
include "../utils/helper.php";
$instructorID = $_SESSION["instructorID"];
console_log($instructorID);
$Username = $_SESSION["Username"];
$Password =  $_SESSION["Password"];
$FName  = $_SESSION["FName"];
$LName =  $_SESSION["LName"];
$RGName = $_SESSION["RGName"];

$sql = "
SELECT * FROM course JOIN instructor ON instructor.CourseID = course.CourseCode 
WHERE instructor.InstructorNumber= $instructorID ;";
$courses_specific_to_instructor = mysqli_query($conn, $sql);
?>






<head>
    <link rel="stylesheet" href="instructorCoursePage.css">
    <script src="instructorCoursePage.js"></script>
    <title>Instructor Course Page</title>
</head>

<body>
    <div class="sidenav">
        <img class="profilephoto" src="../Icons/user.svg" width="100" height="100">
        <div class="navTextDiv">
            <label class="user"><?php echo $_SESSION['FName'] . " ";
                                echo $_SESSION['LName'];  ?> </label>
            <br>
            <label class="user">Instructor</label>
            <hr>
        </div>
        <div class="navTextDiv">
            <a href="#">Course Page</a>
        </div>
        <hr>
        <div class="navTextDiv">
            <a href="researchGroupPage.php">Research Group Page</a>
        </div>
        <div class="navTextDiv1" style=" position: absolute; width: 100%; bottom: 3%; text-align: center; ">
            <hr>
            <a href="../unsetsession.php">Logout</a>
            <hr>
        </div>
        <hr>
    </div>



    <div class="content">
        <div class="tableclass">
            <table style="width:100%">
                <tr>
                    <th>Course Code</th>
                    <th>Course name</th>
                    <th>Course type</th>
                    <th>Number of Registere Student</th>
                    <th>Course time</th>
                    <th>Upload Class Material</th>
                </tr>
                <?php while ($row = mysqli_fetch_array($courses_specific_to_instructor)) :;  ?>
                    <tr>
                        <td><?php echo $row["CourseCode"]; ?></td>
                        <td><?php echo $row["Name"]; ?></td>
                        <td><?php echo $row["Type"]; ?></td>
                        <td><?php echo $row["NumberofStudents"]; ?></td>
                        <td><?php echo $row["Time"]; ?></td>
                        <td>
                            <form action="instructorCoursePage.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="file">
                                <button type="submit" name="submit">submit</button>
                            </form>
                        </td>

                    </tr>
                    <?php
                    // Get the related information from the table for updating database
                    $CourseCode = $row['CourseCode'];
                    echo "this is course code : " . $CourseCode;

                    if (isset($_POST['submit'])) {
                        $filename = $_FILES['file']['name'];
                        $fileTmpName = $_FILES['file']["tmp_name"];
                        $path = "../Files/" . $filename;

                        $query = "
                        INSERT INTO upload(stdID,Name) VALUES ('$CourseCode','$filename')
                        ";
                        $run = mysqli_query($conn, $query);

                        if ($run) {
                            move_uploaded_file($fileTmpName, $path);
                            echo "succ";
                        } else {
                            echo "error" . mysqli_error($conn);
                        }
                    }

                    ?>

                <?php endwhile; ?>



                <tr style="background-color: #ffe2e2">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Download taken courses</td>
                    <td title="Download Taken Courses"><img src="../Icons/download-file.svg" width="35" height="35" onclick="showAlert()"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="main">
    </div>
</body>

</html>