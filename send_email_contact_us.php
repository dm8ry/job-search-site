<?php

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
	
	if(isset($_POST['em']) && isset($_POST['fn']) && isset($_POST['ln']) && isset($_POST['sb']) && isset($_POST['ms']))
	{		
	
		//Email information
		$admin_email = $admin_email_address;
		$subject = "A new contact message from jobs972.com";
		$email = htmlspecialchars (substr($_POST['em'], 0, 50));
		$first_name = htmlspecialchars (substr($_POST['fn'], 0 , 50));
		$last_name = htmlspecialchars (substr($_POST['ln'], 0, 50));
		$subj = htmlspecialchars (substr($_POST['sb'],0, 70));
		$msg = htmlspecialchars (substr($_POST['ms'],0, 600));	

		$email=str_replace('"', "", $email);
		$email = str_replace("'", "", $email);
		$email = stripslashes($email);
		
		$first_name=str_replace('"', "", $first_name);
		$first_name = str_replace("'", "", $first_name);
		$first_name = stripslashes($first_name);
		
		$last_name=str_replace('"', "", $last_name);
		$last_name = str_replace("'", "", $last_name);
		$last_name = stripslashes($last_name);		
		
		$subj=str_replace('"', "", $subj);
		$subj = str_replace("'", "", $subj);	
		$subj = stripslashes($subj);
		
		$msg=str_replace('"', "", $msg);
		$msg = str_replace("'", "", $msg);	
		$msg = stripslashes($msg);		
		
		$ip_addr=$_SERVER['REMOTE_ADDR'];
		
		$headers = "From: " . strip_tags($admin_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($email) . "\r\n";		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";		
		
		if (isValidEmail($email))
		{
					
			$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
			$cur_dt =  $date->format('d-m-Y H:i:s');  
			$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()			
		  
			$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/>' ."\n" .
						 'You have a new message from the contact page of the Jobs972.com!' . '<br/><br/>' ."\n" .
						 'The date of the Message: <b>' . $cur_dt . '</b><br/>' ."\n" .
						 'The first name of the Sender: <b>' . $first_name . '</b><br/>' ."\n" .
						 'The last name of the Sender: <b>' . $last_name . '</b><br/>' ."\n" .
						 'Email of the Sender: <b>' . $email . '</b><br/>' ."\n" .
						 'The Subject of the Message: <b>' . $subj . '</b><br/>' ."\n" .
						 'The Message: <b>' . $msg . '</b><br/><br/>' ."\n" .
						 'Regards, ' . ' <br/>' ."\n" .
						 'Administrator.</body></html>';
						 
			$message2 = '<html><body>' ."\n" .
						 'The Contact Us message sent from the Jobs972.com!' . '<br/>' ."\n" .
						 'The Date of the Message: <b>' . $cur_dt . '</b><br/>' ."\n" .
						 'The First Name of the Sender: <b>' . $first_name . '</b><br/>' ."\n" .
						 'The Last Name of the Sender: <b>' . $last_name . '</b><br/>' ."\n" .
						 'Email of the Sender: <b>' . $email . '</b><br/>' ."\n" .
						 'The Subject of the Message: <b>' . $subj . '</b><br/>' ."\n" .
						 'The Message: <b>' . $msg . '</b><br/>' ."\n" .
						 'IP Address: <b>' . $ip_addr. '</b><br/></body></html>';
			
		 	if (!mail($admin_email, "$subject", $message, $headers)) 
			{
			   // something wrong...			   
			   
			} else
			{  
			
				// everything is good...
				
				// log into businesslog
				
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 

				$conn->query("set names 'utf8'");
				
				$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
				VALUES ('$db_cur_dt', 1, 0, '$ip_addr', '$email', '$message', '$message2', 'contactus.php' )";

				if ($conn->query($sql) === TRUE) {
					// echo "New record created successfully";
				} else {
					// echo "Error: " . $sql . "<br>" . $conn->error;
				}

				$conn->close();				
		 	} 
			
		}
	}
  
?>