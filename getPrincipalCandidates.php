<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_POST['the_curr_page']) && isset($_POST['recs_per_page']) && isset($_SESSION['princ_email']) && isset($_SESSION['princ_id']) )
	{
		
		$princ_id = $_SESSION['princ_id'];
		$princ_email = $_SESSION['princ_email'];
		$the_curr_page = $_POST['the_curr_page'];
		$recs_per_page = $_POST['recs_per_page'];

		$pos_search_candidates_name = $_POST['pos_search_candidates_name'];
		$pos_search_keyword = $_POST['pos_search_keyword'];
	
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");
		
		
		$sql_principal_actions = "select a.name action_name
								from principal_role_link prl, role_action_link ral, action a
								where prl.princ_id = $princ_id 
								and ral.role_id = prl.role_id
								and a.id = ral.action_id";
									
		$arr_principal_actions = array();		
		$results_principal_actions = mysqli_query($conn, $sql_principal_actions); 	
		
		while($line = mysqli_fetch_assoc($results_principal_actions)){
			$arr_principal_actions[] = $line;
		}		
		
		
		$sql0 = "select 
						count(1) n_of_recs 
				from 
					users us					
				where 
					us.status = 1
				and
					(concat(upper(substr(us.firstname, 1, 1)), lower(substr(us.firstname, 2, 100)),' ', upper(substr(us.lastname,1,1)), lower(substr(us.lastname, 2, 100))) = '$pos_search_candidates_name' or '$pos_search_candidates_name' = '-25')
				and
					(lower(us.about) like lower('%$pos_search_keyword%') or lower(us.positions) like lower('%$pos_search_keyword%') or '$pos_search_keyword' = '')					
				and
					us.is_verified = '1' ";
 
		$arr_n_of_recs = array();		
		$results_n_of_recs = mysqli_query($conn, $sql0); 	
		
		while($line = mysqli_fetch_assoc($results_n_of_recs)){
			$arr_n_of_recs[] = $line;
		}
		
		$tot_n_of_recs = $arr_n_of_recs[0]['n_of_recs'];
		
		if ($tot_n_of_recs > 0)
		{
		
			$n_of_pages = ceil($tot_n_of_recs/$recs_per_page);
			
			if ($the_curr_page < 1) $the_curr_page = 1;
			if ($the_curr_page > $n_of_pages) $the_curr_page = $n_of_pages;
			
			$sql = "select 
						us.id, 
						DATE_FORMAT(us.modify_dt,'%d/%m/%Y %H:%i') moddt,
						us.firstname,
						us.lastname,
						us.mobile,
						us.city,
						us.positions,
						us.linkedin,
						us.about,
						DATE_FORMAT(us.last_login,'%d/%m/%Y %H:%i') lastlogin
					from 
						users us					
					where 
						us.status = 1
					and 
						(concat(upper(substr(us.firstname, 1, 1)), lower(substr(us.firstname, 2, 100)),' ', upper(substr(us.lastname,1,1)), lower(substr(us.lastname, 2, 100))) = '$pos_search_candidates_name' or '$pos_search_candidates_name' = '-25')					
					and
						(lower(us.about) like lower('%$pos_search_keyword%') or lower(us.positions) like lower('%$pos_search_keyword%') or '$pos_search_keyword' = '')											
					and
						us.is_verified = '1' order by us.modify_dt desc
					limit ".($the_curr_page - 1) * $recs_per_page.", ".$recs_per_page." ";
	 
			$arr_the_recs_detailed = array();		
			$results_recent_activities = mysqli_query($conn, $sql); 	
			
			while($line = mysqli_fetch_assoc($results_recent_activities)){
				$arr_the_recs_detailed[] = $line;
			}

			$search_position_state = 0;
			
			if (($pos_search_candidates_name == '-25') && ($pos_search_keyword == ''))
			{
				$search_position_state = 0;
			}
			else
			{
				$search_position_state = 1;
			}
			
			if ($search_position_state == 1)
			{
				$txt_search_position_state="btn-warning";
			}
			else
			{
				$txt_search_position_state="btn-primary";
			}			
					 					 
			$part_1 = '<br/>						
							<div class="container"> 
							
								<div class="pull-left">
									A List Of The Candidates:
								</div>									
								<div class="pull-right">																	
									<a class="btn '.$txt_search_position_state.'" onclick="searchPrincipalCandidateForm();" style="border-radius: 24px;">Search Candidate...</a>
								</div>
								<div class="clearfix"></div>

								<br/>
								
								<div class="row">	
									<div class="col-md-12">';
		
			$part_2 = "";
						
				for($idx=0; $idx<sizeof($arr_the_recs_detailed); $idx++)
				{
			
					$sql_resumes = 'select file_path, file_desc from resumes where user_id = '.$arr_the_recs_detailed[$idx]['id'].' and status = "1" order by modify_dt desc ';
					
					$arr_the_resumes_detailed = array();		
					$results_resumes = mysqli_query($conn, $sql_resumes); 	
					
					while($line = mysqli_fetch_assoc($results_resumes)){
						$arr_the_resumes_detailed[] = $line;
					}
					
					$resume_part = '';
					
					for($idy = 0; $idy < sizeof($arr_the_resumes_detailed); $idy++)
					{
					
					$resume_part = $resume_part .
								'<tr>
									<td style="width:120px; text-align:right;">
										<b>Resume #:'.($idy + 1).'</b>
									</td>
									<td><a href="'.$arr_the_resumes_detailed[$idy]['file_path'].'" target="_blank">'.$arr_the_resumes_detailed[$idy]['file_desc'].'</a></td>
								</tr>';					
					}
			
					$part_2 = $part_2 .
							'<div class="panel panel-default">
							  <div class="panel-heading">
								<div class="pull-left" style="font-size:16px;">'.$arr_the_recs_detailed[$idx]['firstname'].' '.$arr_the_recs_detailed[$idx]['lastname'].'
								</div>
								<div class="pull-right" style="font-size:16px;">'.$arr_the_recs_detailed[$idx]['moddt'].'
								</div>								
								<div class="clearfix"></div>								
							  </div>
								<div class="panel-body">
									<table style="border-spacing: 10px; border-collapse: separate;">
									<tr>
										<td style="width:120px; text-align:right;">
											<b>Mobile:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['mobile'].'</td>
									</tr>
									<tr>
										<td style="width:120px; text-align:right;">
											<b>City:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['city'].'</td>
									</tr>	
									<tr>
										<td style="width:120px; text-align:right;">
											<b>Positions:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['positions'].'</td>
									</tr>
									<tr>
										<td style="width:120px; text-align:right;">
											<b>LinkedIn:</b>
										</td>
										<td><a href="'.$arr_the_recs_detailed[$idx]['linkedin'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['linkedin'].'</a></td>
									</tr>	
									<tr>
										<td style="width:120px; text-align:right;">
											<b>About:</b>
										</td>
										<td>'.nl2br($arr_the_recs_detailed[$idx]['about']).'</td>
									</tr>	
									<tr>
										<td style="width:120px; text-align:right;">
											<b>Last Login:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['lastlogin'].'</td>
									</tr>'.$resume_part.'									
									</table>					
								</div>
							</div>';
				} // idx

		
				$part_3 = '</div>	
							</div>';

			$prev_page = $the_curr_page-1;
			$next_page = $the_curr_page+1;
						  
			$part_4 = '<ul class="pager">' ."\n" .
						  '<li class="previous"><a href="javascript:void(0);" onclick="getPrincipalCandidatesAjax('.$prev_page.',\''.$pos_search_candidates_name.'\',\''.$pos_search_keyword.'\');">Previous</a></li>' ."\n" .
						  '<li style="text-align:center"><a href="javascript:void(0);">'.$the_curr_page.'</a></li>' ."\n" .
						  '<li style="text-align:center">&nbsp;of&nbsp;</li>' ."\n" .
						  '<li style="text-align:center"><a href="javascript:void(0);">'.$n_of_pages.'</a></li>' ."\n" .
						  '<li style="text-align:center">&nbsp;pages&nbsp;</li>' ."\n" .
						  '<li class="next"><a href="javascript:void(0);" onclick="getPrincipalCandidatesAjax('.$next_page.',\''.$pos_search_candidates_name.'\',\''.$pos_search_keyword.'\');" >Next</a></li>' ."\n" .
						'</ul>
						</div>'."\n";
					
			$conn->close();
			
			$the_reply = $part_1 . $part_2 . $part_3 . $part_4 ;
									
			echo json_encode(array("val_1" =>  $the_reply, "val_2" => $tot_n_of_recs));	
		
		}
		else
		{		
		
			$search_position_state = 0;
			
			if (($pos_search_candidates_name == '-25') && ($pos_search_keyword == ''))
			{
				$search_position_state = 0;
			}
			else
			{
				$search_position_state = 1;
			}
			
			if ($search_position_state == 1)
			{
				$txt_search_position_state="btn-warning";
			}
			else
			{
				$txt_search_position_state="btn-primary";
			}		
		
			$the_reply = '<br/> 
							<div class="container"> 
							
								<div class="pull-left">
									No Candidates Yet...
								</div>
								<div class="pull-right">																	
									<a class="btn '.$txt_search_position_state.'" onclick="searchPrincipalCandidateForm();" style="border-radius: 24px;">Search Position...</a>
								</div>								
								<div class="clearfix"></div>
							</div>';
		
			echo json_encode(array("val_1" =>  $the_reply, "val_2" => 0));
		}
		 
	}	
	else
	{
		echo 'Error!!!';
	}

?>