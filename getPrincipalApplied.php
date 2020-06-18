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

		$pos_search_applied_name = $_POST['pos_search_applied_name'];
		$pos_search_applied_position = $_POST['pos_search_applied_position'];
		$pos_search_applied_company = $_POST['pos_search_applied_company'];
		$pos_search_applied_location = $_POST['pos_search_applied_location'];
	
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
		
		
		$sql0 = "select count(1) n_of_recs 
				from 
					user_positions up, 
					positions p, 
					users u, 
					company co, 
					city ci, 
					resumes r,
					principal_position_link ppl
				where 
					up.status = 'A'
						   and p.id = up.pos_id
						   and up.user_id = u.id
						   and up.pos_id = p.id
						   and up.res_id = r.id
						   and r.id = up.res_id
						   and p.company_id = co.id
						   and co.placement_id = ci.id
						   and p.pos_status = '1'
						   and u.status = '1'
						   and (concat(upper(substr(u.firstname,1,1)), lower(substr(u.firstname,2,100)),' ',upper(substr(u.lastname,1,1)), lower(substr(u.lastname,2,100))) = '$pos_search_applied_name' or '$pos_search_applied_name' = '-25')
						   and (p.pos_title = '$pos_search_applied_position' or '$pos_search_applied_position' = '-25')
						   and (co.the_name = '$pos_search_applied_company' or '$pos_search_applied_company' = '-25')
						   and (ci.name_en = '$pos_search_applied_location' or '$pos_search_applied_location' = '-25')
						   and ppl.princ_id = $princ_id 
						   and ppl.pos_id  = p.id";
				
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
						u.firstname,
						u.lastname,
						u.city,
						u.linkedin,
						u.email,
						u.mobile,
						u.city,
						u.positions,
						u.linkedin,
						u.about,
						p.pos_title,
						p.id pos_id,
						p.pos_desc,
						co.the_name company_name,
						ci.name_en city_name,
						r.file_path,
						r.file_desc,
						up.cover_letter,
						up.id upid,
						DATE_FORMAT(up.modify_dt,'%d/%m/%Y %H:%i:%s') apply_dt,
						p.pos_notes,
						p.pos_contact_email,
						DATE_FORMAT(up.informer_dt,'%d/%m/%Y @ %H:%i') informer_dt
				from 
					user_positions up, 
					positions p, 
					users u, 
					company co, 
					city ci, 
					resumes r,					
					principal_position_link ppl
				where 
					up.status = 'A'
						   and p.id = up.pos_id
						   and up.user_id = u.id
						   and up.pos_id = p.id
						   and up.res_id = r.id						   
						   and r.id = up.res_id
						   and p.company_id = co.id
						   and co.placement_id = ci.id
						   and p.pos_status = '1'
						   and u.status = '1'						   
						   and ppl.princ_id = $princ_id 
						   and ppl.pos_id  = p.id
						   and (concat(upper(substr(u.firstname,1,1)), lower(substr(u.firstname,2,100)),' ',upper(substr(u.lastname,1,1)), lower(substr(u.lastname,2,100))) = '$pos_search_applied_name' or '$pos_search_applied_name' = '-25')
						   and (p.pos_title = '$pos_search_applied_position' or '$pos_search_applied_position' = '-25')
						   and (co.the_name = '$pos_search_applied_company' or '$pos_search_applied_company' = '-25')
						   and (ci.name_en = '$pos_search_applied_location' or '$pos_search_applied_location' = '-25')
						   order by up.modify_dt desc
					limit ".($the_curr_page - 1) * $recs_per_page.", ".$recs_per_page." ";
	 
			$arr_the_recs_detailed = array();		
			$results_recent_activities = mysqli_query($conn, $sql); 	
			
			while($line = mysqli_fetch_assoc($results_recent_activities)){
				$arr_the_recs_detailed[] = $line;
			}			
				
			$conn->close();			
					
			$search_position_state = 0;
			
			if (($pos_search_applied_name == '-25') && 
				($pos_search_applied_position == '-25') && 
				($pos_search_applied_company == '-25') &&
				($pos_search_applied_location == '-25'))
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
									A List Of Applications For Your Positions
								</div>									
								<div class="pull-right"> 
									<a class="btn '.$txt_search_position_state.'" onclick="searchPrincipalAppliedForm();" style="border-radius: 24px;">Search Applied...</a>																		
								</div>
								<div class="clearfix"></div>

								<br/>
								
								<div class="row">	
									<div class="col-md-12">';
		
			$part_2 = "";
						
			for($idx=0; $idx<sizeof($arr_the_recs_detailed); $idx++)
			{
			
				$positions_informer = 0;

				for($idy=0; $idy<sizeof($arr_principal_actions); $idy++)
				{
					if ($arr_principal_actions[$idy]['action_name'] == "POSITIONS_INFORMER")
					{
						$positions_informer = 1;
					}
				}	

				if ($positions_informer == 1)
				{
				
					$suggest_email = '';
					
					if ($arr_the_recs_detailed[$idx]['pos_contact_email'] == '')
					{
						if ($arr_the_recs_detailed[$idx]['pos_notes'] == '')
						{
							$suggest_email = '';
						}
						else
						{
							$suggest_email = $arr_the_recs_detailed[$idx]['pos_notes'];
						}
					}
					else
					{
						$suggest_email = $arr_the_recs_detailed[$idx]['pos_contact_email'];
					}
					
					$informer_part_color = "btn-primary";
					$informer_part_time = "Inform...";					
					
					if (($arr_the_recs_detailed[$idx]['informer_dt'] != '') && ($arr_the_recs_detailed[$idx]['informer_dt'] != '00/00/0000 @ 00:00' ))
					{
						$informer_part_color = "btn-warning";
						$informer_part_time = 'Informed On '.$arr_the_recs_detailed[$idx]['informer_dt'];
					}
					
					$informer_part = '<a class="btn '.$informer_part_color.'" onclick="informTheCompany('.$arr_the_recs_detailed[$idx]['upid'].',\''.$arr_the_recs_detailed[$idx]['pos_title'].'\',\''.$arr_the_recs_detailed[$idx]['company_name'].'\',\''.$arr_the_recs_detailed[$idx]['firstname'].' '.$arr_the_recs_detailed[$idx]['lastname'].'\',\'CV - '.$arr_the_recs_detailed[$idx]['firstname'].' '.$arr_the_recs_detailed[$idx]['lastname'].' - '.$arr_the_recs_detailed[$idx]['file_desc'].'\',\''.$suggest_email.'\');" style="border-radius: 24px;">'.$informer_part_time.'</a>
										  &nbsp;&nbsp;';
				}
				else
				{
					$informer_part = '';
				}			
		
				
		
				$part_2 = $part_2 .
						'<div class="panel panel-default">
						  <div class="panel-heading">
							<div class="pull-left" style="font-size:16px; margin-top: 7px;"><b>'.
								$arr_the_recs_detailed[$idx]['firstname'].' '.$arr_the_recs_detailed[$idx]['lastname'].'</b> has applied for <a href="index.php?i='.$arr_the_recs_detailed[$idx]['pos_id'].'" target="_blank" >'.$arr_the_recs_detailed[$idx]['pos_title'].' @ '.$arr_the_recs_detailed[$idx]['company_name'].'</a>  
							</div>
							<div class="pull-right">'.$informer_part.'									
								<a class="btn btn-primary" onclick="notRelevantPrincipalApplied('.$arr_the_recs_detailed[$idx]['upid'].',\''.$arr_the_recs_detailed[$idx]['pos_title'].' @ '.$arr_the_recs_detailed[$idx]['company_name'].'\',\''.$arr_the_recs_detailed[$idx]['firstname'].' '.$arr_the_recs_detailed[$idx]['lastname'].'\');" style="border-radius: 24px;">Not Relevant...</a>
							</div>								
							<div class="clearfix"></div>								
						  </div>
							<div class="panel-body">
								<table style="border-spacing: 10px; border-collapse: separate;">
								<tr>
									<td style="width:100px; text-align:right;">
										<b>Applied On:</b>
									</td>
									<td>'.$arr_the_recs_detailed[$idx]['apply_dt'].'</td>
								</tr>									
								<tr>
									<td style="text-align:right;">
										<b>Candidate:</b>
									</td>
									<td>'.$arr_the_recs_detailed[$idx]['firstname'].' '.$arr_the_recs_detailed[$idx]['lastname'].'</td>
								</tr>
								<tr>
									<td style="text-align:right;">
										<b>Mobile:</b>
									</td>
									<td>'.$arr_the_recs_detailed[$idx]['mobile'].'</td>
								</tr>
								<tr>
									<td style="text-align:right;">
										<b>Lives In:</b>
									</td>
									<td>'.$arr_the_recs_detailed[$idx]['city'].'</td>
								</tr>	
								<tr>
									<td style="text-align:right;">
										<b>Looking For:</b>
									</td>
									<td>'.$arr_the_recs_detailed[$idx]['positions'].'</td>
								</tr>
								<tr>
									<td style="text-align:right;">
										<b>About:</b>
									</td>
									<td>'.$arr_the_recs_detailed[$idx]['about'].'</td>
								</tr>
								<tr>
									<td style="text-align:right;">
										<b>Cover Letter:</b>
									</td>
									<td>'.$arr_the_recs_detailed[$idx]['cover_letter'].'</td>
								</tr>									
								<tr>
									<td style="text-align:right;">
										<b>Resume:</b>
									</td>
									<td><a href="'.$arr_the_recs_detailed[$idx]['file_path'].'" target="_blank">CV - '.$arr_the_recs_detailed[$idx]['firstname'].' '.$arr_the_recs_detailed[$idx]['lastname'].' - '.$arr_the_recs_detailed[$idx]['file_desc'].'</a></td>
								</tr>									
								<tr>
									<td style="text-align:right;">
										<b>Applied For:</b>
									</td>
									<td>'.$arr_the_recs_detailed[$idx]['pos_title'].' @ '.$arr_the_recs_detailed[$idx]['company_name'].' in '.$arr_the_recs_detailed[$idx]['city_name'].'</td>
								</tr>
								<tr>
									<td style="text-align:right;">
										<b>Position:</b>
									</td>
									<td>'.nl2br($arr_the_recs_detailed[$idx]['pos_desc']).'</td>
								</tr>									
								</table>					
							</div>
						</div>';
			} // idx

	
			$part_3 = '</div>	
						</div>';

			$prev_page = $the_curr_page-1;
			$next_page = $the_curr_page+1;
						  
			$part_4 = '<ul class="pager">' ."\n" .
						  '<li class="previous"><a href="javascript:void(0);" onclick="getPrincipalAppliedAjax('.$prev_page.',\''.$pos_search_applied_name.'\',\''.$pos_search_applied_position.'\',\''.$pos_search_applied_company.'\',\''.$pos_search_applied_location.'\');">Previous</a></li>' ."\n" .
						  '<li style="text-align:center"><a href="javascript:void(0);">'.$the_curr_page.'</a></li>' ."\n" .
						  '<li style="text-align:center">&nbsp;of&nbsp;</li>' ."\n" .
						  '<li style="text-align:center"><a href="javascript:void(0);">'.$n_of_pages.'</a></li>' ."\n" .
						  '<li style="text-align:center">&nbsp;pages&nbsp;</li>' ."\n" .
						  '<li class="next"><a href="javascript:void(0);" onclick="getPrincipalAppliedAjax('.$next_page.',\''.$pos_search_applied_name.'\',\''.$pos_search_applied_position.'\',\''.$pos_search_applied_company.'\',\''.$pos_search_applied_location.'\');" >Next</a></li>' ."\n" .
						'</ul>
						</div>'."\n";
					

			$the_reply = $part_1 . $part_2 . $part_3 . $part_4 ;
									
			echo json_encode(array("val_1" =>  $the_reply, "val_2" => $tot_n_of_recs));
		
		}
		else
		{		
		
			if (($pos_search_applied_name == '-25') && 
				($pos_search_applied_position == '-25') && 
				($pos_search_applied_company == '-25') &&
				($pos_search_applied_location == '-25'))
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
									No Any Application For Your Positions or Search Criteria Yet...
								</div>
								<div class="pull-right"> 
									<a class="btn '.$txt_search_position_state.'" onclick="searchPrincipalAppliedForm();" style="border-radius: 24px;">Search Applied...</a>																		
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