<?php session_start();

	//
	// apply user details
	//
	
	include_once('inc/db_connect.php');
	include_once('admin_email.php');
		
	if (!$_SESSION['princ_email'])  
		exit;
		
	if  ( 
		($_POST['elm_name']!='Password') &&
		($_POST['elm_name']!='Firstname') &&
		($_POST['elm_name']!='Lastname') &&
		($_POST['elm_name']!='About') &&
		($_POST['elm_name']!='Company') &&
		($_POST['elm_name']!='Website') &&
		($_POST['elm_name']!='Mobile') &&
		($_POST['elm_name']!='City') 
		)     
		exit;		
	
	mb_internal_encoding("UTF-8");
	
	// Create connection
	$conn0 = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn0->connect_error) {
		die("Connection failed: " . $conn0->connect_error);
	} 	
	
	$conn0->query("set names 'utf8'");	
	
	$sql0 = "SELECT * FROM principals where upper(trim(princ_email)) = upper(trim('".$_SESSION['princ_email']."'))";
	
	$result0 = $conn0->query($sql0);

	if ($result0->num_rows != 1) 
	{   
		exit;	    
	} 
	else 
	{
		// Ok
	}
	
	$conn0->close();	
	
	function isValidEmail($email){ 
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
	
	if (isset($_POST['ud_data_to_change']) && isset($_POST['elm_name']))		
	{
	
		$admin_email = $admin_email_address;
		$subject = "Principal Details Change Jobs972.com";		

		$ud_data_to_change = mb_substr($_POST['ud_data_to_change'], 0, 100);	 
		
		$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
		$cur_dt =  $date->format('d-m-Y H:i:s');  
		$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()
		
		$ip_addr=$_SERVER['REMOTE_ADDR'];
		
		$headers = "From: " . strip_tags($admin_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		mb_internal_encoding("UTF-8");
		
			if ($_POST['elm_name']=='Password')
			{
			
				$asterisked_pwd = preg_replace("|.|","*",$_POST['ud_data_to_change']);
			
				$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
							 'Principal Details Change on the Jobs972.com!' . '<br/><br/> ' ."\n" .
							 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'Principal Email: <b>' . $_SESSION['princ_email'] . '</b><br/>' ."\n" .
							 'Attribute Change: <b>' . $_POST['elm_name'] . '</b><br/>' ."\n" .
							 'Attribute New Value: <b>' . $asterisked_pwd . '</b><br/>' ."\n" .					
							 'IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
							 'Regards, ' . ' <br/> ' ."\n" .
							 'Administrator.</body></html>';	

				$message2 = '<html><body> ' ."\n" .
							 'Principal Details Change on the Jobs972.com!' . '<br/>' ."\n" .
							 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'Principal Email: <b>' . $_SESSION['princ_email'] . '</b><br/>' ."\n" .
							 'Attribute Change: <b>' . $_POST['elm_name'] . '</b><br/>' ."\n" .
							 'Attribute New Value: <b>' . $asterisked_pwd . '</b><br/>' ."\n" .	
							 'IP Address: <b>' . $ip_addr . '</b><br/></body></html>';			 
			
			
			}
			else
			{
			
				$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
							 'Principal Details Change on the Jobs972.com!' . '<br/><br/> ' ."\n" .
							 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'Principal Email: <b>' . $_SESSION['princ_email'] . '</b><br/>' ."\n" .
							 'Attribute Change: <b>' . $_POST['elm_name'] . '</b><br/>' ."\n" .
							 'Attribute New Value: <b>' . $_POST['ud_data_to_change'] . '</b><br/>' ."\n" .					
							 'IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
							 'Regards, ' . ' <br/> ' ."\n" .
							 'Administrator.</body></html>';	

				$message2 = '<html><body> ' ."\n" .
							 'Principal Details Change on the Jobs972.com!' . '<br/>' ."\n" .
							 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'Principal Email: <b>' . $_SESSION['princ_email'] . '</b><br/>' ."\n" .
							 'Attribute Change: <b>' . $_POST['elm_name'] . '</b><br/>' ."\n" .
							 'Attribute New Value: <b>' . $_POST['ud_data_to_change'] . '</b><br/>' ."\n" .					
							 'IP Address: <b>' . $ip_addr . '</b><br/></body></html>';			 
			
			}
		
		 	if (!mail($admin_email, "$subject", $message, $headers)) 
			{
			   // something wrong...
			   // echo "something wrong ";
			   
			} else
			{  				
				// everything is good...
				// echo "everything is good ";
				
				// log into businesslog
				
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 

				$conn->query("set names 'utf8'");
				
				$princ_email = $_SESSION['princ_email'];
				$princ_id = $_SESSION['princ_id'];
				
				$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
				VALUES ('$db_cur_dt', 11, $princ_id, '$ip_addr', '$princ_email', '$message', '$message2', '')";

				if ($conn->query($sql) === TRUE) {
					//  echo "1 New record created successfully";
				} else {
					// echo "Error1: " . $sql . "<br>" . $conn->error;
				}

				$sql2 = "";
				
				if ($_POST['elm_name'] == 'Password')
				{
					$sql2= 'update principals set modifydt=  \''.$db_cur_dt.'\', princ_pwd = trim(\''.$_POST['ud_data_to_change'].'\') where upper(princ_email) = upper(trim(\''.$princ_email.'\'))';
				}
				
				if ($_POST['elm_name'] == 'Firstname')
				{
					$sql2= 'update principals set modifydt=  \''.$db_cur_dt.'\', princ_firstname = trim(\''.$_POST['ud_data_to_change'].'\') where upper(princ_email) = upper(trim(\''.$princ_email.'\'))';
				}				
				
				if ($_POST['elm_name'] == 'Lastname')
				{
					$sql2= 'update principals set modifydt=  \''.$db_cur_dt.'\', princ_lastname = trim(\''.$_POST['ud_data_to_change'].'\') where upper(princ_email) = upper(trim(\''.$princ_email.'\'))';
				}
				
				if ($_POST['elm_name'] == 'About')
				{
					$sql2= 'update principals set modifydt=  \''.$db_cur_dt.'\', princ_about = trim(\''.$_POST['ud_data_to_change'].'\') where upper(princ_email) = upper(trim(\''.$princ_email.'\'))';
				}				
				
				if ($_POST['elm_name'] == 'Company')
				{
					$sql2= 'update principals set modifydt=  \''.$db_cur_dt.'\', company = trim(\''.$_POST['ud_data_to_change'].'\') where upper(princ_email) = upper(trim(\''.$princ_email.'\'))';
				}
				
				if ($_POST['elm_name'] == 'Website')
				{
					$sql2= 'update principals set modifydt=  \''.$db_cur_dt.'\', website = trim(\''.$_POST['ud_data_to_change'].'\') where upper(princ_email) = upper(trim(\''.$princ_email.'\'))';
				}				

				if ($_POST['elm_name'] == 'City')
				{
					$sql2= 'update principals set modifydt=  \''.$db_cur_dt.'\', city = trim(\''.$_POST['ud_data_to_change'].'\') where upper(princ_email) = upper(trim(\''.$princ_email.'\'))';
				}					
				
				if ($_POST['elm_name'] == 'Mobile')
				{
					$sql2= 'update principals set modifydt=  \''.$db_cur_dt.'\', mobile = trim(\''.$_POST['ud_data_to_change'].'\') where upper(princ_email) = upper(trim(\''.$princ_email.'\'))';
				}				
				
				if ($conn->query($sql2) === TRUE) {
					// echo "Record updated successfully";
				} else {
					// echo "Error: " . $sql . "<br>" . $conn->error;
				}				
				
				$conn->close();				
		 	} 		
		
		
	} // if isset 
	
	//
	//
	//
	
?>	