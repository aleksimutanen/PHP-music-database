<?php
// start the session
session_start();
 
// unset all of the session variables
$_SESSION = array();
 
// end session
session_destroy();
 
// load login page
header("location: login.php");
exit;
?>