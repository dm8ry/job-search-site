<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_SESSION['logged_in_email']) && isset($_SESSION['logged_in_userid'])  && isset($_POST['sma_id']) )
	{
	
		$logged_in_email = $_SESSION['logged_in_email'];
		$logged_user_id  = $_SESSION['logged_in_userid'];
		$sma_id = $_POST['sma_id'];
	
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");
					
		$sql_smart_agents = "select sa.*, DATE_FORMAT(sa.modify_dt,'%d/%m/%Y %H:%i:%s') the_dt, DATE_FORMAT(sa.last_run,'%d/%m/%Y %H:%i:%s') the_last_run_dt
				from smart_agent sa
				where sa.id = ".$sma_id;

		$arr_smart_agents = array();		
		$results_smart_agents = mysqli_query($conn, $sql_smart_agents); 	
			
		while($line = mysqli_fetch_assoc($results_smart_agents)){
			$arr_smart_agents[] = $line;
		}
								
		$conn->close();			
		
		echo  json_encode(
						array(
								"val_1" => $arr_smart_agents[0]['id'], 
								"val_2" => $arr_smart_agents[0]['p1_recent_days'], 
								"val_3" => $arr_smart_agents[0]['p2_region_city'], 
								"val_4" => $arr_smart_agents[0]['p3_category'], 
								"val_5" => $arr_smart_agents[0]['p4_sub_category'], 
								"val_6" => $arr_smart_agents[0]['p5_contains_txt']
							  )
						);
		 
	}	
	else
	{
		echo json_encode(array("val_1" => $repl_txt, "val_2" => sizeof($arr_smart_agents))); 
	}

?>