<?php
require '../config/db.php';
session_start();

if(!isset($_GET['id'])){
    header("Location: view_result.php");
    exit;
}

$id = $_GET['id'];

$query = "DELETE FROM results WHERE id = '$id'";

if(mysqli_query($con, $query)){

echo "<script>
alert('Result deleted successfully');
window.location='view_result.php';
</script>";

}else{

echo "Error deleting result.";

}
?>