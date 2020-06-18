<?php session_start();

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");
	
	if (
			isset($_POST['position_title']) &&
			isset($_POST['company_nm']) &&
			isset($_POST['pos_type']) &&
			isset($_POST['pos_desc_eng']) 
		)
	{
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$conn->query("set names 'utf8'");	
						
		//Email information
		$admin_email = $admin_email_address;
		$subject = "A New Position Was Created on the Jobs972.com";	

		$position_title = $conn->real_escape_string($_POST['position_title']);
		$position_title_heb = $conn->real_escape_string($_POST['position_title_heb']);
		$pos_desc_eng = $conn->real_escape_string($_POST['pos_desc_eng']);
		$pos_desc_heb = $conn->real_escape_string($_POST['pos_desc_heb']);
		
		$company_nm = $_POST['company_nm'];
		$pos_type = $_POST['pos_type'];
		
		$pos_cat1 = $_POST['pos_cat1'];
		$pos_scat1 = $_POST['pos_scat1'];
		$pos_cat2 = $_POST['pos_cat2'];
		$pos_scat2 = $_POST['pos_scat2'];
		$pos_cat3 = $_POST['pos_cat3'];
		$pos_scat3 = $_POST['pos_scat3'];
		$pos_cat4 = $_POST['pos_cat4'];
		$pos_scat4 = $_POST['pos_scat4'];
		$pos_cat5 = $_POST['pos_cat5'];
		$pos_scat5 = $_POST['pos_scat5'];
		
		$pos_contact_email = $conn->real_escape_string($_POST['pos_contact_email']);
		$pos_notes = $conn->real_escape_string($_POST['pos_notes']);
		
		$sql_get_companyname_by_id =  'select the_name from company where id = '.$company_nm;
		
		echo ' '.$sql_get_companyname_by_id.'  ';
		
		$arr_company_name = array();		
		$results_company_name = mysqli_query($conn, $sql_get_companyname_by_id); 	
		
		while($line = mysqli_fetch_assoc($results_company_name)){
			$arr_company_name[] = $line;
		}			
		
		$company_name = $arr_company_name[0]['the_name'];
		
		$princ_id = $_SESSION['princ_id'];
		$princ_first_name = $_SESSION['princ_first_name'];
		$princ_email = $_SESSION['princ_email'];	
		
		$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
		$cur_dt =  $date->format('d-m-Y H:i:s');  
		$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()	
		
		$ip_addr=$_SERVER['REMOTE_ADDR'];
		
		$headers = "From: " . strip_tags($admin_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'A New Position Was Added On the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Add Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $company_name . '</b><br/>' ."\n" .
					 'Position Title: <b>' . $position_title . '</b><br/>' ."\n" .
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'You Have Added A New Position on the Jobs972.com!' . '<br/>' ."\n" .
					 'It is waiting for Admin approval.' . '<br/>' ."\n" .
					 'Add Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Your Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Your Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $company_name . '</b><br/>' ."\n" .
					 'Position Title: <b>' . $position_title . '</b><br/>' ."\n" .
					 'IP Address: <b>' . $ip_addr . '</b><br/></body></html>';
					 
		if (!mail($admin_email, "$subject", $message, $headers)) 
		{
		   // something wrong...
		   // echo "something wrong ";
		   
		} else
		{  				
			// everything is good...
			// echo "everything is good ";
			
			// log into businesslog
			
			$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
			VALUES ('$db_cur_dt', 21, $princ_id, '$ip_addr', '$princ_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				   echo "1 New record created successfully";
			} else {
				  echo "Error1: " . $sql . "<br>" . $conn->error;
			}

			$sql2 = "insert into positions (createdt,      modifydt,     principal_id,  pos_title,          pos_title_heb,  company_id,   pos_desc,         pos_desc_heb,    nviews, napply,  job_type,    pos_cat, 	pos_sub_cat, pos_cat_2,   pos_sub_cat_2,  pos_cat_3, pos_sub_cat_3,  pos_cat_4, pos_sub_cat_4,  pos_cat_5, pos_sub_cat_5, pos_priority, pos_status,  pos_contact_email, pos_notes) 
			                       values ('$db_cur_dt', '$db_cur_dt',   $princ_id,     '$position_title',  '',             $company_nm,  '$pos_desc_eng',  '$pos_desc_heb', 0, 	 0,		  '$pos_type', '$pos_cat1',   '$pos_scat1',  '$pos_cat2',   '$pos_scat2',	  '$pos_cat3', '$pos_scat3', 	 '$pos_cat4', '$pos_scat4',		'$pos_cat5', '$pos_scat5',	  0, 			'2',		 '$pos_contact_email', '$pos_notes')";
						
			if ($conn->query($sql2) === TRUE) {
				  echo "2 Record inserted successfully";
			} else {
				  echo "Error2: " . $sql2 . "<br>" . $conn->error;
			}				
			
			$sql3 = "insert into principal_position_link select $princ_id, id from positions where pos_title = '$position_title' and  company_id=$company_nm and pos_desc = '$pos_desc_eng' ";
						
			if ($conn->query($sql3) === TRUE) {
				  echo "3 Record inserted successfully";
			} else {
				 echo "Error3: " . $sql3 . "<br>" . $conn->error;
			}		
			
		} 							 
	
		echo "Ok";
		
		$conn->close();	
	
	}	
	
?>