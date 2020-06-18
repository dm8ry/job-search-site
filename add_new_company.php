<?php session_start();

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");

	if (
			isset($_POST['company_name']) &&
			isset($_POST['company_city']) &&
			isset($_POST['company_desc_eng']) &&
			isset($_POST['company_desc_heb']) &&
			isset($_POST['company_addr_eng']) &&
			isset($_POST['company_addr_heb']) &&
			isset($_POST['company_phone']) &&
			isset($_POST['company_fax']) &&
			isset($_POST['company_email']) &&
			isset($_POST['company_website']) &&
			isset($_POST['company_n_of_people']) &&
			isset($_POST['company_founded']) &&
			isset($_POST['company_industry']) &&
			isset($_POST['company_type']) &&
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
		$subject = "A New Company Was Defined on the Jobs972.com";	

		$company_name = $conn->real_escape_string($_POST['company_name']);
		$company_city = $conn->real_escape_string($_POST['company_city']);
		$company_desc_eng = $conn->real_escape_string($_POST['company_desc_eng']);
		$company_desc_heb = $conn->real_escape_string($_POST['company_desc_heb']);
		$company_addr_eng = $conn->real_escape_string($_POST['company_addr_eng']);
		$company_addr_heb = $conn->real_escape_string($_POST['company_addr_heb']);
		$company_phone = $conn->real_escape_string($_POST['company_phone']);
		$company_fax = $conn->real_escape_string($_POST['company_fax']);
		$company_email = $conn->real_escape_string($_POST['company_email']);
		$company_website = $conn->real_escape_string($_POST['company_website']);
		$company_n_of_people = $conn->real_escape_string($_POST['company_n_of_people']);		
		
		if ($_POST['company_founded'] == '') 
		{
			$company_founded = "";
		}
		else
		{
			$company_founded = $_POST['company_founded'];
		}		
				
		if ($_POST['company_industry'] == -1) 
		{
			$company_industry = "";
		}
		else
		{
			$company_industry = $_POST['company_industry'];
		}		
		
		if ($_POST['company_type'] == -1) 
		{
			$company_type = "";
		}
		else
		{
			$company_type = $_POST['company_type'];
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
					 'A New Company Was Added On the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Add Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $company_name . '</b><br/>' ."\n" .					
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'You Have Defined A New Company on the Jobs972.com!' . '<br/>' ."\n" .
					 'It is waiting for Admin approval.' . '<br/>' ."\n" .
					 'Definition Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $company_name . '</b><br/>' ."\n" .					 
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
			VALUES ('$db_cur_dt', 19, $princ_id, '$ip_addr', '$princ_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				   echo "1 New record created successfully";
			} else {
				  echo "Error1: " . $sql . "<br>" . $conn->error;
			}

			$sql2 = "insert into company (createdt,   modifydt,     the_name,       placement_id,    photo_logo,     website,         num_people,          the_descrip,        the_descrip_heb,        address,             address_heb,           phone_1,          fax_1,           email_1,            status, nviews, num_positions, industry,            c_type,                  founded) 
			                    values ('$db_cur_dt', '$db_cur_dt', '$company_name', '$company_city',    '',       '$company_website', '$company_n_of_people' , '$company_desc_eng',  '$company_desc_heb',  '$company_addr_eng',  '$company_addr_heb',  '$company_phone', '$company_fax',   '$company_email',   '2',    0,      0,             '$company_industry',  '$company_type',      '$company_founded' )";
						
			if ($conn->query($sql2) === TRUE) {
				  echo "2 Record inserted successfully";
			} else {
				  echo "Error2: " . $sql2 . "<br>" . $conn->error;
			}				
			
			$sql3 = "insert into principal_company_link select $princ_id, id from company where the_name = '$company_name' ";
						
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