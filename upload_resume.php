<?php session_start();

	include_once('inc/db_connect.php');
	include_once('admin_email.php');

	mb_internal_encoding("UTF-8");
	
	////////////////////////////////
	//  upload resume
	//
	
	if ($_FILES["my-file-selector"]["name"])
	{	

		$now = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''));
		$sfx_date = $now->setTimeZone(new DateTimeZone('Asia/Jerusalem'));
		$sfx_cur_dt = $sfx_date->format("Ymd_His_u");			
			
		$target_suffix = "";
		$target_dir = "app_data/resumes/";
		$target_file = $target_dir . $sfx_cur_dt. "_". basename($_FILES["my-file-selector"]["name"]);
		$uploadOk = 1;
		$resumeFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			
		// Check if file already exists
		if (file_exists($target_file)) 
		{
			echo "Such File Already Exists!";
			$uploadOk = 0;
			exit;			
		}	
		
		// Check file size
		if ($_FILES["my-file-selector"]["size"] > 1024*300) 
		{
			echo "Max Filesize 300KB!";
			$uploadOk = 0;
			exit;				
		}	
		
		// Allow certain file formats
		if(($resumeFileType != "doc") && ($resumeFileType != "docx") && ($resumeFileType != "pdf" )) 
		{
			echo "Wrong File Format!";
			$uploadOk = 0;
			exit;					
		}	
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) 
		{
			echo "Error!";
			$uploadOk = 0;
			exit;
		// if everything is ok, try to upload file
		} 
		else 
		{
			if (move_uploaded_file($_FILES["my-file-selector"]["tmp_name"], $target_file)) 
			{
				// echo "Ok"; //echo "The file ". $target_file. " has been uploaded.";
			} else {
				echo "Error!";
				$uploadOk = 0;
				exit;
			}
		}	
	
	}	
	
	if (isset($_POST['resume_description']) && ($uploadOk == 1))
	{

		//Email information
		$admin_email = $admin_email_address;
		$subject = "Resume was uploaded from Jobs972.com";	

		$resume_description = htmlspecialchars (mb_substr($_POST['resume_description'], 0, 30));
	
		$resume_description=str_replace('"', "", $resume_description);
		$resume_description = str_replace("'", "", $resume_description);
		$resume_description = stripslashes($resume_description);	
	
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
					 'Resume was uploaded on the Jobs972.com!' . '<br/><br/> ' ."\n" .
					 'Upload Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'User Email: <b>' . $email . '</b><br/>' ."\n" .
					 'User FirstName: <b>' . $fn . '</b><br/>' ."\n" .
					 'User LastName: <b>' . $ln . '</b><br/>' ."\n" .
					 'Resume Description: <b>' . $resume_description . '</b><br/>' ."\n" .
					 'Resume FileName: <b>' . substr(basename($target_file),23, 100) . '</b><br/>' ."\n" .
					 'IP address: <b>' . $ip_addr . '</b><br/>' ."\n" .
					 '<br/>Regards, ' . ' <br/> ' ."\n" .
					 'Administrator.</body></html>';		
					 
		$message2 = '<html><body> ' ."\n" .
					 'A New Resume Was Uploaded on the Jobs972.com!' . '<br/>' ."\n" .
					 'Upload Date: <b>' . $cur_dt . '</b><br/> ' ."\n" .
					 'Your Email: <b>' . $_SESSION['logged_in_email'] . '</b><br/>' ."\n" .
					 'Resume Description: <b>' . $resume_description . '</b><br/>' ."\n" .	
					 'Resume FileName: <b>' . substr(basename($target_file),23, 100) . '</b><br/>' ."\n" .
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
			
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 

			$conn->query("set names 'utf8'");
			
			$logged_in_email = $_SESSION['logged_in_email'];
			
			$logged_user_id = $_SESSION['logged_in_userid'];
			
			$sql = "INSERT INTO businesslog (datex, alert_id, principal_id, ip_addr, email, the_info, the_info_user_en, the_page) 
			VALUES ('$db_cur_dt', 7, 0, '$ip_addr', '$logged_in_email', '$message', '$message2', '')";

			if ($conn->query($sql) === TRUE) {
				//  echo "1 New record created successfully";
			} else {
				// echo "Error1: " . $sql . "<br>" . $conn->error;
			}

			$sql2 = "insert into resumes (user_id, create_dt, modify_dt, file_path, file_desc, status) values ($logged_user_id, '$db_cur_dt', '$db_cur_dt', '$target_file', '$resume_description', '1')";
						
			if ($conn->query($sql2) === TRUE) {
				// echo "Record updated successfully";
			} else {
				// echo "Error: " . $sql . "<br>" . $conn->error;
			}				
			
			$conn->close();				
		} 							 
	
		echo "Ok";
	
	}	

	
?>