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

		$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
		$cur_dt =  $date->format('d-m-Y H:i:s');  
		$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()		
		
		$sql_generate_recommended_positions = "insert into user_positions (user_id, pos_id, res_id, modify_dt, status)
								select  sa.user_id, p.id, null, '$db_cur_dt' , 'R'
								from positions p, company co, city ci, smart_agent sa
								where p.pos_status = '1'
								and co.id = p.company_id
								and co.placement_id = ci.id
								and sa.user_id = $logged_user_id 
								and sa.status = '1'
								and (p.modifydt >= now() + interval 10 hour - interval sa.p1_recent_days  day)
								and ((-1 = sa.p2_region_city) or (ci.name_en = sa.p2_region_city) or (ci.region_en = sa.p2_region_city))
								and ((-1 = sa.p3_category) or (p.pos_cat = sa.p3_category))
								and ((-1 = sa.p4_sub_category) or (p.pos_sub_cat = sa.p4_sub_category))							
								and (sa.p5_contains_txt is null or INSTR(p.pos_desc, p5_contains_txt ) >0)
								and p.id not in (select pos_id from user_positions where user_id = $logged_user_id)
								order by p.modifydt desc";
 
		mysqli_query($conn, $sql_generate_recommended_positions); 

		$sql_generate_recommended_positions = "insert into user_positions (user_id, pos_id, res_id, modify_dt, status)
								select  sa.user_id, p.id, null, '$db_cur_dt' , 'R'
								from positions p, company co, city ci, smart_agent sa
								where p.pos_status = '1'
								and co.id = p.company_id
								and co.placement_id = ci.id
								and sa.user_id = $logged_user_id 
								and sa.status = '1'
								and (p.modifydt >= now() + interval 10 hour - interval sa.p1_recent_days  day)
								and ((-1 = sa.p2_region_city) or (ci.name_en = sa.p2_region_city) or (ci.region_en = sa.p2_region_city))
								and ((-1 = sa.p3_category) or (p.pos_cat_2 = sa.p3_category))
								and ((-1 = sa.p4_sub_category) or (p.pos_sub_cat_2 = sa.p4_sub_category))							
								and (sa.p5_contains_txt is null or INSTR(p.pos_desc, p5_contains_txt ) >0)
								and p.id not in (select pos_id from user_positions where user_id = $logged_user_id)
								order by p.modifydt desc";
 
		mysqli_query($conn, $sql_generate_recommended_positions);

		$sql_generate_recommended_positions = "insert into user_positions (user_id, pos_id, res_id, modify_dt, status)
								select  sa.user_id, p.id, null, '$db_cur_dt' , 'R'
								from positions p, company co, city ci, smart_agent sa
								where p.pos_status = '1'
								and co.id = p.company_id
								and co.placement_id = ci.id
								and sa.user_id = $logged_user_id 
								and sa.status = '1'
								and (p.modifydt >= now() + interval 10 hour - interval sa.p1_recent_days  day)
								and ((-1 = sa.p2_region_city) or (ci.name_en = sa.p2_region_city) or (ci.region_en = sa.p2_region_city))
								and ((-1 = sa.p3_category) or (p.pos_cat_3 = sa.p3_category))
								and ((-1 = sa.p4_sub_category) or (p.pos_sub_cat_3 = sa.p4_sub_category))							
								and (sa.p5_contains_txt is null or INSTR(p.pos_desc, p5_contains_txt ) >0)
								and p.id not in (select pos_id from user_positions where user_id = $logged_user_id)
								order by p.modifydt desc";
 
		mysqli_query($conn, $sql_generate_recommended_positions);		
		
		$sql_generate_recommended_positions = "insert into user_positions (user_id, pos_id, res_id, modify_dt, status)
								select  sa.user_id, p.id, null, '$db_cur_dt' , 'R'
								from positions p, company co, city ci, smart_agent sa
								where p.pos_status = '1'
								and co.id = p.company_id
								and co.placement_id = ci.id
								and sa.user_id = $logged_user_id 
								and sa.status = '1'
								and (p.modifydt >= now() + interval 10 hour - interval sa.p1_recent_days  day)
								and ((-1 = sa.p2_region_city) or (ci.name_en = sa.p2_region_city) or (ci.region_en = sa.p2_region_city))
								and ((-1 = sa.p3_category) or (p.pos_cat_4 = sa.p3_category))
								and ((-1 = sa.p4_sub_category) or (p.pos_sub_cat_4 = sa.p4_sub_category))							
								and (sa.p5_contains_txt is null or INSTR(p.pos_desc, p5_contains_txt ) >0)
								and p.id not in (select pos_id from user_positions where user_id = $logged_user_id)
								order by p.modifydt desc";
 
		mysqli_query($conn, $sql_generate_recommended_positions);		
		
		$sql_generate_recommended_positions = "insert into user_positions (user_id, pos_id, res_id, modify_dt, status)
								select  sa.user_id, p.id, null, '$db_cur_dt' , 'R'
								from positions p, company co, city ci, smart_agent sa
								where p.pos_status = '1'
								and co.id = p.company_id
								and co.placement_id = ci.id
								and sa.user_id = $logged_user_id 
								and sa.status = '1'
								and (p.modifydt >= now() + interval 10 hour - interval sa.p1_recent_days  day)
								and ((-1 = sa.p2_region_city) or (ci.name_en = sa.p2_region_city) or (ci.region_en = sa.p2_region_city))
								and ((-1 = sa.p3_category) or (p.pos_cat_5 = sa.p3_category))
								and ((-1 = sa.p4_sub_category) or (p.pos_sub_cat_5 = sa.p4_sub_category))							
								and (sa.p5_contains_txt is null or INSTR(p.pos_desc, p5_contains_txt ) >0)
								and p.id not in (select pos_id from user_positions where user_id = $logged_user_id)
								order by p.modifydt desc";
 
		mysqli_query($conn, $sql_generate_recommended_positions);		
		
		$sql_generate_recommended_positions2 = "update smart_agent set last_run ='$db_cur_dt' where status = '1' and user_id =  $logged_user_id ";
 
		mysqli_query($conn, $sql_generate_recommended_positions2);
		
		$conn->close();			
							
		// echo  'Ok';
		 
	}	
	else
	{
		echo 'Error!!!';
	}

?>