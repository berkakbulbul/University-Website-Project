<?php
// Connecting to the database
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

function check_username($conn, $accType, $username)
{
    // First check if user exist in the database or not after dropping actions
    $sql_check = "SELECT * FROM $accType WHERE Username='$username'";
    $result = $conn->query($sql_check);
    if (($result->num_rows > 0)) {
        return True;
    }
    return False;
}
?>
