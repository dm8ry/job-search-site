<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_POST['company_id']) && isset($_SESSION['princ_email']) && isset($_SESSION['princ_id']) )
	{
		
		$princ_id = $_SESSION['princ_id'];
		$princ_email = $_SESSION['princ_email'];
		$the_curr_page = 1;
		$recs_per_page = 5;	
		$company_id = $_POST['company_id'];
	
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");
		
		$sql0 = "select 
						count(1) n_of_recs 
				from 
					company co, 
					city ci,
					principal_company_link pcl 
				where 
					co.placement_id = ci.id 
				and 
					co.status in ('1', '2')
				and 
					pcl.comp_id = co.id 
				and
					co.id = ".$company_id."
				and 
					pcl.princ_id = ".$princ_id;
 
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
						co.the_name, 
						ci.name_en 
						locatio, 
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
						co.founded ,
						co.status
					from 
						company co, 
						city ci,
						principal_company_link pcl 
					where 
						co.placement_id = ci.id 
					and 
						co.id = ".$company_id."
					and
						co.status in ( '1', '2')
					and 
						pcl.comp_id = co.id 
					and pcl.princ_id = ".$princ_id." order by co.modifydt desc
					limit ".($the_curr_page - 1) * $recs_per_page.", ".$recs_per_page." ";
	 
			$arr_the_recs_detailed = array();		
			$results_recent_activities = mysqli_query($conn, $sql); 	
			
			while($line = mysqli_fetch_assoc($results_recent_activities)){
				$arr_the_recs_detailed[] = $line;
			}			
				
			$conn->close();			
										
					 
			$part_1 = '<br/>						
							<div class="container"> 
							
								<div class="pull-left">
									A List Of Your Companies
								</div>									
								<div
								class="pull-right">									
									<a class="btn btn-primary" onclick="addPrincipalCompanyForm();" style="border-radius: 24px;">Add Your Company...</a>								
									&nbsp;&nbsp;
									<a class="btn btn-primary" onclick="searchPrincipalCompanyForm();" style="border-radius: 24px;">Search Company...</a>																		
								</div>
								<div class="clearfix"></div>

								<br/>
								
								<div class="row">	
									<div class="col-md-12">';
		
			$part_2 = "";
			
			
				for($idx=0; $idx<sizeof($arr_the_recs_detailed); $idx++)
				{
			
			
					$the_description = '';
					
					if ($arr_the_recs_detailed[$idx]['the_descrip'] == '')
					{
						 
						$the_description = '<tr>
												<td style="width:20px; text-align:right;">
													<b>Description:</b>
												</td>
												<td dir="rtl">'.$arr_the_recs_detailed[$idx]['the_descrip_heb'].'</td>
											</tr>';					
						
					}
					else
					{

						$the_description = '<tr>
												<td style="width:20px; text-align:right;">
													<b>Description:</b>
												</td>
												<td>'.$arr_the_recs_detailed[$idx]['the_descrip'].'</td>
											</tr>';
					}	


					$the_address = '';

					if ($arr_the_recs_detailed[$idx]['address'] != '')
					{
						$the_address = '<tr>
											<td style="width:20px; text-align:right;">
												<b>Address:</b>
											</td>
											<td>'.$arr_the_recs_detailed[$idx]['address'].'</td>
										</tr>';
					}				
					elseif ($arr_companies[$idx]['address_heb'] != '')
					{
						$the_address =  '<tr>
											<td style="width:20px; text-align:right;">
												<b>Address:</b>
											</td>
											<td dir="rtl">'.$arr_the_recs_detailed[$idx]['address_heb'].'</td>
										</tr>';
					}	


					$the_industry = '';

					if ($arr_the_recs_detailed[$idx]['industry'] != '' && $arr_the_recs_detailed[$idx]['industry'] != '0')
					{
						$the_industry = '<tr>
											<td style="width:20px; text-align:right;">
												<b>Industry:</b>
											</td>
											<td>'.$arr_the_recs_detailed[$idx]['industry'].'</td>
										</tr>';																				
					}	

					$the_c_type = '';

					if ($arr_the_recs_detailed[$idx]['c_type'] != '' && $arr_the_recs_detailed[$idx]['c_type'] != '0')
					{
						$the_c_type = '<tr>
											<td style="width:20px; text-align:right;">
												<b>Type:</b>
											</td>
											<td>'.$arr_the_recs_detailed[$idx]['c_type'].'</td>
										</tr>';																				
					}
					
					$the_founded = '';

					if ($arr_the_recs_detailed[$idx]['founded'] != '' && $arr_the_recs_detailed[$idx]['founded'] != '0')
					{
						$the_founded = '<tr>
											<td style="width:20px; text-align:right;">
												<b>Founded:</b>
											</td>
											<td>'.$arr_the_recs_detailed[$idx]['founded'].'</td>
										</tr>';																				
					}									
	
					$the_comp_size = '';

					if ($arr_the_recs_detailed[$idx]['num_people'] != '' && $arr_the_recs_detailed[$idx]['num_people'] != '0')
					{
						$the_comp_size = '<tr>
											<td style="width:20px; text-align:right;">
												<b>Company Size:</b>
											</td>
											<td>'.$arr_the_recs_detailed[$idx]['num_people'].'</td>
										</tr>';																				
					}

					$is_waiting_approval = '';

					if ($arr_the_recs_detailed[$idx]['status'] == '2')
					{
						$is_waiting_approval = '<span style="color: red"> <i>- waiting for approval</i></span>';																				
					}					
			
					$part_2 = $part_2 .
							'<div class="panel panel-default">
							  <div class="panel-heading">
								<div class="pull-left" style="font-size:22px;"> 
									<a href="companies.php?c='.$arr_the_recs_detailed[$idx]['id'].'" target="_blank" >'.$arr_the_recs_detailed[$idx]['the_name'].'</a> '.$is_waiting_approval.'
								</div>
								<div class="pull-right"> 
									<a class="btn btn-primary pull-right" onclick="editPrincipalCompanyForm('.$arr_the_recs_detailed[$idx]['id'].');" style="border-radius: 24px;">Edit...</a>
								</div>
								<div class="clearfix"></div>								
							  </div>
								<div class="panel-body">
									<table style="border-spacing: 10px; border-collapse: separate;">
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Company:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['the_name'].'</td>
									</tr>
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Location:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['locatio'].'</td>
									</tr>'.$the_description.' '.$the_industry.' '.$the_c_type.' '.$the_founded.' '.$the_comp_size.'	
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Website:</b>
										</td>
										<td>
											<a href="'.$arr_the_recs_detailed[$idx]['website'].'" target="_blank">'.$arr_the_recs_detailed[$idx]['website'].'</a>
										</td>
									</tr>'.$the_address.'
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Phone:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['phone_1'].'</td>
									</tr>						
									<tr>
										<td style="width:20px; text-align:right;">
											<b>Fax:</b>
										</td>
										<td>'.$arr_the_recs_detailed[$idx]['fax_1'].'</td>
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
						  '<li style="text-align:center"><a href="javascript:void(0);" onclick="getPrincipalCompaniesAjax(1);">Show All My Companies</a></li>' ."\n" .					
						'</ul>
						</div>'."\n";
					

			$the_reply = $part_1 . $part_2 . $part_3 . $part_4 ;
									
			echo json_encode(array("val_1" =>  $the_reply, "val_2" => $tot_n_of_recs));
		
		}
		else
		{		
		
			$the_reply = '<br/> 
							<div class="container"> 
							
								<div class="pull-left">
									No Companies Yet...
								</div>									
								<div class="pull-right">
									<a class="btn btn-primary pull-right" onclick="addPrincipalCompanyForm();" style="border-radius: 24px;">Add Your Company</a>
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