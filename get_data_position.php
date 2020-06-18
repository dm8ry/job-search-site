<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		
	
	if ( isset($_POST['pos_id']) )
	{
	
		$pos_id = $_POST['pos_id'];
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");
		
		$sql = "select *
				from positions   
				where id = ".$pos_id;
 
		$arr_the_recs_detailed = array();		
		$results_the_recs_detailed = mysqli_query($conn, $sql); 	
		
		if ($results_the_recs_detailed->num_rows == 1)
		{
			
			while($line = mysqli_fetch_assoc($results_the_recs_detailed)){
				$arr_the_recs_detailed[] = $line;
			}

			echo  json_encode(array(
									"val_0" =>  $arr_the_recs_detailed[0]['pos_title'], 
									"val_1" =>  $arr_the_recs_detailed[0]['pos_title_heb'], 
									"val_2" =>  $arr_the_recs_detailed[0]['company_id'],
									"val_3" =>  $arr_the_recs_detailed[0]['job_type'],								
									"val_4" =>  $arr_the_recs_detailed[0]['pos_desc'],
									"val_5" =>  $arr_the_recs_detailed[0]['pos_desc_heb'],
									"val_6" =>  $arr_the_recs_detailed[0]['pos_cat'],
									"val_7" =>  $arr_the_recs_detailed[0]['pos_sub_cat'],
									"val_8" =>  $arr_the_recs_detailed[0]['pos_cat_2'],
									"val_9" =>  $arr_the_recs_detailed[0]['pos_sub_cat_2'],
									"val_10" =>  $arr_the_recs_detailed[0]['pos_cat_3'],
									"val_11" =>  $arr_the_recs_detailed[0]['pos_sub_cat_3'],
									"val_12" =>  $arr_the_recs_detailed[0]['pos_cat_4'],
									"val_13" =>  $arr_the_recs_detailed[0]['pos_sub_cat_4'],
									"val_14" =>  $arr_the_recs_detailed[0]['pos_cat_5'],
									"val_15" =>  $arr_the_recs_detailed[0]['pos_sub_cat_5'],
									"val_16" =>  $arr_the_recs_detailed[0]['pos_contact_email'],
									"val_17" =>  $arr_the_recs_detailed[0]['pos_notes'],
									"val_18" =>  $arr_the_recs_detailed[0]['pos_status'],
									"val_19" =>  $arr_the_recs_detailed[0]['pos_autoupd']
									));			
		
		}
		else
		{
			echo  json_encode(array(
									"val_0" =>  "",
									"val_1" =>  "", 
									"val_2" => "",
									"val_3" => "",
									"val_4" => "",
									"val_5" => "",
									"val_6" => "",
									"val_7" => "",
									"val_8" => "",
									"val_9" => "",
									"val_10" => "",
									"val_11" => "",
									"val_12" => "",
									"val_13" => "",
									"val_14" => "",
									"val_15" => "",
									"val_16" => "",
									"val_17" => "",
									"val_18" => "",
									"val_19" => ""
									));
		}
		
	}
	
?>