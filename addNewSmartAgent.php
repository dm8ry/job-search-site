<?php session_start();

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");
	
	if (isset($_SESSION['logged_in_userid']))
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
		$subject = "A New Smart Agent Was Defined on the Jobs972.com";	

		$p1_recent_days = $_POST['sma_days_select'];
		$p2_region_city = $_POST['sma_region_n_city_select'];		
		$p3_category = $_POST['sma_categories_select'];
		$p4_sub_category = $_POST['sma_sub_categories_select'];
		$p5_contains_txt = $_POST['sma_contains_txt'];
		
		$sql_categories = "select id, cat_name from category where id = ".$p3_category;
									
		$arr_categories = array();		
		$results_categories = mysqli_query($conn, $sql_categories); 	
		
		while($line = mysqli_fetch_assoc($results_categories)){
			$arr_categories[] = $line;
		}			
		
		$sql_sub_categories = "select id, subcat_name from sub_category where id = ".$p4_sub_category;
									
		$arr_sub_categories = array();		
		$results_sub_categories = mysqli_query($conn, $sql_sub_categories); 	
		
		while($line = mysqli_fetch_assoc($results_sub_categories)){
			$arr_sub_categories[] = $line;
		}			
		
		$msg_region_city = ''; 
		
		if ($p2_region_city!=-1)
			$msg_region_city ='Find Positions from: <b>' . $p2_region_city . '</b> region/city.<br/>' ."\n";
		else
			$msg_region_city ='Find Positions from: <b>All</b> region/city.<br/>' ."\n";
			
		$msg_contains_txt = '';
		
		if ($p3_category==-1)
		{
			$msg_category = 'Find Positions from <b>All</b> the categories.<br/>' ."\n";
		}
		else
		{
			$msg_category = 'Find Positions from the <b>' . $arr_categories[0]['cat_name'] . '</b> category.<br/>' ."\n";
		}		
		
		if ($p4_sub_category==-1)
		{
			$msg_sub_category = 'Find Positions from <b>All</b> the sub-categories.<br/>' ."\n";
		}
		else
		{
			$msg_sub_category = 'Find Positions from the <b>' . $arr_sub_categories[0]['subcat_name'] . '</b> sub-category.<br/>' ."\n";
		}		
		
		if ($p5_contains_txt=='')
		{
			$msg_contains_txt = '';
		}
		else
		{
			$msg_contains_txt = 'Find Positions containing the <b>' . $p5_contains_txt . '</b> text.<br/>' ."\n";
		}
	
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

		$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'A New Agent Was Defined On the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Definition Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'User Email: <b>' . $email . '</b><br/>' ."\n" .
					 'User FirstName: <b>' . $fn . '</b><br/>' ."\n" .
					 'User LastName: <b>' . $ln . '</b><br/>' ."\n" .					 
					 'Find Positions for: <b>' . $p1_recent_days . '</b> recent days.<br/>' ."\n" .
					 $msg_region_city.
					 $msg_category.
					 $msg_sub_category.
					 $msg_contains_txt.
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'You Have Defined A New Smart Agent on the Jobs972.com!' . '<br/>' ."\n" .
					 'Definition Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Your Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
					 'Find Positions for: <b>' . $p1_recent_days . '</b> recent days.<br/>' ."\n" .
					 $msg_region_city.
					 $msg_category.
					 $msg_sub_category.
					 $msg_contains_txt.					 
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
			
			$logged_user_id = $_SESSION['logged_in_userid'];
			
			$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
			VALUES ('$db_cur_dt', 13, 0, '$ip_addr', '$logged_in_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				//  echo "1 New record created successfully";
			} else {
				// echo "Error1: " . $sql . "<br>" . $conn->error;
			}

			$sql2 = "insert into smart_agent (create_dt,   modify_dt,    user_id,      last_run, status, p1_recent_days, p2_region_city, p3_category, p4_sub_category, p5_contains_txt) 
			                          values ('$db_cur_dt', '$db_cur_dt', $logged_user_id, '', '1', '$p1_recent_days', '$p2_region_city', $p3_category, $p4_sub_category,  '$p5_contains_txt')";
						
			if ($conn->query($sql2) === TRUE) {
				//  echo "Record updated successfully";
			} else {
				//  echo "Error: " . $sql2 . "<br>" . $conn->error;
			}				
			
						
		} 							 
	
		echo "Ok";
		
		$conn->close();	
	
	}	

	
?>