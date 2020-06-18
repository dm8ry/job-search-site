<?php session_start();

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");
	
	if (
			isset($_POST['comp_id']) &&			
			isset($_SESSION['princ_login']) &&
			isset($_SESSION['princ_id']) &&
			isset($_SESSION['princ_first_name']) &&
			isset($_SESSION['princ_email']) 
		)
	{
			
		$comp_id = $_POST['comp_id'];		
				
		$princ_id = $_SESSION['princ_id'];
		$princ_first_name = $_SESSION['princ_first_name'];
		$princ_email = $_SESSION['princ_email'];			
			
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$conn->query("set names 'utf8'");	
						
		$sql_the_company_name = "select the_name from company where id = $comp_id ";
									
		$arr_the_company_name = array();		
		$results_the_company_name = mysqli_query($conn, $sql_the_company_name); 	
		
		while($line = mysqli_fetch_assoc($results_the_company_name)){
			$arr_the_company_name[] = $line;
		}		
				
		$the_company_name = $arr_the_company_name[0]['the_name'];
				
		//Email information
		$admin_email = $admin_email_address;
		$subject = "The Company $the_company_name Was Approved on the Jobs972.com";		
		
		$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
		$cur_dt =  $date->format('d-m-Y H:i:s');  
		$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()	
		
		$ip_addr=$_SERVER['REMOTE_ADDR'];
		
		$headers = "From: " . strip_tags($admin_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'The Company Was Approved On the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Approval Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Principal Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Principal Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $the_company_name . '</b><br/>' ."\n" .					
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'You Have Approved The Company on the Jobs972.com!' . '<br/>' ."\n" .
					 'Approval Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Your Email: <b>' . $princ_email . '</b><br/>' ."\n" .
					 'Your Firstname: <b>' . $princ_first_name . '</b><br/>' ."\n" .
					 'Company Name: <b>' . $the_company_name . '</b><br/>' ."\n" .					 
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
			VALUES ('$db_cur_dt', 23, $princ_id, '$ip_addr', '$princ_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				   echo "1 New record created successfully";
			} else {
				  echo "Error1: " . $sql . "<br>" . $conn->error;
			}
			
			$sql2 = "update company
					  set modifydt = '$db_cur_dt',						 
						 status = '1'
						where id = $comp_id ";
			    
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