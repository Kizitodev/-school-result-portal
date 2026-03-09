<?php
 require_once("../config/db.php");
?>

<?php
if (isset($_GET['student_id'])) {

    $student_id = intval($_GET['student_id']);

    // Get student department and level
    $student_query = mysqli_query($con, "SELECT department, student_level FROM student_table WHERE id = $student_id");
 
    if (!$student_query || mysqli_num_rows($student_query) == 0) {
        echo json_encode([]);
        exit;
    }

    $student = mysqli_fetch_assoc($student_query);

    $department = $student['department'];
    $level = $student['student_level'];


    // Get matching subjects
    $subject_query = mysqli_query($con, " SELECT id, subject_name, subject_code 
        FROM subject_table
        WHERE LOWER(department) = LOWER('$department')
        AND LOWER(student_level) = LOWER('$level')

        
    ");

    $subjects = [];

    while ($row = mysqli_fetch_assoc($subject_query)) {
        $subjects[] = [
            "id" => $row['id'],
            "name" => $row['subject_name'],
            "code" => $row['subject_code']
        ];
    }

    echo json_encode($subjects);
}
?>