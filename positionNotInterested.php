<?php session_start();

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");
	
	if (isset($_POST['up_id']))
	{
		
		//Email information
		$admin_email = $admin_email_address;
		$subject = "Position is not interesting for user from Jobs972.com";	

		$up_id =  $_POST['up_id'];			
		 
		$logged_user_id = $_SESSION['logged_in_userid'];
		$email  = $_SESSION['logged_in_email'];
		$fn  = $_SESSION['logged_in_user_firstname'];
		$ln  = $_SESSION['logged_in_user_lastname'];
		
		$pos_title = $_POST['pos_title'];
		$company_name_x = $_POST['company_name_x'];
		$pos_id = $_POST['pos_id'];
		$comp_id = $_POST['comp_id'];
		
		$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
		$cur_dt =  $date->format('d-m-Y H:i:s');  
		$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()	
		
		$ip_addr=$_SERVER['REMOTE_ADDR'];
		
		$headers = "From: " . strip_tags($admin_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Position is not interesting for user on the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Reject Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'User Email: <b>' . $email . '</b><br/>' ."\n" .
					 'User FirstName: <b>' . $fn . '</b><br/>' ."\n" .
					 'User LastName: <b>' . $ln . '</b><br/>' ."\n" .
					 'Position: <a href="index.php?i='.$pos_id.'" target="_blank"><b>' . $pos_title . '</b></a><br/>' ."\n" .
					 'Company Name: <a href="companies.php?c='.$comp_id.'" target="_blank"><b>' . $company_name_x . '</b></a><br/>' ."\n" .
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'Position is not interesting for user on the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Reject Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'User Email: <b>' . $email . '</b><br/>' ."\n" .
					 'User FirstName: <b>' . $fn . '</b><br/>' ."\n" .
					 'User LastName: <b>' . $ln . '</b><br/>' ."\n" .
					 'Position: <a href="index.php?i='.$pos_id.'" target="_blank"><b>' . $pos_title . '</b></a><br/>' ."\n" .
					 'Company Name: <a href="companies.php?c='.$comp_id.'" target="_blank"><b>' . $company_name_x . '</b></a><br/>' ."\n" .
					 'IP Address: <b>' . $ip_addr . '</b><br/></body></html>';
					 
		if (!mail($admin_email, "$subject", $message, $headers)) 
		{
		   // something wrong...
		   // echo "something wrong ";
		   
		} else
		{  				
			// everything is good...
			// echo "everything is good ";
			
			// log into businesslog
			
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 

			$conn->query("set names 'utf8'");
			
			$logged_in_email = $_SESSION['logged_in_email'];
			
			$logged_user_id = $_SESSION['logged_in_userid'];
			
			$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
			VALUES ('$db_cur_dt', 10, 0, '$ip_addr', '$logged_in_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				//  echo "1 New record created successfully";
			} else {
				// echo "Error1: " . $sql . "<br>" . $conn->error;
			}

			$sql2 = "update user_positions set modify_dt='$db_cur_dt' , status = 'X' where id = ".$up_id;
						
			if ($conn->query($sql2) === TRUE) {
				// echo "Record updated successfully";
			} else {
				// echo "Error: " . $sql . "<br>" . $conn->error;
			}				
			
			$conn->close();				
		} 							 
	
		echo "Ok";
	
	}	

?>