<?php

	//
	// create new user
	//
	
	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");
	
	// Create connection
	$conn0 = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn0->connect_error) {
		die("Connection failed: " . $conn0->connect_error);
	} 

	$conn0->query("set names 'utf8'");	
	
	$sql0 = "SELECT * FROM users where email = '".$_POST['su_email']."'";
	
	$result0 = $conn0->query($sql0);

	if ($result0->num_rows == 1) 
	{    
		echo "EXISTS";
		exit;	    
	} 
	else 
	{
		// Ok
	}
	
	$conn0->close();	
	
	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}

	if (isset($_POST['su_first_name']) && isset($_POST['su_last_name']) && isset($_POST['su_email']) && isset($_POST['su_pwd']))		
	{

		$admin_email = $admin_email_address;
		$subject = "A new user registered Jobs972.com";		

		$su_first_name = htmlspecialchars (mb_substr($_POST['su_first_name'], 0, 20));
	
		$su_first_name=str_replace('"', "", $su_first_name);
		$su_first_name = str_replace("'", "", $su_first_name);
		$su_first_name = stripslashes($su_first_name);
		$su_first_name = ucfirst($su_first_name);

		$su_last_name = htmlspecialchars (mb_substr($_POST['su_last_name'], 0, 20));
	
		$su_last_name=str_replace('"', "", $su_last_name);
		$su_last_name = str_replace("'", "", $su_last_name);
		$su_last_name = stripslashes($su_last_name);
		$su_last_name = ucfirst($su_last_name);
		
		$su_email = htmlspecialchars (mb_substr($_POST['su_email'], 0, 30));
	
		$su_email=str_replace('"', "", $su_email);
		$su_email = str_replace("'", "", $su_email);
		$su_email = stripslashes($su_email);		
		
		$su_pwd = htmlspecialchars (mb_substr($_POST['su_pwd'], 0, 30));
	
		$su_pwd=str_replace('"', "", $su_pwd);
		$su_pwd = str_replace("'", "", $su_pwd);
		$su_pwd = stripslashes($su_pwd);		
		
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
					 'A new user was registered on the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Registration Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'User Firstname: <b>' . $su_first_name . '</b><br/>' ."\n" .
					 'User Lastname: <b>' . $su_last_name . '</b><br/>' ."\n" .
					 'Email: <b>' . $su_email . '</b><br/><br/>' ."\n" .					
					 'Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';	

		$message2 = '<html><body> ' ."\n" .
					 'You were Registered on the Jobs972.com!' . '<br/>' ."\n" .
					 'Registration Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Your Firstname: <b>' . $su_first_name . '</b><br/>' ."\n" .
					 'Your Lastname: <b>' . $su_last_name . '</b><br/>' ."\n" .
					 'Your Email: <b>' . $su_email . '</b><br/></body></html>';			 
		
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
				
				$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
				VALUES ('$db_cur_dt', 2, 0, '$ip_addr', '$su_email', '$message', '$message2', '')";

				if ($conn->query($sql) === TRUE) {
					//  echo "1 New record created successfully";
				} else {
					// echo "Error1: " . $sql . "<br>" . $conn->error;
				}

				$sql2 = "INSERT INTO users (create_dt,	  modify_dt,	firstname,	lastname,	mobile,	city,	positions,	linkedin,	iscitizen,	email,	pwd,	status, is_verified, verification_salt, points ) 
				                    VALUES ('$db_cur_dt', '$db_cur_dt', '$su_first_name', '$su_last_name', '', '', '', '', '1', '$su_email', '$su_pwd', '1', '0', UUID(), 0)";

				if ($conn->query($sql2) === TRUE) {
					//  echo "2 New record created successfully";
				} else {
					//  echo "Error2: " . $sql . "<br>" . $conn->error;
				}				
				
				$conn->close();	

				// send email to user to verify this account
				
				// Create connection
				$conn2 = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn2->connect_error) {
					die("Connection failed: " . $conn2->connect_error);
				} 

				$conn2->query("set names 'utf8'");	
				
				$sql2 = "SELECT * FROM users where email = '".$_POST['su_email']."'";
				
				$result2 = $conn2->query($sql2);

				if ($result2->num_rows == 1) 
				{    
				
					$row = $result2->fetch_assoc();
				
					$the_salt = $row['verification_salt'];
					
					$subject2 = "Registration on the Jobs972.com";	
					
					$headers = "From: " . strip_tags($admin_email) . "\r\n";
					$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
					
					mb_internal_encoding("UTF-8");
			
					$message = '<html><body>Dear '.$su_first_name.' '.$su_last_name.'!' . '<br/><br/> ' ."\n" .
								 'Congratulations! You are just registered on the <a href="http://jobs972.com" target="_blank">Jobs972.com</a>!' . '<br/> ' ."\n" .
								 'Welcome to <a href="http://jobs972.com" target="_blank">Jobs972</a>: The most challenging positions, The most attractive companies, Totally Free!' . '<br/> ' ."\n" .							 
								 'Please follow this link to verify your account: <a href="https://jobs972.com/verify_email_jobs972.php?uobjid='.$the_salt.'" target="_blank"><b>Verify Your Account</b></a><br/><br/>' ."\n" .											
								 'Regards, ' . ' <br/> ' ."\n" .
								 'Jobs972.com</body></html>';				
					
					mail($su_email, "$subject2", $message, $headers);  

					if (!mail($admin_email, "$subject", $message, $headers)) 
					{
					   // something wrong...
					   // echo "something is wrong ";
					   
					}
					else
					{
						// echo "Mail sent Ok";
					}
					
				} 
				else 
				{
					// something is wrong...
					// echo "something is wrong 2";
				}
				
				$conn2->close();				
				
		 	} 		
		
		
	} // if isset 
	
	//
	//
	//
	
?>	