<?php
// Start session
session_start();

// Connection established to MySQL
include "connect.php";

// Get the related information from the table for updating database
$fileName = $_GET['resume'];

// $qry = "select distinct Name from upload where upload.stdID='$CourseCode';";
// $result = mysqli_query($conn,$qry);

// $fetched = mysqli_fetch_array($result);

// $fileName = $fetched["Name"];

if(!empty($fileName)){
    // $fileName = basename($fetched["Name"]);
    // echo $fileName;
    $filePath  = "../resume/".$fileName;
    
    if(!empty($fileName) && file_exists($filePath)){
        //define header
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        
        //read file 
        readfile($filePath);
        exit;
    }
    else{
        echo "file not exit";
    }
}

else{
    $_SESSION["error"] = "There is no material to download";
    header("Location: http://localhost/universitywebproject/student/studentCoursePage.php");
}


?>