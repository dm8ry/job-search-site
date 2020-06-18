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
		
		$txt_reply = $txt_reply.'<table class="table table-striped">'."\n";
	    $txt_reply = $txt_reply.'<thead>'."\n";
		$txt_reply = $txt_reply.'<tr>'."\n";
		$txt_reply = $txt_reply.'<th></th>'."\n";
		$txt_reply = $txt_reply.'<th>Filename</th>'."\n";
		$txt_reply = $txt_reply.'<th>Description</th>'."\n";
		$txt_reply = $txt_reply.'<th>Last Modified</th>'."\n";
		
		$show_add_resume_btn='';
		if (sizeof($arr_resumes_details) < $arr_max_resumes_per_user[0]['prop_value']) 
		{ 
			$show_add_resume_btn='<button type="button" class="btn btn-default" onClick="addResume();">Add...</button>';
		}
		
		$txt_reply = $txt_reply.'<th colspan="2">'.$show_add_resume_btn.'</th>'."\n";
		$txt_reply = $txt_reply.'</tr>'."\n";
		$txt_reply = $txt_reply.'</thead>'."\n";
		$txt_reply = $txt_reply.'<tbody>'."\n";				
			
		for($idx=0; $idx<sizeof($arr_resumes_details); $idx++)
		{
			$txt_reply = $txt_reply.'<tr>'."\n";	
			$txt_reply = $txt_reply.'<td style="vertical-align:middle"><a href="'.$arr_resumes_details[$idx]['file_path'].'"><img title="'.$arr_resumes_details[$idx]['file_desc'].'" src="images/file_img7.png" border="0"></a></td>'."\n";
			$txt_reply = $txt_reply.'<td style="vertical-align:middle">'.substr(basename($arr_resumes_details[$idx]['file_path']), 23, 100).'</td>'."\n";
			$txt_reply = $txt_reply.'<td style="vertical-align:middle">'.$arr_resumes_details[$idx]['file_desc'].'</td>'."\n";
			$txt_reply = $txt_reply.'<td style="vertical-align:middle">'.$arr_resumes_details[$idx]['modify_dt'].'</td>'."\n";
			$txt_reply = $txt_reply.'<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="editResume(\''.$arr_resumes_details[$idx]['file_desc'].'\', \''.substr(basename($arr_resumes_details[$idx]['file_path']), 23, 100).'\','.$arr_resumes_details[$idx]['id'].', \''.$arr_resumes_details[$idx]['file_desc'].'\', \''.basename($arr_resumes_details[$idx]['file_path']).'\'); ">Edit...</button></td>'."\n";
		 	$txt_reply = $txt_reply.'<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="deleteResume(\''.$arr_resumes_details[$idx]['id'].'\', \''.$arr_resumes_details[$idx]['file_desc'].'\', \''.basename($arr_resumes_details[$idx]['file_path']).'\');">Delete...</button></td>'."\n";
		    $txt_reply = $txt_reply.'</tr>'."\n";
		}
 
		$txt_reply = $txt_reply.'</tbody>'."\n";	
		$txt_reply = $txt_reply.'</table>'."\n";	

	    echo  json_encode(array("val_1" => $txt_reply, "val_2" => sizeof($arr_resumes_details)));
		 
	}	
	else
	{
	   echo  json_encode(array("val_1" => 'Error!!!', "val_2" => 0));
	}

?>