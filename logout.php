<?php
//start session
session_start();

//unset all session variables
$_SESSION = [];

//destroy the session
session_destroy();

//redirect to login page
header("Location: login.php");
exit();
?>

