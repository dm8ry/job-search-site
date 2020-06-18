<?php session_start();

	// apply for this position ajax

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");
	
	//echo $_POST['apply_position_resume'];
	
	if ( isset($_POST['apply_position_resume']) && isset($_POST['apply_position_name']) && isset($_POST['apply_for_this_position_user_pos_id']) )
	{
			
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$conn->query("set names 'utf8'");	
		
		// check position id
		$sql0 = "select id from positions where pos_status = '1' and id in (select pos_id from user_positions where id = ".$_POST['apply_for_this_position_user_pos_id'].") ";
		$result0= $conn->query($sql0);
		if ($result0->num_rows == 0)
		{
			$pos_ref_id = -1;
		}
		else
		{		
			$row0 = $result0->fetch_assoc();
			$pos_ref_id = $row0['id'];
		}		
	
		//Email information
		$admin_email = $admin_email_address;
		$subject = "Apply for Position on the Jobs972.com";	

		$apply_for_this_position_user_pos_id = $_POST['apply_for_this_position_user_pos_id'];
		$apply_position_name = $_POST['apply_position_name'];
		$apply_position_resume_id = $_POST['apply_position_resume'];
		
		$apply_resume_cover_txt = htmlspecialchars (mb_substr($_POST['apply_resume_cover'], 0, 300));
	
		$apply_resume_cover_txt=str_replace('"', "", $apply_resume_cover_txt);
		$apply_resume_cover_txt = str_replace("'", "", $apply_resume_cover_txt);
		$apply_resume_cover_txt = stripslashes($apply_resume_cover_txt);	
	
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
		
		if ($pos_ref_id == -1)
		{
	
			$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'A User Applied for Position on the Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'Applicatoin Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'User Email: <b>' . $email . '</b><br/>' ."\n" .
						 'User FirstName: <b>' . $fn . '</b><br/>' ."\n" .
						 'User LastName: <b>' . $ln . '</b><br/>' ."\n" .
						 'Position Description: <b>' . $apply_position_name . '</b><br/>' ."\n" .
						 'Cover Letter: <b>' . $apply_resume_cover_txt . '</b><br/>' ."\n" .						
						 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
						 '<br/>Regards, ' . ' <br/> ' ."\n" .
						 'Administrator.</body></html>';		
						 
			$message2 = '<html><body> ' ."\n" .
						 'You Have Applied for Position on the Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'Applicatoin Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'Your Email: <b>' . $email . '</b><br/>' ."\n" .
						 'Your Firstname: <b>' . $fn . '</b><br/>' ."\n" .
						 'Your Lastname: <b>' . $ln . '</b><br/>' ."\n" .
						 'You Have Applied For Position: <b>' . $apply_position_name . '</b><br/>' ."\n" .
						 'Cover Letter: <b>' . $apply_resume_cover_txt . '</b><br/>' ."\n" .
						 'IP address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
						 'Regards,<br/>' ."\n" .
						 'Jobs972.com</body></html>';
		}
		else
		{
		
			$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'A User Applied for Position on the Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'Applicatoin Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'User Email: <b>' . $email . '</b><br/>' ."\n" .
						 'User FirstName: <b>' . $fn . '</b><br/>' ."\n" .
						 'User LastName: <b>' . $ln . '</b><br/>' ."\n" .
						 'Position Description: <a href="http://jobs972.com/index.php?i='.$pos_ref_id.'" target="_blank"><b>' . $apply_position_name . '</b></a><br/>' ."\n" .
						 'Cover Letter: <b>' . $apply_resume_cover_txt . '</b><br/>' ."\n" .						
						 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
						 '<br/>Regards, ' . ' <br/> ' ."\n" .
						 'Administrator.</body></html>';		
						 
			$message2 = '<html><body> ' ."\n" .
						 'You Have Applied for Position on the Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'Applicatoin Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'Your Email: <b>' . $email . '</b><br/>' ."\n" .
						 'Your Firstname: <b>' . $fn . '</b><br/>' ."\n" .
						 'Your Lastname: <b>' . $ln . '</b><br/>' ."\n" .
						 'You Have Applied For Position: <a href="http://jobs972.com/index.php?i='.$pos_ref_id.'" target="_blank"><b>' . $apply_position_name . '</b></a><br/>' ."\n" .
						 'Cover Letter: <b>' . $apply_resume_cover_txt . '</b><br/>' ."\n" .
						 'IP address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
						 'Regards,<br/>' ."\n" .
						 'Jobs972.com</body></html>';
		
		}
		
		if (!mail($admin_email, "$subject", $message2, $headers)) 
		{
		   // something wrong...
		   // echo "something wrong ";   
		} 
		else
		{  				
			// everything is good...
			// echo "everything is good ";
			
			// log into businesslog
			
			$logged_in_email = $_SESSION['logged_in_email'];
			$logged_user_id = $_SESSION['logged_in_userid'];
			
			$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
			VALUES ('$db_cur_dt', 12, 0, '$ip_addr', '$logged_in_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				//  echo "1 New record created successfully";
			} else {
				//  echo "Error1: " . $sql . "<br>" . $conn->error;
			}

			$sql2 = "update user_positions set status = 'A', modify_dt='$db_cur_dt', res_id=$apply_position_resume_id, cover_letter='$apply_resume_cover_txt' where id=$apply_for_this_position_user_pos_id";			

			if ($conn->query($sql2) === TRUE) {
				 // echo "Record updated successfully";
			} else {
				// echo "Error: " . $sql . "<br>" . $conn->error;
			}				
			
			$sql3 = "update positions set napply=napply+1 where id=(select pos_id from user_positions where id=$apply_for_this_position_user_pos_id)";			

			if ($conn->query($sql3) === TRUE) {
				 // echo "Record updated successfully";
			} else {
				// echo "Error: " . $sql . "<br>" . $conn->error;
			}			
			
			$sql4 = "select prop_value from app_properties where prop_name = 'default_email_apply_positions' ";
			$result4= $conn->query($sql4);
			$row4 = $result4->fetch_assoc();
			$def_email_to_apply = $row4['prop_value'];
			
			$sql5 = "select pos_contact_email from positions where id=(select pos_id from user_positions where id=$apply_for_this_position_user_pos_id) ";
			$result5= $conn->query($sql5);
			$row5 = $result5->fetch_assoc();
			$pos_contact_email = $row5['pos_contact_email'];			
			
			$subject_apply = "Apply For Position on the Jobs972.com";	
			
			$headers = "From: " . strip_tags($admin_email) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";			
			
			mb_internal_encoding("UTF-8");
			
			if ($pos_ref_id == -1)
			{
				$message = '<html><body>Dear Recruter!' . '<br/><br/> ' ."\n" .
							 'A New Candindate Just Applied For Position <b>'.$apply_position_name.'</b> You Have Placed on the Jobs972.com!' . '<br/> ' ."\n" .
							 'Candidate Firstname: <b>'.$fn.'</b>;  Candidate Lastname: <b>'.$ln.'</b>' . '<br/> ' ."\n" .
							 'Applicatoin Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'Please see this application details following the link: <a href="https://jobs972.com/principal" target="_blank"><b>Principal Login</b></a><br/>' ."\n" .
							 'Welcome to Jobs972: The most challenging positions, The most attractive companies, Totally Free!' . '<br/><br/>' ."\n" .
							 'Regards, ' . ' <br/> ' ."\n" .
							 'Jobs972.com</body></html>';							
			}
			else
			{
				$message = '<html><body>Dear Recruter!' . '<br/><br/> ' ."\n" .
							 'A New Candindate Just Applied For Position <a href="http://jobs972.com/index.php?i='.$pos_ref_id.'" target="_blank"><b>'.$apply_position_name.'</b></a> You Have Placed on the Jobs972.com!' . '<br/> ' ."\n" .
							 'Candidate Firstname: <b>'.$fn.'</b>;  Candidate Lastname: <b>'.$ln.'</b>' . '<br/> ' ."\n" .
							 'Applicatoin Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'Please see this application details following the link: <a href="https://jobs972.com/principal" target="_blank"><b>Principal Login</b></a><br/>' ."\n" .
							 'Welcome to Jobs972: The most challenging positions, The most attractive companies, Totally Free!' . '<br/><br/>' ."\n" .
							 'Regards, ' . ' <br/> ' ."\n" .
							 'Jobs972.com</body></html>';	
			}						 
			
			if ($pos_contact_email == '')
			{
				mail($def_email_to_apply, "$subject_apply", $message, $headers);
			}
			else
			{
				mail($pos_contact_email, "$subject_apply", $message, $headers);
			}
			
		} 							 
	
		echo "Ok";
	
		$conn->close();
	
	}		
	
?>