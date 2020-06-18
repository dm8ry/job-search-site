<?php session_start();

	//
	// Invite Your Friend
	//

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");
	
	if ( isset($_SESSION['logged_in_userid']) && isset($_POST['invfr_friend_email']) &&  isset($_POST['invfr_friend_fn'])  &&  isset($_POST['invfr_friend_ln']) )
	{
			
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$conn->query("set names 'utf8'");			
			
		$user_id  = $_SESSION['logged_in_userid'];
		$invfr_friend_email = $_POST['invfr_friend_email'];
		$invfr_friend_fn = $_POST['invfr_friend_fn'];
		$invfr_friend_ln = $_POST['invfr_friend_ln'];
			
		//Email information
		$admin_email = $admin_email_address;
		$subject = "Invite Your Friend on the Jobs972.com";	
				
		$email  = $_SESSION['logged_in_email'];
		$fn  = $_SESSION['logged_in_user_firstname'];
		$ln  = $_SESSION['logged_in_user_lastname'];		
		
		$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
		$cur_dt =  $date->format('d-m-Y H:i:s');  
		$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()	
		
		$ip_addr=$_SERVER['REMOTE_ADDR'];
		
		$headers = "From: " . strip_tags($admin_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		
		$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'A User Invited A Friend on the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Invite Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'User Email: <b>' . $email . '</b><br/>' ."\n" .
					 'User FirstName: <b>' . $fn . '</b><br/>' ."\n" .
					 'User LastName: <b>' . $ln . '</b><br/>' ."\n" .
					 'Friends FirstName: <b>' . $invfr_friend_fn . '</b><br/>' ."\n" .
					 'Friends LastName: <b>' . $invfr_friend_ln . '</b><br/>' ."\n" .
					 'Friends Email: <b>' . $invfr_friend_email . '</b><br/>' ."\n" .
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'You Have Invited A Friend to Use the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Invite Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Your Email: <b>' . $email . '</b><br/>' ."\n" .
					 'Your Firstname: <b>' . $fn . '</b><br/>' ."\n" .
					 'Your Lastname: <b>' . $ln . '</b><br/>' ."\n" .
					 'Friends FirstName: <b>' . $invfr_friend_fn . '</b><br/>' ."\n" .
					 'Friends LastName: <b>' . $invfr_friend_ln . '</b><br/>' ."\n" .
					 'Friends Email: <b>' . $invfr_friend_email . '</b><br/>' ."\n" .					
					 'IP address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
					 'Regards,<br/>' ."\n" .
					 'Jobs972.com</body></html>';
					 				
		if (!mail($admin_email, "$subject", $message2, $headers)) 
		{
		   // something wrong...
		   // echo "something wrong ";
		   
		} else
		{  				
			// everything is good...
			// echo "everything is good ";
			
			// log into businesslog
			
			$logged_in_email = $_SESSION['logged_in_email'];
			
			$logged_user_id = $_SESSION['logged_in_userid'];
			
			$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
			VALUES ('$db_cur_dt', 28, 0, '$ip_addr', '$logged_in_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				//  echo "1 New record created successfully";
			} else {
				//  echo "Error1: " . $sql . "<br>" . $conn->error;
			}					
			
			$sql3 = "update users set points=points+1 where id=$logged_user_id ";			

			if ($conn->query($sql3) === TRUE) {
				 // echo "Record updated successfully";
			} else {
				// echo "Error: " . $sql . "<br>" . $conn->error;
			}				
						
			$subject_invite = $fn." ".$ln." Invites You To Jobs972.com!";	
			
			$headers = "From: " . strip_tags($admin_email) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";			
			
			mb_internal_encoding("UTF-8");
			
			$message = '<html><body>Dear '.$invfr_friend_fn.' '.$invfr_friend_ln.'!' . '<br/><br/> ' ."\n" .
						 $fn.' '.$ln.' Invites You To <a href="http://jobs972.com" target="_blank">Jobs972.com</a>!'. '<br/><br/> ' ."\n" .						 
						 'Welcome to <a href="http://jobs972.com" target="_blank">Jobs972</a>: The most challenging positions, The most attractive companies, Totally Free!' . '<br/><br/>' ."\n" .
						 'Find Job in Israel | חיפוש עבודה | Israeli Companies | משרות הייטק | High Paying Jobs in Israel | לוח דרושים איכותי' . '<br/><br/>' ."\n" .
						 'Regards, ' . ' <br/> ' ."\n" .
						 'Jobs972.com</body></html>';				
			
			mail($invfr_friend_email, "$subject_invite", $message, $headers); 		
		} 							 		
		
		$conn->close();
	
	}		
	
?>