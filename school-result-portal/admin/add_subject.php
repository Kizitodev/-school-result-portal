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
    <title>add subject</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center">ABC University</h3>
    <h5 class="text-center mb-4">Admin Add Subject</h5>
    <div class="card p-4">
        <h4>Add Subject</h4>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Subject Name</label>
                <input type="text" name="subject_name" class="form-control" required="required">
            </div>

            <div class="mb-3">
                <label class="form-label">Subject Code</label>
                <input type="text" name="subject_code" class="form-control" required="required">
            </div>
           
            <div class="mb-3">
                <label class="form-label">Department</label>
                <input type="text" name="department" class="form-control" required="required">
            </div>
          
            <div class="mb-3">
                <label class="form-label">Level</label>
                <input type="text" name="student_level" class="form-control" required="required">
            </div>

            <div class="mb-3">
                <label class="form-label">Unit</label>
                <input type="text" name="unit" class="form-control" required="required">
            </div>

            

           <input type="submit" value="Add subject" class="bg-info py-2 px-4
                        border-0" name="add_subject">
        </form>
    </div>
</div>

</body>
</html>

<!-- PHP CODE -->

<?php 
 if(isset($_POST['add_subject'])){
     $subject_name = $_POST['subject_name'];
     $subject_code = $_POST['subject_code'];
     $department = $_POST['department'];
     $level = $_POST['student_level'];
     $unit = $_POST['unit'];
     
    
        $insert_data = "INSERT into `subject_table`(subject_name,subject_code,department,student_level,unit)
        values('$subject_name','$subject_code','$department','$level','$unit') ";

        $query = mysqli_query($con, $insert_data);
     

        if($query){
                echo "<script> alert('Successfull')</script>";
            }
     
 }

?>