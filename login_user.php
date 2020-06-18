<?php session_start();  

  // login_user.php
  // check user exists\
  
   include_once('inc/db_connect.php');
   include_once('admin_email.php');  
   
   $is_success =0;
  
	mb_internal_encoding("UTF-8");
	
	if (empty($_POST['lo_email']) || empty($_POST['lo_pwd'])) 
	{
		echo "ERROR";
	}	
	else
	{
	
		// Create connection
		$conn0 = new mysqli($servername, $username, $password, $dbname);
		
		// Check connection
		if ($conn0->connect_error) {
			die("Connection failed: " . $conn0->connect_error);
		} 

		$conn0->query("set names 'utf8'");	
	
		$sql0 = "SELECT * FROM users where status=1 and upper(email) = upper(trim('".$_POST['lo_email']."')) and pwd = '".$_POST['lo_pwd']."'";			
		
		$result0 = mysqli_query($conn0, $sql0); 
		
		$arr_user_details = array();
		
		while($line = mysqli_fetch_assoc($result0)){
			$arr_user_details[] = $line;
		}		
	
		if ($result0->num_rows == 1) 
		{   				
			$is_success =1;
		}		
		else
		{
			$is_success =0;
		}
		
		if (empty($_POST['lo_email']) || empty($_POST['lo_pwd']) || (sizeof($arr_user_details)==0) ) 
		{
			echo "Wrong";
		}
		else if ($arr_user_details[0]['is_verified'] == 0)
		{
			echo "Not Verified";
		}
		else
		{
		
			$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
			$cur_dt =  $date->format('d-m-Y H:i:s');  
			$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()
			
			$ip_addr=$_SERVER['REMOTE_ADDR'];
			
			$lo_email = $_POST['lo_email'];
			
			$message = '<html><body>Hello, Jobs972.com!' . '<br/><br/> ' ."\n" .
				 'User Logged In the Jobs972.com!' . '<br/><br/> ' ."\n" .
				 'Login Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .			
				 'Email: <b>' . $lo_email . '</b><br/>' ."\n" .					
				 'Login IP Address: <b>' . $ip_addr . '</b><br/><br/>' ."\n" .
				 'Regards, ' . ' <br/> ' ."\n" .
				 'Administrator.</body></html>';
				 
			$message2 = '<html><body> ' ."\n" .
				 'You Logged In the Jobs972.com!' . '<br/>' ."\n" .
				 'Login Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .			
				 'Your Email: <b>' . $lo_email . '</b><br/> ' ."\n" .	
				 'Login IP Address: <b>' . $ip_addr . '</b><br/></body></html>';

			$sql1 = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
				VALUES ('$db_cur_dt', 3, 0, '$ip_addr', '$lo_email', '$message', '$message2', '')";	
		
			if ($conn0->query($sql1) === TRUE) {
				//  echo "New record created successfully";
			} else {
				// echo "Error: " . $sql1 . "<br>" . $conn0->error;
			}	
			
			$sql2 = "update users set last_login = '$db_cur_dt' where id = ".$arr_user_details[0]['id'];	
		
			if ($conn0->query($sql2) === TRUE) {
				//  echo "Update done successfully";
			} else {
				// echo "Error: " . $sql2 . "<br>" . $conn0->error;
			}		
		
			$_SESSION['auth_login'] = 1;
			$_SESSION['logged_in_user_firstname'] = $arr_user_details[0]['firstname'];
			$_SESSION['logged_in_user_lastname'] = $arr_user_details[0]['lastname'];
			$_SESSION['logged_in_email'] = $arr_user_details[0]['email'];
			$_SESSION['logged_in_userid'] = $arr_user_details[0]['id'];
			
			echo "OK";			
		
		}	
		
		$conn0->close();
				
	}   
  
?>