<?php session_start();

	//
	// apply user details
	//
	
	include_once('inc/db_connect.php');
	include_once('admin_email.php');
		
	if (!$_SESSION['logged_in_email'])  
		exit;
		
	if  ( 
		($_POST['elm_name']!='Password') && 
		($_POST['elm_name']!='Firstname') && 
		($_POST['elm_name']!='Lastname') && 
		($_POST['elm_name']!='Profile_Status') &&
		($_POST['elm_name']!='City') &&
		($_POST['elm_name']!='Mobile') &&
		($_POST['elm_name']!='Positions') &&
		($_POST['elm_name']!='LinkedInURL') &&
		($_POST['elm_name']!='About') &&
		($_POST['elm_name']!='Is_Citizen')		
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
	
	$sql0 = "SELECT * FROM users where upper(trim(email)) = upper(trim('".$_SESSION['logged_in_email']."'))";
	
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
		$subject = "User Details Change Jobs972.com";		

		if ($_POST['elm_name'] == 'LinkedInURL')
		{			
			$ud_data_to_change = $conn0->real_escape_string(mb_substr($_POST['ud_data_to_change'], 0, 1000));
		}
		else
		{
			$ud_data_to_change = $conn0->real_escape_string(mb_substr($_POST['ud_data_to_change'], 0, 100));
		}
		
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
							 'User Details Change on the Jobs972.com!' . '<br/><br/> ' ."\n" .
							 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'User Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
							 'Attribute Change: <b>' . $_POST['elm_name'] . '</b><br/>' ."\n" .
							 'Attribute New Value: <b>' . $asterisked_pwd . '</b><br/>' ."\n" .					
							 'IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
							 'Regards, ' . ' <br/> ' ."\n" .
							 'Administrator.</body></html>';	

				$message2 = '<html><body> ' ."\n" .
							 'Your Profile Was Changed on the Jobs972.com!' . '<br/>' ."\n" .
							 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'Your Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
							 'Attribute Changed: <b>' . $_POST['elm_name'] . '</b><br/>' ."\n" .
							 'Attribute New Value: <b>' . $asterisked_pwd . '</b><br/>' ."\n" .					
							 'Your IP Address: <b>' . $ip_addr . '</b><br/></body></html>';	

			}
			else
			{
			
				$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
							 'User Details Change on the Jobs972.com!' . '<br/><br/> ' ."\n" .
							 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'User Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
							 'Attribute Change: <b>' . $_POST['elm_name'] . '</b><br/>' ."\n" .
							 'Attribute New Value: <b>' . $_POST['ud_data_to_change'] . '</b><br/>' ."\n" .					
							 'IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
							 'Regards, ' . ' <br/> ' ."\n" .
							 'Administrator.</body></html>';	

				$message2 = '<html><body> ' ."\n" .
							 'User Details Change on the Jobs972.com!' . '<br/>' ."\n" .
							 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
							 'User Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
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
				
				$logged_in_email = $_SESSION['logged_in_email'];
				
				$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
				VALUES ('$db_cur_dt', 4, 0, '$ip_addr', '$logged_in_email', '$message', '$message2', '')";

				if ($conn->query($sql) === TRUE) {
					//  echo "1 New record created successfully";
				} else {
					// echo "Error1: " . $sql . "<br>" . $conn->error;
				}

				$sql2 = "";
				
				if ($_POST['elm_name'] == 'Password')
				{
					$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', pwd = trim(\''.$_POST['ud_data_to_change'].'\') where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
				}
				
				if ($_POST['elm_name'] == 'Firstname')
				{
					$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', firstname = trim(\''.$_POST['ud_data_to_change'].'\') where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
				}

				if ($_POST['elm_name'] == 'Lastname')
				{
					$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', lastname = trim(\''.$_POST['ud_data_to_change'].'\') where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
				}

				if ($_POST['elm_name'] == 'City')
				{
					$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', city = trim(\''.$_POST['ud_data_to_change'].'\') where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
				}	

				if ($_POST['elm_name'] == 'Mobile')
				{
					$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', mobile = trim(\''.$_POST['ud_data_to_change'].'\') where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
				}

				if ($_POST['elm_name'] == 'Positions')
				{
					$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', positions = trim(\''.$_POST['ud_data_to_change'].'\') where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
				}

				if ($_POST['elm_name'] == 'LinkedInURL')
				{
					$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', linkedin = trim(\''.$_POST['ud_data_to_change'].'\') where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
				}				
				
				if ($_POST['elm_name'] == 'Is_Citizen')
				{
					$sql2= 'update users set modify_dt= \''.$db_cur_dt.'\', iscitizen = '.$_POST['ud_data_to_change'].' where upper(email) = upper(trim(\''.$logged_in_email.'\'))';					
				}				
				
				if ($_POST['elm_name'] == 'Profile_Status')
				{
					$sql2= 'update users set modify_dt= \''.$db_cur_dt.'\', status = '.$_POST['ud_data_to_change'].' where upper(email) = upper(trim(\''.$logged_in_email.'\'))';					
				}	

				if ($_POST['elm_name'] == 'About')
				{					
				
					$strToPlace = $_POST['ud_data_to_change'];
					
					$strToPlace=str_replace('"', "", $strToPlace);
					$strToPlace = str_replace("'", "", $strToPlace);
					$strToPlace = stripslashes($strToPlace);					
					
					$sql2= 'update users set modify_dt= \''.$db_cur_dt.'\', about = \''.$strToPlace.'\' where upper(email) = upper(trim(\''.$logged_in_email.'\'))';					
				}				
				
				if ($conn->query($sql2) === TRUE) {
					//  echo "Record updated successfully";
				} else {
					// echo "Error: " . $sql2 . "<br>" . $conn->error;
				}				
				
				$conn->close();				
		 	} 		
		
		
	} // if isset 
	
	//
	//
	//
	
?>	