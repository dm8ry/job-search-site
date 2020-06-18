<?php session_start();

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");
	
	if (
			isset($_POST['company_id_edit']) &&
			isset($_POST['company_name_edit']) &&
			isset($_POST['company_city_edit']) &&
			isset($_POST['company_desc_eng_edit']) &&
			isset($_POST['company_desc_heb_edit']) &&
			isset($_POST['company_addr_eng_edit']) &&
			isset($_POST['company_addr_heb_edit']) &&
			isset($_POST['company_phone_edit']) &&
			isset($_POST['company_fax_edit']) &&
			isset($_POST['company_email_edit']) &&
			isset($_POST['company_website_edit']) &&
			isset($_POST['company_n_of_people_edit']) &&
			isset($_POST['company_founded_edit']) &&
			isset($_POST['company_industry_edit']) &&
			isset($_POST['company_type_edit']) &&
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
		$subject = "A Company Was Updated on the Jobs972.com";	

		$company_id_edit = $conn->real_escape_string($_POST['company_id_edit']);
		$company_name = $conn->real_escape_string($_POST['company_name_edit']);
		$company_city = $conn->real_escape_string($_POST['company_city_edit']);
		$company_desc_eng = $conn->real_escape_string($_POST['company_desc_eng_edit']);
		$company_desc_heb = $conn->real_escape_string($_POST['company_desc_heb_edit']);
		$company_addr_eng = $conn->real_escape_string($_POST['company_addr_eng_edit']);
		$company_addr_heb = $conn->real_escape_string($_POST['company_addr_heb_edit']);
		$company_phone = $conn->real_escape_string($_POST['company_phone_edit']);
		$company_fax = $conn->real_escape_string($_POST['company_fax_edit']);
		$company_email = $conn->real_escape_string($_POST['company_email_edit']);
		$company_website = $conn->real_escape_string($_POST['company_website_edit']);
		$company_n_of_people = $conn->real_escape_string($_POST['company_n_of_people_edit']);		
		
		if ($_POST['company_founded_edit'] == '') 
		{
			$company_founded = "";
		}
		else
		{
			$company_founded = $_POST['company_founded_edit'];
		}		
				
		if ($_POST['company_industry_edit'] == -1) 
		{
			$company_industry = "";
		}
		else
		{
			$company_industry = $_POST['company_industry_edit'];
		}		
		
		if ($_POST['company_type_edit'] == -1) 
		{
			$company_type = "";
		}
		else
		{
			$company_type = $_POST['company_type_edit'];
		}
		
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
					 'A Company Was Updated On the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Update Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $company_name . '</b><br/>' ."\n" .					
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'You Have Updated The Company on the Jobs972.com!' . '<br/>' ."\n" .
					 'It is waiting for Admin approval.' . '<br/>' ."\n" .
					 'Update Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $company_name . '</b><br/>' ."\n" .					 
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
			VALUES ('$db_cur_dt', 20, $princ_id, '$ip_addr', '$princ_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				   echo "1 New record created successfully";
			} else {
				  echo "Error1: " . $sql . "<br>" . $conn->error;
			}
			
			$sql2 = "update company
					  set modifydt = '$db_cur_dt',
						 the_name = '$company_name',
						 placement_id = '$company_city',
						 photo_logo = '',
						 website = '$company_website',
						 num_people = $company_n_of_people,
						 the_descrip = '$company_desc_eng',
						 the_descrip_heb = '$company_desc_heb',
						 address = '$company_addr_eng',
						 address_heb = '$company_addr_heb',
						 phone_1 = '$company_phone',
						 fax_1 = '$company_fax',
						 email_1 = '$company_email',
						 status = '2',
						 industry = '$company_industry',
						 c_type = '$company_type',
						 founded = '$company_founded'
					  where id = $company_id_edit";
			    
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