<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', FALSE);
$conn = new mysqli("localhost", "root", "", "universitywebproject"); //root

// Check connection
if ($conn->connect_errno) {
    // echo("Not connected");
    // echo($conn->connect_error);
    exit();
} else {
    // echo("Connected");
}
trigger_error(mysqli_error($conn));
?>