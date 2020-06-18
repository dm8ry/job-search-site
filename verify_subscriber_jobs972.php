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
		
		$sql0 = "SELECT * FROM subscribers where trim(salt_value) = trim('".$_GET['uobjid']."') and is_email_confirmed='0' ";
		
		$arr_user_details = array();
		$results_user_details = mysqli_query($conn0, $sql0); 

		while($line = mysqli_fetch_assoc($results_user_details)){
			$arr_user_details[] = $line;
		}			

		if ($results_user_details->num_rows == 1) 
		{    		
	
			$admin_email = $admin_email_address;
			$subject = "Subscriber Email Has Verified Jobs972.com";		
				
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
						 'Visitor Subscription Was Successfully Verified on the Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'Verify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'Subscriber Email: <b>' . $arr_user_details[0]['email'] . '</b><br/>' ."\n" .
						 'Subscriber First Name: <b>' . $arr_user_details[0]['first_name'] . '</b><br/>' ."\n" .
						 'Subscriber Last Name: <b>' . $arr_user_details[0]['last_name'] . '</b><br/>' ."\n" .
						 'Subscriber Phone: <b>' . $arr_user_details[0]['phone'] . '</b><br/>' ."\n" .
						 'Subscriber City: <b>' . $arr_user_details[0]['city'] . '</b><br/>' ."\n" .
						 'IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
						 'Regards, ' . ' <br/> ' ."\n" .
						 'Administrator.</body></html>';	

			$message2 = '';			 
			
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
				VALUES ('$db_cur_dt', 30, 0, '$ip_addr', '$verified_email', '$message', '', '')";

				$kx =0;
				
				if ($conn->query($sql) === TRUE) {
					//  echo "1 New record created successfully";
					$kx++;
				} else {
					// echo "Error1: " . $sql . "<br>" . $conn->error;
				}

				
				$sql2= "update 
								subscribers 
							set 
								is_email_confirmed = '1', 
								status = '1', 
								email_confirmation_dt = '".$db_cur_dt."' 
							where 
								trim(salt_value) = trim('".$_GET['uobjid']."')";
				 
				
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
					header('Location: https://jobs972.com/thankyousubscribtionverified.php');					
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