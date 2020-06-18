<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_SESSION['princ_email']) && isset($_SESSION['princ_id']) && isset($_POST['the_position_title']) &&  isset($_SESSION['princ_first_name']) && isset($_POST['n']) )
	{
	
		$princ_id = $_SESSION['princ_id'];
		$princ_email  = $_SESSION['princ_email'];
		$princ_first_name = $_SESSION['princ_first_name'];
		$u_p_id  = $_POST['n'];
		$the_position_title = $_POST['the_position_title'];
		$the_candidate_name = $_POST['the_candidate_name'];
	
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");
		
		$admin_email = $admin_email_address;
		$subject = "Not Relevant: candidate $the_candidate_name for position $the_position_title on the Jobs972.com";		

		$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
		$cur_dt =  $date->format('d-m-Y H:i:s');  
		$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()			
		
		$ip_addr=$_SERVER['REMOTE_ADDR'];
		
		$headers = "From: " . strip_tags($admin_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Not Relevant Application: candidate '.$the_candidate_name.' for position '.$the_position_title.' on the Jobs972.com' . '<br/> ' ."\n" .
					 'Reject Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Position Title: <b>' . $the_position_title . '</b><br/>' ."\n" .
					 'Candidate: <b>' . $the_candidate_name . '</b><br/>' ."\n" .
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'Not Relevant Application: candidate <b>'.$the_candidate_name.'</b> for position <b>'.$the_position_title.'</b> on the Jobs972.com' . '<br/> ' ."\n" .
					 'Reject Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Your Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Your Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Position Title: <b>' . $the_position_title . '</b><br/>' ."\n" .					 
					 'Candidate: <b>' . $the_candidate_name . '</b><br/>' ."\n" .
					 'IP Address: <b>' . $ip_addr . '</b><br/></body></html>';		
		
		$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
		VALUES ('$db_cur_dt', 25, $princ_id, '$ip_addr', '$princ_email', '$message', '$message2', '')";

		if ($conn->query($sql) === TRUE) {
			   echo "1 New record created successfully";
		} else {
			  echo "Error1: " . $sql . "<br>" . $conn->error;
		}		
		
		$sql_generate_recommended_positions2 = "update user_positions set status='W' where id=$u_p_id";
 
		mysqli_query($conn, $sql_generate_recommended_positions2);
		
		$conn->close();			
							
		// echo  'Ok';
		 
	}	
	else
	{
		echo 'Error!!!';
	}

?>