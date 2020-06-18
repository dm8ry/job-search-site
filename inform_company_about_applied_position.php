<?php session_start();

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	require_once('pmailer/class.phpmailer.php');
	require_once('pmailer/PHPMailerAutoload.php');
	
	mb_internal_encoding("UTF-8");
	
	if (
			isset($_POST['n']) &&			
			isset($_POST['ic_email']) &&
			isset($_SESSION['princ_login']) &&
			isset($_SESSION['princ_id']) &&
			isset($_SESSION['princ_first_name']) &&
			isset($_SESSION['princ_email']) 
		)
	{

			$up_n = $_POST['n'];		
				
			$princ_login = $_SESSION['princ_login'];
			$princ_first_name = $_SESSION['princ_first_name'];
			$princ_id = $_SESSION['princ_id'];
			$princ_email = $_SESSION['princ_email'];
			$ic_email = $_POST['ic_email'];
						
			$admin_email = $admin_email_address;
			$subject = "Informer: The Company Was Informed About Position Applied on the Jobs972.com";		
			
			$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
			$cur_dt =  $date->format('d-m-Y H:i:s');  
			$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()	
			
			$ip_addr=$_SERVER['REMOTE_ADDR'];						
						
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 

			$conn->query("set names 'utf8'");			
			
			$sql_the_details = "select 
									up.user_id,
									up.pos_id,
									up.res_id,
									up.cover_letter,
									p.pos_title,
									p.pos_desc,
									us.firstname,
									us.lastname,
									us.mobile,
									us.city,
									us.linkedin,
									us.about,
									us.positions,
									r.file_path,
									r.file_desc,
									co.the_name company_name,
									ci.name_en	company_city
								from 
									user_positions up,	
									positions p,
									users us,
									resumes r,
									company co,
									city ci
								where 
									up.id = $up_n 
							    and
									p.id = up.pos_id
								and 
									p.pos_status = '1'
								and
									us.id = up.user_id
								and
									us.status = '1'
								and
									r.id = up.res_id
								and
									r.status = '1' 
								and
									p.company_id = co.id
								and
									co.placement_id = ci.id
								and
									co.status = '1' ";
										
			$arr_the_details = array();		
			$results_the_details = mysqli_query($conn, $sql_the_details); 	
			
			while($line = mysqli_fetch_assoc($results_the_details)){
				$arr_the_details[] = $line;
			}
			
			if (sizeof($arr_the_details) == 1)
			{
				// echo "1 Record Found!";
				
				//// send email
				
				if ( strlen($arr_the_details[0]['about']) > 0 )
				{
					$about_part = 'About Candidate: <b>' . $arr_the_details[0]['about'] . '</b><br/>'."\n";
				}
				else
				{
					$about_part = '';
				}
				
				if ( strlen($arr_the_details[0]['cover_letter']) > 0 )
				{
					$cover_letter_part = 'Cover Letter: <b>' . $arr_the_details[0]['cover_letter'] . '</b><br/>'."\n";
				}
				else
				{
					$cover_letter_part = '';
				}				
				
				if ( strlen($arr_the_details[0]['mobile']) > 0 )
				{
					$mobile_part = 'Candidate Mobile: <b>' . $arr_the_details[0]['mobile'] . '</b><br/>'."\n";
				}
				else
				{
					$mobile_part = '';
				}	

				if ( strlen($arr_the_details[0]['city']) > 0 )
				{
					$livesin_part = 'Candidate Lives In: <b>' . $arr_the_details[0]['city'] . '</b><br/>'."\n";
				}
				else
				{
					$livesin_part = '';
				}	

				if ( strlen($arr_the_details[0]['positions']) > 0 )
				{
					$positions_part = 'Candidate Is Looking For: <b>' . $arr_the_details[0]['positions'] . '</b><br/>'."\n";
				}
				else
				{
					$positions_part = '';
				}				
				
				$bodytext = '<html><body>Dear '.$arr_the_details[0]['company_name'].'!<br/><br/>'."\n" .
							'A New Candidate Has Applied For Position on Your Company via <a href="http://jobs972.com" target="_blank">Jobs972.com</a>!<br/><br/>'."\n" .
							'Candidate: <b>' . $arr_the_details[0]['firstname'] . ' ' . $arr_the_details[0]['lastname'] . '</b><br/>'."\n" .
							$mobile_part.
							$livesin_part.
							$about_part.
							$positions_part.
							$cover_letter_part.
							'Candidate Resume: <b>Please Find It Attached To This Email</b><br/><br/>'."\n" .
							'Company: <b>' . $arr_the_details[0]['company_name'] . '</b><br/>'."\n" .
							'Position: <b>' . $arr_the_details[0]['pos_title'] . '</b><br/><br/>'."\n" .							
							'Position Description: <br/>' . nl2br($arr_the_details[0]['pos_desc']) . '<br/><br/>'."\n" .
							'Welcome to <a href="http://jobs972.com" target="_blank">Jobs972.com</a>: The most challenging positions, The most attractive companies, Totally Free!' . '<br/>' ."\n" .							
							'The <a href="http://jobs972.com" target="_blank">Jobs972.com</a> provides intuitive interface, which aims to find jobs for those who seeks it, and find the best employees for companies.' . '<br/>' ."\n" .
							'Feel free to send us the detailed list of your company open positions and corresponding requirements to attract the most suitable candidates!' . '<br/><br/>' ."\n" .
							'Regards,<br/>'."\n" .
							'Jobs972.com</body></html>';
							
				$email = new PHPMailer();
				$email->From      = strip_tags($admin_email);
				$email->FromName  = 'Jobs972.com';
				$email->addReplyTo(strip_tags($admin_email), "");
				$email->Subject   = 'A New Candidate '.$arr_the_details[0]['firstname'] . ' ' . $arr_the_details[0]['lastname'].' Has Applied For Position '.$arr_the_details[0]['pos_title'].' on Your Company via Jobs972.com';
				$email->Body      = $bodytext;
				$email->IsHTML(true);
				$email->AddAddress( $ic_email );
				$email->AddAttachment( $_SERVER['DOCUMENT_ROOT'] . '/' . $arr_the_details[0]['file_path'] );				
				$email->Send();
												
				//// businesslog
				
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

				$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
							 'The Company was Informed about Application For Position On the Jobs972.com!' . '<br/><br/> ' ."\n" .
							 'Inform Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
							 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
							 'Position Title: <b>' . $arr_the_details[0]['pos_title'] . '</b><br/>' ."\n" .					
							 'Company Name: <b>' . $arr_the_details[0]['company_name'] . '</b><br/>' ."\n" .
							 'Candidate Name: <b>' . $arr_the_details[0]['firstname'] . ' ' . $arr_the_details[0]['lastname'] . '</b><br/>' ."\n" .
							 'Resume: <b>' . $arr_the_details[0]['file_desc'] . '</b><br/>' ."\n" .
							 'Informed by Email: <b>' . $ic_email . '</b><br/>' ."\n" .
							 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
							 '<br/>Regards, ' . ' <br/> ' ."\n" .
							 'Administrator.</body></html>';		
							 
				$message2 = '<html><body> ' ."\n" .
							 'You Have Informed The Company about Application For Position on the Jobs972.com!' . '<br/>' ."\n" .
							 'Inform Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'Your Email: <b>' . $princ_email . '</b><br/>' ."\n" .
							 'Your Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
							 'Position Title: <b>' . $arr_the_details[0]['pos_title'] . '</b><br/>' ."\n" .					
							 'Company Name: <b>' . $arr_the_details[0]['company_name'] . '</b><br/>' ."\n" .
							 'Candidate Name: <b>' . $arr_the_details[0]['firstname'] . ' ' . $arr_the_details[0]['lastname'] . '</b><br/>' ."\n" .
							 'Resume: <b>' . $arr_the_details[0]['file_desc'] . '</b><br/>' ."\n" .	
							 'Informed by Email: <b>' . $ic_email . '</b><br/>' ."\n" .							 
							 'IP Address: <b>' . $ip_addr . '</b><br/></body></html>';				
				
				if (!mail($admin_email, "$subject", $message, $headers)) 
				{
				   // something wrong...
				   // echo "something wrong ";									   
				} 
				else
				{ 
				
					$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
					VALUES ('$db_cur_dt', 27, $princ_id, '$ip_addr', '$princ_email', '$message', '$message2', '')";

					if ($conn->query($sql) === TRUE) {
						   echo "New record created successfully";
					} else {
						  echo "Error: " . $sql . "<br>" . $conn->error;
					}				
						
				}
				
				//// update last inform date - table user_positions
				
				$sql_10 = "update user_positions
						  set informer_dt = '$db_cur_dt'
							where id = $up_n";
			    
				if ($conn->query($sql_10) === TRUE) {
					  echo "Record updated successfully";
				} else {
					  echo "Error: " . $sql_10 . "<br>" . $conn->error;
				}
					
			}
			else
			{
				echo "No Records Found!";
			}
			
			$conn->close();

	}	

?>