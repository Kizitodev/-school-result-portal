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
    <title>add student</title>
</head>
<body class="bg-light">


<div class="container mt-5">
    <h3 class="text-center">ABC University</h3>
    <h5 class="text-center mb-4">Admin Add Student</h5>
    <div class="card p-4">
        <h4>Add Student</h4>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Matric Number</label>
                <input type="text" name="matric_number" class="form-control" required="required">
            </div>

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" required="required">
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <input type="text" name="department" class="form-control" required="required">
            </div>

            <div class="mb-3">
                <label class="form-label">Level</label>
                <input type="text" name="student_level" class="form-control" required="required">
            </div>

           <input type="submit" value="Add student" class="bg-info py-2 px-4
                        border-0" name="add_student">
        </form>
    </div>
</div>

</body>
</html>

<!-- PHP CODE -->

<?php 
 if(isset($_POST['add_student'])){
     $matric_number = $_POST['matric_number'];
     $full_name = $_POST['full_name'];
     $department = $_POST['department'];
     $student_level = $_POST['student_level'];
     
     if(empty($matric_number) || empty($full_name) || empty($department) || empty($student_level)) {
       echo "<script>alert('All fields are required');</script>";
     } 
     else{
        $insert_data = "INSERT into `student_table`(matric_number,full_name,department,student_level)
        values('$matric_number','$full_name','$department','$student_level') ";

        $query = mysqli_query($con, $insert_data);
     

     if($query){
            echo "<script> alert('Successfull')</script>";
        } else{
            echo "Error:". mysqli_error($con);
        }
     }
 }
?>