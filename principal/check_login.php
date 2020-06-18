<?php
session_start();

	$is_success = 0;

	include_once('./../inc/db_connect.php');
	include_once('./../admin_email.php');

	mb_internal_encoding("UTF-8");
	
	if (empty($_POST['form-username']) || empty($_POST['form-password'])) 
	{
		$error = "Wrong";
	}
	else
	{
	
		// Create connection
		$conn0 = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn0->connect_error) {
			die("Connection failed: " . $conn0->connect_error);
		} 

		$conn0->query("set names 'utf8'");	
		
		$sql0 = "SELECT * FROM principals where status='1' and princ_pwd= '".$_POST['form-password']."' and upper(trim(princ_email)) = upper(trim('".$_POST['form-username']."'))";
		
		$result0 = $conn0->query($sql0);
			
		$arr_princ_details = array();
		
		while($line = mysqli_fetch_assoc($result0)){
			$arr_princ_details[] = $line;
		}			

		if ($result0->num_rows == 1) 
		{    
			$is_success = 1;	    
		} 
		else 
		{
			$is_success = 0;
		}
		
		$conn0->close();
	
	}
	
	if (empty($_POST['form-username']) || empty($_POST['form-password']) || (sizeof($arr_princ_details)==0) ) 
	{
		$error = "Wrong";
	}
	else if ($arr_princ_details[0]['is_verified'] == 0)
	{
		$error = "Not Verified";
	}
	else
	{
		$username = $_POST['form-username'];
		$password = $_POST['form-password'];
			

		if ($is_success == 1)
		{
			$error = "Success";
			$_SESSION['princ_login']= 1;
			$_SESSION['princ_first_name']=$arr_princ_details[0]['princ_firstname'];
			$_SESSION['princ_id']=$arr_princ_details[0]['id'];
			$_SESSION['princ_email']=$arr_princ_details[0]['princ_email'];
		}
		else
		{
			$error = "Wrong";
			unset($_SESSION['princ_login']);
			unset($_SESSION['princ_first_name']);
			unset($_SESSION['princ_id']);
			unset($_SESSION['princ_email']);			
		}
	}

	if (strcmp($error, 'Success')==0)
	{
		// success
		header("Location: ../princ_dashboard.php"); // Redirecting To The Welcome Dashboard Page
	}
	else if (strcmp($error, 'Not Verified')==0)
	{
	
		unset($_SESSION['princ_login']);
		unset($_SESSION['princ_first_name']);
		// wrong
		if(session_destroy()) // Destroying All Sessions
		{
			header("Location: not_verified.php"); // Redirecting To The Wrong Login Page
		}	
	
	}
	else	
	{
		unset($_SESSION['princ_login']);
		unset($_SESSION['princ_first_name']);
		// wrong
		if(session_destroy()) // Destroying All Sessions
		{
			header("Location: wrong_login.php"); // Redirecting To The Wrong Login Page
		}
	}

?>
