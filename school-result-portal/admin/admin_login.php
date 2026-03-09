<?php
 require_once("../config/db.php");
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Login</title>
</head>
<body class="bg-light">


<div class="container mt-5">
    <div class="card p-4 shadow ">
        <h4>Admin Login</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Admin Name</label>
                <input type="text" name="admin_name" class="form-control" required="required">
            </div>

            <div class="mb-3">
                <label class="form-label">Admin Password</label>
                <input type="text" name="admin_password" class="form-control" required="required">
            </div>
    
           <input type="submit" value="Sign In" class="bg-info py-2 px-4
                        border-0" name="submit">
        </form>
    </div>
</div>

</body>
</html>

<!-- PHP CODE -->
<?php
if(isset($_POST['submit'])){

    $admin_name = $_POST['admin_name'];
    $password = $_POST['admin_password'];

    $stmt = mysqli_prepare($con, "SELECT * FROM admin_table WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $admin_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){

        $row_data = mysqli_fetch_assoc($result);

        if(password_verify($password, $row_data['admin_password'])){

            $_SESSION['username'] = $admin_name;

            echo "<script>alert('Logged in')</script>";
            echo "<script>window.open('admin_dashboard.php','_self')</script>";
            exit;

        } else {

            echo "<div class='alert alert-danger'>Incorrect Password</div>";

        }

    } else {

        echo "<div class='alert alert-danger'>User not found</div>";

    }
}

?>