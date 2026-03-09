<?php
 require_once("../config/db.php");
?>
<?php
session_start();
session_destroy();
header("Location: admin_login.php");
exit;
?>