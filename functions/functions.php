<?php

/* --------- */
/* functions */
/* --------- */

	
function getFooter($db_conn) {
		
	if ($db_conn === NULL)
	{
		return '';
	}
	
	$sql_app_properties = "select * from app_properties";
								
	$arr_app_properties = array();		
	$results_app_properties = mysqli_query($db_conn, $sql_app_properties); 

	$small_footer = '';
	
	while($line = mysqli_fetch_assoc($results_app_properties)){
		$arr_app_properties[] = $line;
		
		if ($line[prop_name] == 'small_footer')
		{
			$small_footer = $line[prop_value];
		}
	}			
	
	return $small_footer;
}

function getItemsOnPage($db_conn, $pg_name) {

	if ($db_conn === NULL)
	{
		return 0;
	}

	$def_value = 7;
	
	$ret_value = $def_value;

	$sql_app_properties = "select * from app_properties";
								
	$arr_app_properties = array();		
	$results_app_properties = mysqli_query($db_conn, $sql_app_properties); 

	$item_per_page_index = $def_value;
	$item_per_page_companies = $def_value;
	
	while($line = mysqli_fetch_assoc($results_app_properties)){
		$arr_app_properties[] = $line;
		
		if ($line[prop_name] == 'item_per_page_index')
		{
			$item_per_page_index = $line[prop_value];
		}
		
		if ($line[prop_name] == 'item_per_page_companies')
		{
			$item_per_page_companies = $line[prop_value];
		}		
	}			
	
	switch ($pg_name)
	{
		case "INDEX":
			$ret_value = $item_per_page_index;
			break;
		case "COMPANIES":
			$ret_value = $item_per_page_companies;
			break;			
		default:
			$ret_value = $def_value;
			break;
	}
    return $ret_value;
}

function refreshRelevantPositions($db_conn)
{

	if ($db_conn === NULL)
	{
		/// nothing to do
	}
	else
	{	

		$date = new DateTime("now", new DateTimeZone('Asia/Jerusalem') );
		$cur_dt =  $date->format('d-m-Y H:i:s');  
		$db_cur_dt = $date->format('Y-m-d H:i:s'); // same format as NOW()	

		$update_sql_query = "update positions as x 
								set x.modifydt = '".$db_cur_dt."'
								where x.modifydt < DATE_SUB('".$db_cur_dt."',
																			INTERVAL (select pa.diff_in_minutes 
																						from pos_autoupd as pa 
																						where x.pos_autoupd = pa.id) DAY)  
								and exists 
									(select pa.diff_in_minutes 
										from pos_autoupd pa 
										where x.pos_autoupd = pa.id)";
		
		/* for debug purpose only */
		/* echo '>>>'.$update_sql_query.'>>> <br/>'; */
		
		mysqli_query($db_conn, $update_sql_query);
	}
		
}

function checkIfToShowItemsWithEmptyCategories($db_conn)
{
	$show_items_with_empty_categories = 0;
	
	if ($db_conn === NULL)
	{
		return $show_items_with_empty_categories;
	}
	
	$sql_app_properties = "select * from app_properties";
								
	$arr_app_properties = array();		
	$results_app_properties = mysqli_query($db_conn, $sql_app_properties); 	
	
	while($line = mysqli_fetch_assoc($results_app_properties)){
		$arr_app_properties[] = $line;
		
		if ($line[prop_name] == 'show_items_with_empty_categories')
		{
			$show_items_with_empty_categories = $line[prop_value];
		}
	}			
	
	return $show_items_with_empty_categories;	

}


function getPositionItemsFontSize($db_conn)
{

	$positions_items_font_size = 14;
	
	if ($db_conn === NULL)
	{
		return $positions_items_font_size;
	}
	
	$sql_app_properties = "select * from app_properties";
								
	$arr_app_properties = array();		
	$results_app_properties = mysqli_query($db_conn, $sql_app_properties); 	
	
	while($line = mysqli_fetch_assoc($results_app_properties)){
		$arr_app_properties[] = $line;
		
		if ($line[prop_name] == 'positions_items_font_size')
		{
			$positions_items_font_size = $line[prop_value];
		}
	}			
	
	return $positions_items_font_size;

}

function isPositionsItemsTitleBold($db_conn)
{

	$positions_items_title_bold = '';
	
	if ($db_conn === NULL)
	{
	
		$returned_array = array
		(
			array("name" => "left", "value" => ""),
			array("name" => "right", "value" => "")	
		);
		
		return $returned_array;
	}
	
	$sql_app_properties = "select * from app_properties";
								
	$arr_app_properties = array();		
	$results_app_properties = mysqli_query($db_conn, $sql_app_properties); 	
	
	while($line = mysqli_fetch_assoc($results_app_properties)){
		$arr_app_properties[] = $line;
		
		if ($line[prop_name] == 'positions_items_title_bold')
		{
			$positions_items_title_bold = $line[prop_value];
		}
	}			
	
	if ($positions_items_title_bold == 1)
	{
		$returned_array = array
		(
			array("name" => "left", "value" => "<b>"),
			array("name" => "right", "value" => "</b>")
		);	
	}
	elseif ($positions_items_title_bold == 2)
	{
		$returned_array = array
		(
			array("name" => "left", "value" => "<b>* "),
			array("name" => "right", "value" => " *</b>")
		);	
	}
	elseif ($positions_items_title_bold == 3)
	{
		$returned_array = array
		(
			array("name" => "left", "value" => "* "),
			array("name" => "right", "value" => " *")
		);	
	}
	elseif ($positions_items_title_bold == 4)
	{
		$returned_array = array
		(
			array("name" => "left", "value" => "** "),
			array("name" => "right", "value" => " **")
		);	
	}
	elseif ($positions_items_title_bold == 5)
	{
		$returned_array = array
		(
			array("name" => "left", "value" => "*** "),
			array("name" => "right", "value" => " ***")
		);	
	}
	elseif ($positions_items_title_bold == 6)
	{
		$returned_array = array
		(
			array("name" => "left", "value" => "<b>*** "),
			array("name" => "right", "value" => " ***</b>")
		);	
	}	
	elseif ($positions_items_title_bold == 7)
	{
		$returned_array = array
		(
			array("name" => "left", "value" => "<b>^^^ "),
			array("name" => "right", "value" => " ^^^</b>")
		);	
	}		
	else
	{
		$returned_array = array
		(
			array("name" => "left", "value" => ""),
			array("name" => "right", "value" => "")
		);	
	}	
	
	return $returned_array;

}


function getTrandingJobs($db_conn, $nTop)
{

	$arr_trending_jobs = array();	

	if ($db_conn === NULL)
	{
		return $arr_trending_jobs;
	}	

	$sql_trending_jobs = "select pos_title, id from positions where pos_status='1' order by napply desc, nviews desc limit 0, ".$nTop;
										
	$results_trending_jobs = mysqli_query($db_conn, $sql_trending_jobs); 	
	
	while($line = mysqli_fetch_assoc($results_trending_jobs)){
		$arr_trending_jobs[] = $line;
	}	

	return $arr_trending_jobs;
}


function getTopByViewsJobs($db_conn, $nTop)
{

	$arr_top_by_views_jobs = array();	

	if ($db_conn === NULL)
	{
		return $arr_top_by_views_jobs;
	}	

	$sql_trending_jobs = "select pos_title, id from positions where pos_status='1' order by nviews desc limit 0, ".$nTop;
										
	$results_trending_jobs = mysqli_query($db_conn, $sql_trending_jobs); 	
	
	while($line = mysqli_fetch_assoc($results_trending_jobs)){
		$arr_top_by_views_jobs[] = $line;
	}	

	return $arr_top_by_views_jobs;
}


function getTopCompaniesByViews($db_conn, $nTop)
{

	$arr_top_companies_by_views = array();	

	if ($db_conn === NULL)
	{
		return $arr_top_companies_by_views;
	}	

	$sql_top_companies_by_views = "select id, the_name from company where status = '1' order by nviews desc limit 0, ".$nTop;
										
	$results_top_companies_by_views = mysqli_query($db_conn, $sql_top_companies_by_views); 	
	
	while($line = mysqli_fetch_assoc($results_top_companies_by_views)){
		$arr_top_companies_by_views[] = $line;
	}	

	return $arr_top_companies_by_views;
}



function getPositionItemsBackgroundColor($db_conn)
{

	$positions_items_background_index = '#ffffff';
	
	if ($db_conn === NULL)
	{
		return $positions_items_background_index;
	}
	
	$sql_app_properties = "select * from app_properties";
								
	$arr_app_properties = array();		
	$results_app_properties = mysqli_query($db_conn, $sql_app_properties); 	
	
	while($line = mysqli_fetch_assoc($results_app_properties)){
		$arr_app_properties[] = $line;
		
		if ($line[prop_name] == 'positions_items_background_index')
		{
			$positions_items_background_index = $line[prop_value];
		}
	}			
	
	if (substr($positions_items_background_index, 0, 1) == '#')
	{
		// Ok
	}
	else
	{
		$positions_items_background_index = "#ffffff";
	}	
	
	return $positions_items_background_index;

}



function getPositionItemsHeaderBackgroundColor($db_conn)
{

	$positions_items_header_background_index = '#f5f5f5';
	
	if ($db_conn === NULL)
	{
		return $positions_items_header_background_index;
	}
	
	$sql_app_properties = "select * from app_properties";
								
	$arr_app_properties = array();		
	$results_app_properties = mysqli_query($db_conn, $sql_app_properties); 	
	
	while($line = mysqli_fetch_assoc($results_app_properties)){
		$arr_app_properties[] = $line;
		
		if ($line[prop_name] == 'positions_items_header_background_index')
		{
			$positions_items_header_background_index = $line[prop_value];
		}
	}			
	
	if (substr($positions_items_header_background_index, 0, 1) == '#')
	{
		// Ok
	}
	else
	{
		$positions_items_header_background_index = "#f5f5f5";
	}
		
	return $positions_items_header_background_index;	        

}


function getRegionsEnglish($db_conn)
{

	$sql_regions = "select distinct region_en from city where status='1' and region_en != '' order by 1";
								
	$arr_regions = array();		
	$results_regions = mysqli_query($db_conn, $sql_regions); 	
	
	while($line = mysqli_fetch_assoc($results_regions)){
		$arr_regions[] = $line;
	}
	
	return $arr_regions;

}

function getCities($db_conn)
{

	$sql_cities = "select name_en, id from city where status='1' order by 1";
								
	$arr_cities = array();		
	$results_cities = mysqli_query($db_conn, $sql_cities); 	
	
	while($line = mysqli_fetch_assoc($results_cities)){
		$arr_cities[] = $line;
	}
	
	return $arr_cities;

}

function getCategories($db_conn)
{

	$sql_cat = "select distinct c.id catid, c.cat_name, c.n_pos
							from category c , sub_category sc 
							where c.id = sc.cat_id
							order by c.cat_name";
							
	$arr_cat = array();
	$results_cat = mysqli_query($db_conn, $sql_cat); 	
		
	while($line = mysqli_fetch_assoc($results_cat)){
		$arr_cat[] = $line;
	}	
	
	return $arr_cat;

}

function getAllTheActiveCompanies($db_conn)
{

	$sql_all_the_companies = "select co.id, 
							DATE_FORMAT(co.modifydt,'%d/%m/%Y') moddt, 
							co.the_name,
							CONCAT(UCASE(LEFT(co.the_name, 1)), LCASE(SUBSTRING(co.the_name, 2))) the_name_b,
							ci.name_en locatio,
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
							co.founded
						from company co, city ci 
						where co.placement_id = ci.id
						and co.status = '1'
						order by co.the_name";						

	$arr_all_the_companies = array();		
	$results_all_the_companies = mysqli_query($db_conn, $sql_all_the_companies); 

	while($line = mysqli_fetch_assoc($results_all_the_companies)){
		$arr_all_the_companies[] = $line;	
	}	
	
	return $arr_all_the_companies;

}


function getCategoriesAndSubCategories($db_conn)
{
	$sql_cat_and_subcat = "select c.id catid, c.cat_name, sc.id scatid, sc.subcat_name, c.n_pos
							from category c , sub_category sc 
							where c.id = sc.cat_id
							order by c.cat_name, sc.subcat_name";
							
	$arr_cat_and_subcat = array();
	$results_cat_and_subcat = mysqli_query($db_conn, $sql_cat_and_subcat); 	
		
	while($line = mysqli_fetch_assoc($results_cat_and_subcat)){
		$arr_cat_and_subcat[] = $line;
	}	
	
	return $arr_cat_and_subcat;
}


function getCategoriesItemsBackgroundColor($db_conn)
{

	$categories_items_background = '#ffffff';
	
	if ($db_conn === NULL)
	{
		return $categories_items_background;
	}
	
	$sql_app_properties = "select * from app_properties";
								
	$arr_app_properties = array();		
	$results_app_properties = mysqli_query($db_conn, $sql_app_properties); 	
	
	while($line = mysqli_fetch_assoc($results_app_properties)){
		$arr_app_properties[] = $line;
		
		if ($line[prop_name] == 'categories_items_background')
		{
			$categories_items_background = $line[prop_value];
		}
	}			
	
	if (substr($categories_items_background, 0, 1) == '#')
	{
		// Ok
	}
	else
	{
		$categories_items_background = "#ffffff";
	}	
	
	return $categories_items_background;

}



function getCompaniesItemsBackgroundColor($db_conn)
{

	$companies_items_background = '#ffffff';
	
	if ($db_conn === NULL)
	{
		return $companies_items_background;
	}
	
	$sql_app_properties = "select * from app_properties";
								
	$arr_app_properties = array();		
	$results_app_properties = mysqli_query($db_conn, $sql_app_properties); 	
	
	while($line = mysqli_fetch_assoc($results_app_properties)){
		$arr_app_properties[] = $line;
		
		if ($line[prop_name] == 'companies_items_background')
		{
			$companies_items_background = $line[prop_value];
		}
	}			
	
	if (substr($companies_items_background, 0, 1) == '#')
	{
		// Ok
	}
	else
	{
		$companies_items_background = "#ffffff";
	}	
	
	return $companies_items_background;

}

?>