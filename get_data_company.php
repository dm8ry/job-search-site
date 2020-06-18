<?php session_start(); 

	include_once('inc/db_connect.php');
	include_once('admin_email.php');
	
	mb_internal_encoding("UTF-8");		

	if ( isset($_POST['comp_id']) )
	{
	
		$comp_id = $_POST['comp_id'];
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");
		
		$sql = "select *
				from company  
				where id = ".$comp_id;
 
		$arr_the_recs_detailed = array();		
		$results_the_recs_detailed = mysqli_query($conn, $sql); 	
		
		if ($results_the_recs_detailed->num_rows == 1)
		{
			
			while($line = mysqli_fetch_assoc($results_the_recs_detailed)){
				$arr_the_recs_detailed[] = $line;
			}

			echo  json_encode(array(
									"val_0" =>  $arr_the_recs_detailed[0]['id'], 
									"val_1" =>  $arr_the_recs_detailed[0]['the_name'], 
									"val_2" =>  $arr_the_recs_detailed[0]['placement_id'],
									"val_3" =>  $arr_the_recs_detailed[0]['the_descrip'],
									"val_4" =>  $arr_the_recs_detailed[0]['the_descrip_heb'],
									"val_5" =>  $arr_the_recs_detailed[0]['address'],
									"val_6" =>  $arr_the_recs_detailed[0]['address_heb'],
									"val_7" =>  $arr_the_recs_detailed[0]['phone_1'],
									"val_8" =>  $arr_the_recs_detailed[0]['fax_1'],
									"val_9" =>  $arr_the_recs_detailed[0]['email_1'],
									"val_10" =>  $arr_the_recs_detailed[0]['website'],
									"val_11" =>  $arr_the_recs_detailed[0]['industry'],
									"val_12" =>  $arr_the_recs_detailed[0]['c_type'],
									"val_13" =>  $arr_the_recs_detailed[0]['num_people'],
									"val_14" =>  $arr_the_recs_detailed[0]['founded']									
									));			
		
		}
		else
		{
			echo  json_encode(array(
									"val_0" =>  "-999",
									"val_1" =>  "", 
									"val_2" => -1,
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
									"val_14" => ""
									));
		}
		
	}
	
?>