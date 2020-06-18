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

		$str_title = $_POST['str_title'];
		$str_company = $_POST['str_company'];
		$str_location = $_POST['str_location'];
	
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");
		
		
		$the_sql_query_a = "insert into principal_position_link 
							select 0, id 
							from positions 
							where id not in 
									(select pos_id 
									from principal_position_link  
									where princ_id =0)";

		$conn->query($the_sql_query_a);	

		

		$the_sql_query_b = "update category ca
							set ca.n_pos = (select count(1) 
											from positions p  
											where 
												p.pos_cat = ca.id 
												or 
												p.pos_cat_2 = ca.id
												or 
												p.pos_cat_3 = ca.id
												or 
												p.pos_cat_4 = ca.id
												or 
												p.pos_cat_5 = ca.id)
							where exists 
									(select 1 
										from positions p  
											where p.pos_cat = ca.id 
												or 
												p.pos_cat_2 = ca.id
												or 
												p.pos_cat_3 = ca.id
												or 
												p.pos_cat_4 = ca.id
												or 
												p.pos_cat_5 = ca.id)";

		$conn->query($the_sql_query_b);
		
		
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
					company co, 
					city ci,
					principal_company_link pcl,
					principal_position_link ppl,
					positions p
				where 
					co.placement_id = ci.id 
				and 
					co.status in ('1', '2')
				and
					ppl.princ_id = pcl.princ_id
				and
					ppl.pos_id = p.id
				and 
					pcl.comp_id = co.id 
				and 
					p.company_id =  co.id
				and 
					p.pos_status in ('0', '1', '2')
				and 
					(('$str_title' = '-25') or (p.pos_title = '$str_title'))
				and
					(('$str_company' = '-25') or (co.the_name = '$str_company'))
				and
					(('$str_location' = '-25') or (ci.name_en = '$str_location'))					
				and 
					pcl.princ_id = $princ_id";
 
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
						co.id, 
						DATE_FORMAT(co.modifydt,'%d/%m/%Y') moddt, 
						DATE_FORMAT(p.modifydt,'%d/%m/%Y %H:%i') moddt2, 
						co.the_name, 
						ci.name_en locatio, 
						ci.id locatio_id, 
						co.the_descrip, 
						co.website, 
						co.address, 
						co.phone_1, 
						co.fax_1, 
						co.num_people, 
						co.the_descrip_heb, 
						co.address_heb, 
						co.industry, 
						co.c_type, 
						co.founded,
						p.pos_status status,
						p.id pos_id,
						p.pos_title,
						p.job_type,
						p.pos_desc,
						p.nviews,
						(select ca.cat_name from category ca where ca.id = p.pos_cat) cat_1,
						(select sca.subcat_name from sub_category sca where sca.id = p.pos_sub_cat) scat_1,
						(select ca.id from category ca where ca.id = p.pos_cat) cat_1_id,
						(select sca.id from sub_category sca where sca.id = p.pos_sub_cat) scat_1_id,
						(select ca.cat_name from category ca where ca.id = p.pos_cat_2) cat_2,
						(select sca.subcat_name from sub_category sca where sca.id = p.pos_sub_cat_2) scat_2,
						(select ca.id from category ca where ca.id = p.pos_cat_2) cat_2_id,
						(select sca.id from sub_category sca where sca.id = p.pos_sub_cat_2) scat_2_id,
						(select ca.cat_name from category ca where ca.id = p.pos_cat_3) cat_3,
						(select sca.subcat_name from sub_category sca where sca.id = p.pos_sub_cat_3) scat_3,
						(select ca.id from category ca where ca.id = p.pos_cat_3) cat_3_id,
						(select sca.id from sub_category sca where sca.id = p.pos_sub_cat_3) scat_3_id,
						(select ca.cat_name from category ca where ca.id = p.pos_cat_4) cat_4,
						(select sca.subcat_name from sub_category sca where sca.id = p.pos_sub_cat_4) scat_4,
						(select ca.id from category ca where ca.id = p.pos_cat_4) cat_4_id,
						(select sca.id from sub_category sca where sca.id = p.pos_sub_cat_4) scat_4_id,
						(select ca.cat_name from category ca where ca.id = p.pos_cat_5) cat_5,
						(select sca.subcat_name from sub_category sca where sca.id = p.pos_sub_cat_5) scat_5,
						(select ca.id from category ca where ca.id = p.pos_cat_5) cat_5_id,
						(select sca.id from sub_category sca where sca.id = p.pos_sub_cat_5) scat_5_id						
					from 
						company co, 
						city ci,
						principal_company_link pcl,
						principal_position_link ppl,
						positions p
					where 
						co.placement_id = ci.id 
					and 
						co.status in ( '1', '2')
					and
						ppl.pos_id = p.id
					and
						ppl.princ_id = pcl.princ_id
					and
						pcl.comp_id = co.id
					and 
						p.pos_status in ('0', '1', '2')
					and 
						p.company_id =  co.id
					and 
						(('$str_title' = '-25') or (p.pos_title = '$str_title'))
					and 
						(('$str_company' = '-25') or (co.the_name = '$str_company'))
					and
						(('$str_location' = '-25') or (ci.name_en = '$str_location'))
					and 
						pcl.princ_id = ".$princ_id." order by p.modifydt desc, p.id desc 
					limit ".($the_curr_page - 1) * $recs_per_page.", ".$recs_per_page." ";
	 
			$arr_the_recs_detailed = array();		
			$results_recent_activities = mysqli_query($conn, $sql); 	
			
			while($line = mysqli_fetch_assoc($results_recent_activities)){
				$arr_the_recs_detailed[] = $line;
			}			
				
			$conn->close();			

			
			$can_add_position = 0;
			
			for($idy=0; $idy<sizeof($arr_principal_actions); $idy++)
			{
				if ($arr_principal_actions[$idy]['action_name'] == "CAN_ADD_POSITION")
				{
					$can_add_position = 1;
				}
			}	

			if ($can_add_position == 1)
			{
				$add_position_part = '<a class="btn btn-primary" onclick="addPrincipalPositionForm();" style="border-radius: 24px;">Add Your Position...</a>								
									  &nbsp;&nbsp;';
			}
			else
			{
				$add_position_part = '';
			}
			
			$search_position_state = 0;
			
			if (($str_title == '-25') && ($str_company == '-25') && ($str_location == '-25'))
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
									A List Of The Positions You Manage
								</div>									
								<div class="pull-right">'.$add_position_part.'																		
									<a class="btn '.$txt_search_position_state.'" onclick="searchPrincipalPositionForm();" style="border-radius: 24px;">Search Position...</a>
								</div>
								<div class="clearfix"></div>

								<br/>
								
								<div class="row">	
									<div class="col-md-12">';
		
			$part_2 = "";
						
				for($idx=0; $idx<sizeof($arr_the_recs_detailed); $idx++)
				{
			
					$is_waiting_approval = '';

					if ($arr_the_recs_detailed[$idx]['status'] == '2')
					{
						$is_waiting_approval = '<span style="color: red"> <i>- waiting for approval</i></span>';																				
					}					
			
					$c_sc_1 = '';
					
					if ($arr_the_recs_detailed[$idx]['cat_1'] != '') 
					{ 
						$c_sc_1 = '<a href="index.php?ca='.$arr_the_recs_detailed[$idx]['cat_1_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['cat_1'].'</a> / <a href="index.php?sc='.$arr_the_recs_detailed[$idx]['scat_1_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['scat_1'].'</a><br/>';
					} 
					
					$c_sc_2 = '';
					
					if ($arr_the_recs_detailed[$idx]['cat_2'] != '') 
					{ 
						$c_sc_2 = '<a href="index.php?ca='.$arr_the_recs_detailed[$idx]['cat_2_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['cat_2'].'</a> / <a href="index.php?sc='.$arr_the_recs_detailed[$idx]['scat_2_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['scat_2'].'</a><br/>';
					} 					
			
					$c_sc_3 = '';
					
					if ($arr_the_recs_detailed[$idx]['cat_3'] != '') 
					{ 
						$c_sc_3 = '<a href="index.php?ca='.$arr_the_recs_detailed[$idx]['cat_3_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['cat_3'].'</a> / <a href="index.php?sc='.$arr_the_recs_detailed[$idx]['scat_3_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['scat_3'].'</a><br/>';
					}			
			
					$c_sc_4 = '';
					
					if ($arr_the_recs_detailed[$idx]['cat_4'] != '') 
					{ 
						$c_sc_4 = '<a href="index.php?ca='.$arr_the_recs_detailed[$idx]['cat_4_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['cat_4'].'</a> / <a href="index.php?sc='.$arr_the_recs_detailed[$idx]['scat_4_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['scat_4'].'</a><br/>';
					}	
			
					$c_sc_5 = '';
					
					if ($arr_the_recs_detailed[$idx]['cat_5'] != '') 
					{ 
						$c_sc_5 = '<a href="index.php?ca='.$arr_the_recs_detailed[$idx]['cat_5_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['cat_5'].'</a> / <a href="index.php?sc='.$arr_the_recs_detailed[$idx]['scat_5_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['scat_5'].'</a><br/>';
					}					
			
					$can_approve_position = 0;
					
					for($idy=0; $idy<sizeof($arr_principal_actions); $idy++)
					{
						if ($arr_principal_actions[$idy]['action_name'] == "CAN_APPROVE_POSITIONS")
						{
							$can_approve_position = 1;
						}
					}	

					if  (($can_approve_position == 1) && ($arr_the_recs_detailed[$idx]['status'] == '2'))
					{
						$approve_this_position = '<a class="btn btn-primary" onclick="approvePrincipalPositionForm('.$arr_the_recs_detailed[$idx]['pos_id'].');" style="border-radius: 24px;">Approve...</a>';
					}
					else
					{
						$approve_this_position = '';
					}
			
					$can_edit_position = 0;
					
					for($idy=0; $idy<sizeof($arr_principal_actions); $idy++)
					{
						if ($arr_principal_actions[$idy]['action_name'] == "CAN_EDIT_POSITION")
						{
							$can_edit_position = 1;
						}
					}			
			
					if ($can_edit_position ==  1)
					{
						$edit_position_part = '<a class="btn btn-primary" onclick="editPrincipalPositionForm('.$arr_the_recs_detailed[$idx]['pos_id'].');" style="border-radius: 24px;">Edit...</a>';
					}
					else
					{
						$edit_position_part = '';
					}
					
					$can_renew_position = 0;
					
					for($idy=0; $idy<sizeof($arr_principal_actions); $idy++)
					{
						if ($arr_principal_actions[$idy]['action_name'] == "CAN_RENEW_POSITION")
						{
							$can_renew_position = 1;
						}
					}			
			
					if ($can_renew_position ==  1)
					{
						$renew_position_part = '<a class="btn btn-primary" onclick="renewPrincipalPositionForm('.$arr_the_recs_detailed[$idx]['pos_id'].');" style="border-radius: 24px;">Renew...</a>';												
					}
					else
					{
						$renew_position_part = '';
					}					
					
			
					if ($arr_the_recs_detailed[$idx]['status'] == '0')
					{
						$nonactive_position = " style='background-color: #f5f5f5;' ";						
						$nonactive_position_2 =  "<tr><td style='width:20px; text-align:right; color: red;'><b>Status:</b></td><td style='color: red;'>Non-Active</td></tr>";
					}
					elseif ($arr_the_recs_detailed[$idx]['status'] == '1')
					{
						$nonactive_position = "";						
						$nonactive_position_2 =  "<tr><td style='width:20px; text-align:right; color: green;'><b>Status:</b></td><td style='color: green;'>Active</td></tr>";						
					}
					elseif ($arr_the_recs_detailed[$idx]['status'] == '2')
					{
						$nonactive_position = "";						
						$nonactive_position_2 =  "<tr><td style='width:20px; text-align:right; color: coral;'><b>Status:</b></td><td style='color: coral;'>Waiting For Approval</td></tr>";						
					}					
					else
					{
						$nonactive_position = "";						
						$nonactive_position_2 = "";
					}
			
					$part_2 = $part_2 .
							'<div class="panel panel-default" '.$nonactive_position.' >
							  <div class="panel-heading">
								<div class="pull-left" style="font-size:16px; margin-top: 7px;"> 
									<a href="index.php?i='.$arr_the_recs_detailed[$idx]['pos_id'].'" target="_blank" >'.$arr_the_recs_detailed[$idx]['pos_title'].' @ '.$arr_the_recs_detailed[$idx]['the_name'].'</a> '.$is_waiting_approval.'  <span class="badge">'.$arr_the_recs_detailed[$idx]['nviews'].' views</span>  '.$approve_this_position.'
								</div>
								<div class="pull-right">'.$renew_position_part.'&nbsp;&nbsp;'.$edit_position_part.'</div>
								<div class="clearfix"></div>								
							  </div>
								<div class="panel-body">
									<table style="border-spacing: 10px; border-collapse: separate;">'.$nonactive_position_2.'
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Date:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['moddt2'].'</td>
									</tr>									
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Position:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['pos_title'].'</td>
									</tr>									
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Company:</b>
										</td>
										<td><a href="companies.php?c='.$arr_the_recs_detailed[$idx]['id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['the_name'].'</a></td>
									</tr>
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Location:</b>
										</td>
										<td><a href="https://www.jobs972.com/index.php?p=1&c='.$arr_the_recs_detailed[$idx]['locatio_id'].'&s=" target="_blank">'.$arr_the_recs_detailed[$idx]['locatio'].'</a></td>
									</tr> 					
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Type:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['job_type'].'</td>
									</tr> 
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Description:</b>
										</td>
										<td>'.nl2br($arr_the_recs_detailed[$idx]['pos_desc']).'</td>
									</tr>
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Category:</b>
										</td>
										<td>'.$c_sc_1.' '.$c_sc_2.' '.$c_sc_3.' '.$c_sc_4.' '.$c_sc_5.'</td>
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
						  '<li class="previous"><a href="javascript:void(0);" onclick="getPrincipalPositionsAjax('.$prev_page.',\''.$str_title.'\',\''.$str_company.'\',\''.$str_location.'\');">Previous</a></li>' ."\n" .
						  '<li style="text-align:center"><a href="javascript:void(0);">'.$the_curr_page.'</a></li>' ."\n" .
						  '<li style="text-align:center">&nbsp;of&nbsp;</li>' ."\n" .
						  '<li style="text-align:center"><a href="javascript:void(0);">'.$n_of_pages.'</a></li>' ."\n" .
						  '<li style="text-align:center">&nbsp;pages&nbsp;</li>' ."\n" .
						  '<li class="next"><a href="javascript:void(0);" onclick="getPrincipalPositionsAjax('.$next_page.',\''.$str_title.'\',\''.$str_company.'\',\''.$str_location.'\');" >Next</a></li>' ."\n" .
						'</ul>
						</div>'."\n";
					

			$the_reply = $part_1 . $part_2 . $part_3 . $part_4 ;
									
			echo json_encode(array("val_1" =>  $the_reply, "val_2" => $tot_n_of_recs));
		
		}
		else
		{		
		
			$can_add_position = 0;
			
			for($idy=0; $idy<sizeof($arr_principal_actions); $idy++)
			{
				if ($arr_principal_actions[$idy]['action_name'] == "CAN_ADD_POSITION")
				{
					$can_add_position = 1;
				}
			}	

			if ($can_add_position == 1)
			{
				$add_position_part = '<a class="btn btn-primary" onclick="addPrincipalPositionForm();" style="border-radius: 24px;">Add Your Position...</a>								
									  &nbsp;&nbsp;';
			}
			else
			{
				$add_position_part = '';
			}		
		
			$search_position_state = 0;
			
			if (($str_title == '-25') && ($str_company == '-25') && ($str_location == '-25'))
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
									No Positions Yet...
								</div>									
								<div class="pull-right">'.$add_position_part.'</div>
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