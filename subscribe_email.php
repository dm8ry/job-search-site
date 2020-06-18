<?php

	//
	// subscribe email
	//

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");	
	
	$if_email_exists = 1;
	
	// Create connection
	$conn0 = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn0->connect_error) {
		die("Connection failed: " . $conn0->connect_error);
	} 

	$conn0->query("set names 'utf8'");	
	
	$sql0 = "SELECT * FROM subscribers where upper(email) = upper('".$_POST['subsc_email_onform']."')";
	
	$result0 = $conn0->query($sql0);

	if ($result0->num_rows == 1) 
	{    
		$if_email_exists = 1;  
	} 
	else 
	{
		$if_email_exists = 0;
	}
	
	$conn0->close();	
	
	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}

	if (isset($_POST['subsc_email_onform']))		
	{
	
		$subsc_email_onform = $_POST['subsc_email_onform'];
		
		$admin_email = $admin_email_address;
		$subject = "A new subscriber Jobs972.com";

		$subsc_first_name = htmlspecialchars (mb_substr($_POST['subsc_fname'], 0, 20));
	
		$subsc_first_name=str_replace('"', "", $subsc_first_name);
		$subsc_first_name = str_replace("'", "", $subsc_first_name);
		$subsc_first_name = stripslashes($subsc_first_name);
		$subsc_first_name = ucfirst($subsc_first_name);

		$subsc_last_name = htmlspecialchars (mb_substr($_POST['subsc_lname'], 0, 20));
	
		$subsc_last_name=str_replace('"', "", $subsc_last_name);
		$subsc_last_name = str_replace("'", "", $subsc_last_name);
		$subsc_last_name = stripslashes($subsc_last_name);
		$subsc_last_name = ucfirst($subsc_last_name);
				
		$subsc_phone = htmlspecialchars (mb_substr($_POST['subsc_phone'], 0, 20));
	
		$subsc_phone=str_replace('"', "", $subsc_phone);
		$subsc_phone = str_replace("'", "", $subsc_phone);
		$subsc_phone = stripslashes($subsc_phone);
		$subsc_phone = ucfirst($subsc_phone);		
		
		$subsc_city = htmlspecialchars (mb_substr($_POST['subsc_city'], 0, 20));
	
		$subsc_city=str_replace('"', "", $subsc_city);
		$subsc_city = str_replace("'", "", $subsc_city);
		$subsc_city = stripslashes($subsc_city);
		$subsc_city = ucfirst($subsc_city);		
		
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
					 'A new subscriber on the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Subscribe Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Subscriber Firstname: <b>' . $subsc_first_name . '</b><br/>' ."\n" .
					 'Subscriber Lastname: <b>' . $subsc_last_name . '</b><br/>' ."\n" .
					 'Subscriber Phone: <b>' . $subsc_phone . '</b><br/>' ."\n" .
					 'Subscriber City: <b>' . $subsc_city . '</b><br/>' ."\n" .
					 'Email: <b>' . $subsc_email_onform . '</b><br/><br/>' ."\n" .					
					 'Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';	
		
					if (!mail($admin_email, "$subject", $message, $headers)) 
					{
					   // something wrong...
					   // echo "something wrong ";
					   
					} 
					else
					{		
					
						// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						} 

						$conn->query("set names 'utf8'");	

						$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
						VALUES ('$db_cur_dt', 29, 0, '$ip_addr', '$subsc_email_onform', '$message', '', '')";

						if ($conn->query($sql) === TRUE) {
							//  echo "1 New record created successfully";
						} else {
							// echo "Error1: " . $sql . "<br>" . $conn->error;
						}
						
						$sql2 = "INSERT INTO subscribers (email,	 
														  first_name,
														  last_name,
														  phone,
														  city,
														  subscribe_dt,
														  last_sent_dt,
														  status,
														  salt_value,
														  is_email_confirmed,
														  email_confirmation_dt)
											VALUES 
														('$subsc_email_onform',
														 '$subsc_first_name',
														 '$subsc_last_name',
														 '$subsc_phone',
														 '$subsc_city',														 
														'$db_cur_dt', 
														'NULL', 
														'0',
														UUID(),
														'0',
														'NULL')";

						if ($conn->query($sql2) === TRUE) {
							//  echo "2 New record created successfully";
						} else {
							//  echo "Error2: " . $sql . "<br>" . $conn->error;
						}				
						
						$conn->close();

						// send email to verify this subscribtion
						//
					
						// Create connection
						$conn2 = new mysqli($servername, $username, $password, $dbname);
						// Check connection
						if ($conn2->connect_error) {
							die("Connection failed: " . $conn2->connect_error);
						} 

						$conn2->query("set names 'utf8'");	
						
						$sql2 = "SELECT * FROM subscribers where upper(email) = upper('".$subsc_email_onform."')";
						
						$result2 = $conn2->query($sql2);

						if ($result2->num_rows == 1) 
						{    
						
							$row = $result2->fetch_assoc();
						
							$the_salt = $row['salt_value'];
							
							$subject2 = "Your Subscribtion on the Jobs972.com";	
							
							$headers = "From: " . strip_tags($admin_email) . "\r\n";
							$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
							
							mb_internal_encoding("UTF-8");
					
							$message = '<html><body>Dear '.$subsc_email_onform.'!' . '<br/><br/> ' ."\n" .
										 'Congratulations! You are just subscribed on the <a href="http://jobs972.com" target="_blank">Jobs972.com</a>!' . '<br/> ' ."\n" .
										 'Welcome to <a href="http://jobs972.com" target="_blank">Jobs972</a>: The most challenging positions, The most attractive companies, Totally Free!' . '<br/> ' ."\n" .							 
										 'Please follow this link to verify your email address: <a href="https://jobs972.com/verify_subscriber_jobs972.php?uobjid='.$the_salt.'" target="_blank"><b>Verify Your Email</b></a><br/><br/>' ."\n" .											
										 'Regards, ' . ' <br/> ' ."\n" .
										 'Jobs972.com</body></html>';				
							
							mail($subsc_email_onform, "$subject2", $message, $headers);  

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
		
	}	
	
?>