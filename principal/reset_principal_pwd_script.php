<?php session_start(); 

	if (!$_SESSION['res_pwd'])
	{
		header("Location: index.php");
		exit;
	}

	//
	// reset a principal password
	//
	
	include_once('./../inc/db_connect.php');
	include_once('./../admin_email.php');
	
	mb_internal_encoding("UTF-8");
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$conn->query("set names 'utf8'");	
	
	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
	
	function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);
	}	

	if ( isset($_POST['form-username']) )	
	{

		$admin_email = $admin_email_address;
		$subject = "Principal Password Reset Jobs972.com";		

		$sql0 = "SELECT * FROM principals where trim(lower(princ_email)) = trim(lower('".$_POST['form-username']."')) and status='1' and is_verified=1 ";
		
		$arr_user_details = array();
		$results_user_details = mysqli_query($conn, $sql0); 

		while($line = mysqli_fetch_assoc($results_user_details)){
			$arr_user_details[] = $line;
		}			

		if ($results_user_details->num_rows == 1) 
		{
		
			$user_email = $arr_user_details[0]['princ_email'];
			$user_fn = $arr_user_details[0]['princ_firstname'];
			$user_ln = $arr_user_details[0]['princ_lastname'];
			$user_id =  $arr_user_details[0]['id'];
			$user_n_pwd = rand_string(8); // generate random pwd
			
			$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
			$cur_dt =  $date->format('d-m-Y H:i:s');  
			$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()
			
			$ip_addr=$_SERVER['REMOTE_ADDR'];
			
			$headers = "From: " . strip_tags($admin_email) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			mb_internal_encoding("UTF-8");
			
			$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'A principal reset password on the Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'Reset Password Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'Principal Firstname: <b>' . $user_fn . '</b><br/>' ."\n" .
						 'Principal Lastname: <b>' . $user_ln . '</b><br/>' ."\n" .
						 'Principal Email: <b>' . $user_email . '</b><br/><br/>' ."\n" .					
						 'Principal New Password: <b>' . $user_n_pwd . '</b><br/><br/>' ."\n" .	
						 'Regards, ' . ' <br/> ' ."\n" .
						 'Administrator.</body></html>';	

			$message2 = '<html><body> ' ."\n" .
						 'You Reset Password on the Jobs972.com!' . '<br/>' ."\n" .
						 'Reset Password Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'Your Firstname: <b>' . $user_fn . '</b><br/>' ."\n" .
						 'Your Lastname: <b>' . $user_ln . '</b><br/>' ."\n" .
						 'Your Email: <b>' . $user_email . '</b><br/>' ."\n" .
						 'Your New Password: <b>' . $user_n_pwd . '</b><br/></body></html>';			 
			
			if (!mail($admin_email, "$subject", $message, $headers)) 
			{
			   // something wrong...
			   // echo "something wrong ";
			   
			} 
			else
			{  				
				// everything is good...
				// echo "everything is good ";
				
				// log into businesslog
				
				$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
				VALUES ('$db_cur_dt', 18, $user_id, '$ip_addr', '$user_email', '$message', '$message2', '')";

				if ($conn->query($sql) === TRUE) {
					// echo "1 New record created successfully";
				} else {
					// echo "Error1: " . $sql . "<br>" . $conn->error;
				}

				$sql2 = "update principals set modifydt = '$db_cur_dt', princ_pwd='$user_n_pwd' where id = $user_id";

				if ($conn->query($sql2) === TRUE) {
					//  echo "2 New record created successfully";
				} else {
					//  echo "Error2: " . $sql2 . "<br>" . $conn->error;
				}				
				
				// send email to user that his pwd was reset
			
				$subject2 = "Principal Password Reset on the Jobs972.com";	
				
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				
				mb_internal_encoding("UTF-8");
		
				$message = '<html><body>Dear '.$user_fn.' '.$user_ln.'!' . '<br/><br/> ' ."\n" .
							 'You just reset password to login as a Principal to the Jobs972.com!' . '<br/> ' ."\n" .
							 'Your new password as a Principal is: <b>'.$user_n_pwd.'</b> '. '<br/> ' ."\n" .
							 'Welcome to Jobs972: The most challenging positions, The most attractive companies, Totally Free!' . '<br/> ' ."\n" .							 
							 'Please follow this link to login your account with a new password as a Principal: <a href="https://jobs972.com/p" target="_blank"><b>Login Jobs972.com As A Principal</b></a><br/>' ."\n" .
							 'The password also can be changed in your Principal profile page.' . '<br/><br/> ' ."\n" .
							 'Regards, ' . ' <br/> ' ."\n" .
							 'Jobs972.com</body></html>';				
				
				mail($user_email, "$subject2", $message, $headers);  
				
			} 				
		
		} // user exists
	
	} // if isset 
	
	$conn->close();	
			
	header("Location: ./../principal/pwd_success_reset.php");
	
?>	