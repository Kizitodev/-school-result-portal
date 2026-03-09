<?php
 require_once("./config/db.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>student main page</title>
</head>
<body class="bg-light">


<div class="container mt-5">
    <div class="card p-4">
        <h3 class="text-center">ABC University</h3>
        <h5 class="text-center mb-4">Student Result Slip</h5>
        <h4>Student Main Page</h4>

        <form method="POST">
            <div class="mb-3">
                
                <label class="form-label">Matric Number</label>
                 <input type="text" name="matric_number" class="form-control" required="required">
            </div>
           
            <div class="mb-3">
                <label>Session</label>
                <select name="session" class="form-control" required>
                <option value="">Select Session</option>
                <option value="2023/2024">2023/2024</option>
                <option value="2024/2025">2024/2025</option>
                <option value="2025/2026">2025/2026</option>
                </select>
           </div>
          
           <div class="mb-3">
                <label>Semester</label>
                <select name="semester" class="form-control" required>
                <option value="">Select Semester</option>
                <option value="First Semester">First Semester</option>
                <option value="Second Semester">Second Semester</option>
                </select>
           </div>
           <input type="submit" value="Submit" class="bg-info py-2 px-4
                        border-0" name="submit">
        </form>
    </div>
</div>

</body>
</html>

<!-- PHP CODE -->

<?php 
 if(isset($_POST['submit'])){
    $matric_number = $_POST['matric_number'];
    $session = $_POST['session'];
    $semester = $_POST['semester'];

     $select_query = "SELECT * FROM `student_table` where matric_number = '$matric_number' ";
     $result = mysqli_query($con, $select_query);
     
     $row_count = mysqli_num_rows($result);

        
        if($row_count > 0 ){
            $row = mysqli_fetch_assoc($result);
            
            $student_id = $row['id'];
            echo "<div class='card container mt-4 p-3' >
                   <div class='card shadow-sm mb-4'>
                    <div class='card-body'>
                     <h5 class='card-title mb-3'>Student Details</h5>
                        <p><strong>Student Name:</strong>  $row[full_name] </p> 
                        <p><strong>Department:</strong>  $row[department] </p> 
                        <p><strong>Student Level:</strong>  $row[student_level] </p> 
                        <p><strong>Matric Number:</strong>  $row[matric_number] </p> 
                    </div>
                 </div>";
            } 
        else{
                echo "<div class='alert alert-info mt-3' >
                           No Student Found </div>" ;
            }
       $select_query = "  SELECT 
                    student_table.full_name,
                    student_table.matric_number,
                    student_table.department,
                    student_table.student_level,
                    subject_table.subject_name,
                    subject_table.subject_code,
                    subject_table.unit,
                    results.score
                FROM results
                INNER JOIN subject_table 
                    ON results.subject_id = subject_table.id
                INNER JOIN student_table 
                    ON results.student_id = student_table.id
                WHERE student_table.matric_number = ?
                AND results.student_session = ?
                AND results.semester = ?";
                
               
                $total_units = 0;
                $total_points = 0;

                $stmt = mysqli_prepare($con, $select_query);
                mysqli_stmt_bind_param($stmt, "sss", $matric_number, $session, $semester);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row_count = mysqli_num_rows($result);
                  if ($row_count > 0){
                    echo "<h4 class='mb-3'>Academic Results for <strong class='text-primary'>$semester, $session</strong></h4>";
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<tr>
                            <th>Subject</th>
                            <th>Score</th>
                            <th>Grade</th>
                            <th>Unit</th>
                            <th>GP</th>
                            <th>Total</th>
                        </tr>";
                    while($row = mysqli_fetch_assoc($result)){
                        $score = $row['score'];
                        $unit = $row['unit'];

                        // SCORE TABLE
                        if ($score >= 70) {
                            $grade = "A";
                            $grade_point = 5;
                        } elseif ($score >= 60) {
                            $grade = "B";
                            $grade_point = 4;
                        } elseif ($score >= 50) {
                            $grade = "C";
                            $grade_point = 3;
                        } elseif ($score >= 45) {
                            $grade = "D";
                            $grade_point = 2;
                        } elseif ($score >= 40) {
                            $grade = "E";
                            $grade_point = 1;
                        } else {
                            $grade = "F";
                            $grade_point = 0;
                        }

                        $total = $grade_point * $unit;
                         $total_units += $unit;
                         $total_points += $total;

                      echo "<tr>
                        <td>{$row['subject_name']}</td>
                        <td>{$score}</td>
                        <td>{$grade}</td>
                        <td>{$unit}</td>
                        <td>{$grade_point}</td>
                        <td>{$total}</td>
                    </tr>";
                    }  
                    // LOOP ENDS
                    echo "</table>";

                    $gpa = 0;

                    if ($total_units > 0) {
                        $gpa = round($total_points / $total_units, 2);
                    }

                    echo "<br><strong>Total Units:</strong> $total_units<br>";
                    echo "<strong>Total Points:</strong> $total_points<br>";
                    echo " <div class='alert alert-info mt-3'>
                            <strong>GPA:</strong> " . number_format($gpa, 2);
                    echo"  <button onclick='window.print()' class='btn btn-primary'>Print Result</button> ";
                  } else{
                    echo "<div class='alert alert-danger mt-3' >
                           No Result Found </div>" ;
                  }
                     
 }

?> 