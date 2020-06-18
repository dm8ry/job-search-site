<?php session_start(); 

if (!$_SESSION['auth_login'])
{
	header("Location: index.php");
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
	
	$sql_regions = "select distinct region_en from city where status='1' and region_en != '' order by 1";
								
	$arr_regions = array();		
	$results_regions = mysqli_query($conn, $sql_regions); 	
	
	while($line = mysqli_fetch_assoc($results_regions)){
		$arr_regions[] = $line;
	}

	$sql_categories = "select id, cat_name from category order by 2";
								
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
	
	$sql_trending_jobs = "select pos_title, id from positions order by napply desc, nviews desc limit 0, 7";
								
	$arr_trending_jobs = array();		
	$results_trending_jobs = mysqli_query($conn, $sql_trending_jobs); 	
	
	while($line = mysqli_fetch_assoc($results_trending_jobs)){
		$arr_trending_jobs[] = $line;
	}	
	
	$conn->close();		
	
?>	
 
  <meta charset="utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
  <meta name="description" content="Find Job in Israel | חיפוש עבודה | Israeli Companies | משרות הייטק | High Paying Jobs in Israel | לוח דרושים איכותי">
  <meta name="keywords" content="find, job, Israel, עבודה, חיפוש, הייטק, משרות, איכותי, דרושים, לוח, High, Paying, search, employment, companies, work, 972, hr, human, resources ">

  <title>Jobs972 - Find Job in Israel!</title>
	    
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

function  inviteFriendEarnPointsModalOk()
{

	nErrors = 0;
	
	if (document.getElementById("invfr_friend_email").value==null || document.getElementById("invfr_friend_email").value=="")
	{
		document.getElementById("invfr_friend_email").style.borderColor = "red";
		document.getElementById("invfr_friend_email").style.boxShadow = "3px 3px 3px lightgray";			
		nErrors++;
	}	
	else if (!validateEmail(document.getElementById("invfr_friend_email").value))
	{			
		document.getElementById("invfr_friend_email").style.borderColor = "red";
		document.getElementById("invfr_friend_email").style.boxShadow = "3px 3px 3px lightgray";	
		nErrors++;			
	}		
	else 
	{
		document.getElementById("invfr_friend_email").style.borderColor = "green";
		document.getElementById("invfr_friend_email").style.boxShadow = "2px 2px 2px lightgray";
	}

	if (document.getElementById("invfr_friend_fn").value==null || document.getElementById("invfr_friend_fn").value=="")
	{
		document.getElementById("invfr_friend_fn").style.borderColor = "red";
		document.getElementById("invfr_friend_fn").style.boxShadow = "3px 3px 3px lightgray";			
		nErrors++;
	}			
	else 
	{
		document.getElementById("invfr_friend_fn").style.borderColor = "green";
		document.getElementById("invfr_friend_fn").style.boxShadow = "2px 2px 2px lightgray";
	}	
	
	if (document.getElementById("invfr_friend_ln").value==null || document.getElementById("invfr_friend_ln").value=="")
	{
		document.getElementById("invfr_friend_ln").style.borderColor = "red";
		document.getElementById("invfr_friend_ln").style.boxShadow = "3px 3px 3px lightgray";			
		nErrors++;
	}			
	else 
	{
		document.getElementById("invfr_friend_ln").style.borderColor = "green";
		document.getElementById("invfr_friend_ln").style.boxShadow = "2px 2px 2px lightgray";
	}	
	
	if (nErrors==0)
	{	

		var url = "invite_your_friend.php";
		
		var oData = new FormData(document.forms.namedItem("frm_inviteFriendEarnPointsModal"));
		
		var oReq = new XMLHttpRequest();
		
		    oReq.open("POST", url, true);
		    oReq.onload = function(oEvent) {
								
				if (oReq.status == 200) 
				{			
					// alert('>>'+oReq.responseText+'<<');
					
					$('#inviteFriendEarnPointsModal').modal('hide');
					getMyProfileAjax();																																				 
					
					return;
					
				} else {
				  alert("Error " + oReq.status + " occurred.<br \/>");
				}
				
		  };

		oReq.send(oData); 
			
	}	

}

function inviteFriendEarnPoints()
{
	$('#inviteFriendEarnPointsModal').modal('show');
}

function cud_set_unset()
{
	if (document.getElementById("cud_unset").checked == true)
	{		
		document.getElementById("cat_block_cud").style.display = 'none';
		document.getElementById("sub_cat_block_cud").style.display = 'none';
	}
	else
	{
		document.getElementById("cat_block_cud").style.display = '';
		document.getElementById("sub_cat_block_cud").style.display = '';	
	}
}

function removeOptions(obj) {
    while (obj.options.length) {
        obj.remove(0);
    }
}

function populateSubCatEdit()
{

	var selectCat = document.getElementById("sma_edit_categories_select");
	var catChosen = document.getElementById("sma_edit_categories_select").value;
	var select = document.getElementById("sma_edit_sub_categories_select");
	
	removeOptions(select);
	
	var el = document.createElement("option");
	el.textContent = "All";
	el.value = -1;
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

function populateSubCat()
{

	var selectCat = document.getElementById("sma_categories_select");
	var catChosen = document.getElementById("sma_categories_select").value;
	var select = document.getElementById("sma_sub_categories_select");
	
	removeOptions(select);
	
	var el = document.createElement("option");
	el.textContent = "All";
	el.value = -1;
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


function cud_populateSubCat()
{

	var selectCat = document.getElementById("cud_categories_select");
	var catChosen = document.getElementById("cud_categories_select").value;
	var select = document.getElementById("cud_sub_categories_select");
	
	removeOptions(select);
	
	var el = document.createElement("option");
	el.textContent = "All";
	el.value = -1;
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


function changeUserDetailsCatSubcatOk()
{	
	
	var url = "editUserDetailsCatSubcat.php";
				
	var oData = new FormData(document.forms.namedItem("frm_changeUserDetailsCatSubcat"));
	
	var oReq = new XMLHttpRequest();
	  oReq.open("POST", url, true);
	  oReq.onload = function(oEvent) {
							
		if (oReq.status == 200) 
		{			
			// alert('response_data = '+oReq.responseText);
			getMyProfileAjax();			
			return;
		} 
		else 
		{
		  alert("Error " + oReq.status + " occurred.<br \/>");
		}
	  };

	oReq.send(oData); 	
	
}


function editSmartAgentOk()
{	
	
	var url = "editTheSpecificSmartAgent.php";
				
	var oData = new FormData(document.forms.namedItem("frm_editSmartAgent"));
	
	var oReq = new XMLHttpRequest();
	  oReq.open("POST", url, true);
	  oReq.onload = function(oEvent) {
							
		if (oReq.status == 200) 
		{			
		
			// alert('response_data = '+oReq.responseText);
			getSmartAgentsAjax();			
			return;
			
		} else {
		  alert("Error " + oReq.status + " occurred.<br \/>");
		}
	  };

	oReq.send(oData); 	
	
}

function getResumesAjax()
{

	document.getElementById("divResumes").style.display = "none";
	$('#resume').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');
	
	var http = new XMLHttpRequest();
	var url = "getResumes.php";
	var params = null;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			  var response_data = JSON.parse(http.responseText);			  
			  $('#loader').remove();
			  document.getElementById("divResumes").style.display = "block";
			  document.getElementById("divResumes").innerHTML = response_data.val_1;
			  document.getElementById("num_resumes").innerHTML = response_data.val_2;
		}
	}
	http.send(params);	
}

function generateRecommendedPositions()
{	
	var http = new XMLHttpRequest();
	var url = "generateRecommendedPositions.php";
	var params = null;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			//  alert("Ok!");
		}
	}
	http.send(params);	
}

function NotToShowAppliedPosition(a,b)
{	
	var http = new XMLHttpRequest();
	var url = "notToShowAppliedPosition.php";
	var params = 'a='+a;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {			   
			   getAppliedPositionsAjax(1);
		}
	}
	http.send(params);	
}

function getMyProfileAjax()
{

	document.getElementById("divMyProfile").style.display = "none";
	$('#profile').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');
	
	var http = new XMLHttpRequest();
	var url = "getUserDetails.php";
	var params = null;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
		
			  //alert("response: "+http.responseText);
		
			  var response_data = JSON.parse(http.responseText);			  
			  $('#loader').remove();
			  document.getElementById("divMyProfile").style.display = "block";
			  document.getElementById("divMyProfile").innerHTML = response_data.val_1;	

			  var is_profile_non_active = document.getElementById("valIsActive").innerHTML.includes('Non-Active');
			 
			  if (is_profile_non_active == true)
			  {
				document.getElementById("m2").style.display = 'none';
				document.getElementById("m3").style.display = 'none';
				document.getElementById("m4").style.display = 'none';
				document.getElementById("m5").style.display = 'none';
				document.getElementById("m6").style.display = 'none';
				
				document.getElementById("m7").style.display = 'none';
				document.getElementById("m8").style.display = 'none';
				document.getElementById("m9").style.display = 'none';
				document.getElementById("m10").style.display = 'none';
				document.getElementById("m11").style.display = 'none';
				document.getElementById("m12").style.display = 'none';
			  }
			  else
			  {
				document.getElementById("m2").style.display = 'inline';
				document.getElementById("m3").style.display = 'inline';
				document.getElementById("m4").style.display = 'inline';
				document.getElementById("m5").style.display = 'inline';
				document.getElementById("m6").style.display = 'inline';	

				document.getElementById("m7").style.display = '';
				document.getElementById("m8").style.display = '';
				document.getElementById("m9").style.display = '';
				document.getElementById("m10").style.display = '';
				document.getElementById("m11").style.display = '';
				document.getElementById("m12").style.display = '';				
			  }
			  
		}
	}
	http.send(params);	
}

function getSmartAgentsAjax()
{

	document.getElementById("divSmartAgents").style.display = "none";
	$('#smart_agent').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');
	
	var http = new XMLHttpRequest();
	var url = "getSmartAgents.php";
	var params = null;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			  var response_data = JSON.parse(http.responseText);			  
			  $('#loader').remove();
			  document.getElementById("divSmartAgents").style.display = "block";
			  document.getElementById("divSmartAgents").innerHTML = response_data.val_1;
			  document.getElementById("num_smart_agents").innerHTML = response_data.val_2;
		}
	}
	http.send(params);	
}

function testAjax()
{
	var url = "testAjax.php";
			
	$('#tsttst').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');
			
	var oReq = new XMLHttpRequest();
	  oReq.open("POST", url, true);
	  oReq.onload = function(oEvent) {
								
		if (oReq.status == 200) 
		{			
			//alert('>>'+oReq.responseText+'<<');
			$('#loader').remove();
			document.getElementById("divTstOutput").innerHTML=oReq.responseText;
			return;
		} else {
		  alert("Error " + oReq.status + " occurred.<br \/>");
		}
	  };

	oReq.send(null); 
}

function editSmartAgent(n)
{
	
	document.getElementById("editSmartAgentTable").style.display = "none";
	$('#editSmartAgent_modalbody').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');
	$('#editSmartAgent').modal('show');	

	var http = new XMLHttpRequest();
	var url = "getTheSpecificSmartAgent.php";
	var params = "sma_id="+n;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			  var response_data = JSON.parse(http.responseText);			  
						
			// populate elements	
			document.getElementById("smagent_id").value = response_data.val_1;
			document.getElementById("sma_edit_days_select").value = response_data.val_2;
			document.getElementById("sma_edit_region_n_city_select").value = response_data.val_3;
			document.getElementById("sma_edit_categories_select").value = response_data.val_4;
			document.getElementById("sma_edit_sub_categories_select").value = response_data.val_5;
			document.getElementById("sma_edit_contains_txt").value = response_data.val_6;
			
			document.getElementById("editSmartAgentTable").style.display = "table";
			$('#loader').remove();
			  
		}
	}
	http.send(params);

}

function delete_this_smart_agent()
{
	var url = "delete_sma.php";
				
	var oData = new FormData(document.forms.namedItem("frm_deleteThisSmartAgent"));
	
	var oReq = new XMLHttpRequest();
	  oReq.open("POST", url, true);
	  oReq.onload = function(oEvent) {
							
		if (oReq.status == 200) 
		{			
			// alert('>>'+oReq.responseText+'<<');
			
			if (oReq.responseText!='Ok')
			{					
				return;
			}
			else
			{		
				$('#deleteThisSmartAgent').modal('hide');																								
				getSmartAgentsAjax();
			}
			return;
			
		} else {
		  alert("Error " + oReq.status + " occurred.<br \/>");
		}
	  };

	oReq.send(oData); 
}

function deleteSmartAgent(n)
{
	document.getElementById("sma_id").value = n;
	$('#deleteThisSmartAgent').modal('show');
}

function addNewSmartAgentOk()
{
	var url = "addNewSmartAgent.php";
				
	var oData = new FormData(document.forms.namedItem("frm_addNewSmartAgent"));
	
	var oReq = new XMLHttpRequest();
	  oReq.open("POST", url, true);
	  oReq.onload = function(oEvent) {
							
		if (oReq.status == 200) 
		{			
			//alert('responseText='+oReq.responseText);
			
			if (oReq.responseText!='Ok')
			{	
				return;
			}
			else
			{									
				getSmartAgentsAjax();
			}
			
			return;
			
		} else {
		  alert("Error " + oReq.status + " occurred.<br \/>");
		}
	  };

	oReq.send(oData);
}

function addSmartAgent()
{
	// initialize elements
	
	document.getElementById("sma_days_select").value = 14;
	document.getElementById("sma_region_n_city_select").value = -1;
	document.getElementById("sma_categories_select").value = -1;
	document.getElementById("sma_sub_categories_select").value = -1;
	document.getElementById("sma_contains_txt").value = '';
	$('#addNewSmartAgent').modal('show');
}


function changeUserDetailsCatSubcat(n,c,s)
{

	//alert("n="+n+"; c="+c+"; s="+s);
	
	document.getElementById("cat_block_cud").style.display = '';
	document.getElementById("sub_cat_block_cud").style.display = '';
	document.getElementById("cud_unset").checked = false;
	
	document.getElementById("mod_changeUserDetailsCatSubcat_head").innerHTML="Category #"+n+":";
	document.getElementById("mod_changeUserDetailsCatSubcat_head2").innerHTML="Sub-Category #"+n+":";
	document.getElementById("mod_changeUserDetailsCatSubcat_head3").innerHTML="";
	document.getElementById("cud_unset").checked = false;
	document.getElementById("mod_changeUserDetailsCatSubcat_n").value = n;
	document.getElementById('cud_categories_select').value = c;
	cud_populateSubCat();
	document.getElementById('cud_sub_categories_select').value = s;
	
	$('#mod_changeUserDetailsCatSubcat').modal('show');
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

function areYouSurePositionNotInterested(n)
{
	document.getElementById('not_interesting_position_btn').setAttribute('onclick','positionNotInterested('+n+')')
	$('#modalAreYouSurePositionNotInterested').modal('show');
}

function positionNotInterested(n)
{
	var url = "positionNotInterested.php";
				
	var oData = new FormData(document.forms.namedItem("frmPositions"+n));
	
	var oReq = new XMLHttpRequest();
	  oReq.open("POST", url, true);
	  oReq.onload = function(oEvent) {
							
		if (oReq.status == 200) 
		{			
			// alert('>>'+oReq.responseText+'<<');
			
			if (oReq.responseText!='Ok')
			{	
				return;
			}
			else
			{	
						
				$('#modalAreYouSurePositionNotInterested').modal('hide');
				getRecommendedPositionsAjax(1);				
			}
			
			return;
			
		} else {
		  alert("Error " + oReq.status + " occurred.<br \/>");
		}
	  };

	oReq.send(oData);
}


function getResumesWhenApplyingForPosition()
{

	var http = new XMLHttpRequest();
	var url = "getResumesWhenApplyingForPosition.php";
	var params = null;
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {
		if(http.readyState == 4 && http.status == 200) {
			  var response_data = JSON.parse(http.responseText);			  
			  document.getElementById("inp_apply_position_resume").innerHTML = response_data.val_1;
		}
	}
	http.send(params);	
}

function positionToApply(up_id,position_title)
{

	//alert('positionToApply '+n);
	document.getElementById("apply_position_name").value=position_title;
	document.getElementById("apply_for_this_position_user_pos_id").value=up_id;
	
	/* preserve previous state of a cover letter when applying for position
	document.getElementById("elTurnOnCoverLetter").checked = false;
	document.getElementById("apply_resume_cover").value="";	
	document.getElementById("apply_resume_cover").readOnly=true;
	*/
	
	var nResumes = document.getElementById("num_resumes").innerHTML;
		
	if (nResumes == 0)
	{
	
		// should have at least 1 resume uploaded to apply for position
		$("#shouldHaveAtLeastOneResumeLoadedToApply").modal()
	
	}
	else
	{
		getResumesWhenApplyingForPosition();
		$("#applyForPosition").modal()
	
	}
}

function ApplyForPositionYes()
{

	var url = "apply_for_this_position.php";
				
	var oData = new FormData(document.forms.namedItem("frmApplyForPosition"));
	
	var oReq = new XMLHttpRequest();
	  oReq.open("POST", url, true);
	  oReq.onload = function(oEvent) {
							
		if (oReq.status == 200) 
		{			
			//alert('>>'+oReq.responseText+'<<');
			
			if (oReq.responseText!='Ok')
			{	
				return;
			}
			else
			{	
						
				$('#applyForPosition').modal('hide');
				$('#applyForPositionOk').modal('show');
			}
			
			return;
			
		} else {
		  alert("Error " + oReq.status + " occurred.<br \/>");
		}
	  };

	oReq.send(oData);

}

function applyForPositionOkAfter()
{
	getRecommendedPositionsAjax(1);
	getAppliedPositionsAjax(1);
}

function xyz()
{
alert("xyz");
}

function edit_your_resume(i,d,f)
{
	
	var nErrors =0;	
	document.getElementById("mdl_edit_msg").style.display="none";
						
	// check resume_description
	if (document.getElementById("edit_resume_description").value==null || document.getElementById("edit_resume_description").value=="")
	{					
		document.getElementById("edit_resume_description").style.borderColor = "red";
		document.getElementById("edit_resume_description").style.boxShadow = "2px 2px 2px lightgray";
		nErrors++;
	}
	else
	{
		var str=document.getElementById("edit_resume_description").value;
		var n= str.length;
		var specialChars = "$%^&*{}?'\"\\,./~`-=";
		
		var nErrSpecChars = 0;
		
		for(i = 0; i < specialChars.length;i++)
		{
			if(str.indexOf(specialChars[i]) > -1)
			{
				nErrSpecChars++;
			}
		}
		
		if (n > 30 || nErrSpecChars>0)
		{			
			document.getElementById("edit_resume_description").style.borderColor = "red";
			document.getElementById("edit_resume_description").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;						
		}			
		else
		{
			document.getElementById("edit_resume_description").style.borderColor = "green";
			document.getElementById("edit_resume_description").style.boxShadow = "2px 2px 2px lightgray";
		}
	}	 
		 
						
	if (nErrors==0)
	{			

		$('#progressbar_upl2').append('<img src="images/progressbar.gif" class="img-responsive center-block" id="loader">');
	
		document.getElementById("mdl_edit_msg").innerHTML="";
		document.getElementById("mdl_edit_msg").style.display="none";
	
		var url = "update_resume.php";
					
		var oData = new FormData(document.forms.namedItem("frm_editResume"));
		
		var oReq = new XMLHttpRequest();
		  oReq.open("POST", url, true);
		  oReq.onload = function(oEvent) {
						
			$('#loader').remove();
						
			if (oReq.status == 200) 
			{			
				// alert('>>'+oReq.responseText+'<<');
				
				if (oReq.responseText!='Ok')
				{					
					document.getElementById("mdl_edit_msg").innerHTML=oReq.responseText;
					document.getElementById("mdl_edit_msg").style.display="block";									
					return;
				}
				else
				{		
					$('#editResume').modal('hide');																				
					//window.location.reload();														
					getResumesAjax();
				}
				
				return;
				
			} else {
			  alert("Error " + oReq.status + " occurred.<br \/>");
			}
		  };

		oReq.send(oData); 
	}
}

function delete_your_resume()
{
	var url = "delete_resume.php";
				
	var oData = new FormData(document.forms.namedItem("frm_deleteResume"));
	
	var oReq = new XMLHttpRequest();
	  oReq.open("POST", url, true);
	  oReq.onload = function(oEvent) {
							
		if (oReq.status == 200) 
		{			
			// alert('>>'+oReq.responseText+'<<');
			
			if (oReq.responseText!='Ok')
			{					
				document.getElementById("mdl_delete_msg").innerHTML=oReq.responseText;
				document.getElementById("mdl_delete_msg").style.display="block";									
				return;
			}
			else
			{		
				$('#deleteThisResume').modal('hide');																				
				//window.location.reload();	
				getResumesAjax();
			}
			
			return;
			
		} else {
		  alert("Error " + oReq.status + " occurred.<br \/>");
		}
	  };

	oReq.send(oData); 
}

function upload_your_resume()
{	
		
	var nErrors =0;
						
	// check resume_description
	if (document.getElementById("resume_description").value==null || document.getElementById("resume_description").value=="")
	{					
		document.getElementById("resume_description").style.borderColor = "red";
		document.getElementById("resume_description").style.boxShadow = "2px 2px 2px lightgray";
		nErrors++;
	}
	else
	{
		var str=document.getElementById("resume_description").value;
		var n= str.length;
		var specialChars = "$%^&*{}?'\"\\,./~`-=";
		
		var nErrSpecChars = 0;
		
		for(i = 0; i < specialChars.length;i++)
		{
			if(str.indexOf(specialChars[i]) > -1)
			{
				nErrSpecChars++;
			}
		}
		
		if (n > 30 || nErrSpecChars>0)
		{			
			document.getElementById("resume_description").style.borderColor = "red";
			document.getElementById("resume_description").style.boxShadow = "3px 3px 3px lightgray";
			nErrors++;						
		}			
		else
		{
			document.getElementById("resume_description").style.borderColor = "green";
			document.getElementById("resume_description").style.boxShadow = "2px 2px 2px lightgray";
		}
	}	 
	
	// check resume_btn
	if (document.getElementById("my-file-selector").value==null || document.getElementById("my-file-selector").value=="")
	{				
		document.getElementById("resume_btn_upl_resume").style.borderColor = "red";
		document.getElementById("resume_btn_upl_resume").style.boxShadow = "2px 2px 2px lightgray";
		nErrors++;
	}
	else
	{
		document.getElementById("resume_btn_upl_resume").style.borderColor = "green";
		document.getElementById("resume_btn_upl_resume").style.boxShadow = "2px 2px 2px lightgray";
	}	
						
	if (nErrors==0)
	{		
		
		$('#progressbar_upl').append('<img src="images/progressbar.gif" class="img-responsive center-block" id="loader">');	
		document.getElementById("mdl_msg").innerHTML="";
		document.getElementById("mdl_msg").style.display="none";				
	
		var url = "upload_resume.php";
		var oData = new FormData(document.forms.namedItem("frm_userResume"));
		
		var oReq = new XMLHttpRequest();
			oReq.open("POST", url, true);
			oReq.onload = function(oEvent) 
			{				
				// alert("oReq.status = "+oReq.status);
				
				$('#loader').remove();
				
				if (oReq.status == 200) 
				{													
					var txtResponse = oReq.responseText;
					if (txtResponse.localeCompare("Ok") != 0)
					{							
						document.getElementById("mdl_msg").innerHTML=oReq.responseText;
						document.getElementById("mdl_msg").style.display="block";
						return;
					}
					else
					{	
						$('#addResume').modal('hide');																				
						//window.location.reload(true);														
						getResumesAjax();
					}
					return;
				} 
				else 
				{
				  alert("Error " + oReq.status + " occurred.<br \/>");
				}
			};

		oReq.send(oData); 
	}
}

function verifyEmail()
{
	alert ('Verify Email');
}

function changeUserDetails(strEl)
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
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;
		document.getElementById("ud_data_to_change").type='password';
	}
	
	if (strEl == "Firstname")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your Firstname";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Firstname...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;	
		document.getElementById("ud_data_to_change").value = document.getElementById("valFirstname").innerHTML;
	}

	if (strEl == "Lastname")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your Lastname";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Lastname...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;
		document.getElementById("ud_data_to_change").value = document.getElementById("valFirstname").innerHTML;
	}

	if (strEl == "City")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your City";			
		document.getElementById("ud_data_to_change").placeholder = "Enter City...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;	
		document.getElementById("ud_data_to_change").value = document.getElementById("valCity").innerHTML;
	}

	if (strEl == "Mobile")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Your Mobile";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Mobile...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;
		document.getElementById("ud_data_to_change").value = document.getElementById("valMobile").innerHTML;
	}		
	
	if (strEl == "Positions")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change Positions You're Looking For";			
		document.getElementById("ud_data_to_change").placeholder = "Enter Positions...";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;	
		document.getElementById("ud_data_to_change").value = document.getElementById("valPositions").innerHTML;
	}	

	if (strEl == "LinkedInURL")
	{
		document.getElementById("ud_data_to_change_lbl").innerHTML = "Change LinkedIn profile URL";			
		document.getElementById("ud_data_to_change").placeholder = "Enter LinkedIn URL...";
		document.getElementById("ud_data_to_change").onkeydown="limit(this, 130);";
		document.getElementById("ud_data_to_change").onkeyup="limit(this, 130);";
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;')
		document.getElementById("elm_name").value = strEl;
		document.getElementById("ud_data_to_change").value = document.getElementById("valLinkedin").innerHTML;
	}		
	
    if (strEl == "About")
	{

		document.getElementById("inp_ud_data_to_change").innerHTML = '<label for="ud_data_to_change" id="ud_data_to_change_lbl">Tell Us About Yourself</label> <br/>' +
								'<textarea class="form-control" id="ud_data_to_change" name="ud_data_to_change">' +								
							   '</textarea>' +
							  '<input type="hidden" id="elm_name" name="elm_name" value="About" autocomplete="off"> ';		
				
		var str = document.getElementById("valAbout").innerHTML;
		
		document.getElementById("ud_data_to_change").innerHTML = str.replace(/<br\s*[\/]?>/gi, "");
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;');
	}
	
    if (strEl == "Is_Citizen")
	{

		if (document.getElementById("valIsCitizen").innerHTML == 'Yes')
		{
	
	
		document.getElementById("inp_ud_data_to_change").innerHTML = '<label for="ud_data_to_change" id="ud_data_to_change_lbl">Are You A Citizen Of Israel?</label> <br/>' +
								'<select class="form-control" id="ud_data_to_change" name="ud_data_to_change">' +
								'<option value="1" selected>Yes</option>' +
								'<option value="0">No</option>' +
							   '</select>' +
							  '<input type="hidden" id="elm_name" name="elm_name" value="Is_Citizen" autocomplete="off"> ';
		}
		else
		{
	
		document.getElementById("inp_ud_data_to_change").innerHTML = '<label for="ud_data_to_change" id="ud_data_to_change_lbl">Are You A Citizen Of Israel?</label> <br/>' +
								'<select class="form-control" id="ud_data_to_change" name="ud_data_to_change">' +
								'<option value="1">Yes</option>' +
								'<option value="0" selected>No</option>' +
							   '</select>' +
							  '<input type="hidden" id="elm_name" name="elm_name" value="Is_Citizen" autocomplete="off"> ';	
		
		}
				
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;');
	}
	
    if (strEl == "Profile_Status")
	{
		
		if (document.getElementById("valIsActive").innerHTML.includes('Non-Active') == false)
		{	
	
		document.getElementById("inp_ud_data_to_change").innerHTML = '<label for="ud_data_to_change" id="ud_data_to_change_lbl">Choose Profile Status...</label> <br/>' +
								'<select class="form-control" id="ud_data_to_change" name="ud_data_to_change">' +
								'<option value="1" selected>Active</option>' +
								'<option value="0">Non-Active</option>' +
							   '</select>' +
							  '<input type="hidden" id="elm_name" name="elm_name" value="Profile_Status" autocomplete="off"> ';
			
		}			
		else
		{

		document.getElementById("inp_ud_data_to_change").innerHTML = '<label for="ud_data_to_change" id="ud_data_to_change_lbl">Choose Profile Status...</label> <br/>' +
								'<select class="form-control" id="ud_data_to_change" name="ud_data_to_change">' +
								'<option value="1">Active</option>' +
								'<option value="0" selected>Non-Active</option>' +
							   '</select>' +
							  '<input type="hidden" id="elm_name" name="elm_name" value="Profile_Status" autocomplete="off"> ';
				
		}
		
		document.getElementById("ud_data_to_change_btn").setAttribute('onclick','apply_userDetails(\''+strEl+'\'); return false;');
	}			
	
	$("#userDetails").modal()
}	
	
function apply_userDetails(strEl)
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
			
			var url = "apply_user_details.php";
						
			var oData = new FormData(document.forms.namedItem("frm_userDetails"));
			
			var oReq = new XMLHttpRequest();
			  oReq.open("POST", url, true);
			  oReq.onload = function(oEvent) {
									
				if (oReq.status == 200) 
				{			
					//alert('>>'+oReq.responseText);						 
					$('#userDetails').modal('hide');						
					getMyProfileAjax();
						
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
	var url = "getRecentActivityDetails.php";
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

function addResume()
{
	
	document.getElementById("mdl_msg").style.display="none";

	document.getElementById("resume_description").value='';			
	document.getElementById("resume_description").style.borderColor = "#e3e3e3";
	document.getElementById("resume_description").style.boxShadow = "none";

	document.getElementById("my-file-selector").value='';
	document.getElementById("resume_btn_upl_resume").style.borderColor = "#e3e3e3";
	document.getElementById("resume_btn_upl_resume").style.boxShadow = "none";
	
	document.getElementById("upload-file-info").innerHTML="Choose...";

	$('#addResume').modal('show');
}

function editResume(d, f, ii, dd, pp)
{
	document.getElementById("mdl_edit_msg").innerHTML="";
	document.getElementById("mdl_edit_msg").style.display="none";
		
    document.getElementById("edit_resume_description").value = d;
	document.getElementById("upload-file-edit-info").innerHTML = f;
	
	document.getElementById("rec_e_id").value = ii;
	document.getElementById("res_e_desc").value = dd;
	document.getElementById("res_e_filename").value = pp;	
	
	$('#editResume').modal('show');
}

function deleteResume(i, d, p)
{	
	document.getElementById("rec_id").value = i;
	document.getElementById("res_desc").value = d;
	document.getElementById("res_filename").value = p;
	$('#deleteThisResume').modal('show');
}

function getRecentActivitiesAjax(n_page)
{
	document.getElementById("divRecentActivities").style.display = "none";
	$('#recent_activities').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');
	
	var http = new XMLHttpRequest();
	var url = "getRecentActivity.php";
	var params = "the_curr_page="+n_page+"&recs_per_page=7";
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			  			 
			  var response_data = JSON.parse(http.responseText);
			  
			  $('#loader').remove();
			  document.getElementById("divRecentActivities").style.display = "block";
			  document.getElementById("divRecentActivities").innerHTML = response_data.val_1;
			  document.getElementById("num_recent_activities_rec_no").innerHTML = response_data.val_2;
		}
	}
	http.send(params);	
}	



function getAppliedPositionsAjax(n_page)
{
	document.getElementById("divAppliedPositions").style.display = "none";
	$('#app_positions').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');
	
	var http = new XMLHttpRequest();
	var url = "getAppliedPositions.php";
	var params = "the_curr_page="+n_page+"&recs_per_page=7";
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			  // alert(http.responseText);	
			  var response_data = JSON.parse(http.responseText);
			  $('#loader').remove();
			  document.getElementById("divAppliedPositions").style.display = "block";			  
			  document.getElementById("divAppliedPositions").innerHTML = response_data.val_1;
			  document.getElementById("num_applied_positions").innerHTML = response_data.val_2;
		}
	}
	http.send(params);	
}


function getRecommendedPositionsAjax(n_page)
{

	document.getElementById("divRecommendedPositions").style.display = "none";
	$('#rec_positions').append('<img src="images/loading.gif" class="img-responsive center-block" id="loader">');
	
	var http = new XMLHttpRequest();
	var url = "getRecommendedPositions.php";
	var params = "the_curr_page="+n_page+"&recs_per_page=7";
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			  // alert(http.responseText);	
			  var response_data = JSON.parse(http.responseText);
			  $('#loader').remove();
			  document.getElementById("divRecommendedPositions").style.display = "block";			  
			  document.getElementById("divRecommendedPositions").innerHTML = response_data.val_1;
			  document.getElementById("num_recommended_positions").innerHTML = response_data.val_2;
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
<body onload="getMyProfileAjax(); getResumesAjax(); generateRecommendedPositions(); getRecentActivitiesAjax(1); getAppliedPositionsAjax(1); getRecommendedPositionsAjax(1); getSmartAgentsAjax(); ">	

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
				<li class="active"><a href="user_dashboard.php"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['logged_in_user_firstname']; ?></a></a></li>
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Exit</a></li>		

				<!-- no multilang yet :))))
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">English <span class="caret"></span></a>
				  <ul class="dropdown-menu">					
					<li><a href="#">עיברית</a></li>					
				  </ul>
				</li>	-->
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
							echo '<option value="'.$arr_regions[$idx]['region_en'].'">'.$arr_regions[$idx]['region_en'].'</option>';
						}
						?>		
						<option value="-3">--------------------</option>
						<?					
						for ($idx=0; $idx<sizeof($arr_cities); $idx++)
						{
							echo '<option value="'.$arr_cities[$idx]['id'].'">'.$arr_cities[$idx]['name_en'].'</option>';
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
 
	<div class="row">
	
		<!-- central bar -->
		<div class="col-md-12">
					
		  <ul class="nav nav-tabs" id="myTab">
			<li id="m1"><a data-toggle="tab" href="#profile" onclick="getMyProfileAjax();">Profile</a></li>
			<li id="m2"><a data-toggle="tab" href="#resume" onclick="getResumesAjax();">Resume <span class="badge" id='num_resumes'></span></a></li>			
			<li id="m3"><a data-toggle="tab" href="#smart_agent" onclick="getSmartAgentsAjax();" >My Smart Agent <span id="num_smart_agents" class="badge"></span></a></li>
			<li id="m4"><a data-toggle="tab" href="#rec_positions" onclick="getRecommendedPositionsAjax(1);" >Recommended Positions <span id="num_recommended_positions" class="badge"></span></a></li>			
			<li id="m5"><a data-toggle="tab" href="#app_positions" onclick="getAppliedPositionsAjax(1);" >Applied Positions <span id="num_applied_positions" class="badge"></span></a></li>
			<li id="m6"><a data-toggle="tab" href="#recent_activities" onclick="getRecentActivitiesAjax(1);" >My Recent Activities <span id="num_recent_activities_rec_no" class="badge"></span></a></li>
			<!--<li><a data-toggle="tab" href="#tsttst" onclick="testAjax();">Test</a></li>-->
		  </ul>
						
		  <div class="tab-content" >
		  		  
			<div id="profile" class="tab-pane fade">
			  <div class="container"  style="font-size:14px;" id='divMyProfile' name='divMyProfile'>
			  </div>
			</div>
			
			<div id="resume" class="tab-pane fade">
			  <div class="container"  style="font-size:14px;" id='divResumes' name='divResumes'>
			  </div> 			  
			</div>
			  						
			<div id="app_positions" class="tab-pane fade">
				<div class="container"  style="font-size:14px;" id='divAppliedPositions' name='divAppliedPositions'>
				</div>
			</div>
						
			<div id="smart_agent" class="tab-pane fade">
			  <div class="container"  style="font-size:14px; overflow-x:auto;" id='divSmartAgents' name='divSmartAgents'>
			  </div>			  			  
			</div>	
			
			<div id="rec_positions" class="tab-pane fade">
				<div class="container" style="font-size:14px;"  id='divRecommendedPositions' name='divRecommendedPositions'>
				</div>
			</div>			
			 
			<div id="recent_activities" class="tab-pane fade">
				<div class="container" style="font-size:14px;" id='divRecentActivities' name='divRecentActivities'>
				</div>
			</div>
			
		  </div> <!-- tab-content -->
 				
		</div> <!-- col md 12 -->					
	
	</div>	<!-- row -->
	
 </div> <!-- container -->
  
 <div class="clearfix" style="margin-bottom:20px;"></div> 
 
<!-- Pre footer -->

	<div id="footer">
		<div class="container" style="font-size:15px;">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<h4>Pages</h4>

					<ul>
						<li><a href="index.php">Home</a>
						</li>												
						<li><a href="positions.php">Positions</a>
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
	
	<script>
			
	$(document).ready(function(){
		$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
			localStorage.setItem('activeTab', $(e.target).attr('href'));
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
		  <div class="modal-header" style="font-size:14px;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Activity Details</h4>
		  </div>
		  <div class="modal-body" name='rcntActivityTxt' id='rcntActivityTxt' style="font-size:14px;">				
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="userDetails">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">User Details</h4>
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
							  
							  <input type="hidden" id="elm_name" name="elm_name" value="">
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
			<h4 class="modal-title">User Details</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			The change has been applied successfully!
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="addResume">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Upload Your Resume</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="frm_userResume" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body" id="userResumeBody" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">
						<div id="inp_resume_description" class="form-group">							
							<label for="resume_description" id="resume_description_lbl">Description</label>
							  <input class="form-control" onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
							  id="resume_description" name="resume_description" placeholder="Your Resume Description..." value="" />							  							  
						</div>							
					</td> 
				</tr>
				<tr>
					<td style="padding:7px;">							
						<div id="inp_resume" class="form-group" >
							<label for="resume">Resume File (.doc | .pdf | .docx)</label><br/>
							<label class="btn btn-default" id="resume_btn_upl_resume"  >
								<input id="my-file-selector" name="my-file-selector" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());" >
								<span id="upload-file-info">Choose...</span>
							</label> 							
						</div>		
						<div id="progressbar_upl" class="form-group"></div>
					</td>
				</tr>			
				</table>
		  </div>		  
		  <div class="modal-footer">
			<div id="mdl_msg" name="mdl_msg" class="pull-left" style="color:red; display:none;"></div>			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="submit" id="resume_upload" class="btn btn-primary" onclick="upload_your_resume(); return false;">Upload</button>
		  </div>
		  </form>
		</div> 
	  </div> 
	</div> 	
	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="editResume">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Edit Your Resume</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="frm_editResume" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body" id="userEditResumeBody" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">
						<div id="inp_edit_resume_description" class="form-group">							
							<label for="edit_resume_description" id="edit_resume_description_lbl">Description</label>
							  <input class="form-control" onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
							  id="edit_resume_description" name="edit_resume_description" placeholder="Your Resume Description..." value="" />							  							  
						</div>							
					</td> 
				</tr>
				<tr>
					<td style="padding:7px;">								 
						<div id="inp_edit_resume" class="form-group" >
							<label for="resume">Resume File (.doc | .pdf | .docx)</label><br/>
							<label class="btn btn-default" id="resume_edit_btn_upl_resume"  >
								<input id="my-file-edit-selector" name="my-file-edit-selector" type="file" style="display:none;" onchange="$('#upload-file-edit-info').html($(this).val());" >
								<span id="upload-file-edit-info">Choose...</span>
							</label>						
						</div>
						<div id="progressbar_upl2" class="form-group"></div>
					</td>
				</tr>
				</table>
				<input type="hidden" name="rec_e_id" id="rec_e_id" value="">
				<input type="hidden" name="res_e_desc" id="res_e_desc" value="">
				<input type="hidden" name="res_e_filename" id="res_e_filename" value="">				
		  </div>		  
		  <div class="modal-footer">
			<div id="mdl_edit_msg" name="mdl_edit_msg" class="pull-left" style="color:red; display:none;"></div>			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="submit" id="resume_edit" class="btn btn-primary" onclick="edit_your_resume(); return false;">Upload</button>
		  </div>
		  </form>
		</div> 
	  </div> 
	</div> 	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="deleteThisResume">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Delete This Resume</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="frm_deleteResume" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body" id="userDeleteResumeBody" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">Are you sure?</td>
				</tr>
				</table>
				<input type="hidden" name="rec_id" id="rec_id" value="">
				<input type="hidden" name="res_desc" id="res_desc" value="">
				<input type="hidden" name="res_filename" id="res_filename" value="">
		  </div>		  
		  <div class="modal-footer">
			<div id="mdl_delete_msg" name="mdl_delete_msg" class="pull-left" style="color:red; display:none;"></div>			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="submit" id="resume_delete" class="btn btn-primary" onclick="delete_your_resume(); return false;">Delete</button>
		  </div>
		  </form>
		</div> 
	  </div> 
	</div> 	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="modalAreYouSurePositionNotInterested">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Not Interesting in Position</h4>
		  </div>		  
		  <div class="modal-body" id="YouSurePositionNotInterested" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">Are you sure?</td>
				</tr>
				</table>
		  </div>		  
		  <div class="modal-footer">			
			<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
			<button type="submit" id="not_interesting_position_btn" class="btn btn-primary">Yes</button>
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
				<input type="hidden" name="apply_for_this_position_user_pos_id" id="apply_for_this_position_user_pos_id" value="">
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
			<button type="button" class="btn btn-default" data-dismiss="modal" onClick="applyForPositionOkAfter();" >Ok</button>			
		  </div>		  
		</div> 
	  </div> 
	</div> 	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="addNewSmartAgent">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Add A New Smart Agent</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			<form role="form" data-toggle="validator" name="frm_addNewSmartAgent" enctype="multipart/form-data" method="post" autocomplete="off">
				<table border='0' style="margin-left:auto; margin-right:auto">	
				<tr>
					<td colspan="2" style="padding:3px;">
						Search For Positions That:  
					</td>
				</tr>				
				<tr>
					<td style="padding:3px;">
						Created Recent:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="sma_days_select" name="sma_days_select">									
							<option value="1">1 day</option>
							<option value="7">7 days</option>
							<option value="14" selected>14 days</option>
							<option value="30">30 days</option>
							<option value="60">60 days</option>
							<option value="90">90 days</option>
					   </select>
					</td>					
				</tr>
				<tr>
					<td style="padding:3px;">
						Region and City:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="sma_region_n_city_select" name="sma_region_n_city_select">									
							<option value="-1">All</option>	
							<option value="-2">--------------------</option>
							<?
							for ($idx=0; $idx< sizeof($arr_regions); $idx++)
							{
							?>
								<option value="<? echo $arr_regions[$idx]['region_en']; ?>"><? echo $arr_regions[$idx]['region_en']; ?></option>
							<?
							}
							?>		
							<option value="-3">--------------------</option>
							<?
							for ($idx=0; $idx< sizeof($arr_cities); $idx++)
							{
							?>
								<option value="<? echo $arr_cities[$idx]['name_en']; ?>"><? echo $arr_cities[$idx]['name_en']; ?></option>
							<?
							}
							?>
					   </select>
					</td>					
				</tr>	
				<tr>
					<td style="padding:3px;">
						Category:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="sma_categories_select" name="sma_categories_select" onChange="populateSubCat();">
						<option value="-1">All</option>
						<?
						for($idx=0; $idx<sizeof($arr_categories); $idx++)
						{
						?>
							<option value="<? echo $arr_categories[$idx]['id']; ?>"><? echo $arr_categories[$idx]['cat_name']; ?></option>
						<?
						}
						?>
					   </select>
					</td>					
				</tr>
				<tr>
					<td style="padding:3px;">
						Sub-Category:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="sma_sub_categories_select" name="sma_sub_categories_select">	
						<option value="-1">All</option>							
					   </select>
					</td>					
				</tr>				
				<tr>
					<td style="padding:3px;">
						Contains Text:
					</td>
					<td style="padding:3px;">																			
						<input class="form-control" id="sma_contains_txt" name="sma_contains_txt" placeholder="Text To Search..." value="" />
					</td>					
				</tr>				

				</table>			
			</form>
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="addNewSmartAgentOk();" >Ok</button>
		  </div>						
		</div> 
	  </div> 
	</div>	
	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="editSmartAgent">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Edit Smart Agent</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;" id="editSmartAgent_modalbody" name="editSmartAgent_modalbody">				
			<form role="form" data-toggle="validator" name="frm_editSmartAgent" enctype="multipart/form-data" method="post" autocomplete="off">
				<table border='0' style="margin-left:auto; margin-right:auto; display:none;" id="editSmartAgentTable" name="editSmartAgentTable" >	
				<tr>
					<td colspan="2" style="padding:3px;">
						Search For Positions That:  
					</td>
				</tr>				
				<tr>
					<td style="padding:3px;">
						Created Recent:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="sma_edit_days_select" name="sma_edit_days_select">									
							<option value="1">1 day</option>
							<option value="7">7 days</option>
							<option value="14" selected>14 days</option>
							<option value="30">30 days</option>
							<option value="60">60 days</option>
							<option value="90">90 days</option>
					   </select>
					</td>					
				</tr>
				<tr>
					<td style="padding:3px;">
						Region and City:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="sma_edit_region_n_city_select" name="sma_edit_region_n_city_select">									
							<option value="-1">All</option>	
							<option value="-2">--------------------</option>
							<?
							for ($idx=0; $idx< sizeof($arr_regions); $idx++)
							{
							?>
								<option value="<? echo $arr_regions[$idx]['region_en']; ?>"><? echo $arr_regions[$idx]['region_en']; ?></option>
							<?
							}
							?>		
							<option value="-3">--------------------</option>
							<?
							for ($idx=0; $idx< sizeof($arr_cities); $idx++)
							{
							?>
								<option value="<? echo $arr_cities[$idx]['name_en']; ?>"><? echo $arr_cities[$idx]['name_en']; ?></option>
							<?
							}
							?>
					   </select>
					</td>					
				</tr>	
				<tr>
					<td style="padding:3px;">
						Category:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="sma_edit_categories_select" name="sma_edit_categories_select" onChange="populateSubCatEdit();">
						<option value="-1">All</option>
						<?
						for($idx=0; $idx<sizeof($arr_categories); $idx++)
						{
						?>
							<option value="<? echo $arr_categories[$idx]['id']; ?>"><? echo $arr_categories[$idx]['cat_name']; ?></option>
						<?
						}
						?>
					   </select>
					</td>					
				</tr>
				<tr>
					<td style="padding:3px;">
						Sub-Category:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="sma_edit_sub_categories_select" name="sma_edit_sub_categories_select">	
						<option value="-1">All</option>							
					   </select>
					</td>					
				</tr>				
				<tr>
					<td style="padding:3px;">
						Contains Text:
					</td>
					<td style="padding:3px;">																			
						<input class="form-control" id="sma_edit_contains_txt" name="sma_edit_contains_txt" placeholder="Text To Search..." value="" />
					</td>					
				</tr>
				</table>
				<input type="hidden" id="smagent_id" name="smagent_id" value="">
			</form>
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="editSmartAgentOk();" >Ok</button>
		  </div>						
		</div> 
	  </div> 
	</div>		
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="deleteThisSmartAgent">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Delete This Smart Agent</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="frm_deleteThisSmartAgent" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body" id="DeleteSmartAgentBody" style="font-size:14px;">
				<table style="margin-left:auto; margin-right:auto">				
				<tr>
					<td style="padding:7px;">Are you sure?</td>
				</tr>
				</table>
				<input type="hidden" name="sma_id" id="sma_id" value="">
		  </div>		  
		  <div class="modal-footer">			
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="submit" id="resume_this_sma" class="btn btn-primary" onclick="delete_this_smart_agent(); return false;">Delete</button>
		  </div>
		  </form>
		</div> 
	  </div> 
	</div> 		
	
	
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
		  </form>
		</div> 
	  </div> 
	</div>	
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="mod_changeUserDetailsCatSubcat">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">User Details</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			<form role="form" data-toggle="validator" name="frm_changeUserDetailsCatSubcat" enctype="multipart/form-data" method="post" autocomplete="off">
				<table border='0' style="margin-left:auto; margin-right:auto">				
				<tr id="cat_block_cud">
					<td style="padding:3px;" id="mod_changeUserDetailsCatSubcat_head">
						Category #:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="cud_categories_select" name="cud_categories_select" onChange="cud_populateSubCat();">
						<option value="-1">All</option>
						<?
						for($idx=0; $idx<sizeof($arr_categories); $idx++)
						{
						?>
							<option value="<? echo $arr_categories[$idx]['id']; ?>"><? echo $arr_categories[$idx]['cat_name']; ?></option>
						<?
						}
						?>
					   </select>
					</td>					
				</tr>
				<tr id="sub_cat_block_cud">
					<td style="padding:3px;" id="mod_changeUserDetailsCatSubcat_head2">
						Sub-Category:
					</td>
					<td style="padding:3px;">						
						<select class="form-control" id="cud_sub_categories_select" name="cud_sub_categories_select">	
						<option value="-1">All</option>							
					   </select>
					</td>					
				</tr>
				<tr>
					<td style="padding:3px;" id="mod_changeUserDetailsCatSubcat_head3"></td>
					<td style="padding:3px;">						
						<label><input type="checkbox" id="cud_unset" name="cud_unset" class="form-control" value="Yes" onchange="cud_set_unset();">Unset</label>
					</td>					
				</tr>				
				</table>
				<input type="hidden" name="mod_changeUserDetailsCatSubcat_n" id="mod_changeUserDetailsCatSubcat_n">
			</form>
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="changeUserDetailsCatSubcatOk();" >Ok</button>
		  </div>						
		</div> 
	  </div> 
	</div>		
	
	<div class="modal fade" tabindex="-1" role="dialog" id="inviteFriendEarnPointsModal">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Invite Your Friend And Earn More Points!</h4>
		  </div>
		  <div class="modal-body" style="font-size:14px;">				
			<form role="form" data-toggle="validator" name="frm_inviteFriendEarnPointsModal" enctype="multipart/form-data" method="post" autocomplete="off">				
				<div id="inp_invfr_friend_fn" class="form-group">
					<label for="invfr_friend_fn">Your Friend Firstname</label>
					  <input class="form-control" onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
					  id="invfr_friend_fn" name="invfr_friend_fn" placeholder="Enter Your Friend Firstname" value="" />
				</div>	
				<div id="inp_invfr_friend_ln" class="form-group">
					<label for="invfr_friend_ln">Your Friend Lastname</label>
					  <input class="form-control" onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
					  id="invfr_friend_ln" name="invfr_friend_ln" placeholder="Enter Your Friend Lastname" value="" />
				</div>				
				<div id="inp_invfr_friend_email" class="form-group">			
					<label for="invfr_friend_email">Invite Friend By Email</label>
					  <input class="form-control" onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
					  id="invfr_friend_email" name="invfr_friend_email" placeholder="Enter Your Friend Email" value="" />
				</div>
			</form>
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" onClick="inviteFriendEarnPointsModalOk();" >Invite</button>
		  </div>						
		</div> 
	  </div> 
	</div>		
	
	
</body>
</html>

