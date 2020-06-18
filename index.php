<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php

	// some reCaptcha :)
	$a = rand(3, 17);
	$b = rand(9, 23);
  
	// position id
	//
	if (!$_GET["i"]) 
	{
		$i = -1;
	}
	else
	{				
		$i = intval($_GET['i']);
						
		if (round($i, 0) == $i)
		{							 
			if ($i <= 0) 
			{
				$i = -1;
			}
			else
			{
				// Ok			 
			}
		}
		else
		{				
			$i = -1;
		}
	}	

	
	// ca - cat
	//
	if (!$_GET["ca"]) 
	{
		$ca = -1;
	}
	else
	{				
		$ca = intval($_GET['ca']);
						
		if (round($ca, 0) == $ca)
		{							 
			if ($ca <= 0) 
			{
				$ca = -1;
			}
			else
			{
				// Ok			 
			}
		}
		else
		{				
			$ca = -1;
		}
	}		
	
	
	
	// co -company
	//
	if (!$_GET["co"]) 
	{
		$co = -1;
	}
	else
	{				
		$co = intval($_GET['co']);
						
		if (round($co, 0) == $co)
		{							 
			if ($co <= 0) 
			{
				$co = -1;
			}
			else
			{
				// Ok			 
			}
		}
		else
		{				
			$co = -1;
		}
	}
	
	// sc -subcat
	//
	if (!$_GET["sc"]) 
	{
		$sc = -1;
	}
	else
	{				
		$sc = intval($_GET['sc']);
						
		if (round($sc, 0) == $sc)
		{							 
			if ($sc <= 0) 
			{
				$sc = -1;
			}
			else
			{
				// Ok			 
			}
		}
		else
		{				
			$sc = -1;
		}
	}		
	
	// city
	//
	
	if (!$_GET["c"]) 
	{
		$c = -1;
	}
	else
	{				
		$c = $_GET['c'];
		$c = str_replace("\'", "", $c);
		$c = str_replace("\"", "", $c);
		$c = str_replace("&", "", $c);
		$c = str_replace("!", "", $c);
		$c = str_replace(":", "", $c);
		$c = str_replace("\\", "", $c);
	}
	
	// search
	//
	if (!$_GET["s"]) 
	{
		$s = "";
	}
	else
	{				
		$s = $_GET['s'];
		
		$s = str_replace("\'", "", $s);
		$s = str_replace("'", "", $s);
		$s = str_replace("\"", "", $s);
		$s = str_replace("&", "", $s);
		$s = str_replace("!", "", $s);
		$s = str_replace(":", "", $s);
		$s = str_replace("\\", "", $s);		
		$s = str_replace("%", "", $s);	
		$s = str_replace(";", "", $s);
		$s = str_replace("(", "", $s);
		$s = str_replace(")", "", $s);
						
		if (strlen($s) > 20)
		{							 
			$s = "";
		}
		else
		{				
			// Ok
		}
	}		
	
	// page number
	//
	if (!$_GET["p"]) 
	{
		$p = 1;
	}
	else
	{				
		$p = intval($_GET['p']);
						
		if (round($p, 0) == $p)
		{							 
			if ($p <= 0) 
			{
				$p = 1;
			}
			else
			{
				// Ok			 
			}
		}
		else
		{				
			$p = 1;
		}
	}	

	// conn db parameters
	require_once('inc/db_connect.php');
	
	// conn functions
	require_once('functions/functions.php');
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$conn->query("set names 'utf8'");	
	
	refreshRelevantPositions($conn);
	$small_footer = getFooter($conn);
	$items_on_this_page = getItemsOnPage($conn, 'INDEX');
	$to_show_empty_categories = checkIfToShowItemsWithEmptyCategories($conn);
	$positions_font_size = getPositionItemsFontSize($conn);
	$resultArr = isPositionsItemsTitleBold($conn);
	$to_put_b = $resultArr[0]['value'];
	$to_put_b2 = $resultArr[1]['value'];
	$arr_trending_jobs = getTrandingJobs($conn, 12);
	$arr_top_by_views_jobs = getTopByViewsJobs($conn, 12);
	$arr_top_companies_by_views = getTopCompaniesByViews($conn, 12);
	$positions_background_color = getPositionItemsBackgroundColor($conn);
	$positions_header_background_color = getPositionItemsHeaderBackgroundColor($conn);
	$arr_regions = getRegionsEnglish($conn);
		
	$num_posts_per_page  = $items_on_this_page;
	$start_position = ($p - 1) * $num_posts_per_page;
	$num_recs_to_retrieve = $num_posts_per_page;	
	
	$sql_cities = "select name_en, id from city where status='1' order by 1";
								
	$arr_cities = array();		
	$results_cities = mysqli_query($conn, $sql_cities); 	
	
	while($line = mysqli_fetch_assoc($results_cities)){
		$arr_cities[] = $line;
	}		
	
	// update n of views for this position
	if ($i != -1)
	{
	
		$sql_u = "update positions set nviews=nviews+1 where id=".$i;
		$conn->query($sql_u);
			
	}
	
	$sql_positions_total = "select 	count(1) total_cnt
					from positions p, company co, city ci						
					where p.company_id=co.id
					and ci.id = co.placement_id
					and p.pos_status = '1'
					and co.status = '1'
					and ((ci.id = '".$c."') or ('".$c."' = -1) or ('".$c."' = ci.region_en) or ('".$c."' = ci.region_heb) )
					and ((p.id = ".$i.") or (".$i." = -1))
					and ((co.id = ".$co.") or (".$co." = -1))
					and ((p.pos_sub_cat = ".$sc.") or (p.pos_sub_cat_2 = ".$sc.") or (p.pos_sub_cat_3 = ".$sc.") or (p.pos_sub_cat_4 = ".$sc.") or (p.pos_sub_cat_5 = ".$sc.") or (".$sc." = -1))
					and ((p.pos_cat = ".$ca.") or (p.pos_cat_2 = ".$ca.") or (p.pos_cat_3 = ".$ca.") or (p.pos_cat_4 = ".$ca.") or (p.pos_cat_5 = ".$ca.") or (".$ca." = -1))
					and ((upper(p.pos_desc) like upper('%".$s."%')) or (upper(p.pos_title) like upper('%".$s."%')) or (upper(co.the_name) like upper('%".$s."%')))";
					
	$arr_positions_total = array();
	$results_positions_total = mysqli_query($conn, $sql_positions_total); 

	while($line = mysqli_fetch_assoc($results_positions_total)){
		$arr_positions_total[] = $line;
	}		
	
	$recs_total_cnt = $arr_positions_total[0]['total_cnt'];
	
	$num_of_pages = ceil($recs_total_cnt / $num_posts_per_page);	
		
	if (!$_SESSION['logged_in_email']) 
	{

		$sql_positions = "select 	p.id, 
							DATE_FORMAT(p.modifydt,'%d/%m/%Y') moddt, 
							p.pos_title, 
							co.the_name company_name, 
							ci.name_en locatio, 
							ci.id locatio_id, 
							p.pos_desc,
							co.id comp_id,
							'N' up_status,
							p.job_type,
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
						from positions p, company co, city ci 
						where p.company_id=co.id
						and ci.id = co.placement_id
						and p.pos_status = '1'
						and co.status = '1'
						and ((ci.id = '".$c."') or ('".$c."' = -1) or ('".$c."' = ci.region_en) or ('".$c."' = ci.region_heb) )
						and ((p.id = ".$i.") or (".$i." = -1))
						and ((co.id = ".$co.") or (".$co." = -1))
						and ((p.pos_sub_cat = ".$sc.") or (p.pos_sub_cat_2 = ".$sc.") or (p.pos_sub_cat_3 = ".$sc.") or (p.pos_sub_cat_4 = ".$sc.") or (p.pos_sub_cat_5 = ".$sc.") or (".$sc." = -1))
						and ((p.pos_cat = ".$ca.") or (p.pos_cat_2 = ".$ca.") or (p.pos_cat_3 = ".$ca.") or (p.pos_cat_4 = ".$ca.") or (p.pos_cat_5 = ".$ca.") or (".$ca." = -1))
						and ((upper(p.pos_desc) like upper('%".$s."%')) or (upper(p.pos_title) like upper('%".$s."%')) or (upper(co.the_name) like upper('%".$s."%')))
						order by p.modifydt desc, p.id desc limit ".$start_position.",".$num_recs_to_retrieve;			
	
	}	
	else
	{
	
		$sql_positions = "select 	p.id, 
							DATE_FORMAT(p.modifydt,'%d/%m/%Y') moddt, 
							p.pos_title, 
							co.the_name company_name, 
							ci.name_en locatio, 
							ci.id locatio_id,
							p.pos_desc,
							co.id comp_id,
							ifnull( (select status from user_positions up where up.pos_id = p.id and up.user_id = ".$_SESSION['logged_in_userid']." ), 'N') up_status,
							p.job_type,
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
						from positions p, company co, city ci 						
						where p.company_id=co.id
						and ci.id = co.placement_id
						and p.pos_status = '1'
						and co.status = '1'
						and ((ci.id = '".$c."') or ('".$c."' = -1) or ('".$c."' = ci.region_en) or ('".$c."' = ci.region_heb)  )
						and ((p.id = ".$i.") or (".$i." = -1))
						and ((co.id = ".$co.") or (".$co." = -1))
						and ((p.pos_sub_cat = ".$sc.") or (p.pos_sub_cat_2 = ".$sc.") or (p.pos_sub_cat_3 = ".$sc.") or (p.pos_sub_cat_4 = ".$sc.") or (p.pos_sub_cat_5 = ".$sc.") or (".$sc." = -1))
						and ((p.pos_cat = ".$ca.") or (p.pos_cat_2 = ".$ca.") or (p.pos_cat_3 = ".$ca.") or (p.pos_cat_4 = ".$ca.") or (p.pos_cat_5 = ".$ca.") or (".$ca." = -1))
						and ((upper(p.pos_desc) like upper('%".$s."%')) or (upper(p.pos_title) like upper('%".$s."%')) or (upper(co.the_name) like upper('%".$s."%')))
						order by p.modifydt desc, p.id desc limit ".$start_position.",".$num_recs_to_retrieve;	
	
	}
					
	$arr_positions = array();		
	$results_positions = mysqli_query($conn, $sql_positions); 

	if ($results_positions->num_rows == 0)
	{
	 	
		//$p = 1;
		
		if ($p > 1) 
		{
			$p = $p - 1;
		}
		
		$start_position = ($p - 1) * $num_posts_per_page;
		$num_recs_to_retrieve = $num_posts_per_page;
			
		if (!$_SESSION['logged_in_email']) 
		{			
		
			$sql_positions = "select 	p.id, 
								DATE_FORMAT(p.modifydt,'%d/%m/%Y') moddt, 
								p.pos_title, 
								co.the_name company_name, 
								ci.name_en locatio, 
								ci.id locatio_id,
								p.pos_desc,
								co.id comp_id,
								'N' up_status,
								p.job_type,
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
							from positions p, company co, city ci 
							where p.company_id=co.id
							and ci.id = co.placement_id
							and p.pos_status = '1'
							and co.status = '1'
							and ((ci.id = '".$c."') or ('".$c."' = -1) or ('".$c."' = ci.region_en) or ('".$c."' = ci.region_heb) )
							and ((p.id = ".$i.") or (".$i." = -1))
							and ((co.id = ".$co.") or (".$co." = -1))
							and ((p.pos_sub_cat = ".$sc.") or (p.pos_sub_cat_2 = ".$sc.") or (p.pos_sub_cat_3 = ".$sc.") or (p.pos_sub_cat_4 = ".$sc.") or (p.pos_sub_cat_5 = ".$sc.") or (".$sc." = -1))
							and ((p.pos_cat = ".$ca.") or (p.pos_cat_2 = ".$ca.") or (p.pos_cat_3 = ".$ca.") or (p.pos_cat_4 = ".$ca.") or (p.pos_cat_5 = ".$ca.") or (".$ca." = -1))
							and ((upper(p.pos_desc) like upper('%".$s."%')) or (upper(p.pos_title) like upper('%".$s."%')) or (upper(co.the_name) like upper('%".$s."%')))
							order by p.modifydt desc, p.id desc limit ".$start_position.",".$num_recs_to_retrieve;		
		
		}
		else
		{
		
			$sql_positions = "select 	p.id, 
								DATE_FORMAT(p.modifydt,'%d/%m/%Y') moddt, 
								p.pos_title, 
								co.the_name company_name, 
								ci.name_en locatio, 
								ci.id locatio_id,
								p.pos_desc,
								co.id comp_id,
								ifnull( (select status from user_positions up where up.pos_id = p.id and up.user_id = ".$_SESSION['logged_in_userid']." ), 'N') up_status,
								p.job_type,
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
							from positions p, company co, city ci 							
							where p.company_id=co.id
							and ci.id = co.placement_id
							and p.pos_status = '1'
							and co.status = '1'
							and ((ci.id = '".$c."') or ('".$c."' = -1) or ('".$c."' = ci.region_en) or ('".$c."' = ci.region_heb) )
							and ((p.id = ".$i.") or (".$i." = -1))
							and ((co.id = ".$co.") or (".$co." = -1))
							and ((p.pos_sub_cat = ".$sc.") or (p.pos_sub_cat_2 = ".$sc.") or (p.pos_sub_cat_3 = ".$sc.") or (p.pos_sub_cat_4 = ".$sc.") or (p.pos_sub_cat_5 = ".$sc.") or (".$sc." = -1))
							and ((p.pos_cat = ".$ca.") or (p.pos_cat_2 = ".$ca.") or (p.pos_cat_3 = ".$ca.") or (p.pos_cat_4 = ".$ca.") or (p.pos_cat_5 = ".$ca.") or (".$ca." = -1))
							and ((upper(p.pos_desc) like upper('%".$s."%')) or (upper(p.pos_title) like upper('%".$s."%')) or (upper(co.the_name) like upper('%".$s."%')))
							order by p.modifydt desc, p.id desc limit ".$start_position.",".$num_recs_to_retrieve;		
		
		}
					 
		$arr_positions = array();		
		$results_positions = mysqli_query($conn, $sql_positions); 
	
	}
	
	while($line = mysqli_fetch_assoc($results_positions)){
		$arr_positions[] = $line;
	}		
		
	$arr_num_of_resumes = array();
	
	if ($_SESSION['auth_login'] == 1)
	{
	
		$sql_num_of_resumes = "select id, file_desc from resumes where user_id = ".$_SESSION['logged_in_userid']." order by modify_dt desc";
													
		$results_num_of_resumes = mysqli_query($conn, $sql_num_of_resumes); 	
		
		while($line = mysqli_fetch_assoc($results_num_of_resumes)){
			$arr_num_of_resumes[] = $line;
		}

		$num_of_resume_this_user_has = sizeof($arr_num_of_resumes);
		
	}
	else
	
		$num_of_resume_this_user_has = 0;				
	
	$conn->close();		
	
?>	
 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
	
  <?php   
  if ($i == -1)
  {
  ?>
  <meta name="description" content="Find Job in Israel | חיפוש עבודה | Israeli Companies | משרות הייטק | High Paying Jobs in Israel | לוח דרושים איכותי">
  <meta name="keywords" content="find, job, Israel, עבודה, חיפוש, הייטק, משרות, איכותי, דרושים, לוח, High, Paying, search, employment, companies, work, 972, hr, human, resources ">

  <title>Jobs972 - Find Job in Israel!</title>
  
	<!-- Start Facebook OG -->

	<meta property="og:title" content="Jobs972 - Find Job in Israel!" />
	<meta property="og:url"content="https://www.facebook.com/sharer/sharer.php?u=http://www.jobs972.com" />
	<meta property="og:image" content="https://www.jobs972.com/images/icon3.png" />
	<meta property="og:description"   content="Find Job in Israel | חיפוש עבודה | Israeli Companies | משרות הייטק | High Paying Jobs in Israel | לוח דרושים איכותי" />
	<meta property="og:type"          content="website" />

	<!-- End Facebook -->  
  
  <?
  }
  else
  {
  ?>
  <meta name="description" content="<?php echo "Jobs972.com: ".$arr_positions[0]['pos_title']." @ ".$arr_positions[0]['company_name']; ?>">
  <meta name="keywords" content="<? echo $arr_positions[0]['pos_title']; ?>, <? echo $arr_positions[0]['company_name']; ?>, <? echo $arr_positions[0]['locatio']; ?>, find, job, Israel, עבודה, חיפוש, הייטק, משרות, איכותי, דרושים, לוח, High, Paying, search, employment, companies, work, 972, hr, human, resources">

  <title><?php echo $arr_positions[0]['pos_title']." @ ".$arr_positions[0]['company_name']; ?></title>

	<!-- Start Facebook OG -->

	<meta property="og:title" content="Jobs972.com: <?php echo $arr_positions[0]['pos_title']." @ ".$arr_positions[0]['company_name']; ?>" />
	<meta property="og:url"content="https://www.facebook.com/sharer/sharer.php?u=http://www.jobs972.com/index.php?i=<?php echo $i; ?>" />
	<meta property="og:image" content="https://www.jobs972.com/images/icon3.png" />
	<meta property="og:description"   content="Apply on www.jobs972.com! <?php echo $arr_positions[0]['pos_desc'] ?>" />
	<meta property="og:type"          content="website" />

	<!-- End Facebook -->
  
  <?
  }
  ?>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css"> 
  <link href="assets/css/font-awesome.css" rel="stylesheet">	
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300" rel='stylesheet' type='text/css'>
	
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">		
	<link href='assets/css/jobs972.css' rel='stylesheet' type='text/css'>
	<script src="jquery.min.js"></script>	
	
<script>

$(document).ready(function () {

	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});

	$('.scrollup').click(function () {
		$("html, body").animate({
			scrollTop: 0
		}, 600);
		return false;
	});

});

function validateEmail(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function doTellAFriend(nPositionId, strPositionName, strCompanyName)
{

	document.getElementById("taf_position_id").value = nPositionId;
	document.getElementById("taf_position_title").value = strPositionName;
	document.getElementById("taf_company_name").value = strCompanyName;
	
	$('#TellAFriend').modal('show');
		
}

function doTellAFriendOk()
{

	var nErrors =0;
		
	// check name
	if (document.getElementById("tellafriend_your_name").value==null || document.getElementById("tellafriend_your_name").value=="")
	{
		document.getElementById("tellafriend_your_name").style.borderColor = "red";
		document.getElementById("tellafriend_your_name").style.boxShadow = "3px 3px 3px lightgray";			
		nErrors++;
	}	
	else 
	{
		document.getElementById("tellafriend_your_name").style.borderColor = "green";
		document.getElementById("tellafriend_your_name").style.boxShadow = "2px 2px 2px lightgray";
	}	
		
	// check email
	if (document.getElementById("tellafriend_your_email").value==null || document.getElementById("tellafriend_your_email").value=="")
	{
		document.getElementById("tellafriend_your_email").style.borderColor = "red";
		document.getElementById("tellafriend_your_email").style.boxShadow = "3px 3px 3px lightgray";			
		nErrors++;
	}	
	else if (!validateEmail(document.getElementById("tellafriend_your_email").value))
	{			
		document.getElementById("tellafriend_your_email").style.borderColor = "red";
		document.getElementById("tellafriend_your_email").style.boxShadow = "3px 3px 3px lightgray";	
		nErrors++;			
	}		
	else 
	{
		document.getElementById("tellafriend_your_email").style.borderColor = "green";
		document.getElementById("tellafriend_your_email").style.boxShadow = "2px 2px 2px lightgray";
	}		

	// check name friend
	if (document.getElementById("tellafriend_your_friends_name").value==null || document.getElementById("tellafriend_your_friends_name").value=="")
	{
		document.getElementById("tellafriend_your_friends_name").style.borderColor = "red";
		document.getElementById("tellafriend_your_friends_name").style.boxShadow = "3px 3px 3px lightgray";			
		nErrors++;
	}	
	else 
	{
		document.getElementById("tellafriend_your_friends_name").style.borderColor = "green";
		document.getElementById("tellafriend_your_friends_name").style.boxShadow = "2px 2px 2px lightgray";
	}	
		
	// check email friend
	if (document.getElementById("tellafriend_your_friends_email").value==null || document.getElementById("tellafriend_your_friends_email").value=="")
	{
		document.getElementById("tellafriend_your_friends_email").style.borderColor = "red";
		document.getElementById("tellafriend_your_friends_email").style.boxShadow = "3px 3px 3px lightgray";			
		nErrors++;
	}	
	else if (!validateEmail(document.getElementById("tellafriend_your_friends_email").value))
	{			
		document.getElementById("tellafriend_your_friends_email").style.borderColor = "red";
		document.getElementById("tellafriend_your_friends_email").style.boxShadow = "3px 3px 3px lightgray";	
		nErrors++;			
	}		
	else 
	{
		document.getElementById("tellafriend_your_friends_email").style.borderColor = "green";
		document.getElementById("tellafriend_your_friends_email").style.boxShadow = "2px 2px 2px lightgray";
	}	
	
	// captcha
	if (document.getElementById("captcha_tellafriend").value==null || document.getElementById("captcha_tellafriend").value=="")
	{		
		document.getElementById("captcha_tellafriend").style.borderColor = "red";
		document.getElementById("captcha_tellafriend").style.boxShadow = "3px 3px 3px lightgray";
		nErrors++;
	}	
	else if (document.getElementById("captcha_tellafriend").value!=<?php echo $a+$b; ?>)
	{
		document.getElementById("captcha_tellafriend").style.borderColor = "red";
		document.getElementById("captcha_tellafriend").style.boxShadow = "3px 3px 3px lightgray";
		nErrors++;			
	}
	else
	{
		document.getElementById("captcha_tellafriend").style.borderColor = "green";
		document.getElementById("captcha_tellafriend").style.boxShadow = "2px 2px 2px lightgray";
	}			
						
	if (nErrors==0)
	{					
		var url = "tell_a_friend.php";
					
		var oData = new FormData(document.forms.namedItem("frmTellAFriend"));
		
		var oReq = new XMLHttpRequest();
		  oReq.open("POST", url, true);
		  oReq.onload = function(oEvent) {
								
			if (oReq.status == 200) 
			{			
				// alert('>>'+oReq.responseText);					
				$('#TellAFriend').modal('hide');
				$('#TellAFriendOk').modal('show');
				
				document.getElementById("tellafriend_your_name").value="";
				document.getElementById("tellafriend_your_name").style.borderColor = "lightgray";
				document.getElementById("tellafriend_your_name").style.boxShadow = "none";
				
				document.getElementById("tellafriend_your_email").value="";
				document.getElementById("tellafriend_your_email").style.borderColor = "lightgray";
				document.getElementById("tellafriend_your_email").style.boxShadow = "none";
				
				document.getElementById("tellafriend_your_friends_name").value="";
				document.getElementById("tellafriend_your_friends_name").style.borderColor = "lightgray";
				document.getElementById("tellafriend_your_friends_name").style.boxShadow = "none";	

				document.getElementById("tellafriend_your_friends_email").value="";
				document.getElementById("tellafriend_your_friends_email").style.borderColor = "lightgray";
				document.getElementById("tellafriend_your_friends_email").style.boxShadow = "none";					
				
				document.getElementById("captcha_tellafriend").value="";
				document.getElementById("captcha_tellafriend").style.borderColor = "lightgray";
				document.getElementById("captcha_tellafriend").style.boxShadow = "none";
							
				return;
				
			} else {
			  alert("Error " + oReq.status + " occurred.<br \/>");
			}
		  };

		oReq.send(oData); 
	}

}

function clickAllowSubscr()
{	
	
	if (document.getElementById('subsc_allow').checked)
	{
		$('#subscribe_button').removeClass('disabled');
		$('#subscribe_button').prop('disabled', false);
	}
	else
	{
		$('#subscribe_button').addClass('disabled');
		$('#subscribe_button').prop('disabled', true);
	}
}

function SubscribeToEmail()
{
	var nErrors =0;

	if (document.getElementById("subscr_email").value==null || document.getElementById("subscr_email").value=="")
	{
		document.getElementById("subscr_email").style.borderColor = "red";
		document.getElementById("subscr_email").style.boxShadow = "3px 3px 3px lightgray";			
		nErrors++;
	}	
	else if (!validateEmail(document.getElementById("subscr_email").value))
	{			
		document.getElementById("subscr_email").style.borderColor = "red";
		document.getElementById("subscr_email").style.boxShadow = "3px 3px 3px lightgray";	
		nErrors++;			
	}		
	else 
	{
		document.getElementById("subscr_email").style.borderColor = "green";
		document.getElementById("subscr_email").style.boxShadow = "2px 2px 2px lightgray";
	}		

	if (nErrors==0)
	{	
		document.getElementById("subsc_email_onform").readOnly=true;
		document.getElementById("subsc_email_onform").value=document.getElementById("subscr_email").value;
		$('#SubscribeEmail').modal('show');		
	}
}

function ResetAPassword()
{

		var nErrors =0;
											
		// check email
		if (document.getElementById("rp_email").value==null || document.getElementById("rp_email").value=="")
		{
			document.getElementById("rp_email").style.borderColor = "red";
			document.getElementById("rp_email").style.boxShadow = "3px 3px 3px lightgray";			
			nErrors++;
		}	
		else if (!validateEmail(document.getElementById("rp_email").value))
		{			
			document.getElementById("rp_email").style.borderColor = "red";
			document.getElementById("rp_email").style.boxShadow = "3px 3px 3px lightgray";	
			nErrors++;			
		}		
		else 
		{
			document.getElementById("rp_email").style.borderColor = "green";
			document.getElementById("rp_email").style.boxShadow = "2px 2px 2px lightgray";
		}		
 
		// captcha
		if (document.getElementById("captcharp").value==null || document.getElementById("captcharp").value=="")
		{		
			document.getElementById("captcharp").style.borderColor = "red";
			document.getElementById("captcharp").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}	
		else if (document.getElementById("captcharp").value!=<?php echo $a+$b; ?>)
		{
			document.getElementById("captcharp").style.borderColor = "red";
			document.getElementById("captcharp").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;			
		}
		else
		{
			document.getElementById("captcharp").style.borderColor = "green";
			document.getElementById("captcharp").style.boxShadow = "2px 2px 2px lightgray";
		}			
							
		if (nErrors==0)
		{					
			var url = "reset_a_password.php";
						
			var oData = new FormData(document.forms.namedItem("frmRemindAPassword"));
			
			var oReq = new XMLHttpRequest();
			  oReq.open("POST", url, true);
			  oReq.onload = function(oEvent) {
									
				if (oReq.status == 200) 
				{			
					// alert('>>'+oReq.responseText);					
					$('#ForgotPassword').modal('hide');
					$('#ForgotPasswordOk').modal('show');						
					document.getElementById("rp_email").value="";						
					document.getElementById("captcharp").value="";					
					return;
					
				} else {
				  alert("Error " + oReq.status + " occurred.<br \/>");
				}
			  };

			oReq.send(oData); 
		}

}

function ForgotPassword()
{
	document.getElementById("rp_email").value="";
	document.getElementById("rp_email").style.borderColor = "lightgray";
	document.getElementById("captcharp").value="";
	document.getElementById("captcharp").style.borderColor = "lightgray";
	$('#logIn').modal('hide');
	$('#ForgotPassword').modal('show');
}

function TurnOnOffCoverLetter()
{
	var chck_state = document.getElementById("elTurnOnCoverLetter").checked;
	if (chck_state == true)
	{			
		document.getElementById("apply_resume_cover").readOnly=false;			
	}
	else
	{
		document.getElementById("apply_resume_cover").readOnly=true;	
	}
}

function ApplyForPositionOkFnc()
{
	// reload this page
	location.reload(true);
}

function ApplyForPositionYes()
{
	var url = "apply_for_this_position2.php";
				
	var oData = new FormData(document.forms.namedItem("frmApplyForPosition"));
	
	var oReq = new XMLHttpRequest();
	  oReq.open("POST", url, true);
	  oReq.onload = function(oEvent) {
							
		if (oReq.status == 200) 
		{			
			// alert('>>'+oReq.responseText+'<<');
			if (oReq.responseText=='Ok') 
			{				
				$('#applyForPosition').modal('hide');
				$('#applyForPositionOk').modal('show');				
			}
			else
			{
				$('#applyForPosition').modal('hide');
				$('#applyForPositionAlreadyApplied').modal('show');				
			} 
			return;
			
		} else {
		  alert("Error " + oReq.status + " occurred.<br \/>");
		}
	  };

	oReq.send(oData);
}

function ApplyForPosition(n,d)
{		
	<?
	if ($_SESSION['auth_login'] == 1)
	{
		if ($num_of_resume_this_user_has == 0)
		{
	?>
		$('#shouldHaveAtLeastOneResumeLoadedToApply').modal('show');
	<?
		}
		else
		{
	?>
		document.getElementById("apply_for_this_position_id").value = n;
		document.getElementById("apply_position_name").value = d;
		$('#applyForPosition').modal('show');		
	<?
		}
	}
	else
	{
	?>	
		doLogin();
	<?
	}
	?>	
}
	
// limit input chars
function limit(element, n_max_chars)
{
	var max_chars = n_max_chars;

	if(element.value.length > n_max_chars) {
		element.value = element.value.substr(0, n_max_chars);
	}
}

function sendResume()
{
	$("#submitResume").modal()
}

function doSignUp()
{
	document.getElementById("su_first_name").value = '';
	document.getElementById("su_first_name").style.borderColor = "lightgray";
	document.getElementById("su_last_name").value = '';
	document.getElementById("su_last_name").style.borderColor = "lightgray";
	document.getElementById("su_email").value = '';
	document.getElementById("su_email").style.borderColor = "lightgray";
	document.getElementById("su_pwd").value = '';
	document.getElementById("su_pwd").style.borderColor = "lightgray";
	document.getElementById("captcha").value = '';
	document.getElementById("captcha").style.borderColor = "lightgray";	
	$("#signUp").modal()
}

function doLogin()
{
	document.getElementById("lo_email").value = '';
	document.getElementById("lo_email").style.borderColor = "lightgray";
	document.getElementById("lo_pwd").value = '';
	document.getElementById("lo_pwd").style.borderColor = "lightgray";
	document.getElementById("captcha2").value = '';
	document.getElementById("captcha2").style.borderColor = "lightgray";	
	$("#logIn").modal()
}

function FindJobsFilter()
{

	var e = document.getElementById("inpCity");
	var strCity = e.options[e.selectedIndex].value;
	
	var strSearch = document.getElementById("inpJob").value;	
	
	strSearch = strSearch.replace("\'", "");
	strSearch = strSearch.replace("\"", "");
	strSearch = strSearch.replace("'", "");
	strSearch = strSearch.replace("&", "");
	strSearch = strSearch.replace("!", "");
	strSearch = strSearch.replace("\\", "");
	strSearch = strSearch.replace(";", "");
	strSearch = strSearch.replace("(", "");
	strSearch = strSearch.replace(")", "");
	strSearch = strSearch.replace("%", "");
	
	location.href = "https://jobs972.com/index.php?p=<? echo $p; ?>&c="+strCity+"&s="+strSearch;
}

function signUpTheUser()
	{
		
		var nErrors =0;
											
		// check su_first_name
		
		if (document.getElementById("su_first_name").value==null || document.getElementById("su_first_name").value=="")
		{					
			document.getElementById("su_first_name").style.borderColor = "red";
			document.getElementById("su_first_name").style.boxShadow = "2px 2px 2px lightgray";
			nErrors++;
		}
		else
		{
			var str=document.getElementById("su_first_name").value;
			var n= str.length;
			var specialChars = "<>@!#$%^&*()_+[]{}?:;|'\"\\,./~`-=";
			
			var nErrSpecChars = 0;
			
			for(i = 0; i < specialChars.length;i++)
			{
				if(str.indexOf(specialChars[i]) > -1)
				{
					nErrSpecChars++;
				}
			}
			
			if (n < 2 || n > 20 || str.indexOf(' ')>=0 || nErrSpecChars>0)
			{			
				document.getElementById("su_first_name").style.borderColor = "red";
				document.getElementById("su_first_name").style.boxShadow = "3px 3px 3px lightgray";
				nErrors++;						
			}			
			else
			{
				document.getElementById("su_first_name").style.borderColor = "green";
				document.getElementById("su_first_name").style.boxShadow = "2px 2px 2px lightgray";
			}
		}

		// check su_last_name
		
		if (document.getElementById("su_last_name").value==null || document.getElementById("su_last_name").value=="")
		{					
			document.getElementById("su_last_name").style.borderColor = "red";
			document.getElementById("su_last_name").style.boxShadow = "2px 2px 2px lightgray";
			nErrors++;
		}
		else
		{
			var str=document.getElementById("su_last_name").value;
			var n= str.length;
			var specialChars = "<>@#$%^&()_+[]{}?:;|'\"\\/~`-=";
			
			var nErrSpecChars = 0;
			
			for(i = 0; i < specialChars.length;i++)
			{
				if(str.indexOf(specialChars[i]) > -1)
				{
					nErrSpecChars++;
				}
			}
			
			if (n < 2 || n > 20 || nErrSpecChars>0)
			{			
				document.getElementById("su_last_name").style.borderColor = "red";
				document.getElementById("su_last_name").style.boxShadow = "3px 3px 3px lightgray";
				nErrors++;						
			}			
			else
			{
				document.getElementById("su_last_name").style.borderColor = "green";
				document.getElementById("su_last_name").style.boxShadow = "2px 2px 2px lightgray";
			}
		}
		
		// check email
		
		if (document.getElementById("su_email").value==null || document.getElementById("su_email").value=="")
		{
			document.getElementById("su_email").style.borderColor = "red";
			document.getElementById("su_email").style.boxShadow = "3px 3px 3px lightgray";			
			nErrors++;
		}	
		else if (!validateEmail(document.getElementById("su_email").value))
		{			
			document.getElementById("su_email").style.borderColor = "red";
			document.getElementById("su_email").style.boxShadow = "3px 3px 3px lightgray";	
			nErrors++;			
		}		
		else 
		{
			document.getElementById("su_email").style.borderColor = "green";
			document.getElementById("su_email").style.boxShadow = "2px 2px 2px lightgray";
		}		
 
 
		// check pwd
		
		if (document.getElementById("su_pwd").value==null || document.getElementById("su_pwd").value=="")
		{					
			document.getElementById("su_pwd").style.borderColor = "red";
			document.getElementById("su_pwd").style.boxShadow = "2px 2px 2px lightgray";
			nErrors++;
		}
		else
		{
			var str=document.getElementById("su_pwd").value;
			var n= str.length;
			var specialChars = "()[]{}?:;|'\"\\/~`-=";
			
			var nErrSpecChars = 0;
			
			for(i = 0; i < specialChars.length;i++)
			{
				if(str.indexOf(specialChars[i]) > -1)
				{
					nErrSpecChars++;
				}
			}
			
			if (n < 5 || n > 30 || nErrSpecChars>0)
			{			
				document.getElementById("su_pwd").style.borderColor = "red";
				document.getElementById("su_pwd").style.boxShadow = "3px 3px 3px lightgray";
				nErrors++;						
			}			
			else
			{
				document.getElementById("su_pwd").style.borderColor = "green";
				document.getElementById("su_pwd").style.boxShadow = "2px 2px 2px lightgray";
			}
		}

		// captcha
		
		if (document.getElementById("captcha").value==null || document.getElementById("captcha").value=="")
		{		
			document.getElementById("captcha").style.borderColor = "red";
			document.getElementById("captcha").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}	
		else if (document.getElementById("captcha").value!=<?php echo $a+$b; ?>)
		{
			document.getElementById("captcha").style.borderColor = "red";
			document.getElementById("captcha").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;			
		}
		else
		{
			document.getElementById("captcha").style.borderColor = "green";
			document.getElementById("captcha").style.boxShadow = "2px 2px 2px lightgray";
		}			
							
		if (nErrors==0)
		{					
			var url = "register_new_user.php";
						
			var oData = new FormData(document.forms.namedItem("signUpForm"));
			
			var oReq = new XMLHttpRequest();
			  oReq.open("POST", url, true);
			  oReq.onload = function(oEvent) {
									
				if (oReq.status == 200) 
				{			
					// alert('>>'+oReq.responseText);
						
				    if (oReq.responseText == 'EXISTS')
					{
						$('#signUp').modal('hide');
						$('#signUpAlreadyExists').modal('show');

						document.getElementById("captcha").value="";
						document.getElementById("su_pwd").value="";
					}
					else
					{
						$('#signUp').modal('hide');
						$('#signUpOk').modal('show');
						document.getElementById("su_first_name").value="";
						document.getElementById("su_last_name").value="";
						document.getElementById("su_email").value="";
						document.getElementById("su_pwd").value="";
						document.getElementById("captcha").value="";
					}
					return;
					
				} else {
				  alert("Error " + oReq.status + " occurred.<br \/>");
				}
			  };

			oReq.send(oData); 
		}
	}	

	
	
function logInTheUser()
	{
		
		var nErrors =0;
		
		// check email lo_email
		
		if (document.getElementById("lo_email").value==null || document.getElementById("lo_email").value=="")
		{
			document.getElementById("lo_email").style.borderColor = "red";
			document.getElementById("lo_email").style.boxShadow = "3px 3px 3px lightgray";			
			nErrors++;
		}	
		else if (!validateEmail(document.getElementById("lo_email").value))
		{			
			document.getElementById("lo_email").style.borderColor = "red";
			document.getElementById("lo_email").style.boxShadow = "3px 3px 3px lightgray";	
			nErrors++;			
		}		
		else 
		{
			document.getElementById("lo_email").style.borderColor = "green";
			document.getElementById("lo_email").style.boxShadow = "2px 2px 2px lightgray";
		}		
 
 
		// check pwd lo_pwd
		
		if (document.getElementById("lo_pwd").value==null || document.getElementById("lo_pwd").value=="")
		{					
			document.getElementById("lo_pwd").style.borderColor = "red";
			document.getElementById("lo_pwd").style.boxShadow = "2px 2px 2px lightgray";
			nErrors++;
		}
		else
		{
			var str=document.getElementById("lo_pwd").value;
			var n= str.length;
			var specialChars = "()[]{}?:;|'\"\\/~`-=";
			
			var nErrSpecChars = 0;
			
			for(i = 0; i < specialChars.length;i++)
			{
				if(str.indexOf(specialChars[i]) > -1)
				{
					nErrSpecChars++;
				}
			}
			
			if (n < 5 || n > 30 || nErrSpecChars>0)
			{			
				document.getElementById("lo_pwd").style.borderColor = "red";
				document.getElementById("lo_pwd").style.boxShadow = "3px 3px 3px lightgray";
				nErrors++;						
			}			
			else
			{
				document.getElementById("lo_pwd").style.borderColor = "green";
				document.getElementById("lo_pwd").style.boxShadow = "2px 2px 2px lightgray";
			}
		}

		// captcha2
		
		if (document.getElementById("captcha2").value==null || document.getElementById("captcha2").value=="")
		{		
			document.getElementById("captcha2").style.borderColor = "red";
			document.getElementById("captcha2").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}	
		else if (document.getElementById("captcha2").value!=<?php echo $a+$b; ?>)
		{
			document.getElementById("captcha2").style.borderColor = "red";
			document.getElementById("captcha2").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;			
		}
		else
		{
			document.getElementById("captcha2").style.borderColor = "green";
			document.getElementById("captcha2").style.boxShadow = "2px 2px 2px lightgray";
		}			
							
		if (nErrors==0)
		{					
			var url = "login_user.php";
						
			var oData = new FormData(document.forms.namedItem("LoginForm"));
			
			var oReq = new XMLHttpRequest();
			  oReq.open("POST", url, true);
			  oReq.onload = function(oEvent) {
									
				if (oReq.status == 200) 
				{			
					// alert('>>'+oReq.responseText);
						
				    if (oReq.responseText == 'OK')
					{
						$('#logIn').modal('hide');												
						document.getElementById("lo_email").value="";
						document.getElementById("lo_pwd").value="";
						document.getElementById("captcha2").value="";
						
						window.location.replace("http://jobs972.com/user_dashboard.php");
					}
					else if (oReq.responseText == 'Not Verified')
					{
						$('#logIn').modal('hide');						
						$('#accountIsNotVerified').modal('show');

						document.getElementById("lo_email").value="";
						document.getElementById("lo_pwd").value="";
						document.getElementById("captcha2").value="";										
					}
					else
					{
						$('#logIn').modal('hide');						
						$('#logInError').modal('show');

						document.getElementById("lo_email").value="";
						document.getElementById("lo_pwd").value="";
						document.getElementById("captcha2").value="";					
					}
					return;
					
				} else {
				  alert("Error " + oReq.status + " occurred uploading your file.<br \/>");
				}
			  };

			oReq.send(oData); 
		}
	}	
	
</script>

</head>
<body>	

<?php include_once("analyticstracking.php") ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

 <div class="navbar navbar-static-top" style="margin-bottom:0;" >
	<div class="container" style="font-size:smaller;">
		
		<button class ="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">		
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>		
		</button>
		
		<div class="collapse navbar-collapse navHeaderCollapse">
		
			<ul class="nav navbar-nav navbar-left">			
				<li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span></a></li>
				<li><a href="positions.php">Positions</a></li>
				<li><a href="categories.php">Categories</a></li>
				<li><a href="aboutus.php">About Us</a></li>
				<li><a href="companies.php">Companies</a></li>
				<li><a href="contactus.php">Contact Us</a></li>				
			</ul>
			
			<div class="hidden-sm">
			<ul class="nav navbar-nav navbar-right">							 
			
				<?php
				if ($_SESSION['auth_login'] == 1)
				{
				?>				
					<li><a href="user_dashboard.php"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['logged_in_user_firstname']; ?></a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Exit</a></li>													
				<?
				}
				elseif ($_SESSION['princ_login'] == 1)				
				{
				?>
					<li><a style="color:red" href="princ_dashboard.php"><span style="color:red" class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['princ_first_name']; ?></a></li>
					<li><a style="color:red" href="principal/logout.php"><span style="color:red" class="glyphicon glyphicon-log-out"></span> Exit</a></li>					
				<?
				} 
				else
				{
				?>								
					<li><a href="#" onClick="doSignUp()"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
					<li><a href="#" onClick="doLogin()"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>											
				<?
				}
				?>
			
				<!-- no multilang yet... 
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">English <span class="caret"></span></a>
				  <ul class="dropdown-menu">					
					<li><a href="#">עיברית</a></li>					
				  </ul>
				</li> -->			
			</ul>	
			</div>
			
		
		</div> 
		
	</div> 
 </div> <!-- the end of navbar navbar-inverse navbar-static-top -->
 
 
<!-- jtron start -->
  
<div class="jumbotron">
	
	<div class = "container" style="font-size:smaller;">
	
		<a href="https://jobs972.com/index.php" style="text-decoration: none;"><h1>Find Job in Israel!</h1></a>
		<p>Welcome to <b>Jobs972</b>: The most challenging positions, The most attractive companies, Totally Free!</p>
		<p style="font-size:90%">Find Job in Israel | חיפוש עבודה | Israeli Companies | משרות הייטק | High Paying Jobs in Israel | לוח דרושים איכותי</p>
		<table style="border-spacing: 5px; border-collapse: separate;">
			<tr>
				<td style='width:200px;'>
					<input type="text" class="form-control" id="inpJob" name="inpJob" placeholder="Job title, skills, or company" value="<? echo $s; ?>">
				</td>
				<td style='width:200px;'>					
					<select class="form-control" id="inpCity" name="inpCity">
						<option value="-1">All Regions | All Cities</option>	
						<option value="-2">--------------------</option>
						<?
						for ($idx=0; $idx< sizeof($arr_regions); $idx++)
						{
							if ($arr_regions[$idx]['region_en'] == $c)
							{
								echo '<option value="'.$arr_regions[$idx]['region_en'].'" selected>'.$arr_regions[$idx]['region_en'].'</option>';
							}
							else
							{
								echo '<option value="'.$arr_regions[$idx]['region_en'].'">'.$arr_regions[$idx]['region_en'].'</option>';
							}
						}
						?>		
						<option value="-3">--------------------</option>
						<?					
						for ($idx=0; $idx<sizeof($arr_cities); $idx++)
						{
							if ($arr_cities[$idx]['id'] == $c)
							{
								echo '<option value="'.$arr_cities[$idx]['id'].'" selected>'.$arr_cities[$idx]['name_en'].'</option>';
							}
							else
							{
								echo '<option value="'.$arr_cities[$idx]['id'].'">'.$arr_cities[$idx]['name_en'].'</option>';
							}
						}						
						?>												
					</select>					
				</td>
				<td><a class="btn btn-default" style="background: none; color: #ffffff; padding: 6px 12px;" onclick="FindJobsFilter()">Find Jobs</a></td>
			</tr>
		</table>
	</div>
 
 </div>
 
 <!-- jtron end -->
 
 <div class="container" style="font-size:<? echo $positions_font_size ?>px;">
 
	<div class="row">
	
		<!-- central bar -->
		<div class="col-md-9">
		
			<?php
			
			if (sizeof($arr_positions) == 0)
			{
				echo "<i>It looks no any position matching or the position you're looking for is not relevant any more...</i>";
			}
			else
			{			
				for($idx=0; $idx<sizeof($arr_positions); $idx++)
				{
				
				?>
				<div class="panel panel-default">
				
					<div class="panel-heading" style="background:<? echo $positions_header_background_color; ?>;">

						<div class="pull-left">
						  <a href='index.php?i=<? echo $arr_positions[$idx]['id']; ?>'><?php echo $to_put_b.$arr_positions[$idx]['pos_title']." @ ".$arr_positions[$idx]['company_name']." [#".$arr_positions[$idx]['id']."]".$to_put_b2; ?></a>
						  <? 
							if (in_array($arr_positions[$idx]['up_status'], array('A', 'Y'))) {  echo '<span style="color:#ff0066"><i>- applied</i></span>'; }
							if (in_array($arr_positions[$idx]['up_status'], array('R'))) {  echo '<span style="color:#00cc66"><i>- recommended</i></span>'; }
						  ?>
						</div>

						<div class="pull-right">
						  <?php echo $arr_positions[$idx]['moddt']; ?>
						</div>

						<div class="clearfix"></div>

					</div>
	 
					<div class="panel-body" style="background:<? echo $positions_background_color; ?>;">
						 <table style="border-spacing: 10px; border-collapse: separate;">
							<tr>
								<td style="width:20px; text-align:right;">
									<b>Position:</b>
								</td>
								<td>
									<?php echo $arr_positions[$idx]['pos_title']; ?>
								</td>
							</tr>
							<tr>
								<td style="width:20px; text-align:right;">
									<b>Company:</b>
								</td>
								<td>
									<a href='companies.php?c=<?php echo $arr_positions[$idx]['comp_id']; ?>'><?php echo $arr_positions[$idx]['company_name']; ?></a>
								</td>
							</tr>
							<?php
							if ($arr_positions[$idx]['locatio'] != '--')
							{
							?>
							<tr>
								<td style="width:20px; text-align:right;">
									<b>Location:</b>
								</td>
								<td>
									<a href='index.php?c=<?php echo $arr_positions[$idx]['locatio_id']; ?>'><?php echo $arr_positions[$idx]['locatio']; ?></a>
								</td>
							</tr>	
							<?
							}
							?>
							<tr>
								<td style="width:20px; text-align:right;">
									<b>Type:</b>
								</td>
								<td>
									<?php echo $arr_positions[$idx]['job_type']; ?>
								</td>
							</tr>							
							<tr>
								<td style="width:20px; text-align:right;">
									<b>Description:</b>
								</td>
								<td>
									<?php echo nl2br($arr_positions[$idx]['pos_desc']); ?>
								</td>
							</tr>
							<?							
							
							if (($to_show_empty_categories == 0) && 
								($arr_positions[$idx]['cat_1'] == '') &&
								($arr_positions[$idx]['cat_2'] == '') &&
								($arr_positions[$idx]['cat_3'] == '') &&
								($arr_positions[$idx]['cat_4'] == '') &&
								($arr_positions[$idx]['cat_5'] == '')
								)
								{
									// not to show empty cats
								}
								else
								{
								
							?>
							<tr>
								<td style="width:20px; text-align:right;">
									<b>Category:</b>
								</td>
								<td>
									<? if ($arr_positions[$idx]['cat_1'] != '') { ?><a href="index.php?ca=<? echo $arr_positions[$idx]['cat_1_id']; ?>"><? echo $arr_positions[$idx]['cat_1']; ?></a> / <a href="index.php?sc=<? echo $arr_positions[$idx]['scat_1_id']; ?>"><? echo $arr_positions[$idx]['scat_1']; ?></a><br/><? } ?>
									<? if ($arr_positions[$idx]['cat_2'] != '') { ?><a href="index.php?ca=<? echo $arr_positions[$idx]['cat_2_id']; ?>"><? echo $arr_positions[$idx]['cat_2']; ?></a> / <a href="index.php?sc=<? echo $arr_positions[$idx]['scat_2_id']; ?>"><? echo $arr_positions[$idx]['scat_2']; ?></a><br/><? } ?>
									<? if ($arr_positions[$idx]['cat_3'] != '') { ?><a href="index.php?ca=<? echo $arr_positions[$idx]['cat_3_id']; ?>"><? echo $arr_positions[$idx]['cat_3']; ?></a> / <a href="index.php?sc=<? echo $arr_positions[$idx]['scat_3_id']; ?>"><? echo $arr_positions[$idx]['scat_3']; ?></a><br/><? } ?>
									<? if ($arr_positions[$idx]['cat_4'] != '') { ?><a href="index.php?ca=<? echo $arr_positions[$idx]['cat_4_id']; ?>"><? echo $arr_positions[$idx]['cat_4']; ?></a> / <a href="index.php?sc=<? echo $arr_positions[$idx]['scat_4_id']; ?>"><? echo $arr_positions[$idx]['scat_4']; ?></a><br/><? } ?>
									<? if ($arr_positions[$idx]['cat_5'] != '') { ?><a href="index.php?ca=<? echo $arr_positions[$idx]['cat_5_id']; ?>"><? echo $arr_positions[$idx]['cat_5']; ?></a> / <a href="index.php?sc=<? echo $arr_positions[$idx]['scat_5_id']; ?>"><? echo $arr_positions[$idx]['scat_5']; ?></a><br/><? } ?>
								</td>
							</tr>
							<?
							
								}
								
							?>
						 </table>
							<div class="social">								
								<div id="tell_a_friend" class="pull-left">							
								<p class="social">	
									<?php
									
										/*
											<a href="https://www.facebook.com/sharer/sharer.php?u=https://www.jobs972.com/index.php?i=<? echo $arr_positions[$idx]['id']; ?>" target='_blank' class="facebook external" data-animate-hover="shake"><i class="fa fa-facebook"></i></a> 
										*/
										
										$encoded_url = urlencode("https://www.jobs972.com/index.php?i=".$arr_positions[$idx]['id']);									
										$encoded_picture = "https://www.jobs972.com/images/icon3.png";		
										$the_title = "Jobs972.com: ".$arr_positions[$idx]['pos_title']." @ ".$arr_positions[$idx]['company_name']." (".$arr_positions[$idx]['locatio'].")".". Apply now!";
										$the_quote = "Find Job in Israel | חיפוש עבודה | Israeli Companies | משרות הייטק | High Paying Jobs in Israel | לוח דרושים איכותי | Apply Now! | Send Your CV To Us Today! ";
										$the_description = $arr_positions[$idx]['pos_desc'];
										
									?>									
									<a href="https://www.facebook.com/sharer/sharer.php?u=<? echo $encoded_url; ?>&picture=<? echo $encoded_picture; ?>&title=<? echo $the_title; ?>&quote=<? echo $the_quote; ?>&description=<? echo $the_description; ?>" target='_blank' class="facebook external" data-animate-hover="shake" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;"><i class="fa fa-facebook"></i></a>
									<a href="http://twitter.com/share?text=<?php echo "Jobs972.com: ".$arr_positions[$idx]['pos_title']." @ ".$arr_positions[$idx]['company_name']; ?>&url=https://jobs972.com/index.php?i=<? echo $arr_positions[$idx]['id']; ?>&hashtags=jobs972,Job,Israel,לוח,משרות,עבודה,חיפוש, דרושים" target='_blank' class="twitter external" data-animate-hover="shake"><i class="fa fa-twitter"></i></a>
									
									<a href="http://www.linkedin.com/shareArticle?mini=true&url=https://jobs972.com/index.php?i=<? echo $arr_positions[$idx]['id']; ?>&title=<?php echo $arr_positions[$idx]['pos_title']." @ ".$arr_positions[$idx]['company_name']; ?>&summary=<?php echo substr($arr_positions[$idx]['pos_desc'], 0, 600)."..."; ?>&source=https://jobs972.com" target='_blank' class="linkedin external" data-animate-hover="shake"><i class="fa fa-linkedin"></i></a>
									<a href="#" class="gplus external" data-animate-hover="shake"><i class="fa fa-google-plus"></i></a>
									<a href="#" onclick="doTellAFriend(<? echo $arr_positions[$idx]['id']; ?>, '<? echo $arr_positions[$idx]['pos_title']; ?>', '<? echo $arr_positions[$idx]['company_name']; ?>');" class="email external" data-animate-hover="shake"><i class="fa fa-envelope"></i></a>							
							   </p>
							   </div>
																					
							</div>		
							<div class="pull-right">
								<a class="btn btn-primary pull-right <? if (in_array($arr_positions[$idx]['up_status'], array('A', 'Y'))) {  echo 'disabled'; } ?>" style="border-radius: 24px;" <? if (in_array($arr_positions[$idx]['up_status'], array('A', 'Y'))) {  echo 'disabled'; } ?> onClick="ApplyForPosition(<? echo $arr_positions[$idx]['id']; ?>, '<?php echo $arr_positions[$idx]['pos_title']." @ ".$arr_positions[$idx]['company_name']; ?>');">Apply</a>
							</div>
							<div class="clearfix"></div>
					</div>
				</div>
	 
				<?php
				}

				if ($i == -1)
				{
				?>
				
					<!--
					<nav>
						<ul class="pager" >
						  <li class="previous"><a href="index.php?p=<? if (($p-1) >0) echo $p-1; else echo 1; ?>&c=<? echo $c; ?>&s=<? echo $s; ?>&sc=<? echo $sc; ?>&ca=<? echo $ca; ?>">Previous</a></li>
						  <li class="next"><a href="index.php?p=<? if ( ($p+1) <= $num_of_pages) echo $p+1; else echo $p; ?>&c=<? echo $c; ?>&s=<? echo $s; ?>&sc=<? echo $sc; ?>&ca=<? echo $ca; ?>">Next</a></li>
						</ul>
					</nav>
					-->

					<?php
					
					$n_steps_before_and_after = 2;
					
					if ($p - $n_steps_before_and_after < 1)
					{
						$start_paggination = 1;
					}
					else
					{
						$start_paggination = $p - $n_steps_before_and_after;
					}
					
					if ($p + $n_steps_before_and_after > $num_of_pages)
					{
						$end_paggination = $num_of_pages;
					}
					else
					{
						$end_paggination = $p + $n_steps_before_and_after;
					}	

					?>
					
					<nav>
					<div class="text-center">
					  <ul class="pagination">
						<li class="page-item">
						  <a class="page-link" href="index.php?p=1&c=<? echo $c; ?>&s=<? echo $s; ?>&sc=<? echo $sc; ?>&ca=<? echo $ca; ?>&co=<? echo $co; ?>" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
							<span class="sr-only">Previous</span>
						  </a>
						</li>
						<?php
						
							if ($start_paggination > 1)
							{
							
						?>
							<li class="page-item"><span>...</span></li>
							
						<?
							}
						
							for ($idz = $start_paggination; $idz <= $end_paggination; $idz++)
							{
								if ($idz == $p)
								{
						?>
									<li class="page-item active"><a class="page-link" href="index.php?p=<? echo $idz; ?>&c=<? echo $c; ?>&s=<? echo $s; ?>&sc=<? echo $sc; ?>&ca=<? echo $ca; ?>&co=<? echo $co; ?>"><? echo $idz; ?></a></li>
						<?	
								}
								else
								{
						?>
									<li class="page-item"><a class="page-link" href="index.php?p=<? echo $idz; ?>&c=<? echo $c; ?>&s=<? echo $s; ?>&sc=<? echo $sc; ?>&ca=<? echo $ca; ?>&co=<? echo $co; ?>"><? echo $idz; ?></a></li>
						<?
								}	
							}

							if ($end_paggination < $num_of_pages)
							{
						?>
						
							<li class="page-item"><span>...</span></li>
							
						<?
							}
						?>			
						<li class="page-item">
						  <a class="page-link" href="index.php?p=<? echo $num_of_pages; ?>&c=<? echo $c; ?>&s=<? echo $s; ?>&sc=<? echo $sc; ?>&ca=<? echo $ca; ?>&co=<? echo $co; ?>" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
							<span class="sr-only">Next</span>
						  </a>
						</li>
					  </ul>
					</div>
					</nav>
					
				<?
				}
				else
				{
				?>
					<nav>
						<ul class="pager">				  
						  <li class="next"><a href="javascript:history.back()">Back</a></li>
						</ul>
					</nav>							
				<?
				}			
			} // size 0
			?>
		
		</div>	
	
	
		<!-- right bar -->
		<div class="col-md-3">

			<div class="panel panel-default">
				<div class="panel-body" style='text-align:center'>
					<img src="images/banner_2.jpg">
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body" style='text-align:center'>		
					<div class="fb-page" data-href="https://www.facebook.com/jobs972com/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/jobs972com/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/jobs972com/">Find Job in Israel</a></blockquote></div>		
				</div>
			</div>	
			
			<div class="panel panel-default">
				<div class="panel-body" style='text-align:center'>
				<img src="images/banner_2.jpg" style="margin:0 0 20px 0"> 
				<p>Find Job in Israel <br/> 
				חיפוש עבודה <br/> 
				Israeli Companies <br/>  משרות הייטק <br/>  High Paying Jobs in Israel <br/>  לוח דרושים איכותי</p>
				</div>
			</div>			
		
			<div class="panel panel-default">
				<div class="panel-body" style='text-align:center'>
					<a class="twitter-timeline" href="https://twitter.com/jobs972com">Tweets by jobs972com</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
				</div>
			</div>		

			<div class="panel panel-default">
				<div class="panel-body" style='text-align:center'>
					<img src="images/icon3.png">
				</div>
			</div>			
		
		</div>	
	
	</div>
 
 </div>

  
 <div class="clearfix" style="margin-bottom:20px;"></div> 
 
<!-- Pre footer -->

	<div id="footer">
		<div class="container" style="font-size:smaller;">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<h4>Pages</h4>

					<ul>
						<li><a href="index.php">Home</a>
						</li>												
						<li><a href="index.php">Positions</a>
						</li>	
						<li><a href="categories.php">Categories</a>
						</li>						
						<li><a href="companies.php">Companies</a>
						</li>							
						<li><a href="aboutus.php">About Us</a>
						</li>						
						<li><a href="contactus.php">Contact Us</a>
						</li>
					</ul>				

					<hr>
					<h4>Popular Companies</h4>
				 
					<ul>
						<?
						for($idx=0; $idx<sizeof($arr_top_companies_by_views); $idx++)
						{
						?>
							<li><a href="companies.php?c=<? echo $arr_top_companies_by_views[$idx]['id']; ?>"><? echo $arr_top_companies_by_views[$idx]['the_name']; ?></a></li>							
						<?
						}
						?>
					</ul>					
					
					<hr class="hidden-md hidden-lg hidden-sm">

				</div>
				<!-- /.col-md-3 -->

				<div class="col-md-3 col-sm-6">

					<h4>Trending Jobs</h4>
				 
					<ul>
						<?
						for($idx=0; $idx<sizeof($arr_trending_jobs); $idx++)
						{
						?>
							<li><a href="index.php?i=<? echo $arr_trending_jobs[$idx]['id']; ?>"><? echo $arr_trending_jobs[$idx]['pos_title']; ?></a></li>						
						<?
						}
						?>
					</ul>
					
					<hr>
					<h4>Popular Jobs in Israel</h4>
				 
					<ul>
						<?
						for($idx=0; $idx<sizeof($arr_top_by_views_jobs); $idx++)
						{
						?>
							<li><a href="index.php?i=<? echo $arr_top_by_views_jobs[$idx]['id']; ?>"><? echo $arr_top_by_views_jobs[$idx]['pos_title']; ?></a></li>						
						<?
						}
						?>
					</ul>					

					<hr class="hidden-md hidden-lg">

				</div>
				<!-- /.col-md-3 -->

				<div class="col-md-3 col-sm-6">

					<h4>Contact Us</h4>

					<a href="contactus.php">Contact Us</a>

					<hr class="hidden-md hidden-lg">

				</div>
				<!-- /.col-md-3 -->



				<div class="col-md-3 col-sm-6">

					<h4>Subscribe</h4>

					<p class="text-muted" style="font-size:smaller;">Get top new jobs delivered to your inbox</p>

					<form  enctype="multipart/form-data" method="post" name="SubscribeEmail">
						<div class="input-group">							
							<input type="text" class="form-control" name="subscr_email" id="subscr_email">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" onclick="SubscribeToEmail();">Subscribe!</button>
							</span>
						</div>
						<!-- /input-group -->
					</form>

					<hr>

					<h5>Join Us on Social Networks!</h5>

					<p class="social">						
						<a href="https://www.facebook.com/jobs972com" target='_blank' class="facebook external" data-animate-hover="shake"><i class="fa fa-facebook"></i></a>
						<a href="https://twitter.com/jobs972com" target='_blank' class="twitter external" data-animate-hover="shake"><i class="fa fa-twitter"></i></a>
						<a href="#" target='_blank' class="linkedin external" data-animate-hover="shake"><i class="fa fa-linkedin"></i></a>
						<a href="#" class="gplus external" data-animate-hover="shake"><i class="fa fa-google-plus"></i></a>	
						<a href="mailto: ?Subject=Find Job In Israel!" class="email external" data-animate-hover="shake"><i class="fa fa-envelope"></i></a>						
					</p>


				</div>
				<!-- /.col-md-3 -->

			</div>
			<!-- /.row -->

		</div>
		<!-- /.container -->
	</div>
	<!-- /#footer -->	
	
	<!-- End Pre Footer -->
 
 
 <!--- footer start --->
 
 <div id="copyright">
	<div class="container" style="font-size:smaller;">
		<div class="col-md-8">			
			<p class="pull-left"><? echo $small_footer; ?><span class="hidden-sm hidden-xs"> - Find Job in Israel!</span></p>		 
		</div>
		<div class="col-md-4">
			<p class="pull-right"><a href="#">Back To Top</a></p>
		</div>
	</div>
  </div>
  
 <!-- footer end -->
 
 <a href="#" class="scrollup"></a>
 
    <script src="assets/js/bootstrap.min.js"></script>

	<div class="modal fade" tabindex="-1" role="dialog" id="signUp">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Sign Up</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="signUpForm" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">
				<tr>
					<td style="padding:7px;">
						<div id="inp_su_first_name" class="form-group" >
							<label for="su_first_name">First Name</label>
							  <input class="form-control" onkeydown="limit(this, 20);" onkeyup="limit(this, 20);"
							  id="su_first_name" name="su_first_name" placeholder="Your First Name" value="" />
						</div>	
					</td> 
					<td style="padding:7px;">
						<div id="inp_su_last_name" class="form-group" >
							<label for="su_last_name">Last Name</label>
							  <input class="form-control" onkeydown="limit(this, 20);" onkeyup="limit(this, 20);"
							  id="su_last_name" name="su_last_name" placeholder="Your Last Name" value="" />
						</div>	
					</td>
				</tr>				
				<tr>
					<td style="padding:7px;">
						<div id="inp_su_email" class="form-group" >
							<label for="su_email">Email</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="su_email" name="su_email" placeholder="Your Email" value="" />
						</div>	
					</td>
					<td style="padding:7px;">
						<div id="inp_su_pwd" class="form-group" >
							<label for="su_pwd">Password</label>
							  <input type='password' class="form-control" onkeydown="limit(this, 20);" onkeyup="limit(this, 20);"
							  id="su_pwd" name="su_pwd" placeholder="Your Password" value="" />
						</div>						
					</td>
				</tr>
				<tr>
					<td style="padding:7px;">
						<div id="inp_captcha" class="form-group">
							<label for="captcha"><?php echo $a; ?> + <?php echo $b; ?> = ?</label>
							<input type="text" class="form-control" name="captcha" id="captcha">
						</div>	
					</td>
					<td style="padding:7px;">
						<!-- it's nothing to say... -->
					</td>				
				</tr>
				</table>
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="submit" onclick="signUpTheUser(); return false;" class="btn btn-primary">Register</button>
		  </div>
		  </form>
		</div> 
	  </div> 
	</div> 	

	<!--- Login Form --->
	<div class="modal fade" tabindex="-1" role="dialog" id="logIn">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Login</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="LoginForm" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">
						<div id="inp_lo_email" class="form-group" >
							<label for="lo_email">Email</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="lo_email" name="lo_email" placeholder="Your Email" value="" />
						</div>	
					</td>
					<td style="padding:7px;">
						<div id="inp_lo_pwd" class="form-group" >
							<label for="lo_pwd">Password</label>
							  <input type='password' class="form-control" onkeydown="limit(this, 20);" onkeyup="limit(this, 20);"
							  id="lo_pwd" name="lo_pwd" placeholder="Your Password" value="" />
						</div>						
					</td>
				</tr>
				<tr>
					<td style="padding:7px;">
						<div id="inp_captcha2" class="form-group">
							<label for="captcha2"><?php echo $a; ?> + <?php echo $b; ?> = ?</label>
							<input type="text" class="form-control" name="captcha2" id="captcha2">
						</div>	
					</td>
					<td style="padding:7px;">
							<!-- nothing to say --->
					</td>				
				</tr>
				</table>
		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				&nbsp;
				<!-- facebook doesn't have it, and we too :) -->
				<!--
				<div class="checkbox">
				  <label><input type="checkbox" value="">Remember Me</label>
				</div>
				-->
			</div>
			
			
			<div class="pull-left">
				<div>					
					<button type="button" onclick="ForgotPassword(); return false;" class="btn btn-warning">Forgot Password?</button>
				</div>
			</div>			
			<div class="pull-right">
				<div>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" onclick="logInTheUser(); return false;" class="btn btn-primary" >Login</button>
				</div>
			</div>
			
			<div class="clearfix"></div>
			
		  </div>
		  </form>
		</div> 
	  </div> 
	</div>	
	

	<div class="modal fade" tabindex="-1" role="dialog" id="signUpOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Sign Up</h4>
		  </div>		 
		  <div class="modal-body" style="font-size:14px;">
				Congratulations! You've registered successfully!<br/>Please check your email to verify account.
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div>

	<div class="modal fade" tabindex="-1" role="dialog" id="signUpAlreadyExists">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Sign Up</h4>
		  </div>		  
		  <div class="modal-body" style="font-size:14px;">
				Such user already exists!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 		
	
	<!-- no such user modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="logInError">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Log Up</h4>
		  </div>		  
		  <div class="modal-body" style="font-size:14px;">
				We're unable to find this user. Please check your Login and Password details.
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 

	<!-- no account verified modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="accountIsNotVerified">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Log Up</h4>
		  </div>		  
		  <div class="modal-body" style="font-size:14px;">
				It looks your account is not verified yet. Please check your email to verify your account on the Jobs972. Thank you!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 		
	
	<!--- shouldHaveAtLeastOneResumeLoadedToApply -->
	<div class="modal fade" tabindex="-1" role="dialog" id="shouldHaveAtLeastOneResumeLoadedToApply">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Please Upload Your Resume First</h4>
		  </div>
		  
		  <div class="modal-body" id="shouldHaveAtLeastOneResumeLoadedToApplyBody" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">To Apply For This Position, You Should Upload At Least One Resume.</td>
				</tr>
				</table>				
		  </div>		  
		  <div class="modal-footer">			
			<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div>	
	
	
    <!-- apply for a position modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="applyForPosition">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Apply for Position</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="frmApplyForPosition" enctype="multipart/form-data" method="post">
		  <div class="modal-body" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto; width: 95%">
				<tr>
					<td style="padding:7px;">
						<div id="inp_apply_position_name" class="form-group" >
							<label for="apply_position_name">Position:</label>
							  <input class="form-control" 
							  id="apply_position_name" name="apply_position_name" value="" readonly="readonly" />
						</div>	
					</td> 
				</tr>				
				<tr>
					<td style="padding:7px;">
						<div id="inp_apply_position_resume" class="form-group" >
							<label for="apply_position_resume">Choose Resume:</label><br/>	
							<select class="form-control" id="apply_position_resume" name="apply_position_resume" >
								<?
								for($idx=0; $idx<$num_of_resume_this_user_has; $idx++)
								{
								?>
									<option value="<? echo $arr_num_of_resumes[$idx]['id']; ?>"><? echo $arr_num_of_resumes[$idx]['file_desc']; ?></option>
								<?
								}
								?>
							</select>
						</div>	
					</td> 
				</tr>
				<tr>
					<td style="padding:7px;">
						<div id="inp_apply_resume_cover" class="form-group" >
						
							<label for="apply_resume_cover">Cover Letter:</label>							
							<label class='pull-right'><input type="checkbox" id="elTurnOnCoverLetter" onClick="TurnOnOffCoverLetter();"> Inlcude</label>
							
							  <textarea name="apply_resume_cover" placeholder="Your Cover Letter For This Position..." 
							  class="form-about-yourself form-control" id="apply_resume_cover" readonly="readonly"></textarea>							  
						</div>	
					</td> 
				</tr>				
				</table>				
				<input type="hidden" name="apply_for_this_position_id" id="apply_for_this_position_id" value="">
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="submit" onclick="ApplyForPositionYes(); return false;" class="btn btn-primary">Apply</button>
		  </div>
		  </form>
		</div> 
	  </div> 
	</div> 			
		
		
	<div class="modal fade" tabindex="-1" role="dialog" id="applyForPositionOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Apply for Position</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			Congratulations! You've successfully applied for this position!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="ApplyForPositionOkFnc();" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 			
		
	
	<div class="modal fade" tabindex="-1" role="dialog" id="applyForPositionAlreadyApplied">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Apply for Position</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			You've already applied for this position!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 	
	
	
	<!--- ResetPassword --->
	<div class="modal fade" tabindex="-1" role="dialog" id="ForgotPassword">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Forgot Password?</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="frmRemindAPassword" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">
						<div id="inp_rp_email" class="form-group" >
							<label for="rp_email">Email</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="rp_email" name="rp_email" placeholder="Your Email" value="" />
						</div>	
					</td>					 
				</tr>
				<tr>
					<td style="padding:7px;">
						<div id="inp_captcharp" class="form-group">
							<label for="captcharp"><?php echo $a; ?> + <?php echo $b; ?> = ?</label>
							<input type="text" class="form-control" name="captcharp" id="captcharp">
						</div>	
					</td>				
				</tr>				
				</table>
		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				&nbsp;
				<!-- facebook doesn't have it, and we too :) -->
				<!--
				<div class="checkbox">
				  <label><input type="checkbox" value="">Remember Me</label>
				</div>
				-->
			</div>
								
			<div class="pull-right">
				<div>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" onclick="ResetAPassword(); return false;" class="btn btn-primary">Reset A Password</button>
				</div>
			</div>
			
			<div class="clearfix"></div>
			
		  </div>
		  </form>
		</div> 
	  </div> 
	</div>		
	
	<!--- ResetPasswordOk --->
	<div class="modal fade" tabindex="-1" role="dialog" id="ForgotPasswordOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Please check your Email</h4>
		  </div>		  
		  <div class="modal-body" style="font-size:14px;">
				We've just reset your password. Please check your Email for details.
		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				&nbsp;				
			</div>
								
			<div class="pull-right">
				<div>					
					<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
				</div>
			</div>
			
			<div class="clearfix"></div>
			
		  </div>		  
		</div> 
	  </div> 
	</div>	
	
	<!-- subscribe by email -->
	<div class="modal fade" tabindex="-1" role="dialog" id="SubscribeEmail">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Subscribe By Email</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="frmSubscribeByEmail" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">
						<div id="inp_subsc_email_onform" class="form-group" >
							<label for="subsc_email_onform">Email</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="subsc_email_onform" name="subsc_email_onform" placeholder="Your Email" value="" />
						</div>	
					</td>
					<td style="padding:7px;">
						<div id="inp_subsc_fname" class="form-group" >
							<label for="subsc_fname">First Name</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="subsc_fname" name="subsc_fname" placeholder="First Name" value="" />
						</div>	
					</td>
					<td style="padding:7px;">
						<div id="inp_subsc_lname" class="form-group" >
							<label for="subsc_lname">Last Name</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="subsc_lname" name="subsc_lname" placeholder="Last Name" value="" />
						</div>	
					</td>					
				</tr>
				<tr>
					<td style="padding:7px;">
						<div id="inp_subsc_phone" class="form-group" >
							<label for="subsc_phone">Phone</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="subsc_phone" name="subsc_phone" placeholder="Phone" value="" />
						</div>	
					</td>	
					<td style="padding:7px;">
						<div id="inp_subsc_city" class="form-group" >
							<label for="subsc_city">City</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="subsc_city" name="subsc_city" placeholder="City" value="" />
						</div>	
					</td>
					<td style="padding:7px;">
						<div id="inp_captcha_subsc" class="form-group">
							<label for="captcha_subsc"><?php echo $a; ?> + <?php echo $b; ?> = ?</label>
							<input type="text" class="form-control" name="captcha_subsc" id="captcha_subsc">
						</div>	
					</td>					
				</tr>	
				<tr>
					<td style="padding:7px;" colspan="3">
						<div id="inp_subsc_allow" class="form-group">
							<div class="checkbox">
							  <label><input type="checkbox" name="subsc_allow" id="subsc_allow" value="" onclick="clickAllowSubscr();">I allow to send me emails about new positions and news from the Jobs972.com</label>
							</div>
						</div>	
					</td>					
				</tr>				
				</table>
		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				&nbsp;				
			</div>
								
			<div class="pull-right">
				<div>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button id="subscribe_button" type="submit" onclick="doSubscribeByEmail(); return false;" disabled class="btn btn-primary disabled">Subscribe</button>
				</div>
			</div>
			
			<div class="clearfix"></div>
			
		  </div>
		  </form>
		</div> 
	  </div> 
	</div>		

	<!-- subscribe by email Ok -->
	<div class="modal fade" tabindex="-1" role="dialog" id="SubscribeEmailOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Please check your Email</h4>
		  </div>		  
		  <div class="modal-body" style="font-size:14px;">
				Congratulations! You've just subscribed to get news and most attractive positions from the Jobs972.com! Please check your Email inbox to confirm your address.
		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				&nbsp;				
			</div>
								
			<div class="pull-right">
				<div>					
					<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
				</div>
			</div>
			
			<div class="clearfix"></div>
			
		  </div>		  
		</div> 
	  </div> 
	</div>		
	
	
	<!-- tell a friend -->
	<div class="modal fade" tabindex="-1" role="dialog" id="TellAFriend">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Tell A Friend</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="frmTellAFriend" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">
						<div id="inp_tellafriend_your_name" class="form-group" >
							<label for="tellafriend_your_name">Your Name</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="tellafriend_your_name" name="tellafriend_your_name" placeholder="Your Name" value="" />
						</div>	
					</td>
					<td style="padding:7px;">
						<div id="inp_tellafriend_your_email" class="form-group" >
							<label for="tellafriend_your_email">Your Email</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="tellafriend_your_email" name="tellafriend_your_email" placeholder="Your Email" value="" />
						</div>	
					</td>
				</tr>
				<tr>
					<td style="padding:7px;">
						<div id="inp_tellafriend_your_friends_name" class="form-group" >
							<label for="tellafriend_your_friends_name">Your Friend's Name</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="tellafriend_your_friends_name" name="tellafriend_your_friends_name" placeholder="Your Friend's Name" value="" />
						</div>	
					</td>
					<td style="padding:7px;">
						<div id="inp_tellafriend_your_friends_email" class="form-group" >
							<label for="tellafriend_your_friends_email">Your Friend's Email</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="tellafriend_your_friends_email" name="tellafriend_your_friends_email" placeholder="Your Friend's Email" value="" />
						</div>	
					</td>
				</tr>
				<tr>
					<td style="padding:7px;">
						<div id="inp_captcha_tellafriend" class="form-group">
							<label for="captcha_tellafriend"><?php echo $a; ?> + <?php echo $b; ?> = ?</label>
							<input type="text" class="form-control" name="captcha_tellafriend" id="captcha_tellafriend">
						</div>	
					</td>
					<td style="padding:7px;">
						<input type="hidden" name="taf_position_id" id="taf_position_id">
						<input type="hidden" name="taf_position_title" id="taf_position_title">
						<input type="hidden" name="taf_company_name" id="taf_company_name">
					</td>
				</tr>				
				</table>
		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				&nbsp;				
			</div>
								
			<div class="pull-right">
				<div>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button id="subscribe_button" type="submit" onclick="doTellAFriendOk(); return false;" class="btn btn-primary">Tell A Friend</button>
				</div>
			</div>
			
			<div class="clearfix"></div>
			
		  </div>
		  </form>
		</div> 
	  </div> 
	</div>		

	<!-- tell a friend Ok -->
	<div class="modal fade" tabindex="-1" role="dialog" id="TellAFriendOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Tell A Friend</h4>
		  </div>		  
		  <div class="modal-body" style="font-size:14px;">
				We've just told to your friend about this great position! Thank you! 
		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				&nbsp;				
			</div>								
			<div class="pull-right">
				<div>					
					<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
				</div>
			</div>			
			<div class="clearfix"></div>			
		  </div>		  
		</div> 
	  </div> 
	</div>			
	
</body>
</html>

