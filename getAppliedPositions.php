<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_POST['the_curr_page']) && isset($_POST['recs_per_page']) && isset($_SESSION['logged_in_email']) && isset($_SESSION['logged_in_userid']) )
	{
	
		$logged_in_user_id = $_SESSION['logged_in_userid'];
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
				from user_positions up, users us, positions p, company co, city ci 
				where us.id = ".$logged_in_user_id." 
				and up.status = 'A'
				and up.user_id = us.id
				and p.id = up.pos_id
				and p.pos_status = '1'
				and p.company_id=co.id
				and ci.id = co.placement_id";
 
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
			
			$sql = "select 	p.id, 
						DATE_FORMAT(p.modifydt,'%d/%m/%Y') moddt, 
						p.pos_title, 
						co.the_name company_name, 
						ci.name_en locatio, 
						p.pos_desc,
						co.id comp_id,
						up.id up_id,
						DATE_FORMAT(up.modify_dt,'%d/%m/%Y') applydt
					from user_positions up, users us, positions p, company co, city ci
					where us.id = ".$logged_in_user_id."
					and up.status = 'A'
					and up.user_id = us.id
					and p.id = up.pos_id
					and p.pos_status = '1'
					and p.company_id=co.id
					and ci.id = co.placement_id
					order by up.modify_dt desc 
					limit ".($the_curr_page - 1) * $recs_per_page.", ".$recs_per_page." ";
	 
			$arr_the_recs_detailed = array();		
			$results_recent_activities = mysqli_query($conn, $sql); 	
			
			while($line = mysqli_fetch_assoc($results_recent_activities)){
				$arr_the_recs_detailed[] = $line;
			}			
				
			$conn->close();			
					 
			$part_1 = ' ';
						
			$part_2 = '<div class="container">    
						<div class="row">  
						   <div class="col-md-12">
						   <br/> 
						   <p>The list of positions you have applied for:</p>'  ."\n";
								
			$part_3 = '';
								
				for($idx=0; $idx<sizeof($arr_the_recs_detailed); $idx++)
				{
	 
					$part_3a = '';
	 
					if ($arr_the_recs_detailed[$idx]['locatio'] != '--')
					{
	 
					$part_3a = '<tr>
									<td style="width:20px; text-align:right;">
										<b>Location:</b>
									</td>
									<td>'.$arr_the_recs_detailed[$idx]['locatio'].'</td></tr>'."\n";
					}
							
	 
				$part_3 = $part_3.'	<form role="form" data-toggle="validator" name="frmPositions'.$arr_the_recs_detailed[$idx]['up_id'].'" enctype="multipart/form-data" method="post"> ' ."\n".  	
									' <div class="panel panel-default"> '."\n".  		
										'<div class="panel-heading"> '."\n".
											'<div class="pull-left"> '."\n".  
												'<a href="index.php?i='.$arr_the_recs_detailed[$idx]['id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['pos_title']." @ ".$arr_the_recs_detailed[$idx]['company_name'].'</a>
											</div>
											<div class="pull-right">'.$arr_the_recs_detailed[$idx]['moddt'].'</div>
											<div class="clearfix"></div>
										</div>
										<div class="panel-body">
											 <table style="border-spacing: 10px; border-collapse: separate;">
												<tr>
													<td style="width:20px; text-align:right;">
														<b>Apply Date:</b>
													</td>
													<td>'.$arr_the_recs_detailed[$idx]['applydt'].'</td>
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
													<td>
														<a href="companies.php?c='.$arr_the_recs_detailed[$idx]['comp_id'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['company_name'].'</a>
													</td>
												</tr>'.$part_3a.'<tr>
													<td style="width:20px; text-align:right;">
														<b>Description:</b>
													</td>
													<td>'.$arr_the_recs_detailed[$idx]['pos_desc'].'
													</td>
												</tr>												
											 </table> 
												<input type="hidden" name="up_id" id="up_id" value="'.$arr_the_recs_detailed[$idx]['up_id'].'">
												<input type="hidden" name="pos_title" id="pos_title" value="'.$arr_the_recs_detailed[$idx]['pos_title'].'">
												<input type="hidden" name="company_name_x" id="company_name_x" value="'.$arr_the_recs_detailed[$idx]['company_name'].'">
												<input type="hidden" name="pos_id" id="pos_id" value="'.$arr_the_recs_detailed[$idx]['id'].'">
												<input type="hidden" name="comp_id" id="comp_id" value="'.$arr_the_recs_detailed[$idx]['comp_id'].'">
												<div class="pull-left">													
												</div>										 
												<div class="pull-right">
													<a class="btn btn-primary pull-right" onClick="NotToShowAppliedPosition('.$arr_the_recs_detailed[$idx]['up_id'].' , \''.$arr_the_recs_detailed[$idx]['pos_title'].' @ '.$arr_the_recs_detailed[$idx]['company_name'].'\');" style="border-radius: 24px;">Not To Show</a>													
												</div>
												<div class="clearfix"></div>
										</div>
									</div>
								</form>'."\n";
	 
				} // for							
								
			$part_4 = '</div> 
						</div>
							</div>'."\n";

			$prev_page = $the_curr_page-1;
			$next_page = $the_curr_page+1;
						  
			$part_5 = '<ul class="pager">' ."\n" .
						 ' <li class="previous"><a href="javascript:void(0);" onclick="getRecommendedPositionsAjax('.$prev_page.');">Previous</a></li>' ."\n" .
						  '<li style="text-align:center"><a href="javascript:void(0);">'.$the_curr_page.'</a></li>' ."\n" .
						  '<li class="next"><a href="javascript:void(0);" onclick="getRecommendedPositionsAjax('.$next_page.');" >Next</a></li>' ."\n" .
						'</ul>'."\n";
					

			$the_reply = $part_1 . $part_2 . $part_3 . $part_4 . $part_5;
						
			echo  json_encode(array("val_1" =>  $the_reply, "val_2" => sizeof($arr_the_recs_detailed)));
		
		}
		else
		{			
			echo  json_encode(array("val_1" =>  "<br/>No Applied Positions Yet...", "val_2" => 0));
		}
		 
	}	
	else
	{
		echo  json_encode(array("val_1" =>  "Error!", "val_2" => 0));
	}

?>