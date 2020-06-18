<?php

	//
	// tell a friend
	//

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		
	
	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
	
	if (isset($_POST['taf_position_id']) && 
		isset($_POST['taf_position_title']) && 
		isset($_POST['taf_company_name']) && 
		isset($_POST['tellafriend_your_friends_email']) &&
		isset($_POST['tellafriend_your_friends_name']) &&
		isset($_POST['tellafriend_your_email']) &&
		isset($_POST['tellafriend_your_name']))
	{
	

		$taf_position_id = $_POST['taf_position_id'];
		$taf_position_title = $_POST['taf_position_title'];
		$taf_company_name = $_POST['taf_company_name'];
		
	
		$admin_email = $admin_email_address;
		$subject = "Tell A Friend Jobs972.com";

		$tellafriend_your_name = htmlspecialchars (mb_substr($_POST['tellafriend_your_name'], 0, 30));
	
		$tellafriend_your_name=str_replace('"', "", $tellafriend_your_name);
		$tellafriend_your_name = str_replace("'", "", $tellafriend_your_name);
		$tellafriend_your_name = stripslashes($tellafriend_your_name);
		$tellafriend_your_name = ucfirst($tellafriend_your_name);

		$tellafriend_your_email = htmlspecialchars (mb_substr($_POST['tellafriend_your_email'], 0, 30));
	
		$tellafriend_your_email=str_replace('"', "", $tellafriend_your_email);
		$tellafriend_your_email = str_replace("'", "", $tellafriend_your_email);
		$tellafriend_your_email = stripslashes($tellafriend_your_email);
		$tellafriend_your_email = ucfirst($tellafriend_your_email);		
	
		$tellafriend_your_friends_name = htmlspecialchars (mb_substr($_POST['tellafriend_your_friends_name'], 0, 30));
	
		$tellafriend_your_friends_name=str_replace('"', "", $tellafriend_your_friends_name);
		$tellafriend_your_friends_name = str_replace("'", "", $tellafriend_your_friends_name);
		$tellafriend_your_friends_name = stripslashes($tellafriend_your_friends_name);
		$tellafriend_your_friends_name = ucfirst($tellafriend_your_friends_name);	
		
		$tellafriend_your_friends_email = htmlspecialchars (mb_substr($_POST['tellafriend_your_friends_email'], 0, 30));
	
		$tellafriend_your_friends_email=str_replace('"', "", $tellafriend_your_friends_email);
		$tellafriend_your_friends_email = str_replace("'", "", $tellafriend_your_friends_email);
		$tellafriend_your_friends_email = stripslashes($tellafriend_your_friends_email);
		$tellafriend_your_friends_email = ucfirst($tellafriend_your_friends_email);
		
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
					 'Tell A Friend Activity on the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Recommender Name: <b>' . $tellafriend_your_name . '</b><br/>' ."\n" .
					 'Recommender Email: <b>' . $tellafriend_your_email . '</b><br/>' ."\n" .
					 'Friends Name: <b>' . $tellafriend_your_friends_name . '</b><br/>' ."\n" .
					 'Friends Email: <b>' . $tellafriend_your_friends_email . '</b><br/>' ."\n" .
					 'Position Recommended: <b>' . $taf_position_title . '@' . $taf_company_name . '</b><br/><br/>' ."\n" .
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
						VALUES ('$db_cur_dt', 31, 0, '$ip_addr', '$tellafriend_your_email', '$message', '', '')";

						if ($conn->query($sql) === TRUE) {
							//  echo "1 New record created successfully";
						} else {
							// echo "Error1: " . $sql . "<br>" . $conn->error;
						}
												
						// send email to a friend
						//   
						
						$subject2 = "Jobs972.com: " . $tellafriend_your_name . " has recommended position for you!";	
						
						$headers = "From: " . strip_tags($admin_email) . "\r\n";
						$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
						
						mb_internal_encoding("UTF-8");
				
						$message = '<html><body>Dear '.$tellafriend_your_friends_name.'!' . '<br/><br/> ' ."\n" .
									 'Your friend '.$tellafriend_your_name.'('.$tellafriend_your_email.') just recommended a challenging position for you on the <a href="http://jobs972.com" target="_blank">Jobs972.com</a>! ' . '<br/> ' ."\n" .
									 'The position recommended for you: <a href="https://www.jobs972.com/positions.php?i='.$taf_position_id.'" target="_blank" >'.$taf_position_title.' @ '.$taf_company_name.'</a>' . '<br/> ' ."\n" .
									 'Welcome to <a href="http://jobs972.com" target="_blank">Jobs972</a>: The most challenging positions, The most attractive companies, Totally Free!' . '<br/><br/> ' ."\n" .									 
									 'Regards, ' . ' <br/> ' ."\n" .
									 'Jobs972.com</body></html>';				
						
						mail($tellafriend_your_friends_email, "$subject2", $message, $headers);  

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
	
	}
	
?>