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
		
		$sql_max_smagents_per_user = "select prop_value from app_properties where prop_name = 'max_smagents_per_user' ";
									
		$arr_max_smagents_per_user = array();		
		$results_smagents_per_user = mysqli_query($conn, $sql_max_smagents_per_user); 	
		
		while($line = mysqli_fetch_assoc($results_smagents_per_user)){
			$arr_max_smagents_per_user[] = $line;
		}		
					
		$sql_smart_agents = "select sa.*, 
									DATE_FORMAT(sa.modify_dt,'%d/%m/%Y %H:%i:%s') the_dt, 
									DATE_FORMAT(sa.last_run,'%d/%m/%Y %H:%i:%s') the_last_run_dt,
									ca.cat_name,
									sca.subcat_name
				from smart_agent sa 
					left outer join category ca on ca.id = sa.p3_category
					left outer join sub_category sca on sca.id = sa.p4_sub_category
				where sa.user_id = ".$logged_user_id." 
				order by sa.modify_dt desc";

		$arr_smart_agents = array();		
		$results_smart_agents = mysqli_query($conn, $sql_smart_agents); 	
			
		while($line = mysqli_fetch_assoc($results_smart_agents)){
			$arr_smart_agents[] = $line;
		}
								
		$conn->close();			
		
		$show_add_smagent_btn='';
		if (sizeof($arr_smart_agents) < $arr_max_smagents_per_user[0]['prop_value']) 
		{ 
			$show_add_smagent_btn='<button type="button" class="btn btn-default" onClick="addSmartAgent();">Add...</button>';
		}		
		
		$repl_txt_1 = '';
		
		$repl_txt_1 = '<table class="table table-striped">' ."\n" .
					'<thead>' ."\n" .
					'<tr>' ."\n" .
					'<th></th>' ."\n" .
					'<th>Description</th>' ."\n" .
					'<th>Last Modified</th>' ."\n" .
					'<th>Last Run</th>' ."\n" .
					//'<th>Status</th>' ."\n" .
					'<th colspan="2">'.$show_add_smagent_btn.'</th>' ."\n" .
					'</tr>' ."\n" .
					'</thead>' ."\n" .
					'<tbody>' ."\n";
					
		$repl_txt_2 = '';
		
		for($idx=0; $idx<sizeof($arr_smart_agents); $idx++)
		{
			$descr = 'Get all positions that ';
			
			if ($arr_smart_agents[$idx]['p1_recent_days'] != '') 
			{
				$descr = $descr. 'created or modified recent <i>'.$arr_smart_agents[$idx]['p1_recent_days']."</i> days";
			}
	
			if ($arr_smart_agents[$idx]['p2_region_city'] != -1) 
			{
				$descr = $descr. ', from <i>'.$arr_smart_agents[$idx]['p2_region_city']."</i> city/region";
			}
			
	
			if ($arr_smart_agents[$idx]['p3_category'] != -1) 
			{
				$descr = $descr. ', from <i>'.$arr_smart_agents[$idx]['cat_name']."</i> category";
			}

			if ($arr_smart_agents[$idx]['p4_sub_category'] != -1) 
			{
				$descr = $descr. ', from <i>'.$arr_smart_agents[$idx]['subcat_name']."</i> sub-category";
			}			
			
			if ($arr_smart_agents[$idx]['p5_contains_txt'] != '') 
			{
				$descr = $descr. ' and containing text <i>'.$arr_smart_agents[$idx]['p5_contains_txt']."</i>.";
			}			
			
			$the_status = '';
			
			if ($arr_smart_agents[$idx]['status'] == 1) 
			{ 
				$the_status = 'Active'; 
			} 
			else 
			{ 
				$the_status = 'Non-Active'; 
			}
			
			 $repl_txt_2 = $repl_txt_2 . '<tr>'."\n" ;
			 $repl_txt_2 = $repl_txt_2 . '<td style="vertical-align:middle"><img title="'.strip_tags($descr).'" src="images/smart_agent_img7.png" border="0"></td>'."\n" ;
			 $repl_txt_2 = $repl_txt_2 . '<td style="vertical-align:middle">'.$descr.'</td>'."\n" ;
			 $repl_txt_2 = $repl_txt_2 . '<td style="vertical-align:middle">'.$arr_smart_agents[$idx]['the_dt'].'</td>'."\n";
			 $repl_txt_2 = $repl_txt_2 . '<td style="vertical-align:middle">'.$arr_smart_agents[$idx]['the_last_run_dt'].'</td>'."\n";
			 //$repl_txt_2 = $repl_txt_2 . '<td style="vertical-align:middle">'.$the_status.'</td>'."\n";
			 $repl_txt_2 = $repl_txt_2 . '<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="editSmartAgent('.$arr_smart_agents[$idx]['id'].');">Edit...</button></td>'."\n";
			 $repl_txt_2 = $repl_txt_2 . '<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="deleteSmartAgent('.$arr_smart_agents[$idx]['id'].');">Delete...</button></td>'."\n";
			 $repl_txt_2 = $repl_txt_2 . '</tr>	'."\n";						
		}
			
		$repl_txt_3 = '';
		$repl_txt_3 = '</tbody>
						</table>'."\n";
		
		$repl_txt = $repl_txt_1 . $repl_txt_2 . $repl_txt_3;
				
		echo  json_encode(array("val_1" => $repl_txt, "val_2" => sizeof($arr_smart_agents)));
		 
	}	
	else
	{
		echo 'Error!!!';
	}

?>