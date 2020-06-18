<?php

	//
	// create new user
	//
	
	include_once('./../inc/db_connect.php');
	include_once('./../admin_email.php');
	
	mb_internal_encoding("UTF-8");
	
	// Create connection
	$conn0 = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn0->connect_error) {
		die("Connection failed: " . $conn0->connect_error);
	} 

	$conn0->query("set names 'utf8'");	
	
	$sql0 = "SELECT * FROM principals where status=1 and upper(trim(princ_email)) = upper(trim('".$_POST['form-email']."'))";
	
	$result0 = $conn0->query($sql0);

	if ($result0->num_rows == 1) 
	{    
		header("Location: principal_exists.php");
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

	if (isset($_POST['form-first-name']) && 
		isset($_POST['form-last-name']) && 
		isset($_POST['form-email']) && 
		isset($_POST['form-password']) && 
		isset($_POST['form-about-yourself']))		
	{

		$admin_email = $admin_email_address;
		$subject = "A new principal registered Jobs972.com";		

		$pr_first_name = htmlspecialchars (mb_substr($_POST['form-first-name'], 0, 30));
	
		$pr_first_name=str_replace('"', "", $pr_first_name);
		$pr_first_name = str_replace("'", "", $pr_first_name);
		$pr_first_name = stripslashes($pr_first_name);

		$pr_last_name = htmlspecialchars (mb_substr($_POST['form-last-name'], 0, 30));
	
		$pr_last_name=str_replace('"', "", $pr_last_name);
		$pr_last_name = str_replace("'", "", $pr_last_name);
		$pr_last_name = stripslashes($pr_last_name);		
		
		$pr_email = htmlspecialchars (mb_substr($_POST['form-email'], 0, 30));
	
		$pr_email=str_replace('"', "", $pr_email);
		$pr_email = str_replace("'", "", $pr_email);
		$pr_email = stripslashes($pr_email);	
	
		$pr_password = htmlspecialchars (mb_substr($_POST['form-password'], 0, 30));
	
		$pr_password=str_replace('"', "", $pr_password);
		$pr_password = str_replace("'", "", $pr_password);
		$pr_password = stripslashes($pr_password);	

		$pr_about = htmlspecialchars (mb_substr($_POST['form-about-yourself'], 0, 30));
	
		$pr_about=str_replace('"', "", $pr_about);
		$pr_about = str_replace("'", "", $pr_about);
		$pr_about = stripslashes($pr_about);		
		
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
					 'A new principal was registered on the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Creation Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Firstname: <b>' . $pr_first_name . '</b><br/>' ."\n" .
					 'Principal Lastname: <b>' . $pr_last_name . '</b><br/>' ."\n" .
					 'Principal Email: <b>' . $pr_email . '</b><br/>' ."\n" .
					 'Principal About: <b>' . $pr_about . '</b><br/>' ."\n" .					
					 'IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
					 'Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';	

		$message2 = '<html><body> ' ."\n" .
					 'Principal Registered the Jobs972.com!' . '<br/>' ."\n" .
					 'Creation Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Firstname: <b>' . $pr_first_name . '</b><br/>' ."\n" .
					 'Principal Lastname: <b>' . $pr_last_name . '</b><br/>' ."\n" .
					 'Principal Email: <b>' . $pr_email . '</b><br/>' ."\n" .
					 'Principal About: <b>' . $pr_about . '</b><br/>' ."\n" .	
					 'IP Address: <b>' . $ip_addr . '</b><br/></body></html>';			 
		
		 	if (!mail($admin_email, "$subject", $message, $headers)) 
			{
			   // something wrong...
			   // echo "something wrong ";
			   
			} else
			{  		

				$n_of_Oks = 0;
				
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
				VALUES ('$db_cur_dt', 6, 0, '$ip_addr', '$pr_email', '$message', '$message2', '')";

				if ($conn->query($sql) === TRUE) {
					//  echo "New record created successfully";
					$n_of_Oks++;
				} else {
					// echo "Error: " . $sql . "<br>" . $conn->error;
				}

				$sql2 = "INSERT INTO principals (princ_email,   princ_pwd,    princ_firstname,  princ_lastname, createdt,       modifydt,   princ_about, role, status, verification_salt) 
				                         VALUES ('$pr_email', '$pr_password','$pr_first_name', '$pr_last_name', '$db_cur_dt', '$db_cur_dt', '$pr_about', 'Principal', '1', UUID())";

				if ($conn->query($sql2) === TRUE) {
					//  echo "New record created successfully";
					$n_of_Oks++;
				} else {
					//  echo "Error: " . $sql . "<br>" . $conn->error;
				}								
				
				$sql3 = "update businesslog set principal_id = (select id from principals where princ_email = '$pr_email')  where email = '$pr_email' and  alert_id = 6 and principal_id = 0";

				if ($conn->query($sql3) === TRUE) {
					//  echo "New record created successfully";
					$n_of_Oks++;
				} else {
					//  echo "Error: " . $sql . "<br>" . $conn->error;
				}					
				
				$sql4 = "SELECT * FROM principals where princ_email = '".$pr_email."'";
				
				$result4 = $conn->query($sql4);

				if ($result4->num_rows == 1) 
				{									
				
					$row = $result4->fetch_assoc();
					$the_salt = $row['verification_salt'];
					$fn = $row['princ_firstname'];
					$ln = $row['princ_lastname'];
					$em = $row['princ_email'];
					$pr_id = $row['id'];
					
					$sql5 = "insert into principal_role_link select $pr_id, id, '$db_cur_dt' from role where name = 'Principal' ";

					if ($conn->query($sql5) === TRUE) {
						//  echo "New record inserted successfully";
						$n_of_Oks++;
					} else {
						//  echo "Error: " . $sql . "<br>" . $conn->error;
					}					
				
					$subject_v = "Principal Registration on the Jobs972.com";	
					
					$headers_v = "From: " . strip_tags($admin_email) . "\r\n";
					$headers_v .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
					$headers_v .= "MIME-Version: 1.0\r\n";
					$headers_v .= "Content-Type: text/html; charset=UTF-8\r\n";
					
					mb_internal_encoding("UTF-8");
			
					$message_v = '<html><body>Dear '.$fn.' '.$ln.'!' . '<br/><br/> ' ."\n" .
								 'Congratulations! You are just registered as a Principal on the Jobs972.com!' . '<br/> ' ."\n" .
								 'Welcome to Jobs972: The most challenging positions, The most attractive companies, Totally Free!' . '<br/> ' ."\n" .							 
								 'Please follow this link to verify your account: <a href="https://jobs972.com/principal/verify_principal_email_jobs972.php?uobjid='.$the_salt.'" target="_blank"><b>Verify Your Account</b></a><br/><br/>' ."\n" .											
								 'Regards, ' . ' <br/> ' ."\n" .
								 'Jobs972.com</body></html>';				
					
					mail($em, "$subject_v", $message_v, $headers_v); 				
				
				}	
				else
				{
					// something is wrong...
				}
				
				if ($n_of_Oks == 4)
				{
					header("Location: principal_created_ok.php");
					exit;
				}
				
				$conn->close();				
		 	} 		
		
		
	} // if isset 
	
	//
	//
	//
	
?>	