<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_SESSION['logged_in_email']) && isset($_SESSION['logged_in_userid']) )
	{
	
		$logged_in_email = $_SESSION['logged_in_email'];
		$logged_user_id  = $_SESSION['logged_in_userid'];
	
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");

		$sql_max_resumes_per_user = "select prop_value from app_properties where prop_name = 'max_resumes_per_user' ";
									
		$arr_max_resumes_per_user = array();		
		$results_max_resumes_per_user = mysqli_query($conn, $sql_max_resumes_per_user); 	
		
		while($line = mysqli_fetch_assoc($results_max_resumes_per_user)){
			$arr_max_resumes_per_user[] = $line;
		}		
		
		$sql_resumes = "select DATE_FORMAT(r.modify_dt,'%d/%m/%Y %H:%i') modify_dt, r.file_desc, r.file_path, r.id from resumes r, users u where u.id = r.user_id and u.id=$logged_user_id order by r.modify_dt desc";
			
		$arr_resumes_details = array();
		$results_resumes_details = mysqli_query($conn, $sql_resumes); 

		while($line = mysqli_fetch_assoc($results_resumes_details)){
			$arr_resumes_details[] = $line;
		}		
			
		$conn->close();			
		
		
		$txt_reply ='';
				
		$txt_reply = $txt_reply.'<label for="apply_position_resume">Choose Resume:</label><br/>'."\n";
		$txt_reply = $txt_reply.'<select class="form-control" id="apply_position_resume" name="apply_position_resume">'."\n";
									 
		for ($idx = 0; $idx < sizeof($arr_resumes_details); $idx++)
		{
			$txt_reply = $txt_reply.'<option value="'.$arr_resumes_details[$idx]['id'].'">'.$arr_resumes_details[$idx]['file_desc'].'</option>	'."\n";	
		}
								 
		$txt_reply = $txt_reply.'</select>'."\n";
		
		if (sizeof($arr_resumes_details)==0)
		{
		
			echo  json_encode(array("val_1" => $txt_reply, "val_2" => 0));
		
		}
		else
		{
		
			echo  json_encode(array("val_1" => $txt_reply, "val_2" => sizeof($arr_resumes_details)));
		
		}
		 
	}	
	else
	{
	   echo  json_encode(array("val_1" => 'Error!!!', "val_2" => 0));
	}

?>