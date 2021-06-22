<?php
// Starting session
session_start();

// Connection established to MySQL
include "../utils/connect.php";
include "../utils/helper.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <!-- <link rel="stylesheet" href="main.css"> -->
    <link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
    <script src="main.js"></script>
    <title>Main</title>
</head>


<body>
    <div id="header">
        <img src="../Icons/university.svg" height="50" width="50" style="margin-left: 10px; margin-top: 10px;">
        <label style="font-size: large;"> University Internet Gateway</label>
    </div>

    <div class="center">
        <div class="container">
            <div class="text" margin="auto">
                Login</div>
            <form name="loginform" method="post" action="">

                <div class="data">
                    <label>Username</label>
                    <input id="usernameinputID" name="usernameinput" type="text" required>
                </div>
                <div class="data">
                    <label>Password</label>
                    <input id="passwordinputID" name="passwordinput" type="password" required>
                </div>
                <div class="btn">
                    <button type="submit">login</button>
                </div>
                <div class="signup-link">
                    <?php
                    if (isset($_SESSION["error"])) {
                        $error = $_SESSION["error"];
                        echo "<label class='error_message'>$error</label><br>";
                        unset($_SESSION["error"]);
                    }
                    ?>
                    <a href="createAccount.php">Create an Account</a>
                </div>
            </form>
        </div>
    </div>
    <div id="footer"></div>
</body>

<?php
// Initiliazing variables obtained from the user via HTML form
$username = $_POST["usernameinput"];
$password = $_POST["passwordinput"];

// Formatting each type of queries with user inputs to check if user exists or not
$sql = "SELECT * FROM %s WHERE Username='%s' and Password='%s'";
$sql_ins = sprintf($sql, "instructor", $username, $password);
$sql_std = sprintf($sql, "student", $username, $password);
$sql_sec = sprintf($sql, "secretary", $username, $password);

// Checking each table to see which one user registered
// Checking if user instructor
$result = $conn->query($sql_ins);
if ($result->num_rows > 0) {
    // Initializing user information to $_SESSION
    $row = mysqli_fetch_array($result);
    $_SESSION["instructorID"]   = $row[0];
    $_SESSION["Username"]       = $row[2];
    $_SESSION["Password"]       = $row[3];
    $_SESSION["FName"]          = $row[4];
    $_SESSION["LName"]          = $row[5];
    $_SESSION["RGName"]         = $row[6];
    header("Location: http://localhost/universitywebproject/instructor/instructorCoursePage.php");
} else {
    // If user is not instructor then check if user student
    $result = $conn->query($sql_std);
    if ($result->num_rows > 0) {
        // Initializing user information to $_SESSION
        $row = mysqli_fetch_array($result);
        $_SESSION["Username"]   = $row[1];
        $_SESSION["Password"]   = $row[2];
        $_SESSION["FName"]      = $row[3];
        $_SESSION["LName"]      = $row[4];
        $_SESSION["GPA"]        = $row[5];
        $_SESSION["StudentNumber"] = $row[6];
        $_SESSION["Class"] = $row[7]; 
        header("Location: http://localhost/universitywebproject/student/studentCoursePage.php");
    } else {
        // If user is not student check if user secretary
        $result = $conn->query($sql_sec);
        if ($result->num_rows > 0) {
            // Initializing user information to $_SESSION
            $row = mysqli_fetch_array($result);
            $_SESSION["Username"]   = $row[0];
            $_SESSION["Password"]   = $row[1];
            $_SESSION["FName"]      = $row[2];
            $_SESSION["LName"]      = $row[3];
            header("Location: http://localhost/universitywebproject/secretary/secretaryCoursePage.php");
        } else {
            // If user is not either of these three types then redirect them to main.php
            // header("Location: http://127.0.0.1/universitywebproject/login/main.php");
            if($username != null or $password != null){
                $_SESSION["error"] = "Wrong username or password";
                header("Location: http://127.0.0.1/universitywebproject/login/main.php");
            }
        }
    }
}

//close the connection
$conn->close();
?>
</html>