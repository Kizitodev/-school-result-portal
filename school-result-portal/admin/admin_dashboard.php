<?php
 require_once("../config/db.php");
?>
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit;

    $student_query = mysqli_query($con, "SELECT COUNT(*) as total_students FROM students");
    $student_data = mysqli_fetch_assoc($student_query);
    $total_students = $student_data['total_students'];

    $subject_query = mysqli_query($con, "SELECT COUNT(*) as total_subjects FROM subjects");
    $subject_data = mysqli_fetch_assoc($subject_query);
    $total_subjects = $subject_data['total_subjects'];

    $result_query = mysqli_query($con, "SELECT COUNT(*) as total_results FROM results");
    $result_data = mysqli_fetch_assoc($result_query);
    $total_results = $result_data['total_results'];

    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center">ABC University</h3>
    <h5 class="text-center mb-4">Admin Dashboard</h5>
  
    <div class="card shadow">
        <div class="card-body">
            <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>
           
            <hr>
            <a href="add_student.php" class="btn btn-primary mb-2">Add Student</a>
            <a href="add_subject.php" class="btn btn-success mb-2">Add Subject</a>
            <a href="add_result.php" class="btn btn-warning mb-2">Add Result</a>
            <a href="view_result.php" class="btn btn-info mb-2">View Results</a>
            <a href="logout.php" class="btn btn-danger mb-2">Logout</a>
        </div>
    </div>
</div>

</body>
</html>