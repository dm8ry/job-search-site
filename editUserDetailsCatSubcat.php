<?php session_start();

	//
	// apply user details
	//
	
	include_once('inc/db_connect.php');
	include_once('admin_email.php');
		
	if (!$_SESSION['logged_in_email'])  
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
	
	if ( isset($_POST['cud_categories_select']) 
		&& isset($_POST['cud_sub_categories_select'])  
		&& isset($_POST['mod_changeUserDetailsCatSubcat_n']) )
	{
	
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$conn->query("set names 'utf8'");


		if (isset($_POST['cud_unset']) && $_POST['cud_unset'] == 'Yes') 
		{
			// unset

			$admin_email = $admin_email_address;
			$subject = "User Details Change Jobs972.com";				
			
			$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
			$cur_dt =  $date->format('d-m-Y H:i:s');  
			$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()
			
			$ip_addr=$_SERVER['REMOTE_ADDR'];
			
			$headers = "From: " . strip_tags($admin_email) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			mb_internal_encoding("UTF-8");
			 
			$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'User Details Change on the Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'User Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
						 'Attribute Change: <b>Category | Sub-Category #'.$_POST['mod_changeUserDetailsCatSubcat_n'].'</b><br/>' ."\n" .
						 'Attribute New Value: <b>Unset</b><br/>' ."\n" .
						 'IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
						 'Regards, ' . ' <br/> ' ."\n" .
						 'Administrator.</body></html>';	

			$message2 = '<html><body> ' ."\n" .
						 'User Details Change on the Jobs972.com!' . '<br/>' ."\n" .
						 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'User Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
						 'Attribute Change: <b>Category | Sub-Category #'.$_POST['mod_changeUserDetailsCatSubcat_n'].'</b><br/>' ."\n" .
						 'Attribute New Value: <b>Unset</b><br/>' ."\n" .	
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
										
					$logged_in_email = $_SESSION['logged_in_email'];
					
					$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
					VALUES ('$db_cur_dt', 4, 0, '$ip_addr', '$logged_in_email', '$message', '$message2', '')";

					if ($conn->query($sql) === TRUE) {
						//  echo "1 New record created successfully";
					} else {
						// echo "Error1: " . $sql . "<br>" . $conn->error;
					}

					$sql2 = "";
					
					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '1')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_1 = NULL, scat_1 = NULL where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}				
					
					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '2')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_2 = NULL, scat_2 = NULL where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}					
					
					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '3')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_3 = NULL, scat_3 = NULL where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}

					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '4')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_4 = NULL, scat_4 = NULL where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}	

					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '5')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_5 = NULL, scat_5 = NULL where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}				
					
					if ($conn->query($sql2) === TRUE) {
						//  echo "Record updated successfully";
					} else {
						// echo "Error: " . $sql2 . "<br>" . $conn->error;
					}				
					
				} 					
			
			
		}
		else
		{
			// usual flow
		 
			if ($_POST['cud_categories_select'] == -1)
			{
				$cat_name = 'All';
			}
			else
			{
				$sql_category = "select cat_name from category where id = ".$_POST['cud_categories_select'];
				
				$arr_category = array();
				$results_category = mysqli_query($conn, $sql_category); 

				while($line = mysqli_fetch_assoc($results_category)){
					$arr_category[] = $line;
				}
				$cat_name = $arr_category[0]['cat_name'];
			}	

			
			if ($_POST['cud_sub_categories_select'] == -1)
			{
				$scat_name = 'All';
			}
			else
			{
				$sql_scategory = "select subcat_name from sub_category where id = ".$_POST['cud_sub_categories_select'];
				
				$arr_scategory = array();
				$results_scategory = mysqli_query($conn, $sql_scategory); 

				while($line = mysqli_fetch_assoc($results_scategory)){
					$arr_scategory[] = $line;
				}
				$scat_name = $arr_scategory[0]['subcat_name'];	
			}		
			

			$admin_email = $admin_email_address;
			$subject = "User Details Change Jobs972.com";				
			
			$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
			$cur_dt =  $date->format('d-m-Y H:i:s');  
			$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()
			
			$ip_addr=$_SERVER['REMOTE_ADDR'];
			
			$headers = "From: " . strip_tags($admin_email) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";		
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			mb_internal_encoding("UTF-8");
			 
			$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'User Details Change on the Jobs972.com!' . '<br/><br/> ' ."\n" .
						 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'User Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
						 'Attribute Change: <b>Category | Sub-Category #'.$_POST['mod_changeUserDetailsCatSubcat_n'].'</b><br/>' ."\n" .
						 'Attribute New Value: <b>' . $cat_name . ' | '. $scat_name .'</b><br/>' ."\n" .
						 'IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
						 'Regards, ' . ' <br/> ' ."\n" .
						 'Administrator.</body></html>';	

			$message2 = '<html><body> ' ."\n" .
						 'User Details Change on the Jobs972.com!' . '<br/>' ."\n" .
						 'Modify Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
						 'User Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
						 'Attribute Change: <b>Category | Sub-Category #'.$_POST['mod_changeUserDetailsCatSubcat_n'].'</b><br/>' ."\n" .
						 'Attribute New Value: <b>' . $cat_name . ' | '. $scat_name .'</b><br/>' ."\n" .		
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
										
					$logged_in_email = $_SESSION['logged_in_email'];
					
					$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
					VALUES ('$db_cur_dt', 4, 0, '$ip_addr', '$logged_in_email', '$message', '$message2', '')";

					if ($conn->query($sql) === TRUE) {
						//  echo "1 New record created successfully";
					} else {
						// echo "Error1: " . $sql . "<br>" . $conn->error;
					}

					$sql2 = "";
					
					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '1')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_1 = '.$_POST['cud_categories_select'].', scat_1 = '.$_POST['cud_sub_categories_select'].' where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}				
					
					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '2')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_2 = '.$_POST['cud_categories_select'].', scat_2 = '.$_POST['cud_sub_categories_select'].' where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}					
					
					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '3')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_3 = '.$_POST['cud_categories_select'].', scat_3 = '.$_POST['cud_sub_categories_select'].' where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}

					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '4')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_4 = '.$_POST['cud_categories_select'].', scat_4 = '.$_POST['cud_sub_categories_select'].' where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}	

					if ($_POST['mod_changeUserDetailsCatSubcat_n'] == '5')
					{
						$sql2= 'update users set modify_dt=  \''.$db_cur_dt.'\', cat_5 = '.$_POST['cud_categories_select'].', scat_5 = '.$_POST['cud_sub_categories_select'].' where upper(email) = upper(trim(\''.$logged_in_email.'\'))';
					}				
					
					if ($conn->query($sql2) === TRUE) {
						//  echo "Record updated successfully";
					} else {
						// echo "Error: " . $sql2 . "<br>" . $conn->error;
					}				
					
				} 		
		
		} // cud_unset
				
		$conn->close();	
		
	} // if isset 
	
	//
	//
	//
	
?>	