<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_POST['recId']) && isset($_SESSION['princ_email']) )
	{
		
		$logged_in_email = $_SESSION['princ_email'];
		$recId = $_POST['recId'];
	
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");

		$sql0 = "select bl.the_info_user_en
				from businesslog bl 
				where bl.id = ".$recId." ";
 
		$arr_the_info_user_en = array();		
		$results_the_info_user_en = mysqli_query($conn, $sql0); 	
		
		while($line = mysqli_fetch_assoc($results_the_info_user_en)){
			$arr_the_info_user_en[] = $line;
		}

		if (sizeof ($arr_the_info_user_en) == 1)
		{
			echo $arr_the_info_user_en[0]['the_info_user_en'];
		}
		else
		{
			echo ' ';
		}		 
		
	}	
	else
	{
		echo 'Error!!!';
	}

?>