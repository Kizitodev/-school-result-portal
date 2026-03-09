<?php
 require_once("../config/db.php");
 
?>

<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit;
}

$id = $_GET['id'];

$query = "SELECT 
student_table.full_name,
student_table.matric_number AS matric,
subject_table.subject_name,
subject_table.subject_code,
subject_table.unit,
results.score
FROM results
JOIN student_table ON results.student_id = student_table.id
JOIN subject_table ON results.subject_id = subject_table.id
WHERE results.id = '$id'";

$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

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
    <h5 class="text-center mb-4">Admin Edit Result</h5>
  
    <div class="card p-4">
        <h4>Edit Results</h4>

       <form method="POST">

        <div class="mb-3">
        <label>Student</label>
        <input type="text" class="form-control" 
        value="<?php echo $row['full_name']; ?> (<?php echo $row['matric']; ?>)" readonly>
        </div>

        <div class="mb-3">
        <label>Subject</label>
        <input type="text" class="form-control" 
        value="<?php echo $row['subject_name']; ?>" readonly>
        </div>

        <div class="mb-3">
        <label>Score</label>
        <input type="number" name="score" class="form-control"
        value="<?php echo $row['score']; ?>" required>
        </div>

        <button type="submit" name="update" class="btn btn-primary">
        Update Result
        </button>

       </form>
    </div>
</div>

</body>
</html>

<!-- PHP CODE -->
 <?php
if(isset($_POST['update'])){
    $score = $_POST['score'];

        // SAFETY CHECK HERE
    if($score < 0 || $score > 100){
        echo "<div class='alert alert-danger'>Score must be between 0 and 100</div>";
        exit;
    }
    $update_query = "UPDATE results SET score = '$score' WHERE id = '$id'";
    if(mysqli_query($con, $update_query)){
    
    echo "<script>
    alert('Result updated successfully');
    window.location='view_result.php';
    </script>";
    }
    else{
        echo "<script>
        alert('Failed to update result');
        </script>";
    }
 }

?>