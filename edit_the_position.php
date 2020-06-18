<?php session_start();

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");
	
	if (
			isset($_POST['position_title_e']) &&
			isset($_POST['company_nm_e']) &&
			isset($_POST['pos_type_e']) &&
			isset($_POST['pos_desc_eng_e']) &&		
			isset($_SESSION['princ_login']) &&
			isset($_SESSION['princ_id']) &&
			isset($_SESSION['princ_first_name']) &&
			isset($_SESSION['princ_email']) 
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
		$subject = "A Position Was Updated on the Jobs972.com";	

		$pos_id_edit = $_POST['pos_id_edit'];
		$position_title_e = $conn->real_escape_string($_POST['position_title_e']);
		$position_title_heb_e = $conn->real_escape_string($_POST['position_title_heb_e']);
		$company_nm_e = $_POST['company_nm_e'];
		$pos_type_e = $_POST['pos_type_e'];
		$pos_desc_eng_e = $conn->real_escape_string($_POST['pos_desc_eng_e']);
		$pos_desc_heb_e = $conn->real_escape_string($_POST['pos_desc_heb_e']);
		$pos_cat1_e = $_POST['pos_cat1_e'];
		$pos_scat1_e = $_POST['pos_scat1_e'];
		$pos_cat2_e = $_POST['pos_cat2_e'];
		$pos_scat2_e = $_POST['pos_scat2_e'];		
		$pos_cat3_e = $_POST['pos_cat3_e'];
		$pos_scat3_e = $_POST['pos_scat3_e'];
		$pos_cat4_e = $_POST['pos_cat4_e'];
		$pos_scat4_e = $_POST['pos_scat4_e'];		
		$pos_cat5_e = $_POST['pos_cat5_e'];
		$pos_scat5_e = $_POST['pos_scat5_e'];
		
		$pos_auto_renewal = $_POST['pos_reoccurance_e'];
		
		if (($pos_auto_renewal == '1') || ($pos_auto_renewal == '2') || ($pos_auto_renewal == '3')
			|| ($pos_auto_renewal == '4') || ($pos_auto_renewal == '5') || ($pos_auto_renewal == '6') || ($pos_auto_renewal == '7'))
			{
				// nothing to do...
			}
			else
			{
				$pos_auto_renewal = '';
			}
			

		$pos_status = $_POST['pos_status_e'];
		
		if ($pos_status == '1') 
		{
			$pos_status = '2';
		}
		
			
		$pos_notes_e = $conn->real_escape_string($_POST['pos_notes_e']);
		$pos_contact_email_e = $conn->real_escape_string($_POST['pos_contact_email_e']);		
		
		$sql_get_companyname_by_id =  'select the_name from company where id = '.$company_nm_e;
		
		echo ' '.$sql_get_companyname_by_id.'  ';
		
		$arr_company_name = array();		
		$results_company_name = mysqli_query($conn, $sql_get_companyname_by_id); 	
		
		while($line = mysqli_fetch_assoc($results_company_name)){
			$arr_company_name[] = $line;
		}			
		
		$company_name_e = $arr_company_name[0]['the_name'];		
		
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
					 'A Position Was Updated On the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Update Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Position Title: <b>' . $position_title_e . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $company_name_e . '</b><br/>' ."\n" .
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'You Have Updated The Company on the Jobs972.com!' . '<br/>' ."\n" .
					 'It is waiting for Admin approval.' . '<br/>' ."\n" .
					 'Update Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Position Title: <b>' . $position_title_e . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $company_name_e . '</b><br/>' ."\n" .					 
					 'IP Address: <b>' . $ip_addr . '</b><br/></body></html>';
					 
		if (!mail($admin_email, "$subject", $message, $headers)) 
		{
		   // something wrong...
		   // echo "something wrong ";
		   
		} 
		else
		{  				
			// everything is good...
			// echo "everything is good ";			 
			 
			// log into businesslog
			
			$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
			VALUES ('$db_cur_dt', 22, $princ_id, '$ip_addr', '$princ_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				   echo "1 New record created successfully";
			} else {
				  echo "Error1: " . $sql . "<br>" . $conn->error;
			}
			
			if ($pos_cat4_e == '') $pos_cat4_e = 0;
			if ($pos_scat4_e == '') $pos_scat4_e = 0;
			if ($pos_cat5_e == '') $pos_cat5_e = 0;
			if ($pos_scat5_e == '') $pos_scat5_e = 0;
			
			$sql2 = "update positions
					  set modifydt = '$db_cur_dt',
						 pos_title = '$position_title_e',
						 pos_title_heb = '$position_title_heb_e',
						 company_id = $company_nm_e,
						 pos_desc = '$pos_desc_eng_e',
						 pos_desc_heb = '$pos_desc_heb_e',
						 job_type = '$pos_type_e',
						 pos_cat = $pos_cat1_e,
						 pos_sub_cat = $pos_scat1_e,
						 pos_cat_2 = $pos_cat2_e,
						 pos_sub_cat_2 = $pos_scat2_e,
						 pos_cat_3 = $pos_cat3_e,
						 pos_sub_cat_3 = $pos_scat3_e,
						 pos_cat_4 = $pos_cat4_e,
						 pos_sub_cat_4 = $pos_scat4_e,
						 pos_cat_5 = $pos_cat5_e,
						 pos_sub_cat_5 = $pos_scat5_e,
						 pos_contact_email = '$pos_contact_email_e',
						 pos_notes = '$pos_notes_e',
						 pos_status = '$pos_status',
						 pos_autoupd = $pos_auto_renewal
					  where id = $pos_id_edit";
			    
			if ($conn->query($sql2) === TRUE) {
				  echo "2 Record updated successfully";				  
			} else {
				  echo "Error2: " . $sql2 . "<br>" . $conn->error;
			}						
			
		} 							 
	
		echo "Ok";
		
		$conn->close();	
	
	}	
	
?>