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
    <title>add result</title>
</head>
<body class="bg-light">
  
<div class="container mt-5">
    <h3 class="text-center">ABC University</h3>
    <h5 class="text-center mb-4">Admin Add Result</h5>
    <div class="card p-4">
        <h4>Add Result</h4>

        <form  id="resultForm" method="POST">
            <div class="mb-3">
                <label class="form-label">Student Name</label>
        
                    <input type="text" id="student_search" class="form-control"  placeholder="Type name or matric number">

                    <input type="hidden" name="student_id" id="student_id">

                    <div id="suggestions"> </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject </label>
                 <select id="subject_select" name="subject_name" class="form-control" required="required">
                    <option value="">-- Select Subject --</option>
                 
                 </select>
            </div>
           
            <div class="mb-3">
                <label>Session</label>
                <select name="student_session" class="form-control" required>
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

            <div class="mb-3">
                <label class="form-label">score</label>
                <input  type="number" name="score" class="form-control" required="required">
            </div>

           <input type="submit" value="Add result" class="bg-info py-2 px-4  border-0" name="add_result">
       
        </form>
    </div>
</div>

</body>
</html>

<!-- PHP CODE -->

<?php 
 if(isset($_POST['add_result'])){
     $student_name = $_POST['student_id'];
     $subject_name = $_POST['subject_name'];
     $score = $_POST['score'];
     $student_session = $_POST['student_session'];
     $semester = $_POST['semester'];
     
    
        $insert_data = "INSERT into `results`(student_id,subject_id,score,student_session,semester)
        values('$student_name','$subject_name','$score','$student_session','$semester') ";

        $query = mysqli_query($con, $insert_data);

        if (!$query) {

            if (mysqli_errno($con) == 1062) {
               echo "<div class='alert alert-danger'>
                    Result already exists.
                </div>";
            } else {
                echo "Error: " . mysqli_error($con);
            }

        } else {
             echo "<div class='alert alert-success'>
                    Result added.
                </div>";
        }
     
 }

?>


<script>
const searchInput = document.getElementById("student_search");
const suggestionsBox = document.getElementById("suggestions");
const studentIdInput = document.getElementById("student_id");

searchInput.addEventListener("keyup", function() {

    studentIdInput.value = ""; // reset selection
    let query = searchInput.value;

    if (query.length === 0) {
        suggestionsBox.innerHTML = ""; 
        return;
    }

    fetch("search_student.php?query=" + query)
        .then(response => response.json())
        .then(data => {

            suggestionsBox.innerHTML = "";

            data.forEach(student => {

                let div = document.createElement("div");

                div.textContent = student.name + " (" + student.matric + ")";
                div.style.padding = "5px";
                div.style.cursor = "pointer";
                div.style.borderBottom = "1px solid #ccc";

                div.addEventListener("click", function() {

                    // Fill input
                    searchInput.value = student.name + " (" + student.matric + ")";

                    // Store student ID
                    studentIdInput.value = student.id;

                    // Clear suggestions
                    suggestionsBox.innerHTML = "";

                    // 🔥 Fetch subjects based on selected student
                    fetch("fetch_subject.php?student_id=" + student.id)
                        .then(response => response.json())
                        .then(subjects => {

                            const subjectSelect = document.getElementById("subject_select");

                            subjectSelect.innerHTML = '<option value="">Select Subject</option>';

                            subjects.forEach(subject => {

                                let option = document.createElement("option");
                                option.value = subject.id;
                                option.textContent = subject.name + " (" + subject.code + ")";

                                subjectSelect.appendChild(option);
                            });

                        })
                        .catch(error => console.error("Subject Fetch Error:", error));

                });

                suggestionsBox.appendChild(div);

            });

        })
        .catch(error => console.error("Search Error:", error));
});


const form = document.getElementById("resultForm");

form.addEventListener("submit", function(e) {

    if (studentIdInput.value === "") {
        e.preventDefault();
        alert("Please select a student from the list.");
    }

});
</script>

