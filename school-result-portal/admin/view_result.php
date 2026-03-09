<?php
 require_once("../config/db.php");
 
?>

<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>view subject</title>
</head>
<body class="bg-light">


<div class="container mt-5">
    <h3 class="text-center">ABC University</h3>
    <h5 class="text-center mb-4">Admin View Results</h5>
  
    <div class="card p-4">
        <h4>View Subject</h4>

       <form method="GET">
        <div class="mb-3">
                <label class="form-label">Session</label>
                <select name="session" class="form-control">
                <option value="">Select Session</option>
                <option>2024/2025</option>
                <option>2025/2026</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Semester</label>
                <select name="semester" class="form-control">
                    <option value="">Select Semester</option>
                    <option>First Semester</option>
                    <option>Second Semester</option>
                </select>
            </div>

        <button class="btn btn-primary" name="submit">Search</button>

       </form>
    </div>
</div>

</body>
</html>

<!-- PHP CODE -->
<?php 
  if(isset($_GET['submit'])){
    $session = $_GET['session'];
    $semester = $_GET['semester'];

    // Fetch results based on session and semester
    $sql = "SELECT 
        student_table.full_name,
        student_table.matric_number,
        subject_table.subject_name,
        subject_table.subject_code,
        results.score,
        results.student_session,
        results.semester,
        results.id
        FROM results
        JOIN student_table ON results.student_id = student_table.id
        JOIN subject_table ON results.subject_id = subject_table.id
        WHERE results.student_session = ?
        AND results.semester = ?";

    $stmt = mysqli_prepare($con, $sql);
    if(!$stmt){
    die("Prepare failed: " . mysqli_error($con));
}
    mysqli_stmt_bind_param($stmt, "ss", $session, $semester);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        echo "<table class='table table-bordered mt-4'>
                <tr>
                    <th>Student </th>
                    <th>Subject </th>
                    <th>Score</th>
                    <th>Matric</th>
                    <th>Session</th>
                    <th>Semester</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>";
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>
                    <td>".$row['full_name']."</td>
                    <td>".$row['subject_name']."</td>
                    <td>".$row['score']."</td>
                    <td>".$row['matric_number']."</td>
                    <td>".$row['student_session']."</td>
                    <td>".$row['semester']."</td>
                    <td><a href='edit_result.php?id=".$row['id']."' class='btn btn-sm btn-primary'>Edit</a></td>
                    <td><a href='delete_result.php?id=".$row['id']."' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this result?');\">Delete</a></td>
                    </tr>";
        }
   }
}
?>