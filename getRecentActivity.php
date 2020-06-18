<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_POST['the_curr_page']) && isset($_POST['recs_per_page']) && isset($_SESSION['logged_in_email']) )
	{
	
		$logged_in_email = $_SESSION['logged_in_email'];
		$the_curr_page = $_POST['the_curr_page'];
		$recs_per_page = $_POST['recs_per_page'];
	
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");

		$sql0 = "select count(1) n_of_recs
				from businesslog bl, alerts al
				where bl.alert_id = al.id
				and bl.datex >= (now() + INTERVAL 10 HOUR - INTERVAL 14 DAY)
				and upper(bl.email) = upper('".$logged_in_email."')";
 
		$arr_n_of_recs = array();		
		$results_n_of_recs = mysqli_query($conn, $sql0); 	
		
		while($line = mysqli_fetch_assoc($results_n_of_recs)){
			$arr_n_of_recs[] = $line;
		}
		
		$tot_n_of_recs = $arr_n_of_recs[0]['n_of_recs'];
		
		if ($tot_n_of_recs == 0)
		{			
			echo json_encode(array("val_1" =>  '<br/>No Any Activity Yet...', "val_2" => 0));
			exit;
		}
		
		$n_of_pages = ceil($tot_n_of_recs/$recs_per_page);
		
		if ($the_curr_page < 1) $the_curr_page = 1;
		if ($the_curr_page > $n_of_pages) $the_curr_page = $n_of_pages;
		
		$sql = "select bl.id, DATE_FORMAT(bl.datex,'%d/%m/%Y %H:%i:%s') the_dt, al.name_eng, bl.the_info_user_en
				from businesslog bl, alerts al
				where bl.alert_id = al.id
				and bl.datex >= (now() + INTERVAL 10 HOUR - INTERVAL 14 DAY)
				and upper(bl.email) = upper('".$logged_in_email."')
				order by bl.datex desc
				limit ".($the_curr_page - 1) * $recs_per_page.", ".$recs_per_page." ";
 
		$arr_recent_activities = array();		
		$results_recent_activities = mysqli_query($conn, $sql); 	
		
		while($line = mysqli_fetch_assoc($results_recent_activities)){
			$arr_recent_activities[] = $line;
		}			
			
		$conn->close();			
		 		 
		$part_1 = '<br/>' .
					 '<p>The list of your activities for 14 recent days in reverse order:</p>'  ."\n" .
				     '<table class="table table-striped">' ."\n" .
					 '<thead>' ."\n" .
					 '<tr>' ."\n" . 
						'<th>OpId</th>'. "\n" .
						'<th>Date</th>' ."\n" .
						'<th>Activity</th>' ."\n" .
						'<th>Info</th>' ."\n" .
					  '</tr>' ."\n" .
					'</thead>' ."\n" .
					'<tbody>' ."\n";
					
		$part_2 = '';
		
					  for ($idx= 0; $idx < sizeof($arr_recent_activities); $idx++)
					  {
		
					  $part_2 = $part_2. 	'<tr>' ."\n" .
											'<td style="vertical-align:middle">'.$arr_recent_activities[$idx]['id'].'</td>' ."\n" .
											'<td style="vertical-align:middle">'.$arr_recent_activities[$idx]['the_dt'].'</td>' ."\n" .   
											'<td style="vertical-align:middle">'.$arr_recent_activities[$idx]['name_eng'].'</td>' ."\n" .
											'<td style="vertical-align:middle"><button type="button" class="btn btn-default" onclick="getRecentActivityDetails('.$arr_recent_activities[$idx]['id'].')" >Details...</button></td>' ."\n" .
											'</tr>' ."\n" ;
											
					  }

		$prev_page = $the_curr_page-1;
		$next_page = $the_curr_page+1;
					  
		$part_3 = '</tbody>' ."\n" .
				  '</table>' ."\n" .				  
					'<ul class="pager">' ."\n" .
					 ' <li class="previous"><a href="javascript:void(0);" onclick="getRecentActivitiesAjax('.$prev_page.');">Previous</a></li>' ."\n" .
					  '<li style="text-align:center"><a href="javascript:void(0);">'.$the_curr_page.'</a></li>' ."\n" .
					  '<li class="next"><a href="javascript:void(0);" onclick="getRecentActivitiesAjax('.$next_page.');" >Next</a></li>' ."\n" .
					'</ul>';
				

		$the_reply = $part_1 . $part_2 . $part_3;
		
		echo json_encode(array("val_1" =>  $the_reply, "val_2" => $tot_n_of_recs));
		 
	}	
	else
	{		
		echo json_encode(array("val_1" =>  "Error!", "val_2" => 0));
	}

?>