<?php session_start(); 

unset($_SESSION['auth_login']);
unset($_SESSION['logged_in_user_firstname']);
unset($_SESSION['logged_in_user_lastname']);
unset($_SESSION['logged_in_email']);
unset($_SESSION['logged_in_userid']);
session_destroy();
header("Location: index.php");
exit;

?>