<?php
function generated_student_number($conn)
{
    $generatedNumber = rand(10000000, 99999999);

    $query = "SELECT student.StudentNumber FROM student;";
    $result = mysqli_query($conn, $query);
    $isFound = True;
    while ($isFound) {
        while ($row = mysqli_fetch_array($result)) {
            if ($generatedNumber == $row["StudentNumber"]) {
                $generatedNumber = rand(10000000, 99999999);
                $isFound = False;
                break;
            }
            if ($isFound) {
                return $generatedNumber;
            }
        }
        $isFound = True;
    }
}

function generated_instructor_number($conn)
{
    $generatedNumber = rand(100000, 999999);

    $query = "SELECT student.StudentNumber FROM student;";
    $result = mysqli_query($conn, $query);
    $isFound = True;
    while ($isFound) {
        while ($row = mysqli_fetch_array($result)) {
            if ($generatedNumber == $row["StudentNumber"]) {
                $generatedNumber = rand(10000000, 99999999);
                $isFound = False;
                break;
            }
            if ($isFound) {
                return $generatedNumber;
            }
        }
        $isFound = True;
    }
}

function check_username($conn, $accType, $username)
{
    $sql_check = "SELECT * FROM $accType WHERE Username='$username'";
    $result = $conn->query($sql_check);
    if (($result->num_rows > 0)) {
        return True;
    }
    return False;
}

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
