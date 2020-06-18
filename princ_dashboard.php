<?php session_start(); 

if (!$_SESSION['princ_login'])
{
	header("Location: principal/index.php");
	exit;
}

?>

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
		$c = intval ($_GET['c']);
		$c = str_replace("\'", "", $c);
		$c = str_replace("\"", "", $c);
		$c = str_replace("&", "", $c);
		$c = str_replace("!", "", $c);
		$c = str_replace(":", "", $c);
		$c = str_replace("\\", "", $c);
						
		if (round($c, 0) == $c)
		{							 
			if ($c <= 0) 
			{
				$c = -1;
			}
			else
			{
				// Ok			 
			}
		}
		else
		{				
			$c = -1;
		}
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

	$num_posts_per_page  = 7;
	$start_position = ($p - 1) * $num_posts_per_page;
	$num_recs_to_retrieve = $num_posts_per_page;

	// conn db parameters
	require_once('inc/db_connect.php');
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$conn->query("set names 'utf8'");		
	
	$sql_cities = "select name_en, id from city where status='1' order by 1";
								
	$arr_cities = array();		
	$results_cities = mysqli_query($conn, $sql_cities); 	
	
	while($line = mysqli_fetch_assoc($results_cities)){
		$arr_cities[] = $line;
	}			
	
	// get principal details
	
	$sql_princ_details = "select * from principals where princ_email = upper(trim('".$_SESSION['princ_email']."'))";	
	
	$arr_princ_details = array();
	$results_princ_details = mysqli_query($conn, $sql_princ_details); 

	while($line = mysqli_fetch_assoc($results_princ_details)){
		$arr_princ_details[] = $line;
	}	
	
	$sql_trending_jobs = "select pos_title, id from positions order by napply desc, nviews desc limit 0, 7";
								
	$arr_trending_jobs = array();		
	$results_trending_jobs = mysqli_query($conn, $sql_trending_jobs); 	
	
	while($line = mysqli_fetch_assoc($results_trending_jobs)){
		$arr_trending_jobs[] = $line;
	}	
	
	$sql_regions = "select distinct region_en from city where status='1' and region_en != '' order by 1";
								
	$arr_regions = array();		
	$results_regions = mysqli_query($conn, $sql_regions); 	
	
	while($line = mysqli_fetch_assoc($results_regions)){
		$arr_regions[] = $line;
	}

	$sql_company_types = "select * from company_type where status='1' order by value";
								
	$arr_company_types = array();		
	$results_company_types = mysqli_query($conn, $sql_company_types); 	
	
	while($line = mysqli_fetch_assoc($results_company_types)){
		$arr_company_types[] = $line;
	}

	$sql_company_industries = "select * from company_industry where status='1' order by value";
								
	$arr_company_industries = array();		
	$results_company_industries = mysqli_query($conn, $sql_company_industries); 	
	
	while($line = mysqli_fetch_assoc($results_company_industries)){
		$arr_company_industries[] = $line;
	}		
	
	$sql_princ_companies = "select co.id, co.the_name
							from company co, principal_company_link pcl 
							where 
								co.id=pcl.comp_id 
							and 
								pcl.princ_id= ".$_SESSION['princ_id']."
							and 
								co.status in ('1','2') 
							order 
								by co.the_name";
								
	$arr_princ_companies = array();		
	$results_princ_companies = mysqli_query($conn, $sql_princ_companies); 	
	
	while($line = mysqli_fetch_assoc($results_princ_companies)){
		$arr_princ_companies[] = $line;
	}	
	
	$sql_job_type = "select jt.id, jt.name
							from job_type jt 
							where jt.status = '1'
							order by jt.name";
								
	$arr_job_type = array();		
	$results_job_type = mysqli_query($conn, $sql_job_type); 	
	
	while($line = mysqli_fetch_assoc($results_job_type)){
		$arr_job_type[] = $line;
	}		
		
	$sql_categories = "select ca.id, ca.cat_name
							from category ca 							
							order by ca.cat_name";
								
	$arr_categories = array();		
	$results_categories = mysqli_query($conn, $sql_categories); 	
	
	while($line = mysqli_fetch_assoc($results_categories)){
		$arr_categories[] = $line;
	}	
	
	$sql_categories_and_subcategories = "select ca.cat_name, ca.id cat_id, sca.subcat_name, sca.id subcat_id
											from category ca
                                            join sub_category sca on sca.cat_id = ca.id
                                            order by ca.cat_name, subcat_name";
								
	$arr_categories_and_subcategories = array();		
	$results_categories_and_subcategories = mysqli_query($conn, $sql_categories_and_subcategories); 	
	
	while($line = mysqli_fetch_assoc($results_categories_and_subcategories)){
		$arr_categories_and_subcategories[] = $line;
	}		
	
	
	$princ_id = $_SESSION['princ_id'];
	
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
	

	$sql_princ_search_positions = "select distinct p.pos_title				
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
				p.company_id = co.id
			and 
				pcl.princ_id = $princ_id 
			order by 1";

	$arr_princ_search_positions = array();		
	$results_princ_search_positions = mysqli_query($conn, $sql_princ_search_positions); 	
	
	while($line = mysqli_fetch_assoc($results_princ_search_positions)){
		$arr_princ_search_positions[] = $line;
	}	
	
	$sql_princ_search_companies = "select distinct co.the_name				
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
				p.company_id = co.id
			and 
				pcl.princ_id = $princ_id 
			order by 1";

	$arr_princ_search_companies = array();		
	$results_princ_search_companies = mysqli_query($conn, $sql_princ_search_companies); 	
	
	while($line = mysqli_fetch_assoc($results_princ_search_companies)){
		$arr_princ_search_companies[] = $line;
	}		
	
	$sql_princ_search_locations = "select distinct ci.name_en				
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
				p.company_id = co.id
			and 
				pcl.princ_id = $princ_id 
			order by 1";

	$arr_princ_search_locations = array();		
	$results_princ_search_locations = mysqli_query($conn, $sql_princ_search_locations); 	
	
	while($line = mysqli_fetch_assoc($results_princ_search_locations)){
		$arr_princ_search_locations[] = $line;
	}		
	
	
	$sql_principal_applied_names = "select distinct concat(upper(substr(u.firstname,1,1)), lower(substr(u.firstname,2,100)),' ',upper(substr(u.lastname,1,1)), lower(substr(u.lastname,2,100))) the_name
			from 
				user_positions up, 
				positions p, 
				users u, 
				company co, 
				city ci, 
				resumes r
			where 
				up.status = 'A'
					   and p.id = up.pos_id
					   and up.user_id = u.id
					   and r.id = up.res_id
					   and p.company_id = co.id
					   and co.placement_id = ci.id
					   and p.pos_status = '1'
					   and u.status = '1'					  
					   and p.principal_id = $princ_id 
					   order by 1";
			
	$arr_principal_applied_names = array();		
	$results_principal_applied_names = mysqli_query($conn, $sql_principal_applied_names); 	
	
	while($line = mysqli_fetch_assoc($results_principal_applied_names)){
		$arr_principal_applied_names[] = $line;
	}	
	
	
	$sql_principal_applied_positions = "select distinct pos_title  
			from 
				user_positions up, 
				positions p, 
				users u, 
				company co, 
				city ci, 
				resumes r
			where 
				up.status = 'A'
					   and p.id = up.pos_id
					   and up.user_id = u.id
					   and r.id = up.res_id
					   and p.company_id = co.id
					   and co.placement_id = ci.id
					   and p.pos_status = '1'
					   and u.status = '1'					  
					   and p.principal_id = $princ_id 
					   order by 1";
			
	$arr_principal_applied_positions = array();		
	$results_principal_applied_positions = mysqli_query($conn, $sql_principal_applied_positions); 	
	
	while($line = mysqli_fetch_assoc($results_principal_applied_positions)){
		$arr_principal_applied_positions[] = $line;
	}
	
	
	$sql_principal_applied_companies = "select distinct co.the_name  
			from 
				user_positions up, 
				positions p, 
				users u, 
				company co, 
				city ci, 
				resumes r
			where 
				up.status = 'A'
					   and p.id = up.pos_id
					   and up.user_id = u.id
					   and r.id = up.res_id
					   and p.company_id = co.id
					   and co.placement_id = ci.id
					   and p.pos_status = '1'
					   and u.status = '1'					  
					   and p.principal_id = $princ_id 
					   order by 1";
			
	$arr_principal_applied_companies = array();		
	$results_principal_applied_companies = mysqli_query($conn, $sql_principal_applied_companies); 	
	
	while($line = mysqli_fetch_assoc($results_principal_applied_companies)){
		$arr_principal_applied_companies[] = $line;
	}
	
	
	$sql_principal_applied_locations = "select distinct ci.name_en
			from 
				user_positions up, 
				positions p, 
				users u, 
				company co, 
				city ci, 
				resumes r
			where 
				up.status = 'A'
					   and p.id = up.pos_id
					   and up.user_id = u.id
					   and r.id = up.res_id
					   and p.company_id = co.id
					   and co.placement_id = ci.id
					   and p.pos_status = '1'
					   and u.status = '1'					  
					   and p.principal_id = $princ_id 
					   order by 1";
			
	$arr_principal_applied_locations = array();		
	$results_principal_applied_locations = mysqli_query($conn, $sql_principal_applied_locations); 	
	
	while($line = mysqli_fetch_assoc($results_principal_applied_locations)){
		$arr_principal_applied_locations[] = $line;
	}	
	
	
	$sql_candidates_names = "select 
					concat(upper(substr(us.firstname, 1, 1)), lower(substr(us.firstname, 2, 100)),' ', upper(substr(us.lastname,1,1)), lower(substr(us.lastname, 2, 100))) the_name 
			from 
				users us					
			where 
				us.status = 1			
			and
				us.is_verified = '1' ";

	$arr_candidates_names = array();		
	$results_candidates_names = mysqli_query($conn, $sql_candidates_names); 	
	
	while($line = mysqli_fetch_assoc($results_candidates_names)){
		$arr_candidates_names[] = $line;
	}	
	
	
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
  <?
  }
  else
  {
  ?>
  <meta name="description" content="<?php echo "Jobs972.com: ".$arr_positions[0]['pos_title']." @ ".$arr_positions[0]['company_name']; ?>">
  <meta name="keywords" content="<? echo $arr_positions[0]['pos_title']; ?>, <? echo $arr_positions[0]['company_name']; ?>, <? echo $arr_positions[0]['locatio']; ?>, find, job, Israel, עבודה, חיפוש, הייטק, משרות, איכותי, דרושים, לוח, High, Paying, search, employment, companies, work, 972, hr, human, resources">

  <title><?php echo $arr_positions[0]['pos_title']." @ ".$arr_positions[0]['company_name']; ?></title>  
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
	
<style>

body {
    font-family: 'Roboto', sans-serif;
    font-size: 18px;  	
}

.navbar-brand > a
{   
  font-size: 20px;
  font-weight: bold;
  margin: 0px;
  text-decoration: none;
}

#copyright {
  background: #333;
  color: #ffffff;
  padding: 20px 0;
  font-size: 18px;
}

#copyright p {
  margin: 0;
}

#footer {
  background: #e0e0e0;
  padding: 20px 0;
}

#footer ul {
  padding-left: 0;
  list-style: none;
}

#footer ul a {
  color: #999999;
}

#footer .social {
  text-align: left;
}

#footer .social a {
  margin: 0 10px 0 0;
  color: #fff;
  display: inline-block;
  width: 30px;
  height: 30px;
  border-radius: 15px;
  line-height: 26px;
  font-size: 15px;
  text-align: center;
  -webkit-transition: all 0.2s ease-out;
  -moz-transition: all 0.2s ease-out;
  transition: all 0.2s ease-out;
  vertical-align: bottom;
  background-color: #555555;
}

#footer .social a i {
  vertical-align: bottom;
  line-height: 30px;
}

#footer .social a.odnoklassniki:hover {
  background-color: #f8892c;
}		

#footer .social a.facebook:hover {
  background-color: #4460ae;
}

#footer .social a.gplus:hover {
  background-color: #c21f25;
}

#footer .social a.twitter:hover {
  background-color: #3cf;
}

#footer .social a.instagram:hover {
  background-color: #cd4378;
}

#footer .social a.email:hover {
  background-color: #4a7f45;
}

#footer .social a.linkedin:hover {
  background-color: #0177b5;
}

.jumbotron { 
    background: url("images/jmb_back2.jpg"); 
    color: #FFF;
}

.navbar-toggle {
  border-color: transparent; /* Removes border color */
  /* float: left;  Move navbar toggle to left */
}

.navbar-toggle .icon-bar {
  background-color: #337ab7; /* Changes regular toggle color */
}

.navbar-toggle .icon-bar:hover {
  background-color: #337ab7; /* Changes toggle color on hover */
}

#tell_a_friend .social {
  text-align: left;
}

#tell_a_friend .social a {
  margin: 0 10px 0 0;
  color: #fff;
  display: inline-block;
  width: 30px;
  height: 30px;
  border-radius: 15px;
  line-height: 26px;
  font-size: 15px;
  text-align: center;
  -webkit-transition: all 0.2s ease-out;
  -moz-transition: all 0.2s ease-out;
  transition: all 0.2s ease-out;
  vertical-align: bottom;
  background-color: #555555;
}

#tell_a_friend .social a i {
  vertical-align: bottom;
  line-height: 30px;
}

#tell_a_friend .social a.odnoklassniki {
  background-color: #f8892c;
}		

#tell_a_friend .social a.facebook {
  background-color: #4460ae;
}

#tell_a_friend .social a.gplus {
  background-color: #c21f25;
}

#tell_a_friend .social a.twitter {
  background-color: #3cf;
}

#tell_a_friend .social a.instagram {
  background-color: #cd4378;
}

#tell_a_friend .social a.email {
  background-color: #4a7f45;
}	

#tell_a_friend .social a.linkedin {
  background-color: #0177b5;
}

.navbar-nav > .active{
background: #eeeeee;
}
.navbar-default .navbar-nav > .active > a, 
.navbar-default .navbar-nav > .active > a:hover, 
.navbar-default .navbar-nav > .active > a:focus {  
  background: #ffffff;
}

</style>

<script>

function informCompanyAboutAppliedPositionOkFunc()
{
	getPrincipalAppliedAjax(1, -25, -25, -25, -25);
}

function change_suggested_use()
{
		if (document.getElementById('suggested_use').checked) 
		{
			if (validateEmail(document.getElementById("ic_email_s").value) && (document.getElementById("ic_email_s").value != ''))
			{
				document.getElementById("ic_email").value=document.getElementById("ic_email_s").value;	
			}
			else
			{
				document.getElementById("ic_email").value='';	
				document.getElementById("ic_email").style.borderColor = "lightgray";
				document.getElementById("ic_email").style.boxShadow = "none";			
			}
        } 
		else 
		{
			document.getElementById("ic_email").value='';	
			document.getElementById("ic_email").style.borderColor = "lightgray";
			document.getElementById("ic_email").style.boxShadow = "none";
        }
}

function informTheCompany(n,p,c,cand,r,e)
{	

	document.getElementById('suggested_use').checked = false;
	
	document.getElementById("ic_email").value='';	
	document.getElementById("ic_email").style.borderColor = "lightgray";
	document.getElementById("ic_email").style.boxShadow = "none";
		
	document.getElementById('informTheCompanyUserPositionId').value = n;
	document.getElementById('ic_position').value = p;
	document.getElementById('ic_company').value = c;
	document.getElementById('ic_candidate').value = cand;
	document.getElementById('ic_resume').value = r;
	document.getElementById('ic_email_s').value = e;
	
	$('#informCompanyAboutAppliedPosition').modal('show');
}

function informTheCompanyAjax()
{	
	
	nErrors=0;
	
	if (document.getElementById("ic_email").value==null || document.getElementById("ic_email").value=="")
	{
		document.getElementById("ic_email").style.borderColor = "red";
		document.getElementById("ic_email").style.boxShadow = "3px 3px 3px lightgray";			
		nErrors++;
	}	
	else if (!validateEmail(document.getElementById("ic_email").value))
	{			
		document.getElementById("ic_email").style.borderColor = "red";
		document.getElementById("ic_email").style.boxShadow = "3px 3px 3px lightgray";	
		nErrors++;			
	}		
	else 
	{
		document.getElementById("ic_email").style.borderColor = "green";
		document.getElementById("ic_email").style.boxShadow = "2px 2px 2px lightgray";
	}	

	if (nErrors==0)
	{
		
		$('#informCompanyAboutAppliedPosition').modal('hide');
		
		var n = document.getElementById('informTheCompanyUserPositionId').value;
		var ic_email = document.getElementById('ic_email').value;
		
		
		var http = new XMLHttpRequest();
		var url = "inform_company_about_applied_position.php";
		var params = "n="+n+"&ic_email="+ic_email;
		http.open("POST", url, true);

		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200) {
				  
				 // alert(http.responseText);					  				 
				 $('#informCompanyAboutAppliedPositionOk').modal('show');
			}
		}
		http.send(params);
		
	}
}

function searchPrincipalCandidatesDialogOk()
{
	pos_search_candidates_name = document.getElementById('pos_search_candidates_name').value;
	pos_search_keyword = document.getElementById('pos_search_keyword').value;
			
	getPrincipalCandidatesAjax( 1, 
								pos_search_candidates_name, 
								pos_search_keyword);
}

function searchPrincipalCandidatesDialogResetAll()
{
	document.getElementById('pos_search_candidates_name').value = -25;
	document.getElementById('pos_search_keyword').value = "";
}

function searchPrincipalCandidateForm()
{
	$('#searchPrincipalCandidateDialog').modal('show');
}

function searchPrincipalAppliedDialogResetAll()
{
	document.getElementById('pos_search_applied_name').value = -25;
	document.getElementById('pos_search_applied_position').value = -25;
	document.getElementById('pos_search_applied_company').value = -25;
	document.getElementById('pos_search_applied_location').value = -25;
}

function searchPrincipalAppliedDialogOk()
{
	pos_search_applied_name = document.getElementById('pos_search_applied_name').value;
	pos_search_applied_position = document.getElementById('pos_search_applied_position').value;
	pos_search_applied_company = document.getElementById('pos_search_applied_company').value;
	pos_search_applied_location = document.getElementById('pos_search_applied_location').value;
			
	getPrincipalAppliedAjax( 1, 
							 pos_search_applied_name, 
							 pos_search_applied_position, 
							 pos_search_applied_company, 
							 pos_search_applied_location );
}

function searchPrincipalAppliedForm()
{
	$('#searchPrincipalAppliedDialog').modal('show');
}

function searchPrincipalPositionDialogResetAll()
{
	document.getElementById('pos_search_title').value = -25;
	document.getElementById('pos_search_company').value = -25;
	document.getElementById('pos_search_location').value = -25;
}

function searchPrincipalPositionDialogOk()
{
	pos_search_title = document.getElementById('pos_search_title').value;
	pos_search_company = document.getElementById('pos_search_company').value;
	pos_search_location = document.getElementById('pos_search_location').value;
			
	getPrincipalPositionsAjax(1, pos_search_title, pos_search_company, pos_search_location);
}

function searchPrincipalPositionForm()
{	
	$('#searchPrincipalPositionDialog').modal('show');	
}

function renewPrincipalPositionFormOk()
{
	getPrincipalPositionsAjax(1, -25, -25, -25);
}

function renewPrincipalPositionForm(n)
{

	var http = new XMLHttpRequest();
	var url = "renew_this_position.php";
	var params = "pos_id="+n;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			  
			  // alert(http.responseText);					  
			  $('#renewPositionOk').modal('show');	
		}
	}
	http.send(params);
		 
}

function notRelevantPrincipalApplied(n,p,c)
{	
	var http = new XMLHttpRequest();
	var url = "notRelevantPrincipalApplied.php";
	var params = 'n='+n+'&the_position_title='+p+'&the_candidate_name='+c;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {			   
			   getPrincipalAppliedAjax(1,-25, -25, -25, -25);
		}
	}
	http.send(params);		
}

function getPrincipalCandidatesAjax(n_page, pos_search_candidates_name, pos_search_keyword)
{	

	pos_search_keyword = pos_search_keyword.replace("\'", "");
	pos_search_keyword = pos_search_keyword.replace("\"", "");
	pos_search_keyword = pos_search_keyword.replace("'", "");
	pos_search_keyword = pos_search_keyword.replace("&", "");
	pos_search_keyword = pos_search_keyword.replace("!", "");
	pos_search_keyword = pos_search_keyword.replace("\\", "");
	pos_search_keyword = pos_search_keyword.replace(";", "");
	pos_search_keyword = pos_search_keyword.replace("(", "");
	pos_search_keyword = pos_search_keyword.replace(")", "");
	pos_search_keyword = pos_search_keyword.replace("%", "");
	
	if (pos_search_candidates_name == '-25')
	{
		document.getElementById('pos_search_candidates_name').value = -25;
	}

	if (pos_search_keyword == '')
	{
		document.getElementById('pos_search_keyword').value = '';
	}

	document.getElementById("divPrincipalCandidates").style.display = "none";
	$('#candidates').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');

	var http = new XMLHttpRequest();
	var url = "getPrincipalCandidates.php";
	var params = "the_curr_page="+n_page+"&recs_per_page=9&pos_search_candidates_name="+pos_search_candidates_name+"&pos_search_keyword="+pos_search_keyword;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			  // alert(http.responseText);		
			  
			  var response_data = JSON.parse(http.responseText);

			  $('#loader').remove();
			  document.getElementById("divPrincipalCandidates").style.display = "block";
			  document.getElementById("divPrincipalCandidates").innerHTML = response_data.val_1;
			  document.getElementById("num_candidates_rec_no").innerHTML = response_data.val_2;
			  
		}
	}
	http.send(params);	
}

function getPrincipalAppliedAjax(n_page, pos_search_applied_name, pos_search_applied_position, pos_search_applied_company, pos_search_applied_location)
{	
	if (pos_search_applied_name == '-25')
	{
		document.getElementById('pos_search_applied_name').value = -25;
	}

	if (pos_search_applied_position == '-25')
	{
		document.getElementById('pos_search_applied_position').value = -25;
	}

	if (pos_search_applied_company == '-25')
	{
		document.getElementById('pos_search_applied_company').value = -25;
	}

	if (pos_search_applied_location == '-25')
	{
		document.getElementById('pos_search_applied_location').value = -25;
	}	
	
	document.getElementById("divPrincipalApplied").style.display = "none";
	$('#applied').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');

	var http = new XMLHttpRequest();
	var url = "getPrincipalApplied.php";
	var params = "the_curr_page="+n_page+"&recs_per_page=5"+"&pos_search_applied_name="+pos_search_applied_name+"&pos_search_applied_position="+pos_search_applied_position+"&pos_search_applied_company="+pos_search_applied_company+"&pos_search_applied_location="+pos_search_applied_location;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			  // alert(http.responseText);		
			  
			  var response_data = JSON.parse(http.responseText);

			  $('#loader').remove();
			  document.getElementById("divPrincipalApplied").style.display = "block";
			  document.getElementById("divPrincipalApplied").innerHTML = response_data.val_1;
			  document.getElementById("num_applied_rec_no").innerHTML = response_data.val_2;
			  
		}
	}
	http.send(params);	
}

function approvePrincipalPositionAjaxOk()
{
	location.reload(true);	
}

function approvePrincipalPositionForm(n)
{
	var http = new XMLHttpRequest();
	var url = "approve_this_position.php";
	var params = "pos_id="+n;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			  
			  // alert(http.responseText);					  
			  $('#approvePositionOk').modal('show');	
		}
	}
	http.send(params);
}

function approvePrincipalCompaniesAjaxOk()
{
	location.reload(true);	
	//getPrincipalCompaniesAjax(1);
}

function approvePrincipalCompanyForm(n)
{

	var http = new XMLHttpRequest();
	var url = "approve_the_company.php";
	var params = "comp_id="+n;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			  
			  // alert(http.responseText);					  
			  $('#approveCompanyOk').modal('show');	
		}
	}
	http.send(params);
		 
}

function editPrincipalPositionAjaxOk()
{
	//location.reload(true);
	getPrincipalPositionsAjax(1, -25, -25, -25);
}

function editPrincipalPositionAjax()
{
		// 		
		nErrors=0;
		
		// position_title_e
		if (document.getElementById("position_title_e").value==null || document.getElementById("position_title_e").value=="")
		{				
			document.getElementById("position_title_e").style.borderColor = "red";
			document.getElementById("position_title_e").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("position_title_e").style.borderColor = "green";
			document.getElementById("position_title_e").style.boxShadow = "2px 2px 2px lightgray";
		}			
		
		// company_nm_e
		if (document.getElementById("company_nm_e").value==null || document.getElementById("company_nm_e").value==-10)
		{				
			document.getElementById("company_nm_e").style.borderColor = "red";
			document.getElementById("company_nm_e").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_nm_e").style.borderColor = "green";
			document.getElementById("company_nm_e").style.boxShadow = "2px 2px 2px lightgray";
		}	
		

		// pos_type_e
		if (document.getElementById("pos_type_e").value==null || document.getElementById("pos_type_e").value==-10)
		{				
			document.getElementById("pos_type_e").style.borderColor = "red";
			document.getElementById("pos_type_e").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("pos_type_e").style.borderColor = "green";
			document.getElementById("pos_type_e").style.boxShadow = "2px 2px 2px lightgray";
		}
		
		// pos_desc_eng_e
		if (document.getElementById("pos_desc_eng_e").value==null || document.getElementById("pos_desc_eng_e").value=="")
		{				
			document.getElementById("pos_desc_eng_e").style.borderColor = "red";
			document.getElementById("pos_desc_eng_e").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("pos_desc_eng_e").style.borderColor = "green";
			document.getElementById("pos_desc_eng_e").style.boxShadow = "2px 2px 2px lightgray";
		}		
		
		if (nErrors==0)
		{				
			
			var url = "edit_the_position.php";
						
			var oData = new FormData(document.forms.namedItem("frm_editPosition"));
			
			var oReq = new XMLHttpRequest();
			  oReq.open("POST", url, true);
			  oReq.onload = function(oEvent) {
									
				if (oReq.status == 200) 
				{			
					    // alert('>>'+oReq.responseText);
						 
						$('#editPosition').modal('hide');
						$('#editPositionOk').modal('show');							
						
					return;
					
				} else {
				  alert("Error " + oReq.status + " occurred.<br \/>");
				}
			  };

			oReq.send(oData); 
		}
}

function editPrincipalPositionForm(n)
{

	document.getElementById("position_title_e").style.borderColor = "lightgray";
	document.getElementById("position_title_e").style.boxShadow = "none";	
	
	document.getElementById("company_nm_e").style.borderColor = "lightgray";
	document.getElementById("company_nm_e").style.boxShadow = "none";		
	
	document.getElementById("pos_type_e").style.borderColor = "lightgray";
	document.getElementById("pos_type_e").style.boxShadow = "none";	
	
	document.getElementById("pos_desc_eng_e").style.borderColor = "lightgray";
	document.getElementById("pos_desc_eng_e").style.boxShadow = "none";		
	
	// open a dialog to edit position details...
	$('#editPosition').modal('show');
	
	document.getElementById("divEditThePositionBodyTable").style.display = "none";
	$('#divEditThePositionBody').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');

	var http = new XMLHttpRequest();
	var url = "get_data_position.php";
	var params = "pos_id="+n;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			  // alert(http.responseText);		
			  
			  var response_data = JSON.parse(http.responseText);
			  			  						  
			  document.getElementById("pos_id_edit").value = n;
			  document.getElementById("position_title_e").value = response_data.val_0;
			  document.getElementById("inp_position_title_heb_e").value = response_data.val_1;
			  document.getElementById("company_nm_e").value = response_data.val_2;
			  document.getElementById("pos_type_e").value = response_data.val_3;
			  document.getElementById("pos_desc_eng_e").value = response_data.val_4;
			  document.getElementById("pos_desc_heb_e").value = response_data.val_5;
		 	  document.getElementById("pos_cat1_e").value = response_data.val_6;
			  populateSubCat('pos_cat1_e', 'pos_scat1_e'); 			
			  document.getElementById("pos_scat1_e").value = response_data.val_7;			  
			  document.getElementById("pos_cat2_e").value = response_data.val_8;
			  populateSubCat('pos_cat2_e', 'pos_scat2_e');
			  document.getElementById("pos_scat2_e").value = response_data.val_9;
			  document.getElementById("pos_cat3_e").value = response_data.val_10;
			  populateSubCat('pos_cat3_e', 'pos_scat3_e');
			  document.getElementById("pos_scat3_e").value = response_data.val_11;			  
			  document.getElementById("pos_contact_email_e").value = response_data.val_16;
			  document.getElementById("pos_notes_e").value = response_data.val_17;
			  document.getElementById("pos_status_e").value = response_data.val_18;
			  
			  if ((response_data.val_19 == '1') || (response_data.val_19 == '2')
					|| (response_data.val_19 == '3') || (response_data.val_19 == '4')
					|| (response_data.val_19 == '5') || (response_data.val_19 == '6')
					|| (response_data.val_19 == '7'))
			  {
				document.getElementById("pos_reoccurance_e").value = response_data.val_19;
			  }
			  else
			  {
				document.getElementById("pos_reoccurance_e").value = 0;
			  }
			  
			  
			  $('#loader').remove();
			  document.getElementById("divEditThePositionBodyTable").style.display = "";
		}
	}
	http.send(params);		
}

function addPrincipalPositionAjaxOk()
{
	getPrincipalPositionsAjax(1, -25, -25, -25);
}

function addPrincipalPositionAjax()
{
		
		// 		
		nErrors=0;
		
		// position_title
		if (document.getElementById("position_title").value==null || document.getElementById("position_title").value=="")
		{				
			document.getElementById("position_title").style.borderColor = "red";
			document.getElementById("position_title").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("position_title").style.borderColor = "green";
			document.getElementById("position_title").style.boxShadow = "2px 2px 2px lightgray";
		}			
		
		// company_nm
		if (document.getElementById("company_nm").value==null || document.getElementById("company_nm").value==-10)
		{				
			document.getElementById("company_nm").style.borderColor = "red";
			document.getElementById("company_nm").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_nm").style.borderColor = "green";
			document.getElementById("company_nm").style.boxShadow = "2px 2px 2px lightgray";
		}	
		

		// pos_type
		if (document.getElementById("pos_type").value==null || document.getElementById("pos_type").value=="-10")
		{				
			document.getElementById("pos_type").style.borderColor = "red";
			document.getElementById("pos_type").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("pos_type").style.borderColor = "green";
			document.getElementById("pos_type").style.boxShadow = "2px 2px 2px lightgray";
		}
		
		
		// pos_desc_eng
		if (document.getElementById("pos_desc_eng").value==null || document.getElementById("pos_desc_eng").value=="")
		{				
			document.getElementById("pos_desc_eng").style.borderColor = "red";
			document.getElementById("pos_desc_eng").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("pos_desc_eng").style.borderColor = "green";
			document.getElementById("pos_desc_eng").style.boxShadow = "2px 2px 2px lightgray";
		}		
		
		
		if (nErrors==0)
		{				
			
			var url = "add_new_position.php";
						
			var oData = new FormData(document.forms.namedItem("frm_addPosition"));
			
			var oReq = new XMLHttpRequest();
			  oReq.open("POST", url, true);
			  oReq.onload = function(oEvent) {
									
				if (oReq.status == 200) 
				{			
					// alert('>>'+oReq.responseText);
					 
					$('#addPosition').modal('hide');
					$('#addPositionOk').modal('show');							
						
					return;
					
				} else {
				  alert("Error " + oReq.status + " occurred.<br \/>");
				}
			  };

			oReq.send(oData); 
		}
}


function removeOptions(obj) {
    while (obj.options.length) {
        obj.remove(0);
    }
}


function populateSubCat(theCat, theSubCat)
{

	var selectCat = document.getElementById(theCat);
	var catChosen = document.getElementById(theCat).value;
	var select = document.getElementById(theSubCat);
	
	removeOptions(select);
	
	var el = document.createElement("option");
	el.textContent = "Choose...";
	el.value = '0';
	select.appendChild(el);	
	
	<?
	for($idx=0; $idx<sizeof($arr_categories_and_subcategories); $idx++)
	{
	?>
	
		if (catChosen == <? echo $arr_categories_and_subcategories[$idx]['cat_id'] ?>)
		{
			var el = document.createElement("option");
			el.textContent = '<? echo $arr_categories_and_subcategories[$idx]['subcat_name'] ?>';
			el.value = <? echo $arr_categories_and_subcategories[$idx]['subcat_id'] ?>;
			select.appendChild(el);	
		}
	
	<?
	}
	?>

}

function addPrincipalPositionForm()
{
	// initialize necessary input fields
	document.getElementById("position_title").value='';	
	document.getElementById("position_title").style.borderColor = "lightgray";
	document.getElementById("position_title").style.boxShadow = "none";
	
	document.getElementById("position_title_heb").value='';	
	document.getElementById("position_title_heb").style.borderColor = "lightgray";
	document.getElementById("position_title_heb").style.boxShadow = "none";
	
	document.getElementById("company_nm").value=-10;	
	document.getElementById("company_nm").style.borderColor = "lightgray";
	document.getElementById("company_nm").style.boxShadow = "none";	

	document.getElementById("pos_type").value=-10;	
	document.getElementById("pos_type").style.borderColor = "lightgray";
	document.getElementById("pos_type").style.boxShadow = "none";	
	
	document.getElementById("pos_desc_eng").value='';	
	document.getElementById("pos_desc_eng").style.borderColor = "lightgray";
	document.getElementById("pos_desc_eng").style.boxShadow = "none";
	
	document.getElementById("pos_desc_heb").value='';	
	document.getElementById("pos_desc_heb").style.borderColor = "lightgray";
	document.getElementById("pos_desc_heb").style.boxShadow = "none";
	
	document.getElementById("pos_cat1").value='';	
	document.getElementById("pos_cat1").style.borderColor = "lightgray";
	document.getElementById("pos_cat1").style.boxShadow = "none";	
	
	document.getElementById("pos_scat1").value='';	
	document.getElementById("pos_scat1").style.borderColor = "lightgray";
	document.getElementById("pos_scat1").style.boxShadow = "none";		
		
	document.getElementById("pos_cat2").value='';	
	document.getElementById("pos_cat2").style.borderColor = "lightgray";
	document.getElementById("pos_cat2").style.boxShadow = "none";	
	
	document.getElementById("pos_scat2").value='';	
	document.getElementById("pos_scat2").style.borderColor = "lightgray";
	document.getElementById("pos_scat2").style.boxShadow = "none";	
	
	document.getElementById("pos_cat3").value='';	
	document.getElementById("pos_cat3").style.borderColor = "lightgray";
	document.getElementById("pos_cat3").style.boxShadow = "none";
	
	document.getElementById("pos_scat3").value='';	
	document.getElementById("pos_scat3").style.borderColor = "lightgray";
	document.getElementById("pos_scat3").style.boxShadow = "none";	
	
	document.getElementById("pos_contact_email").value='';	
	document.getElementById("pos_contact_email").style.borderColor = "lightgray";
	document.getElementById("pos_contact_email").style.boxShadow = "none";	
	
	document.getElementById("pos_notes").value='';	
	document.getElementById("pos_notes").style.borderColor = "lightgray";
	document.getElementById("pos_notes").style.boxShadow = "none";	
	
	// open a dialog to enter position details...
	$('#addPosition').modal('show');
}

function getPrincipalPositionsAjax(n_page, str_title, str_company, str_location)
{	

	if (str_title == '-25')
	{
		document.getElementById('pos_search_title').value = -25;
	}

	if (str_company == '-25')
	{
		document.getElementById('pos_search_company').value = -25;
	}

	if (str_location == '-25')
	{
		document.getElementById('pos_search_location').value = -25;
	}	
	
	document.getElementById("divPrincipalPositions").style.display = "none";
	$('#positions').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');

	var http = new XMLHttpRequest();
	var url = "getPrincipalPositions.php";
	var params = "the_curr_page="+n_page+"&recs_per_page=5&str_title="+str_title+"&str_company="+str_company+"&str_location="+str_location;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			  // alert(http.responseText);		
			  
			  var response_data = JSON.parse(http.responseText);

			  $('#loader').remove();
			  document.getElementById("divPrincipalPositions").style.display = "block";
			  document.getElementById("divPrincipalPositions").innerHTML = response_data.val_1;
			  document.getElementById("num_positions_rec_no").innerHTML = response_data.val_2;
			  
		}
	}
	http.send(params);	
}


function searchPrincipalCompanyAjax()
{

	nErrors=0;
	
	// company name
	if (document.getElementById("company_name_search").value==null || document.getElementById("company_name_search").value=="-10")
	{				
		document.getElementById("company_name_search").style.borderColor = "red";
		document.getElementById("company_name_search").style.boxShadow = "3px 3px 3px lightgray";
		nErrors++;
	}			
	else
	{			
		document.getElementById("company_name_search").style.borderColor = "green";
		document.getElementById("company_name_search").style.boxShadow = "2px 2px 2px lightgray";
	}
	
	if (nErrors == 0)
	{

		$('#searchCompany').modal('hide');
		document.getElementById("divPrincipalCompanies").style.display = "none";
		$('#companies').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');

		var company_id = document.getElementById("company_name_search").value;
		var http = new XMLHttpRequest();
		var url = "getPrincipalSpecificCompany.php";
		var params = "company_id="+company_id;
		http.open("POST", url, true);

		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200) {
				  // alert(http.responseText);		
				  
				  var response_data = JSON.parse(http.responseText);

				  $('#loader').remove();
				  document.getElementById("divPrincipalCompanies").style.display = "block";
				  document.getElementById("divPrincipalCompanies").innerHTML = response_data.val_1;
				  document.getElementById("num_companies_rec_no").innerHTML = response_data.val_2;				  				  
			}
		}
		http.send(params);

	}	
}

function searchPrincipalCompanyForm()
{
	document.getElementById("company_name_search").value = -10;
	document.getElementById("company_name_search").style.borderColor = "lightgray";
	document.getElementById("company_name_search").style.boxShadow = "none";
			
	$('#searchCompany').modal('show');
}

function editPrincipalCompanyAjaxOk()
{
	//location.reload(true);
	getPrincipalCompaniesAjax(1);
}

function editPrincipalCompanyAjax()
{
		// 		
		nErrors=0;
		
		// company name
		if (document.getElementById("company_name_edit").value==null || document.getElementById("company_name_edit").value=="")
		{				
			document.getElementById("company_name_edit").style.borderColor = "red";
			document.getElementById("company_name_edit").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_name_edit").style.borderColor = "green";
			document.getElementById("company_name_edit").style.boxShadow = "2px 2px 2px lightgray";
		}			
		
		// company city
		if (document.getElementById("company_city_edit").value==null || document.getElementById("company_city_edit").value==-10)
		{				
			document.getElementById("company_city_edit").style.borderColor = "red";
			document.getElementById("company_city_edit").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_city_edit").style.borderColor = "green";
			document.getElementById("company_city_edit").style.boxShadow = "2px 2px 2px lightgray";
		}	
		

		// company description english
		if (document.getElementById("company_desc_eng_edit").value==null || document.getElementById("company_desc_eng_edit").value=="")
		{				
			document.getElementById("company_desc_eng_edit").style.borderColor = "red";
			document.getElementById("company_desc_eng_edit").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_desc_eng_edit").style.borderColor = "green";
			document.getElementById("company_desc_eng_edit").style.boxShadow = "2px 2px 2px lightgray";
		}
		
		
		// company address english
		if (document.getElementById("company_addr_eng_edit").value==null || document.getElementById("company_addr_eng_edit").value=="")
		{				
			document.getElementById("company_addr_eng_edit").style.borderColor = "red";
			document.getElementById("company_addr_eng_edit").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_addr_eng_edit").style.borderColor = "green";
			document.getElementById("company_addr_eng_edit").style.boxShadow = "2px 2px 2px lightgray";
		}		
		
		
		// company_industry_edit
		if (document.getElementById("company_industry_edit").value==null || document.getElementById("company_industry_edit").value==-1)
		{				
			document.getElementById("company_industry_edit").style.borderColor = "red";
			document.getElementById("company_industry_edit").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_industry_edit").style.borderColor = "green";
			document.getElementById("company_industry_edit").style.boxShadow = "2px 2px 2px lightgray";
		}
		
		
		// company_type_edit
		if (document.getElementById("company_type_edit").value==null || document.getElementById("company_type_edit").value==-1)
		{				
			document.getElementById("company_type_edit").style.borderColor = "red";
			document.getElementById("company_type_edit").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_type_edit").style.borderColor = "green";
			document.getElementById("company_type_edit").style.boxShadow = "2px 2px 2px lightgray";
		}		
		
		
		// company_n_of_people_edit
		if (document.getElementById("company_n_of_people_edit").value==null || document.getElementById("company_n_of_people_edit").value=="")
		{				
			document.getElementById("company_n_of_people_edit").style.borderColor = "red";
			document.getElementById("company_n_of_people_edit").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_n_of_people_edit").style.borderColor = "green";
			document.getElementById("company_n_of_people_edit").style.boxShadow = "2px 2px 2px lightgray";
		}

		
		// company_n_of_people_edit
		if (document.getElementById("company_founded_edit").value==null || document.getElementById("company_founded_edit").value=="")
		{				
			document.getElementById("company_founded_edit").style.borderColor = "red";
			document.getElementById("company_founded_edit").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_founded_edit").style.borderColor = "green";
			document.getElementById("company_founded_edit").style.boxShadow = "2px 2px 2px lightgray";
		}		
		
		if (nErrors==0)
		{				
			
			var url = "edit_the_company.php";
						
			var oData = new FormData(document.forms.namedItem("frm_editCompany"));
			
			var oReq = new XMLHttpRequest();
			  oReq.open("POST", url, true);
			  oReq.onload = function(oEvent) {
									
				if (oReq.status == 200) 
				{			
					    // alert('>>'+oReq.responseText);
						 
						$('#editCompany').modal('hide');
						$('#editCompanyOk').modal('show');							
						
					return;
					
				} else {
				  alert("Error " + oReq.status + " occurred.<br \/>");
				}
			  };

			oReq.send(oData); 
		}
}

function editPrincipalCompanyForm(n)
{
	
	document.getElementById("company_name_edit").style.borderColor = "lightgray";
	document.getElementById("company_name_edit").style.boxShadow = "none";	
	
	document.getElementById("company_city_edit").style.borderColor = "lightgray";
	document.getElementById("company_city_edit").style.boxShadow = "none";	
	
	document.getElementById("company_desc_eng_edit").style.borderColor = "lightgray";
	document.getElementById("company_desc_eng_edit").style.boxShadow = "none";	
	
	document.getElementById("company_addr_eng_edit").style.borderColor = "lightgray";
	document.getElementById("company_addr_eng_edit").style.boxShadow = "none";	
	
	document.getElementById("company_industry_edit").style.borderColor = "lightgray";
	document.getElementById("company_industry_edit").style.boxShadow = "none";	
	
	document.getElementById("company_type_edit").style.borderColor = "lightgray";
	document.getElementById("company_type_edit").style.boxShadow = "none";		
	
	document.getElementById("company_n_of_people_edit").style.borderColor = "lightgray";
	document.getElementById("company_n_of_people_edit").style.boxShadow = "none";	
	
	document.getElementById("company_founded_edit").style.borderColor = "lightgray";
	document.getElementById("company_founded_edit").style.boxShadow = "none";	
	
	$('#editCompany').modal('show');

	document.getElementById("divEditTheCompanyBodyTable").style.display = "none";
	$('#divEditTheCompanyBody').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');

	var http = new XMLHttpRequest();
	var url = "get_data_company.php";
	var params = "comp_id="+n;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			  // alert(http.responseText);		
			  
			  var response_data = JSON.parse(http.responseText);
			  			  
			  document.getElementById("company_id_edit").value = response_data.val_0;
			  document.getElementById("company_name_edit").value = response_data.val_1;
			  document.getElementById("company_city_edit").value = response_data.val_2;
			  document.getElementById("company_desc_eng_edit").value = response_data.val_3;
			  document.getElementById("company_desc_heb_edit").value = response_data.val_4;
			  document.getElementById("company_addr_eng_edit").value = response_data.val_5;
			  document.getElementById("company_addr_heb_edit").value = response_data.val_6;			  
			  document.getElementById("company_phone_edit").value = response_data.val_7;
			  document.getElementById("company_fax_edit").value = response_data.val_8;
			  document.getElementById("company_email_edit").value = response_data.val_9;
			  document.getElementById("company_website_edit").value = response_data.val_10;
			  document.getElementById("company_industry_edit").value = response_data.val_11;
			  document.getElementById("company_type_edit").value = response_data.val_12;
			  document.getElementById("company_n_of_people_edit").value = response_data.val_13;
			  document.getElementById("company_founded_edit").value = response_data.val_14;			  
			  
			  $('#loader').remove();
			  document.getElementById("divEditTheCompanyBodyTable").style.display = "";
			  
		}
	}
	http.send(params);	
	
}

function addPrincipalCompanyAjaxOk()
{
	//location.reload(true);
	getPrincipalCompaniesAjax(1);
}

function addPrincipalCompanyAjax()
{
		
		// 		
		nErrors=0;
		
		// company name
		if (document.getElementById("company_name").value==null || document.getElementById("company_name").value=="")
		{				
			document.getElementById("company_name").style.borderColor = "red";
			document.getElementById("company_name").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_name").style.borderColor = "green";
			document.getElementById("company_name").style.boxShadow = "2px 2px 2px lightgray";
		}			
		
		// company city
		if (document.getElementById("company_city").value==null || document.getElementById("company_city").value==-10)
		{				
			document.getElementById("company_city").style.borderColor = "red";
			document.getElementById("company_city").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_city").style.borderColor = "green";
			document.getElementById("company_city").style.boxShadow = "2px 2px 2px lightgray";
		}	
		

		// company description english
		if (document.getElementById("company_desc_eng").value==null || document.getElementById("company_desc_eng").value=="")
		{				
			document.getElementById("company_desc_eng").style.borderColor = "red";
			document.getElementById("company_desc_eng").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_desc_eng").style.borderColor = "green";
			document.getElementById("company_desc_eng").style.boxShadow = "2px 2px 2px lightgray";
		}
		
		
		// company address english
		if (document.getElementById("company_addr_eng").value==null || document.getElementById("company_addr_eng").value=="")
		{				
			document.getElementById("company_addr_eng").style.borderColor = "red";
			document.getElementById("company_addr_eng").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_addr_eng").style.borderColor = "green";
			document.getElementById("company_addr_eng").style.boxShadow = "2px 2px 2px lightgray";
		}		
		

		// company_industry
		if (document.getElementById("company_industry").value==null || document.getElementById("company_industry").value==-1)
		{				
			document.getElementById("company_industry").style.borderColor = "red";
			document.getElementById("company_industry").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_industry").style.borderColor = "green";
			document.getElementById("company_industry").style.boxShadow = "2px 2px 2px lightgray";
		}			
		
		// company_type
		if (document.getElementById("company_type").value==null || document.getElementById("company_type").value==-1)
		{				
			document.getElementById("company_type").style.borderColor = "red";
			document.getElementById("company_type").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_type").style.borderColor = "green";
			document.getElementById("company_type").style.boxShadow = "2px 2px 2px lightgray";
		}			
		
		// company_n_of_people
		if (document.getElementById("company_n_of_people").value==null || document.getElementById("company_n_of_people").value=="")
		{				
			document.getElementById("company_n_of_people").style.borderColor = "red";
			document.getElementById("company_n_of_people").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_n_of_people").style.borderColor = "green";
			document.getElementById("company_n_of_people").style.boxShadow = "2px 2px 2px lightgray";
		}		
		
		// inp_company_founded
		if (document.getElementById("company_founded").value==null || document.getElementById("company_founded").value=="")
		{				
			document.getElementById("company_founded").style.borderColor = "red";
			document.getElementById("company_founded").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("company_founded").style.borderColor = "green";
			document.getElementById("company_founded").style.boxShadow = "2px 2px 2px lightgray";
		}			
		
		if (nErrors==0)
		{				
			
			var url = "add_new_company.php";
						
			var oData = new FormData(document.forms.namedItem("frm_addCompany"));
			
			var oReq = new XMLHttpRequest();
			  oReq.open("POST", url, true);
			  oReq.onload = function(oEvent) {
									
				if (oReq.status == 200) 
				{			
					    // alert('>>'+oReq.responseText);
						 
						$('#addCompany').modal('hide');
						$('#addCompanyOk').modal('show');							
						
					return;
					
				} else {
				  alert("Error " + oReq.status + " occurred.<br \/>");
				}
			  };

			oReq.send(oData); 
		}
}

function addPrincipalCompanyForm()
{
	// initialize necessary input fields
	document.getElementById("company_name").value='';	
	document.getElementById("company_name").style.borderColor = "lightgray";
	document.getElementById("company_name").style.boxShadow = "none";
	
	document.getElementById("company_city").value=-10;
	document.getElementById("company_city").style.borderColor = "lightgray";
	document.getElementById("company_city").style.boxShadow = "none";
	
	document.getElementById("company_desc_eng").value = '';
	document.getElementById("company_desc_eng").style.borderColor = "lightgray";
	document.getElementById("company_desc_eng").style.boxShadow = "none";
	
	document.getElementById("company_addr_eng").value = '';
	document.getElementById("company_addr_eng").style.borderColor = "lightgray";
	document.getElementById("company_addr_eng").style.boxShadow = "none";	
	
	document.getElementById("company_industry").style.borderColor = "lightgray";
	document.getElementById("company_industry").style.boxShadow = "none";	
	
	document.getElementById("company_type").style.borderColor = "lightgray";
	document.getElementById("company_type").style.boxShadow = "none";	
	
	document.getElementById("company_n_of_people").style.borderColor = "lightgray";
	document.getElementById("company_n_of_people").style.boxShadow = "none";	
	
	document.getElementById("company_founded").style.borderColor = "lightgray";
	document.getElementById("company_founded").style.boxShadow = "none";	
	
	document.getElementById("company_desc_heb").value = '';
	document.getElementById("company_addr_eng").value = '';
	document.getElementById("company_addr_heb").value = '';
	document.getElementById("company_phone").value = '';
	document.getElementById("company_fax").value = '';
	document.getElementById("company_email").value = '';
	document.getElementById("company_website").value = '';
	document.getElementById("company_industry").value = -1;
	document.getElementById("company_type").value = -1;
	document.getElementById("company_n_of_people").value = '';
	document.getElementById("company_founded").value = '';
	
	// open a dialog to enter company details...
	$('#addCompany').modal('show');
}

function getPrincipalCompaniesAjax(n_page)
{	

	document.getElementById("divPrincipalCompanies").style.display = "none";
	$('#companies').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');

	var http = new XMLHttpRequest();
	var url = "getPrincipalCompanies.php";
	var params = "the_curr_page="+n_page+"&recs_per_page=5";
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			   // alert(http.responseText);		
			  
			  var response_data = JSON.parse(http.responseText);

			  $('#loader').remove();
			  document.getElementById("divPrincipalCompanies").style.display = "block";
			  document.getElementById("divPrincipalCompanies").innerHTML = response_data.val_1;
			  document.getElementById("num_companies_rec_no").innerHTML = response_data.val_2;
			  
		}
	}
	http.send(params);	
}

function verifyEmail()
{
	// alert ('Verify Email');
}

function changePrincDetails(strEl)
{

	// initialize first
	 document.getElementById("inp_ud_data_to_change").innerHTML = '<label for="ud_data_to_change" id="ud_data_to_change_lbl"></label>' +
								  ' <input class="form-control" onkeydown="limit(this, 50);" onkeyup="limit(this, 50);" ' +
								  ' id="ud_data_to_change" name="ud_data_to_change" placeholder="" value="" autocomplete="off" /> ' +							  
								  ' <input type="hidden" id="elm_name" name="elm_name" value="" autocomplete="off"> '; 

	if ((strEl == null) || (strEl == "")) return;
	
	if (strEl == "Password")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Password";			
		document.getElementById("ud_data_to_change").placeholder = "Enter New Password...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_princDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;	
		document.getElementById("ud_data_to_change").type='password';
	}
	
	if (strEl == "Firstname")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your Firstname";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Firstname...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_princDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;
		document.getElementById("ud_data_to_change").value = '<?php echo $arr_princ_details[0]['princ_firstname']; ?>';
	}

	if (strEl == "Lastname")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your Lastname";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Lastname...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_princDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;
		document.getElementById("ud_data_to_change").value = '<?php echo $arr_princ_details[0]['princ_lastname']; ?>';
	}
	
	if (strEl == "About")
	{		
		
		document.getElementById("inp_ud_data_to_change").innerHTML = ' <div class="form-group"> '+
            	            ' <label for="ud_data_to_change" id="ud_data_to_change_lbl">About Your Company</label> ' +
            	            ' <textarea id="ud_data_to_change" name="ud_data_to_change" placeholder="About Your Company..."  ' +
            				' class="form-about-yourself form-control"></textarea> ' +
							' <input type="hidden" id="elm_name" name="elm_name" value="About" autocomplete="off"> ' +
                            ' </div>';
							  
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_princDetails(\''+strEl+'\'); return false;');

		document.getElementById("ud_data_to_change").value = <?php echo json_encode($arr_princ_details[0]['princ_about']); ?>;

	}	

	if (strEl == "Company")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your Company";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Your Company...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_princDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;
		document.getElementById("ud_data_to_change").value = '<?php echo $arr_princ_details[0]['company']; ?>';			
	}	

	if (strEl == "Website")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your Website";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Your Website...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_princDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;
		document.getElementById("ud_data_to_change").value = '<?php echo $arr_princ_details[0]['website']; ?>';			
	}	
	
	if (strEl == "Mobile")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your Mobile";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Your Mobile...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_princDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;	
		document.getElementById("ud_data_to_change").value = '<?php echo $arr_princ_details[0]['mobile']; ?>';
	}	

	if (strEl == "City")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your City";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Your City...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_princDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;	
		document.getElementById("ud_data_to_change").value = '<?php echo $arr_princ_details[0]['city']; ?>';
	}	
	
    if (strEl == "Profile_Status")
	{

		document.getElementById("inp_ud_data_to_change").innerHTML = '<label for="ud_data_to_change" id="ud_data_to_change_lbl">Choose Profile Status...</label> <br/>' +
								'<select id="ud_data_to_change" name="ud_data_to_change">' +
								'<option value="1" selected>Active</option>' +
								'<option value="0">Non-Active</option>' +
							   '</select>' +
							  '<input type="hidden" id="elm_name" name="elm_name" value="Profile_Status" autocomplete="off"> ';
							  
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_princDetails(\''+strEl+'\'); return false;');
	}			
	
	$("#userDetails").modal()
}	
	
function apply_princDetails(strEl)
{
		
		// 		
		nErrors=0;
		
		if (document.getElementById("ud_data_to_change").value==null || document.getElementById("ud_data_to_change").value=="")
		{				
			document.getElementById("ud_data_to_change").style.borderColor = "red";
			document.getElementById("ud_data_to_change").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;
		}			
		else
		{			
			document.getElementById("ud_data_to_change").style.borderColor = "green";
			document.getElementById("ud_data_to_change").style.boxShadow = "2px 2px 2px lightgray";
		}			
							
		if (nErrors==0)
		{				
			
			var url = "apply_princ_details.php";
						
			var oData = new FormData(document.forms.namedItem("frm_userDetails"));
			
			var oReq = new XMLHttpRequest();
			  oReq.open("POST", url, true);
			  oReq.onload = function(oEvent) {
									
				if (oReq.status == 200) 
				{			
					    // alert('>>'+oReq.responseText);
						 
						$('#userDetails').modal('hide');
						//$('#userDetailsOk').modal('show');	
						location.reload(true);
						
					return;
					
				} else {
				  alert("Error " + oReq.status + " occurred.<br \/>");
				}
			  };

			oReq.send(oData); 
		}
}
	
function getRecentActivityDetails(recId)
{
		
	var http = new XMLHttpRequest();
	var url = "getPrincRecentActivityDetails.php";
	var params = "recId="+recId;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			  // alert(http.responseText);			  
			  document.getElementById("rcntActivityTxt").innerHTML = http.responseText;			  
			  $('#recentActivityDetails').modal('show');
		}
	}
	http.send(params);	
}

function getRecentActivitiesAjax(n_page)
{

	document.getElementById("divRecentActivities").style.display = "none";
	$('#recent_activities').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');

	var http = new XMLHttpRequest();
	var url = "getPrincRecentActivity.php";
	var params = "the_curr_page="+n_page+"&recs_per_page=7";
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			  // alert(http.responseText);		
			  var response_data = JSON.parse(http.responseText);
			  
			  $('#loader').remove();
			  document.getElementById("divRecentActivities").style.display = "block";
			  document.getElementById("divRecentActivities").innerHTML = response_data.val_1;
			  document.getElementById("num_recent_activities_rec_no").innerHTML = response_data.val_2;
		}
	}
	http.send(params);		
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
	$("#signUp").modal()
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

function validateEmail(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
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
			
			if (n < 4 || n > 20 || str.indexOf(' ')>=0 || nErrSpecChars>0)
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
			
			if (n < 4 || n > 20 || nErrSpecChars>0)
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
				  alert("Error " + oReq.status + " occurred uploading your file.<br \/>");
				}
			  };

			oReq.send(oData); 
		}
	}	

</script>

</head>
<body onload="getRecentActivitiesAjax(1); getPrincipalCompaniesAjax(1); getPrincipalPositionsAjax(1, -25, -25, -25); getPrincipalAppliedAjax(1, -25, -25, -25, -25); getPrincipalCandidatesAjax(1, -25, '');"> 	

 <div class="navbar navbar-static-top" style="margin-bottom:0;" >
	<div class="container" style="font-size:16px;">
		
		<button class ="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
		
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		
		</button>
		
		<div class="collapse navbar-collapse navHeaderCollapse">
		
			<ul class="nav navbar-nav navbar-left">			
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span></a></li>
				<li><a href="positions.php">Positions</a></li>
				<li><a href="categories.php">Categories</a></li>
				<li><a href="aboutus.php">About Us</a></li>
				<li><a href="companies.php">Companies</a></li>
				<li><a href="contactus.php">Contact Us</a></li>				
			</ul>
			
			<div class="hidden-sm">
			<ul class="nav navbar-nav navbar-right">							 
				<li class="active"><a style="color:red" href="princ_dashboard.php"><span style="color:red" class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['princ_first_name']; ?></a></a></li>
				<li><a style="color:red" href="principal/logout.php"><span style="color:red" class="glyphicon glyphicon-log-out"></span> Exit</a></li>		

				<!-- no multilang yet :))))
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">English <span class="caret"></span></a>
				  <ul class="dropdown-menu">					
					<li><a href="#">עיברית</a></li>					
				  </ul>
				</li>	
				-->
			</ul>	
			</div>
			
		
		</div> 
		
	</div> 
 </div> <!-- the end of navbar navbar-inverse navbar-static-top -->
 
 
<!-- jtron start -->
  
<div class="jumbotron">
	
	<div class = "container" style="font-size:14px;">
	
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
 
 
 <div class="container" style="font-size:14px;">
 
	<div class="row" >
	
		<!-- central bar -->
		<div class="col-md-12">
					
		  <ul class="nav nav-tabs" id="myTab">
			<li><a data-toggle="tab" href="#profile"><b>P</b>rofile</a></li>
			<li><a data-toggle="tab" href="#companies" onclick="getPrincipalCompaniesAjax(1);"><b>C</b>ompanies <span id="num_companies_rec_no" class="badge"></span></a></li>
			<li><a data-toggle="tab" href="#positions" onclick="getPrincipalPositionsAjax(1, -25, -25, -25);"><b>P</b>ositions <span id="num_positions_rec_no" class="badge"></span></a></li>
			<li><a data-toggle="tab" href="#applied" onclick="getPrincipalAppliedAjax(1, -25, -25, -25, -25);"><b>A</b>pplied <span id="num_applied_rec_no" class="badge"></span></a></li>			
			<li><a data-toggle="tab" href="#candidates" onclick="getPrincipalCandidatesAjax(1, -25, '');"><b>C</b>andidates <span id="num_candidates_rec_no" class="badge"></span></a></li>
			<li><a data-toggle="tab" href="#recent_activities" onclick="getRecentActivitiesAjax(1);" ><b>R</b>ecent Activities <span id="num_recent_activities_rec_no" class="badge"></span></a></li>
		  </ul>
						
		  <div class="tab-content" >
		  
		  
			<div id="profile" class="tab-pane fade in active">
			  
			  <br/>
			  
			  <div class="container"  style="font-size:14px;" id='divMyProfile' name='divMyProfile'>
			  
			  <!-- my profile start -->
			  
				 <table class="table table-striped">
					<thead>
					  <tr>
						<th></th>
						<th></th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td style="vertical-align:middle; width:20%;">Email</td>
						<td style="vertical-align:middle"><?php echo $arr_princ_details[0]['princ_email']; ?></td>
						<td style="vertical-align:middle"><button type="button" class="btn btn-default <?php if ($arr_princ_details[0]['is_verified'] == 1) echo "disabled"; ?>" onClick="verifyEmail()"><?php if ($arr_princ_details[0]['is_verified'] == 1) echo "Verified"; else echo "Verify..."; ?></button></td>
					  </tr>		
					  <tr>
						<td style="vertical-align:middle">Password</td>
						<td style="vertical-align:middle"><?php echo str_repeat("*", strlen($arr_princ_details[0]['princ_pwd'])); ?></td>
						<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="changePrincDetails('Password')">Change...</button></td>
					  </tr>					  
					  <tr>
						<td style="vertical-align:middle">First Name</td>
						<td style="vertical-align:middle"><?php echo $arr_princ_details[0]['princ_firstname']; ?></td>
						<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="changePrincDetails('Firstname')">Edit...</button></td>
					  </tr>
					  <tr>
						<td style="vertical-align:middle">Last Name</td>
						<td style="vertical-align:middle"><?php echo $arr_princ_details[0]['princ_lastname']; ?></td>
						<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="changePrincDetails('Lastname')">Edit...</button></td>
					  </tr>
					  <tr>
						<td style="vertical-align:middle">About Your Company</td>
						<td style="vertical-align:middle"><?php echo nl2br($arr_princ_details[0]['princ_about']); ?></td>
						<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="changePrincDetails('About')">Edit...</button></td>
					  </tr>						  
					  <tr>
						<td style="vertical-align:middle">Company</td>
						<td style="vertical-align:middle"><?php echo $arr_princ_details[0]['company']; ?></td>
						<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="changePrincDetails('Company')">Edit...</button></td>
					  </tr>	
					  <tr>
						<td style="vertical-align:middle">Website</td>
						<?
						
						$url = $arr_princ_details[0]['website'];
						if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
							$url = "http://" . $url;
						}
						
						$url =strtolower($url);
						
						?>
						<td style="vertical-align:middle"><a href='<? echo $url; ?>' target='_blank'><?php echo $arr_princ_details[0]['website']; ?></a></td>
						<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="changePrincDetails('Website')">Edit...</button></td>
					  </tr>						  
					  <tr>
						<td style="vertical-align:middle">City</td>
						<td style="vertical-align:middle"><?php echo $arr_princ_details[0]['city']; ?></td>
						<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="changePrincDetails('City')">Edit...</button></td>
					  </tr>
					  <tr>
						<td style="vertical-align:middle">Mobile</td>
						<td style="vertical-align:middle"><?php echo $arr_princ_details[0]['mobile']; ?></td>
						<td style="vertical-align:middle"><button type="button" class="btn btn-default" onClick="changePrincDetails('Mobile')">Edit...</button></td>
					  </tr>					  
					</tbody>
				  </table>			  
			  
			  </div>
			  
			  <!-- my profile end -->
			  
			</div>
			
			<div id="companies" style="font-size:14px;" class="tab-pane fade">
				<div class="container" style="font-size:14px;" id='divPrincipalCompanies' name='divPrincipalCompanies'>		
			  				  
				</div>
			</div>
		
			<div id="positions" style="font-size:14px;" class="tab-pane fade">
				<div class="container" style="font-size:14px;" id='divPrincipalPositions' name='divPrincipalPositions'>		
			  				  
				</div>
			</div>			
		
			<div id="applied" style="font-size:14px;" class="tab-pane fade">
				<div class="container" style="font-size:14px;" id='divPrincipalApplied' name='divPrincipalApplied'>		
			  		
				</div>
			</div>
			
			<div id="candidates" style="font-size:14px;" class="tab-pane fade">
				<div class="container" style="font-size:14px;" id='divPrincipalCandidates' name='divPrincipalCandidates'>		
			  		
				</div>
			</div>			
			 
			<div id="recent_activities" class="tab-pane fade">			
				<div class="container"  style="overflow-x:auto; font-size:14px;" id='divRecentActivities' name='divRecentActivities'>		
			  				  
				</div>				
			</div>	<!-- recent activities -->	
			
		</div> <!-- tab-content -->
 				
		  </div> <!-- col md 12 -->					
	
	</div>	<!-- row -->
	
 </div> <!-- container -->
  
 <div class="clearfix" style="margin-bottom:20px;"></div> 
 
<!-- Pre footer -->

	<div id="footer">
		<div class="container" style="font-size:14px;">
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

					<p class="text-muted" style="font-size:14px;">Get top new jobs delivered to your inbox</p>

					<form  enctype="multipart/form-data" method="post" name="SubscribeEmail">
						<div class="input-group">
							
							<input type="text" class="form-control" name="subscr_email" id="subscr_email">

							<span class="input-group-btn">

								<button class="btn btn-default" type="button" onclick="#">Subscribe!</button>

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
	<div class="container" style="font-size:14px;">
		<div class="col-md-8">
			<p class="pull-left">© "Jobs972", 2016<span class="hidden-sm hidden-xs"> - Find Job in Israel!</span></p>		 
		</div>
		<div class="col-md-4">
			<p class="pull-right"><a href="#">Back To Top</a></p>
		</div>
	</div>
  </div>
  
 <!-- footer end -->
 
    <script src="jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	
	<div class="modal fade" tabindex="-1" role="dialog" id="signUp">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Sign Up</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="signUpForm" enctype="multipart/form-data" method="post">
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
							<label for="captcha">How much it'll be <?php echo $a; ?> + <?php echo $b; ?> = ?</label>
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


	<div class="modal fade" tabindex="-1" role="dialog" id="signUpOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Sign Up</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="signUpForm" enctype="multipart/form-data" method="post">
		  <div class="modal-body" style="font-size:14px;">
				Congratulations! You've registered successfully!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>			
		  </div>
		  </form>
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
		  <form role="form" data-toggle="validator" name="signUpForm" enctype="multipart/form-data" method="post">
		  <div class="modal-body" style="font-size:14px;">
				Such user already exists!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>			
		  </div>
		  </form>
		</div> 
	  </div> 
	</div> 	

	<div class="modal fade" tabindex="-1" role="dialog" id="recentActivityDetails">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Activity Details</h4>
		  </div>
		  <div class="modal-body" name='rcntActivityTxt' id='rcntActivityTxt' style="font-size:14px;">				
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="userDetails">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Principal Details</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="frm_userDetails" enctype="multipart/form-data" method="post">
		  <div class="modal-body" id="userDetailsBody" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">
				<tr>
					<td style="padding:7px;">

						<div id="inp_ud_data_to_change" class="form-group">
							<label for="ud_data_to_change" id="ud_data_to_change_lbl"></label>
							  <input class="form-control" onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
							  id="ud_data_to_change" name="ud_data_to_change" placeholder="" value="" autocomplete="off" />
							  
							  <input type="hidden" id="elm_name" name="elm_name" value="" autocomplete="off">
						</div>							

					</td> 
				</tr>								
				</table>
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="submit" id="ud_data_to_change_btn" class="btn btn-primary">Apply</button>
		  </div>
		  </form>
		</div> 
	  </div> 
	</div> 

	<div class="modal fade" tabindex="-1" role="dialog" id="userDetailsOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Principal Details</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			The change has been applied successfully!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:location.reload(true);" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="addCompany">
	  <div class="modal-dialog">
		<form role="form" data-toggle="validator" name="frm_addCompany" enctype="multipart/form-data" method="post" autocomplete="off">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add A New Company</h4>
		  </div>		   
		  <div class="modal-body" style="font-size:12px;">				
				<table style="margin-left:auto; margin-right:auto" style="font-size:12px;">
				<tr>
					<td style="padding:7px; width:2000px;" colspan="2" >
						<div id="inp_company_name" class="form-group" >
							<label for="company_name">Company Name</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_name" name="company_name" placeholder="Your Company Name" value="" />
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;" colspan="2">
						<div id="inp_company_city" class="form-group" >
							<label for="company_city">Company City</label>							  
							  <select class="form-control" id="company_city" name="company_city">
							  <option value="-10">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_cities); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_cities[$idx]['id']; ?>"><? echo $arr_cities[$idx]['name_en']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>	
					</td>
				</tr>
				<tr>
					<td style="padding:7px; width:2000px;" colspan="2">
						<div id="inp_company_desc_eng" class="form-group" >
							<label for="company_desc_eng">Company Description English</label>
							  <textarea class="form-control" style="resize: none;" id="company_desc_eng" name="company_desc_eng" placeholder="Company Description English"></textarea>
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;" colspan="2">
						<div id="inp_company_desc_heb" class="form-group" >
							<label for="company_desc_heb">Company Description Hebrew</label>
							  <textarea class="form-control" style="resize: none;" id="company_desc_heb" name="company_desc_heb" placeholder="Company Description Hebrew"></textarea>
						</div>	
					</td> 					
				</tr>	
				<tr>
					<td style="padding:7px;" colspan="2">
						<div id="inp_company_addr_eng" class="form-group" >
							<label for="company_addr_eng">Company Address English</label>
							  <textarea class="form-control"
							   id="company_addr_eng" style="resize: none;" name="company_addr_eng" placeholder="Company Address English"></textarea>
						</div>	
					</td> 
					<td style="padding:7px;" colspan="2">
						<div id="inp_company_addr_heb" class="form-group" >
							<label for="company_addr_heb">Company Address Hebrew</label>
							  <textarea class="form-control"
							  id="company_addr_heb" style="resize: none;" name="company_addr_heb" placeholder="Company Address Hebrew"></textarea>
						</div>	
					</td> 					
				</tr>	
				<tr>
					<td style="padding:7px; width:2000px;">
						<div id="inp_company_phone" class="form-group" >
							<label for="company_phone">Phone</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_phone" name="company_phone" placeholder="Phone" value="" />
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;">
						<div id="inp_company_fax" class="form-group" >
							<label for="company_fax">Fax</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_fax" name="company_fax" placeholder="Fax" value="" />
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;">
						<div id="inp_company_email" class="form-group" >
							<label for="company_email">Email</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_email" name="company_email" placeholder="Email" value="" />
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;">
						<div id="inp_company_website" class="form-group" >
							<label for="company_website">Website</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_website" name="company_website" placeholder="Website" value="" />
						</div>	
					</td> 										
				</tr>
				<tr>
					<td style="padding:7px;">
						<div id="inp_company_industry" class="form-group" >
							<label for="company_industry">Industry</label>   
							  <select class="form-control" id="company_industry" name="company_industry">
							  <option value="-1">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_company_industries); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_company_industries[$idx]['value']; ?>"><? echo $arr_company_industries[$idx]['value']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>	
					</td> 
					<td style="padding:7px;">
						<div id="inp_company_type" class="form-group" >
							<label for="company_type">Company Type</label>
							  <select class="form-control" id="company_type" name="company_type">
							  <option value="-1">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_company_types); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_company_types[$idx]['value']; ?>"><? echo $arr_company_types[$idx]['value']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>	
					</td> 
					<td style="padding:7px;">
						<div id="inp_company_n_of_people" class="form-group" >
							<label for="company_n_of_people">Num Of People</label>
							  <input class="form-control" onkeydown="limit(this, 10);" onkeyup="limit(this, 10);"
							  id="company_n_of_people" name="company_n_of_people" placeholder="Num Of People" value="" />
						</div>	
					</td> 					
					<td style="padding:7px;">
						<div id="inp_company_founded" class="form-group" >
							<label for="company_founded">Founded</label>
							  <input class="form-control" onkeydown="limit(this, 10);" onkeyup="limit(this, 10);"
							  id="company_founded" name="company_founded" placeholder="Founded" value="" />
						</div>	
					</td> 					
				</tr>				
				</table>
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>			
			<button type="submit" class="btn btn-primary" onClick="addPrincipalCompanyAjax(); return false;" >Send To Approve</button>			
		  </div>		  
		</div> 
		</form>
	  </div> 
	</div>			
	
	<div class="modal fade" tabindex="-1" role="dialog" id="addCompanyOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add A New Company</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			The New Company Was Sent For Approval!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="addPrincipalCompanyAjaxOk();" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="editCompanyOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Edit The Company</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			The Edited Company Was Sent For Approval!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="editPrincipalCompanyAjaxOk();" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="editCompany">
	  <div class="modal-dialog">
		<form role="form" data-toggle="validator" name="frm_editCompany" enctype="multipart/form-data" method="post" autocomplete="off">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Edit The Company</h4>
		  </div>		   		  
		  <div class="modal-body" style="font-size:12px;" id="divEditTheCompanyBody">				
				<table style="margin-left:auto; margin-right:auto" style="font-size:12px;" id="divEditTheCompanyBodyTable">
				<tr>
					<td style="padding:7px; width:2000px;" colspan="2" >
						<div id="inp_company_name_edit" class="form-group" >
							<label for="company_name_edit">Company Name</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_name_edit" name="company_name_edit" placeholder="Your Company Name" value="" />
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;" colspan="2">
						<div id="inp_company_city_edit" class="form-group" >
							<label for="company_city_edit">Company City</label>							  
							  <select class="form-control" id="company_city_edit" name="company_city_edit">
							  <option value="-10">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_cities); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_cities[$idx]['id']; ?>"><? echo $arr_cities[$idx]['name_en']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>	
					</td>
				</tr>
				<tr>
					<td style="padding:7px; width:2000px;" colspan="2">
						<div id="inp_company_desc_eng_edit" class="form-group" >
							<label for="company_desc_eng_edit">Company Description English</label>
							  <textarea class="form-control" id="company_desc_eng_edit" style="resize: none;" name="company_desc_eng_edit" placeholder="Company Description English"></textarea>
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;" colspan="2">
						<div id="inp_company_desc_heb_edit" class="form-group" >
							<label for="company_desc_heb_edit">Company Description Hebrew</label>
							  <textarea class="form-control" id="company_desc_heb_edit" style="resize: none;" name="company_desc_heb_edit" placeholder="Company Description Hebrew"></textarea>
						</div>	
					</td> 					
				</tr>	
				<tr>
					<td style="padding:7px;" colspan="2">
						<div id="inp_company_addr_eng_edit" class="form-group" >
							<label for="company_addr_eng_edit">Company Address English</label>
							  <textarea class="form-control"
							   id="company_addr_eng_edit" style="resize: none;" name="company_addr_eng_edit" placeholder="Company Address English"></textarea>
						</div>	
					</td> 
					<td style="padding:7px;" colspan="2">
						<div id="inp_company_addr_heb_edit" class="form-group" >
							<label for="company_addr_heb_edit">Company Address Hebrew</label>
							  <textarea class="form-control"
							  id="company_addr_heb_edit" style="resize: none;" name="company_addr_heb_edit" placeholder="Company Address Hebrew"></textarea>
						</div>	
					</td> 					
				</tr>	
				<tr>
					<td style="padding:7px; width:2000px;">
						<div id="inp_company_phone_edit" class="form-group" >
							<label for="company_phone_edit">Phone</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_phone_edit" name="company_phone_edit" placeholder="Phone" value="" />
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;">
						<div id="inp_company_fax_edit" class="form-group" >
							<label for="company_fax_edit">Fax</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_fax_edit" name="company_fax_edit" placeholder="Fax" value="" />
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;">
						<div id="inp_company_email_edit" class="form-group" >
							<label for="company_email_edit">Email</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_email_edit" name="company_email_edit" placeholder="Email" value="" />
						</div>	
					</td> 
					<td style="padding:7px; width:2000px;">
						<div id="inp_company_website_edit" class="form-group" >
							<label for="company_website_edit">Website</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
							  id="company_website_edit" name="company_website_edit" placeholder="Website" value="" />
						</div>	
					</td> 										
				</tr>
				<tr>
					<td style="padding:7px;">
						<div id="inp_company_industry_edit" class="form-group" >
							<label for="company_industry_edit">Industry</label>   
							  <select class="form-control" id="company_industry_edit" name="company_industry_edit">
							  <option value="-1">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_company_industries); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_company_industries[$idx]['value']; ?>"><? echo $arr_company_industries[$idx]['value']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>	
					</td> 
					<td style="padding:7px;">
						<div id="inp_company_type_edit" class="form-group" >
							<label for="company_type_edit">Company Type</label>
							  <select class="form-control" id="company_type_edit" name="company_type_edit">
							  <option value="-1">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_company_types); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_company_types[$idx]['value']; ?>"><? echo $arr_company_types[$idx]['value']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>	
					</td> 
					<td style="padding:7px;">
						<div id="inp_company_n_of_people_edit" class="form-group" >
							<label for="company_n_of_people_edit">Num Of People</label>
							  <input class="form-control" onkeydown="limit(this, 10);" onkeyup="limit(this, 10);"
							  id="company_n_of_people_edit" name="company_n_of_people_edit" placeholder="Num Of People" value="" />
						</div>	
					</td> 					
					<td style="padding:7px;">
						<div id="inp_company_founded_edit" class="form-group" >
							<label for="company_founded_edit">Founded</label>
							  <input class="form-control" onkeydown="limit(this, 10);" onkeyup="limit(this, 10);"
							  id="company_founded_edit" name="company_founded_edit" placeholder="Founded" value="" />
						</div>	
					</td> 					
				</tr>	
				<input id="company_id_edit" name="company_id_edit" type="hidden" value="" />
				</table>
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>			
			<button type="submit" class="btn btn-primary" onClick="editPrincipalCompanyAjax(); return false;" >Send To Approve</button>			
		  </div>		  
		</div> 
		</form>
	  </div> 
	</div>	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="searchCompany">
	  <div class="modal-dialog">
		<form role="form" data-toggle="validator" name="frm_searchCompany" enctype="multipart/form-data" method="post">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Search The Company</h4>
		  </div>		   		  
		  <div class="modal-body" style="font-size:12px;" id="divSearchTheCompanyBody">				
				<table style="margin-left:auto; margin-right:auto" style="font-size:12px;" id="divSearchTheCompanyBodyTable">
				<tr>
					<td style="padding:7px;">
						<div id="inp_company_name_search" class="form-group" >
							<label for="company_name_search">By Company Name</label>							  
							  <select class="form-control" id="company_name_search" name="company_name_search">
							  <option value="-10">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_princ_companies); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_princ_companies[$idx]['id']; ?>"><? echo $arr_princ_companies[$idx]['the_name']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>	
					</td> 
				</tr>			
				</table>
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>			
			<button type="submit" class="btn btn-primary" onClick="searchPrincipalCompanyAjax(); return false;" >Search</button>			
		  </div>		  
		</div> 
		</form>
	  </div> 
	</div>	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="addPosition">
	  <div class="modal-dialog">
		<form role="form" data-toggle="validator" name="frm_addPosition" enctype="multipart/form-data" method="post" autocomplete="off">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add A New Position</h4>
		  </div>		   
		  <div class="modal-body" style="font-size:12px;">

				<ul class="nav nav-tabs">
				  <li class="active"><a href="#11" data-toggle="tab">Position, Type, Company, Description</a></li>
				  <li><a href="#22" data-toggle="tab">Categories, Contacts, Notes</a></li>			  
				</ul>
		  
			<div class="tab-content">
			<div class="tab-pane active" id="11">		  
		  
				<br/>
				<table style="margin-left:auto; margin-right:auto; width:100%; table-layout: fixed" style="font-size:12px;">
				<tr>
					<td style="padding:7px;" colspan="2" >
						<div id="inp_position_title" class="form-group" >
							<label for="position_title">Position Title English</label>
							  <input class="form-control" onkeydown="limit(this, 35);" onkeyup="limit(this, 35);" style="font-size: 12px;" 
							  id="position_title" name="position_title" placeholder="Position Title English" value="" />
						</div>	
					</td> 
					<td style="padding:7px;" colspan="2" >
						<div id="inp_position_title_heb" class="form-group" >
							<label for="position_title_heb">Position Title Hebrew</label>
							  <input class="form-control" onkeydown="limit(this, 35);" onkeyup="limit(this, 35);" style="font-size: 12px;" 
							  id="position_title_heb" name="position_title_heb" placeholder="Position Title Hebrew" value="" />
						</div>	
					</td>
				</tr>
				<tr>
					<td style="padding:7px;" colspan="2">
						<div id="inp_company_nm" class="form-group" >
							<label for="company_nm">Company</label>							  
							  <select class="form-control" id="company_nm" name="company_nm" style="font-size: 12px;">
							  <option value="-10">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_princ_companies); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_princ_companies[$idx]['id']; ?>"><? echo $arr_princ_companies[$idx]['the_name']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>	
					</td> 
					<td style="padding:7px;" colspan="2">
						<div id="inp_pos_type" class="form-group" >
							<label for="pos_type">Position Type</label>							  
							  <select class="form-control" id="pos_type" name="pos_type" style="font-size: 12px;">
							  <option value="-10">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_job_type); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_job_type[$idx]['name']; ?>"><? echo $arr_job_type[$idx]['name']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>	
					</td>
				</tr>				
				<tr>
					<td style="padding:7px;" colspan="2">
						<div id="inp_pos_desc_eng" class="form-group" >
							<label for="pos_desc_eng">Position Description English</label>
							  <textarea rows="16" class="form-control" style="resize: none; font-size: 12px;" id="pos_desc_eng" name="pos_desc_eng" placeholder="Position Description English"></textarea>
						</div>	
					</td> 
					<td style="padding:7px;" colspan="2">
						<div id="inp_pos_desc_heb" class="form-group" >
							<label for="pos_desc_heb">Position Description Hebrew</label>
							  <textarea rows="16" class="form-control" style="resize: none; font-size: 12px;" id="pos_desc_heb" name="pos_desc_heb" placeholder="Position Description Hebrew"></textarea>
						</div>	
					</td> 					
				</tr>			
				</table>
		

				
			</div> <!-- class="tab-pane active" id="11" -->
			
			<div class="tab-pane" id="22">
					
				<br/>
				<table style="margin-left:auto; margin-right:auto; width:100%; table-layout: fixed" style="font-size:12px;">
				<tr>
					<td style="padding:7px;" colspan="2">
						<div id="inp_pos_cat1" class="form-group" >
							<label for="pos_cat1">Category #1</label>							  
							  <select class="form-control" id="pos_cat1" name="pos_cat1" onChange="populateSubCat('pos_cat1', 'pos_scat1');" style="font-size: 12px;">
							  <option value="">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_categories); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_categories[$idx]['id']; ?>"><? echo $arr_categories[$idx]['cat_name']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>
					</td> 
					<td style="padding:7px;" colspan="2">
						<div id="inp_pos_scat1" class="form-group" >
							<label for="pos_scat1">Sub Category #1</label>							  
							  <select class="form-control" id="pos_scat1" name="pos_scat1" style="font-size: 12px;">
							  <option value="">Choose...</option>
							  </select>
						</div>	
					</td> 					
				</tr>
				<tr>
					<td style="padding:7px;" colspan="2">
						<div id="inp_pos_cat2" class="form-group" >
							<label for="pos_cat2">Category #2</label>							  
							  <select class="form-control" id="pos_cat2" name="pos_cat2" onChange="populateSubCat('pos_cat2', 'pos_scat2');" style="font-size: 12px;">
							  <option value="">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_categories); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_categories[$idx]['id']; ?>"><? echo $arr_categories[$idx]['cat_name']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>
					</td> 
					<td style="padding:7px;" colspan="2">
						<div id="inp_pos_scat2" class="form-group" >
							<label for="pos_scat2">Sub Category #2</label>							  
							  <select class="form-control" id="pos_scat2" name="pos_scat2" style="font-size: 12px;">
							  <option value="">Choose...</option>
							  </select>
						</div> 
					</td> 
				</tr> 
				<tr>
					<td style="padding:7px;" colspan="2">
						<div id="inp_pos_cat3" class="form-group" >
							<label for="pos_cat3">Category #3</label>							  
							  <select class="form-control" id="pos_cat3" name="pos_cat3" onChange="populateSubCat('pos_cat3', 'pos_scat3');" style="font-size: 12px;">
							  <option value="">Choose...</option>
							  <?
							  for ($idx=0; $idx<sizeof($arr_categories); $idx++)
							  {
							  ?>
								<option value="<? echo $arr_categories[$idx]['id']; ?>"><? echo $arr_categories[$idx]['cat_name']; ?></option>
							  <?
							  }
							  ?>
							  </select>
						</div>
					</td> 
					<td style="padding:7px;" colspan="2">
						<div id="inp_pos_scat3" class="form-group" >
							<label for="pos_scat3">Sub Category #3</label>							  
							  <select class="form-control" id="pos_scat3" name="pos_scat3" style="font-size: 12px;">
							  <option value="">Choose...</option>
							  </select>
						</div> 
					</td> 
				</tr>		
				<tr>
					<td style="padding:7px;" colspan="2" >
						<div id="inp_pos_contact_email" class="form-group" >
							<label for="pos_contact_email">Position Contact Email</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);" style="font-size: 12px;" 
							  id="pos_contact_email" name="pos_contact_email" placeholder="Position Contact Email" value="" />
						</div>	
					</td> 
					<td style="padding:7px;" colspan="2" >
						<div id="inp_pos_notes" class="form-group" >
							<label for="pos_notes">Position Notes</label>
							  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);" style="font-size: 12px;" 
							  id="pos_notes" name="pos_notes" placeholder="Position Notes" value="" />
						</div>	
					</td>
				</tr>				
				</table>			
			
			</div> <!-- class tab-pane id=22 -->
			
			</div> <!-- class="tab-content" -->
			
		</div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>			
			<button type="submit" class="btn btn-primary" onClick="addPrincipalPositionAjax(); return false;" >Send To Approve</button>			
		  </div>		  
		</div> 
		</form>
	  </div> 
	</div>			
		
	
	<div class="modal fade" tabindex="-1" role="dialog" id="addPositionOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add A New Position</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			The New Position Was Sent For Approval!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="addPrincipalPositionAjaxOk();" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="editPosition">
	  <div class="modal-dialog">
		<form role="form" data-toggle="validator" name="frm_editPosition" enctype="multipart/form-data" method="post" autocomplete="off">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Edit Position</h4>
		  </div>		   
		  <div class="modal-body" style="font-size:12px;" id="divEditThePositionBody">	

			<ul class="nav nav-tabs">
			  <li class="active"><a href="#1" data-toggle="tab">Position, Type, Company, Description</a></li>
			  <li><a href="#2" data-toggle="tab">Categories, Contacts, Notes</a></li>			  
			  <li><a href="#3" data-toggle="tab">Status, Auto Renewal</a></li>
			</ul>
		  
			<div class="tab-content">
			<div class="tab-pane active" id="1">
			
			<br/>
			<table id="divEditThePositionBodyTable" style="margin-left:auto; margin-right:auto; width:100%; table-layout: fixed" style="font-size:12px;">									
			<tr>
				<td style="padding:7px;" colspan="2" >
					<div id="inp_position_title_e" class="form-group" >
						<label for="position_title_e">Position Title English</label>
						  <input class="form-control" onkeydown="limit(this, 35);" onkeyup="limit(this, 35);" style="font-size: 12px;" 
						  id="position_title_e" name="position_title_e" placeholder="Position Title English" value="" />
					</div>	
				</td> 
				<td style="padding:7px;" colspan="2" >
					<div id="inp_position_title_heb_e" class="form-group" >
						<label for="position_title_heb_e">Position Title Hebrew</label>
						  <input class="form-control" onkeydown="limit(this, 35);" onkeyup="limit(this, 35);" style="font-size: 12px;" 
						  id="position_title_heb_e" name="position_title_heb_e" placeholder="Position Title Hebrew" value="" />
					</div>	
				</td>
			</tr>
			<tr>
				<td style="padding:7px;" colspan="2">
					<div id="inp_company_nm_e" class="form-group" >
						<label for="company_nm_e">Company</label>							  
						  <select class="form-control" id="company_nm_e" name="company_nm_e" style="font-size: 12px;" >
						  <option value="-10">Choose...</option>
						  <?
						  for ($idx=0; $idx<sizeof($arr_princ_companies); $idx++)
						  {
						  ?>
							<option value="<? echo $arr_princ_companies[$idx]['id']; ?>"><? echo $arr_princ_companies[$idx]['the_name']; ?></option>
						  <?
						  }
						  ?>
						  </select>
					</div>	
				</td> 
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_type_e" class="form-group" >
						<label for="pos_type_e">Position Type</label>							  
						  <select class="form-control" id="pos_type_e" name="pos_type_e" style="font-size: 12px;" >
						  <option value="-10">Choose...</option>
						  <?
						  for ($idx=0; $idx<sizeof($arr_job_type); $idx++)
						  {
						  ?>
							<option value="<? echo $arr_job_type[$idx]['name']; ?>"><? echo $arr_job_type[$idx]['name']; ?></option>
						  <?
						  }
						  ?>
						  </select>
					</div>	
				</td>
			</tr>				
			<tr>
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_desc_eng_e" class="form-group" >
						<label for="pos_desc_eng_e">Position Description English</label>
						  <textarea rows="16" class="form-control" style="resize: none; font-size: 12px;" id="pos_desc_eng_e" name="pos_desc_eng_e" placeholder="Position Description English"></textarea>
					</div>	
				</td> 
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_desc_heb" class="form-group" >
						<label for="pos_desc_heb_e">Position Description Hebrew</label>
						  <textarea rows="16" class="form-control" style="resize: none; font-size: 12px;" id="pos_desc_heb_e" name="pos_desc_heb_e" placeholder="Position Description Hebrew"></textarea>
					</div>	
				</td> 					
			</tr>
			<input id="pos_id_edit" name="pos_id_edit" type="hidden" value="" />
			</table>
		 
			</div> <!-- tab-pane id=1 -->
			
			<div class="tab-pane" id="2">
			
			<br/>
			<table id="divEditThePositionBodyTable2" style="margin-left:auto; margin-right:auto; width:100%; table-layout: fixed" style="font-size:12px;">
			<tr>
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_cat1_e" class="form-group" >
						<label for="pos_cat1_e">Category #1</label>							  
						  <select class="form-control" id="pos_cat1_e" name="pos_cat1_e" onChange="populateSubCat('pos_cat1_e', 'pos_scat1_e');" style="font-size: 12px;" >
						  <option value="0">Choose...</option>
						  <?
						  for ($idx=0; $idx<sizeof($arr_categories); $idx++)
						  {
						  ?>
							<option value="<? echo $arr_categories[$idx]['id']; ?>"><? echo $arr_categories[$idx]['cat_name']; ?></option>
						  <?
						  }
						  ?>
						  </select>
					</div>
				</td> 
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_scat1_e" class="form-group" >
						<label for="pos_scat1_e">Sub Category #1</label>							  
						  <select class="form-control" id="pos_scat1_e" name="pos_scat1_e" style="font-size: 12px;" >
						  <option value="0">Choose...</option>
						  </select>
					</div>	
				</td> 					
			</tr>
			<tr>
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_cat2_e" class="form-group" >
						<label for="pos_cat2_e">Category #2</label>							  
						  <select class="form-control" id="pos_cat2_e" name="pos_cat2_e" onChange="populateSubCat('pos_cat2_e', 'pos_scat2_e');" style="font-size: 12px;" >
						  <option value="0">Choose...</option>
						  <?
						  for ($idx=0; $idx<sizeof($arr_categories); $idx++)
						  {
						  ?>
							<option value="<? echo $arr_categories[$idx]['id']; ?>"><? echo $arr_categories[$idx]['cat_name']; ?></option>
						  <?
						  }
						  ?>
						  </select>
					</div>
				</td> 
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_scat2_e" class="form-group" >
						<label for="pos_scat2_e">Sub Category #2</label>							  
						  <select class="form-control" id="pos_scat2_e" name="pos_scat2_e" style="font-size: 12px;" >
						  <option value="0">Choose...</option>
						  </select>
					</div> 
				</td> 
			</tr> 
			<tr>
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_cat3_e" class="form-group" >
						<label for="pos_cat3_e">Category #3</label>							  
						  <select class="form-control" id="pos_cat3_e" name="pos_cat3_e" onChange="populateSubCat('pos_cat3_e', 'pos_scat3_e');" style="font-size: 12px;" >
						  <option value="0">Choose...</option>
						  <?
						  for ($idx=0; $idx<sizeof($arr_categories); $idx++)
						  {
						  ?>
							<option value="<? echo $arr_categories[$idx]['id']; ?>"><? echo $arr_categories[$idx]['cat_name']; ?></option>
						  <?
						  }
						  ?>
						  </select>
					</div>
				</td> 
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_scat3_e" class="form-group" >
						<label for="pos_scat3_e">Sub Category #3</label>							  
						  <select class="form-control" id="pos_scat3_e" name="pos_scat3_e" style="font-size: 12px;" >
						  <option value="0">Choose...</option>
						  </select>
					</div> 
				</td> 
			</tr>		
			<tr>
				<td style="padding:7px;" colspan="2" >
					<div id="inp_pos_contact_email_e" class="form-group" >
						<label for="pos_contact_email_e">Position Contact Email</label>
						  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);" style="font-size: 12px;" 
						  id="pos_contact_email_e" name="pos_contact_email_e" placeholder="Position Contact Email" value="" />
					</div>	
				</td> 
				<td style="padding:7px;" colspan="2" >
					<div id="inp_pos_notes_e" class="form-group" >
						<label for="pos_notes_e">Position Notes</label>
						  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);" style="font-size: 12px;" 
						  id="pos_notes_e" name="pos_notes_e" placeholder="Position Notes" value="" />
					</div>	
				</td>
			</tr>
			<input id="pos_id_edit2" name="pos_id_edit2" type="hidden" value="" />
			</table>
			
			</div> <!-- tab-pane id=2 -->
			
			<div class="tab-pane" id="3">
			
			<br/>
			<table id="divEditThePositionBodyTable3" style="margin-left:auto; margin-right:auto; width:100%; table-layout: fixed" style="font-size:12px;">
			<tr>
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_status_e" class="form-group" >
						<label for="pos_status_e">Position Status</label>							  
						  <select class="form-control" id="pos_status_e" name="pos_status_e" style="font-size: 12px;" >						  
							<option value="0">Non-Active</option>
							<option value="1">Active</option>
							<option value="2">Waiting For Approval</option>
							<option value="3">Disable Permanently</option>
						  </select>
					</div>
				</td> 
				<td style="padding:7px;" colspan="2">
					<div id="inp_pos_reoccurance_e" class="form-group" >
						<label for="pos_reoccurance_e">Position Auto Renewal</label>							  
						  <select class="form-control" id="pos_reoccurance_e" name="pos_reoccurance_e" style="font-size: 12px;" >
							<option value="0">No Renewal</option>
							<option value="1">Every 1 Day</option>
							<option value="2">Every 2 Day</option>
							<option value="3">Every 3 Day</option>
							<option value="4">Every 4 Day</option>
							<option value="5">Every 5 Day</option>
							<option value="6">Every 6 Day</option>
							<option value="7">Every 7 Day</option>
						  </select>
					</div>
				</td> 
			</tr>		
			<input id="pos_id_edit3" name="pos_id_edit3" type="hidden" value="" />
			</table>
			
			</div> <!-- tab-pane id=3 -->			
			
			</div> <!-- class="tab-content" -->

		 </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>			
			<button type="submit" class="btn btn-primary" onClick="editPrincipalPositionAjax(); return false;" >Send To Approve</button>			
		  </div>		  
		</div> 
		</form>
	  </div> 
	</div>				
	
	<div class="modal fade" tabindex="-1" role="dialog" id="editPositionOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Edit Position</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			The Position Was Edited And Sent For Approval!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="editPrincipalPositionAjaxOk();" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 		
	
	<div class="modal fade" tabindex="-1" role="dialog" id="approveCompanyOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Approve The Company</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			The Company Was Approved Successfully!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="approvePrincipalCompaniesAjaxOk();" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div>	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="approvePositionOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Approve This Position</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			This Position Was Approved Successfully!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="approvePrincipalPositionAjaxOk();" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div>	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="renewPositionOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Renew This Position</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			This Position Was Renewed Successfully!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" onClick="renewPrincipalPositionFormOk();" data-dismiss="modal">Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div>	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="searchPrincipalPositionDialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Search Position(s)</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">
		  
				<div id="inp_pos_search_title" class="form-group" >
					
					<label for="pos_search_title">Search Position(s) By Title</label>							  
					  <select class="form-control" id="pos_search_title" name="pos_search_title">
					  <option value="-25">Show All</option>
					  <?
					  for ($idx=0; $idx<sizeof($arr_princ_search_positions); $idx++)
					  {
					  ?>
						<option value="<? echo $arr_princ_search_positions[$idx]['pos_title']; ?>"><? echo $arr_princ_search_positions[$idx]['pos_title']; ?></option>
					  <?
					  }
					  ?>
					  </select>
					
				</div>	
				
				<div id="inp_pos_search_company" class="form-group" >

					<label for="pos_search_company">Search Position(s) By Company</label>							  
					  <select class="form-control" id="pos_search_company" name="pos_search_company">
					  <option value="-25">Show All</option>
					  <?
					  for ($idx=0; $idx<sizeof($arr_princ_search_companies); $idx++)
					  {
					  ?>
						<option value="<? echo $arr_princ_search_companies[$idx]['the_name']; ?>"><? echo $arr_princ_search_companies[$idx]['the_name']; ?></option>
					  <?
					  }
					  ?>
					  </select>				
				
				</div>

				<div id="inp_pos_search_location" class="form-group" >

					<label for="pos_search_company">Search Position(s) By Location</label>							  
					  <select class="form-control" id="pos_search_location" name="pos_search_location">
					  <option value="-25">Show All</option>
					  <?
					  for ($idx=0; $idx<sizeof($arr_princ_search_locations); $idx++)
					  {
					  ?>
						<option value="<? echo $arr_princ_search_locations[$idx]['name_en']; ?>"><? echo $arr_princ_search_locations[$idx]['name_en']; ?></option>
					  <?
					  }
					  ?>
					  </select>					
				
				</div>				
		  
		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				<button type="button" class="btn btn-default" onClick="searchPrincipalPositionDialogResetAll(); return false;">Reset</button>
			</div>
			<div class="pull-right">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
			<button type="button" class="btn btn-primary" onClick="searchPrincipalPositionDialogOk();" data-dismiss="modal">Search</button>			
			</div>
			<div class="clearfix"></div>
		  </div>		  
		</div> 
	  </div> 
	</div>		
	
	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="searchPrincipalAppliedDialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Search Applied</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">
		  
				<div id="inp_pos_search_applied_name" class="form-group" >
					
					<label for="pos_search_applied_name">Search Applied By Name</label>							  
					  <select class="form-control" id="pos_search_applied_name" name="pos_search_applied_name">
					  <option value="-25">Show All</option>
					  <?
					  for ($idx=0; $idx<sizeof($arr_principal_applied_names); $idx++)
					  {
					  ?>
						<option value="<? echo $arr_principal_applied_names[$idx]['the_name']; ?>"><? echo $arr_principal_applied_names[$idx]['the_name']; ?></option>
					  <?
					  }
					  ?>
					  </select>
					
				</div>	
				
				<div id="inp_pos_search_applied_position" class="form-group" >

					<label for="pos_search_applied_position">Search Applied By Position</label>							  
					  <select class="form-control" id="pos_search_applied_position" name="pos_search_applied_position">
					  <option value="-25">Show All</option>
					  <?
					  for ($idx=0; $idx<sizeof($arr_principal_applied_positions); $idx++)
					  {
					  ?>
						<option value="<? echo $arr_principal_applied_positions[$idx]['pos_title']; ?>"><? echo $arr_principal_applied_positions[$idx]['pos_title']; ?></option>
					  <?
					  }
					  ?>
					  </select>				
				
				</div>

				<div id="inp_pos_search_applied_company" class="form-group" >

					<label for="pos_search_applied_company">Search Applied By Company</label>							  
					  <select class="form-control" id="pos_search_applied_company" name="pos_search_applied_company">
					  <option value="-25">Show All</option>
					  <?
					  for ($idx=0; $idx<sizeof($arr_principal_applied_companies); $idx++)
					  {
					  ?>
						<option value="<? echo $arr_principal_applied_companies[$idx]['the_name']; ?>"><? echo $arr_principal_applied_companies[$idx]['the_name']; ?></option>
					  <?
					  }
					  ?>
					  </select>					
				
				</div>	

				<div id="inp_pos_search_applied_location" class="form-group" >

					<label for="pos_search_applied_location">Search Applied By Location</label>							  
					  <select class="form-control" id="pos_search_applied_location" name="pos_search_applied_location">
					  <option value="-25">Show All</option>
					  <?
					  for ($idx=0; $idx<sizeof($arr_principal_applied_locations); $idx++)
					  {
					  ?>
						<option value="<? echo $arr_principal_applied_locations[$idx]['name_en']; ?>"><? echo $arr_principal_applied_locations[$idx]['name_en']; ?></option>
					  <?
					  }
					  ?>
					  </select>					
				
				</div>					
		  
		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				<button type="button" class="btn btn-default" onClick="searchPrincipalAppliedDialogResetAll(); return false;">Reset</button>
			</div>
			<div class="pull-right">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
			<button type="button" class="btn btn-primary" onClick="searchPrincipalAppliedDialogOk();" data-dismiss="modal">Search</button>			
			</div>
			<div class="clearfix"></div>
		  </div>		  
		</div> 
	  </div> 
	</div>
	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="searchPrincipalCandidateDialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Search Candidates</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">
		  
				<div id="inp_pos_search_candidates_name" class="form-group" >
					
					<label for="pos_search_candidates_name">Search Candidates By Name</label>							  
					  <select class="form-control" id="pos_search_candidates_name" name="pos_search_candidates_name">
					  <option value="-25">Show All</option>
					  <?
					  for ($idx=0; $idx<sizeof($arr_candidates_names); $idx++)
					  {
					  ?>
						<option value="<? echo $arr_candidates_names[$idx]['the_name']; ?>"><? echo $arr_candidates_names[$idx]['the_name']; ?></option>
					  <?
					  }
					  ?>
					  </select>
					
				</div>	
 
				<div id="inp_pos_search_keyword" class="form-group" >
					<label for="pos_search_keyword">Search Candidates By Keyword</label>
					  <input class="form-control" onkeydown="limit(this, 40);" onkeyup="limit(this, 40);"
					  id="pos_search_keyword" name="pos_search_keyword" placeholder="Keyword" value="" />
				</div>

		  </div>		  
		  <div class="modal-footer">
			<div class="pull-left">
				<button type="button" class="btn btn-default" onClick="searchPrincipalCandidatesDialogResetAll(); return false;">Reset</button>
			</div>
			<div class="pull-right">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
			<button type="button" class="btn btn-primary" onClick="searchPrincipalCandidatesDialogOk();" data-dismiss="modal">Search</button>			
			</div>
			<div class="clearfix"></div>
		  </div>		  
		</div> 
	  </div> 
	</div>	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="informCompanyAboutAppliedPosition">
	  <div class="modal-dialog">
		<form role="form" data-toggle="validator" name="frm_informTheCompanyAboutThisPosition" enctype="multipart/form-data" method="post" autocomplete="off">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Inform The Company About This Position Applied</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
		
				<div id="inp_ic_position" class="form-group" >
					<label for="ic_position">Position:</label>
					  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
					  id="ic_position" name="ic_position" value="" readonly />
				</div>		
		
				<div id="inp_ic_company" class="form-group" >
					<label for="ic_company">Company:</label>
					  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
					  id="ic_company" name="ic_company" value="" readonly />
				</div>	

				<div id="inp_ic_candidate" class="form-group" >
					<label for="ic_candidate">Candidate:</label>
					  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
					  id="ic_candidate" name="ic_candidate" value="" readonly />
				</div>

				<div id="inp_ic_resume" class="form-group" >
					<label for="ic_resume">Resume:</label>
					<label for="ic_resume">Email To Inform:</label>
					  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
					  id="ic_resume" name="ic_resume" value="" readonly />					  
				</div>	

				<div id="inp_ic_email" class="form-group" >
					<label for="ic_email">Email To Inform:</label>
					  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
					  id="ic_email" name="ic_email" value="" />
				</div>

				<div id="inp_ic_email_s" class="form-group" >
					<label for="ic_email_s">Email Suggested:&nbsp;&nbsp;<label for="suggested_use"><input type="checkbox" id="suggested_use" name="suggested_use" onchange="change_suggested_use()"> Use It!</label></label>
					  <input class="form-control" onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
					  id="ic_email_s" name="ic_email_s" value="" readonly />
				</div>				
		
		  </div>	
		  <input type="hidden" id="informTheCompanyUserPositionId" name="informTheCompanyUserPositionId" value=""> 
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
			<button type="button" class="btn btn-primary" onClick="informTheCompanyAjax();">Inform</button>			
		  </div>		  
		</div> 
		</form>
	  </div> 
	</div>	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="informCompanyAboutAppliedPositionOk">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Inform The Company About This Position Applied</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			This Company Was Informed Successfully About This Position Applied By This Candidate!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" onClick="informCompanyAboutAppliedPositionOkFunc();"; data-dismiss="modal">Thank You!</button>			
		  </div>		  
		</div> 
	  </div> 
	</div>	
		
	
	<script>
			
	$(document).ready(function(){
		$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
			
			if (($(e.target).attr('href') != "#1") && ($(e.target).attr('href') != "#2") && ($(e.target).attr('href') != "#3")
					&& ($(e.target).attr('href') != "#11") && ($(e.target).attr('href') != "#22") )
			{				
				localStorage.setItem('activeTab', $(e.target).attr('href'));
			}
		});
		var activeTab = localStorage.getItem('activeTab');
		
		if(activeTab){
			$('#myTab a[href="' + activeTab + '"]').tab('show');
		}
		else
		{
			$('#myTab a[href="#profile"]').tab('show');
		}
	});	
	
	</script>		
	
</body>
</html>

