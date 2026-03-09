<?php
 require_once("../config/db.php");
?>

<?php


if (isset($_GET['query'])) {

    $search = mysqli_real_escape_string($con, $_GET['query']);

    $query = "
        SELECT id, full_name, matric_number 
        FROM student_table
        WHERE full_name LIKE '%$search%' 
        OR matric_number LIKE '%$search%'
        LIMIT 10
    ";

    $result = mysqli_query($con, $query);

    $students = [];

    if (!$result) {
    die("Query Failed: " . mysqli_error($con));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = [
            "id" => $row['id'],
            "name" => $row['full_name'],
            "matric" => $row['matric_number']
        ];
    }

    echo json_encode($students);
}
?>