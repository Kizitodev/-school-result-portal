<?php 
mysqli_report(MYSQLI_REPORT_OFF);
 
$con = mysqli_connect('localhost','root','','students_results_db');
  if(!$con){
    die(mysqli_error($con));
  } 

 
?>