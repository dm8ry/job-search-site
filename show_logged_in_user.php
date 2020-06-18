<? session_start();

echo "logged_in_userid = ".$_SESSION['logged_in_userid'];
echo "<br/>";
echo "logged_in_email = ".$_SESSION['logged_in_email'];
echo "<br/>";
echo "logged_in_user_firstname = ".$_SESSION['logged_in_user_firstname'];
echo "<br/>";
echo "logged_in_user_lastname = ".$_SESSION['logged_in_user_lastname'];
echo "<br/>";

?>