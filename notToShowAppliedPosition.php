<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_SESSION['logged_in_email']) && isset($_SESSION['logged_in_userid']) && isset($_POST['a']) )
	{
	
		$logged_in_email = $_SESSION['logged_in_email'];
		$logged_user_id  = $_SESSION['logged_in_userid'];
		$u_p_id  = $_POST['a'];
	
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");

		$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
		$cur_dt =  $date->format('d-m-Y H:i:s');  
		$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()			
		
		$sql_generate_recommended_positions2 = "update user_positions set status='Y' where user_id=$logged_user_id  and id=$u_p_id";
 
		mysqli_query($conn, $sql_generate_recommended_positions2);
		
		$conn->close();			
							
		// echo  'Ok';
		 
	}	
	else
	{
		echo 'Error!!!';
	}

?>