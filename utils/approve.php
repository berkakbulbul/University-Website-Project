<?php
// Start session
session_start();

// Connection established to MySQL
include "connect.php";

// Get the related information from the table for updating database
$stdID = $_GET['stdID'];
$insID = $_GET['insID'];
$RGName = $_GET['RGName'];


// Delete from requests
$sql_reject = "DELETE FROM rg_requests WHERE insID = $insID AND stdID = $stdID;";
$result_delete = mysqli_query($conn, $sql_reject);

// Add to rg table
$sql_add = "INSERT INTO rg SET Name='$RGName', stdID= '$stdID', instID='$insID';";
$result_add = mysqli_query($conn,$sql_add);

$Username = $row["Username"];
$InstructorNumber = $row["InstructorNumber"];
$Password = $row["Password"];
$FName = $row["FName"];
$LName = $row["LName"];   
$RGName = $row["RGName"];       

// After succsefully updated database redirect to the student course page again
header("Location: http://localhost/universitywebproject/instructor/researchGroupPage.php?InstructorNumber=$InstructorNumber&Username=$Username&Password=$Password&FName=$FName&LName=$LName&RGName=$RGName");
?>

<?php
function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?>