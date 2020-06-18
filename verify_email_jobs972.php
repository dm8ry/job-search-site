<?php session_start(); 

	

	//
	// verify email jobs 972
	//
	
	include_once('inc/db_connect.php');
	include_once('admin_email.php');		

		
	if  (isset($_GET['uobjid']))
	{
	
		// Create connection
		$conn0 = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn0->connect_error) {
			die("Connection failed: " . $conn0->connect_error);
		} 
		
		$conn0->query("set names 'utf8'");	
		
		$sql0 = "SELECT * FROM users where trim(verification_salt) = trim('".$_GET['uobjid']."') and is_verified=0 ";
		
		$arr_user_details = array();
		$results_user_details = mysqli_query($conn0, $sql0); 

		while($line = mysqli_fetch_assoc($results_user_details)){
			$arr_user_details[] = $line;
		}			

		if ($results_user_details->num_rows == 1) 
		{    		
	
			$admin_email = $admin_email_address;
			$subject = "User Email Has Verified Jobs972.com";		
				
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
						 'User Email Was Successfully Verified on the Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'Verify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'User Email: <b>' . $arr_user_details[0]['email'] . '</b><br/>' ."\n" .
						 'IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
						 'Regards, ' . ' <br/> ' ."\n" .
						 'Administrator.</body></html>';	

			$message2 = '<html><body> ' ."\n" .
						 'Your Email Was Verified Successfully on the Jobs972.com!' . '<br/>' ."\n" .
						'Verify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						'Your Email: <b>' . $arr_user_details[0]['email'] . '</b><br/>' ."\n" .
						'Confirmation IP Address: <b>' . $ip_addr . '</b><br/></body></html>';			 
			
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
				
				$verified_email = $arr_user_details[0]['email'];
				
				$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
				VALUES ('$db_cur_dt', 5, 0, '$ip_addr', '$verified_email', '$message', '$message2', '')";

				$kx =0;
				
				if ($conn->query($sql) === TRUE) {
					//  echo "1 New record created successfully";
					$kx++;
				} else {
					// echo "Error1: " . $sql . "<br>" . $conn->error;
				}

				
				$sql2= 'update users set is_verified = 1 where trim(verification_salt) =  trim(\''.$_GET['uobjid'].'\')';
				 
				
				if ($conn->query($sql2) === TRUE) {
					// echo "Record updated successfully";
					$kx++;
				} else {
					// echo "Error: " . $sql . "<br>" . $conn->error;
				}						
				
				$conn->close();				
				
				if ($kx == 2)
				{	
					$_SESSION['verify_email'] = 1;
					header('Location: https://jobs972.com/thankyouemailverified.php');					
				}
		 	} 		

    
		} 
		else 
		{
			// nothing to do...
		}
		
		$conn0->close();		
	
	
	}
	
	
?>	