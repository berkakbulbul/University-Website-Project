<!DOCTYPE html>
<?php
// Starting session
session_start();

// Connection established to MySQL
include "../utils/connect.php";
include "../utils/helper.php";

$studentNumber = $_SESSION["StudentNumber"];
$courseID = $row_courseID["ID"];
$username = $_SESSION["Username"];
$password = $_SESSION["Password"];
$FName = $_SESSION["FName"];
$LName = $_SESSION["LName"];
$GPA = $_SESSION["GPA"];


// Query for research group information
$sql = "SELECT DISTINCT instructor.InstructorNumber, instructor.FName, instructor.LName, rg.Name FROM rg, instructor WHERE rg.instID=instructor.InstructorNumber;";
$result_rg = mysqli_query($conn, $sql);

// Research Group Request
if (isset($_POST['submitapply'])) {
    $instructID = $_POST['research_groups'];    //Instructor ID
    $note = trim($_POST['note']);               // Attached note
    //file
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $path = "../resume/" . $fileName;
    $sql_rg = "INSERT INTO `rg_requests` (`insID`,`stdID`,`note`,`resume`) VALUES ('$instructID','$studentNumber','$note', '$fileName')";
    mysqli_query($conn, $sql_rg);
    move_uploaded_file($fileTmpName, $path);
}
?>
<html>

<head>
    <link rel="stylesheet" href="joinResearchGroup.css">
    <script src="joinResearchGroup.js"></script>
    <title>Join Research Group</title>
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
        <div class="navTextDiv1" style=" position: absolute; width: 100%; bottom: 3%; text-align: center; ">
            <hr>
            <a href="../login/main.php">Logout</a>
            <hr>
        </div>
        <hr>

    </div>

    <div id="availableGroups" class="content">
        <h3>Available Research Groups</h3>
        <div class="tableclass">
            <table style="width:100%" align="center">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Research Area</th>

                </tr>
                <?php while ($row = mysqli_fetch_array($result_rg)) :; ?>
                    <tr>
                        <td><?php echo $row["FName"]; ?></td>
                        <td><?php echo $row["LName"]; ?></td>
                        <td><?php echo $row["Name"]; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <div>
        <button id="joinButton" onclick="myFunction()">Join Research Group</button>
    </div>
    <div id="applyFormId" class="container : hidden">
        <a href="joinResearchGroup.php"><img src="../Icons/cancel.svg" width="30" height="30" style="margin-left: 400px;"></a>
        <div class="text" margin="auto">
            Join a Research Group</div>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="data">
                <label>Course Instructor</label>
                <select name="research_groups" class="dropdown" size="1">
                    <?php
                    $sql = mysqli_query($conn, $sql);
                    while ($row = $sql->fetch_assoc()) {
                        echo "<option value=" . $row["InstructorNumber"] . ">" . $row['FName'] . ' ' . $row['LName'] . ' - ' . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <label>Note :</label>            
            <textarea name="note" maxlength="200"></textarea>
            <label>Add your resume * : </label>
            <input width="40x" height="40px" type="file" name="file" src="https://thumbs.dreamstime.com/b/attachment-paper-clip-icon-logo-template-illustration-design-vector-eps-182061985.jpg">
            <div class="btn">
                <button type="submit" name="submitapply">Apply</button>
            </div>
        </form>
    </div>
    <div class="main">
    </div>
</body>
</html>