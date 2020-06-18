<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php

	// some reCaptcha :)
	$a = rand(3, 17);
	$b = rand(9, 23);

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
	
	$small_footer = getFooter($conn);		
	$arr_cities = getCities($conn);
	$companies_items_background = getCompaniesItemsBackgroundColor($conn);
	$num_posts_per_page  = getItemsOnPage($conn, 'COMPANIES'); // num posts per page
	
	// item id
	//
	if (!$_GET["c"]) 
	{
		$c = -1;
	}
	else
	{				
		$c = intval($_GET['c']);
				
		if (is_numeric($c))
		{				
			if (round($c, 0) == $c)
			{
				// Ok
				// increase number of views for this product in the db
				
				$sqlu = "update company set nviews=nviews+1 where id = ".$c;

				if ($conn->query($sqlu) === TRUE) {
					// Ok
				} else {
					// Not Ok
				}				
				
				//
			}
			else
			{
				$c = -1;
			}
		}
		else
		{				
			$c = -1;
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

	// city of company
	//
	if (!$_GET["ci"]) 
	{
		$ci = -1;
	}
	else
	{				
		$ci = $_GET['ci'];
		$ci = str_replace("\'", "", $ci);
		$ci = str_replace("\"", "", $ci);
		$ci = str_replace("&", "", $ci);
		$ci = str_replace("!", "", $ci);
		$ci = str_replace(":", "", $ci);
		$ci = str_replace("\\", "", $ci);				
	}	
	
	// search
	//
	if (!$_GET["se"]) 
	{
		$se = "";
	}
	else
	{				
		$se = $_GET['se'];
		
		$se = str_replace("\'", "", $se);
		$se = str_replace("'", "", $se);
		$se = str_replace("\"", "", $se);
		$se = str_replace("&", "", $se);
		$se = str_replace("!", "", $se);
		$se = str_replace(":", "", $se);
		$se = str_replace("\\", "", $se);		
		$se = str_replace("%", "", $se);	
		$se = str_replace(";", "", $se);
						
		if (strlen($se) > 30)
		{							 			
			$se = substr($se, 0, 30);
		}
		else
		{				
			// Ok
		}
	}		
	
	$start_position = ($p - 1) * $num_posts_per_page;
	$num_recs_to_retrieve = $num_posts_per_page;	

	$sql_positions_total = "select 	count(1) total_cnt
					     from company co, city ci 
						where co.placement_id = ci.id
						and co.status = 1						
						and ((co.id = ".$c.") or (".$c."= -1))						
						and ((ci.id = '".$ci."') or ('".$ci."' = -1) or ('".$ci."' = ci.region_en) )
						and ((upper(co.the_name) like upper('%".$se."%')) or (upper(co.the_descrip) like upper('%".$se."%')) or (upper(co.address) like upper('%".$se."%')))";
	
	
	$arr_positions_total = array();
	$results_positions_total = mysqli_query($conn, $sql_positions_total); 

	while($line = mysqli_fetch_assoc($results_positions_total)){
		$arr_positions_total[] = $line;
	}		
	
	$recs_total_cnt = $arr_positions_total[0]['total_cnt'];
	
	$num_of_pages = ceil($recs_total_cnt / $num_posts_per_page);	
	
	$sql_companies = "select co.id, 
							DATE_FORMAT(co.modifydt,'%d/%m/%Y') moddt, 
							co.the_name,
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
						and co.status = 1						
						and ((co.id = ".$c.") or (".$c."= -1))
						and ((ci.id = '".$ci."') or ('".$ci."' = -1) or ('".$ci."' = ci.region_en) )
						and ((upper(co.the_name) like upper('%".$se."%')) or (upper(co.the_descrip) like upper('%".$se."%')) or (upper(co.address) like upper('%".$se."%')))
						order by co.the_name limit ".$start_position.",".$num_recs_to_retrieve;	
		
	$arr_companies = array();		
	$results_companies = mysqli_query($conn, $sql_companies); 

    if ($results_companies->num_rows == 0)
	{
	
		//$p = 1;
		
		if ($p > 1) 
		{
			$p = $p - 1;
		}
		
		$start_position = ($p - 1) * $num_posts_per_page;
		$num_recs_to_retrieve = $num_posts_per_page;

		$sql_companies = "select co.id, 
								DATE_FORMAT(co.modifydt,'%d/%m/%Y') moddt, 
								co.the_name,
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
							and co.status = 1						
							and ((co.id = ".$c.") or (".$c."= -1))
							and ((ci.id = '".$ci."') or ('".$ci."' = -1) or ('".$ci."' = ci.region_en) )
							and ((upper(co.the_name) like upper('%".$se."%')) or (upper(co.the_descrip) like upper('%".$se."%')) or (upper(co.address) like upper('%".$se."%')))
							order by co.the_name limit ".$start_position.",".$num_recs_to_retrieve;			

		$arr_companies = array();		
		$results_companies = mysqli_query($conn, $sql_companies); 							
							
	}
	
	while($line = mysqli_fetch_assoc($results_companies)){
		$arr_companies[] = $line;
	}		
	
	$arr_all_the_companies = getAllTheActiveCompanies($conn);	
	$arr_trending_jobs = getTrandingJobs($conn, 12);		
	$arr_regions = getRegionsEnglish($conn);		
		
	$conn->close();	
?>	
 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <?
  if ($c == -1)
  {  
  ?>
  <meta name="description" content="Jobs972 - Israeli Companies">
  <meta name="keywords" content="Jobs972, catalog, Israeli, companies, business, cooperation, Israel, opportunities, employment">
  <title>Jobs972 - Israeli Companies</title>
  <?
  }
  else
  {
  ?>
  
  <meta name="description" content="Jobs972: <? echo $arr_companies[0]['the_name']; ?>">
  <meta name="keywords" content="<? echo $arr_companies[0]['the_name']; ?>, <? if ($arr_companies[0]['locatio'] != '--') { echo $arr_companies[0]['locatio'].", "; } ?> <? if ($arr_companies[0]['address']!='') { echo $arr_companies[0]['address'].", "; } ?> positions, company, employment, open, work, job, Israel">
  <title>Jobs972: <? echo $arr_companies[0]['the_name']; ?></title>  
  
  <?
  }
  ?>
  
  <link rel="stylesheet" href="assets/css/bootstrap.min.css"> 
  <link href="assets/css/font-awesome.css" rel="stylesheet">	
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300" rel='stylesheet' type='text/css'>
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
	
function doSubscribeByEmail()
{
	var nErrors =0;
										
	// check email
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

	// captcha
	if (document.getElementById("captcha_subsc").value==null || document.getElementById("captcha_subsc").value=="")
	{		
		document.getElementById("captcha_subsc").style.borderColor = "red";
		document.getElementById("captcha_subsc").style.boxShadow = "3px 3px 3px lightgray";
		nErrors++;
	}	
	else if (document.getElementById("captcha_subsc").value!=<?php echo $a+$b; ?>)
	{
		document.getElementById("captcha_subsc").style.borderColor = "red";
		document.getElementById("captcha_subsc").style.boxShadow = "3px 3px 3px lightgray";
		nErrors++;			
	}
	else
	{
		document.getElementById("captcha_subsc").style.borderColor = "green";
		document.getElementById("captcha_subsc").style.boxShadow = "2px 2px 2px lightgray";
	}			
						
	if (nErrors==0)
	{					
		var url = "subscribe_email.php";
					
		var oData = new FormData(document.forms.namedItem("frmSubscribeByEmail"));
		
		var oReq = new XMLHttpRequest();
		  oReq.open("POST", url, true);
		  oReq.onload = function(oEvent) {
								
			if (oReq.status == 200) 
			{			
				// alert('>>'+oReq.responseText);					
				$('#SubscribeEmail').modal('hide');
				$('#SubscribeEmailOk').modal('show');
				document.getElementById("subscr_email").value="";
				document.getElementById("subsc_email_onform").value="";
				document.getElementById("subsc_fname").value="";
				document.getElementById("subsc_lname").value="";
				document.getElementById("subsc_phone").value="";
				document.getElementById("subsc_city").value="";
				document.getElementById("captcha_subsc").value="";
				document.getElementById("captcha_subsc").style.borderColor = "lightgray";
				document.getElementById("captcha_subsc").style.boxShadow = "none";
				document.getElementById("subscr_email").style.borderColor = "lightgray";
				document.getElementById("subscr_email").style.boxShadow = "none";				
				document.getElementById('subsc_allow').checked = false;
				$('#subscribe_button').addClass('disabled');
				$('#subscribe_button').prop('disabled', true);				
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
	strSearch = strSearch.replace("%", "");
	
	location.href = "https://jobs972.com/companies.php?p=<? echo $p; ?>&ci="+strCity+"&se="+strSearch;
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
	strSearch = strSearch.replace("%", "");
	
	location.href = "https://jobs972.com/companies.php?p=<? echo $p; ?>&ci="+strCity+"&se="+strSearch;
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
				  alert("Error " + oReq.status + " occurred uploading your file.<br \/>");
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
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span></a></li>
				<li><a href="positions.php">Positions</a></li>
				<li><a href="categories.php">Categories</a></li>
				<li><a href="aboutus.php">About Us</a></li>
				<li class="active"><a href="companies.php">Companies</a></li>
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
					<input type="text" class="form-control" id="inpJob" name="inpJob" placeholder="Company, description..." value="<? echo $se; ?>">
				</td>
				<td style='width:200px;'>					
					<select class="form-control" id="inpCity" name="inpCity">
						<option value="-1">All Regions | All Cities</option>	
						<option value="-2">--------------------</option>
						<?
						for ($idx=0; $idx< sizeof($arr_regions); $idx++)
						{
							if ($arr_regions[$idx]['region_en'] == $ci)
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
							if ($arr_cities[$idx]['id'] == $ci)
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
				<td><a class="btn btn-default" style="background: none; color: #ffffff; padding: 6px 12px;" onclick="FindJobsFilter()">Find Company</a></td>
			</tr>
		</table>
	</div>
 
 </div>
 
 <!-- jtron end -->
 
 <div class="container" style="font-size:15px;">
 
	<div class="row">
	
		<!-- central bar -->
		<div class="col-md-9">
		
			<?php
			
				for($idx=0; $idx<sizeof($arr_companies); $idx++)
				{
			
			?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="pull-left">
						<a href='companies.php?c=<?php echo $arr_companies[$idx]['id']; ?>'><b><?php echo $arr_companies[$idx]['the_name']; ?></b></a>
					</div>
					<div class="pull-right">
						<a href="https://www.jobs972.com/index.php?p=1&c=-1&co=<?php echo $arr_companies[$idx]['id']; ?>"><i>get all <?php echo $arr_companies[$idx]['the_name']; ?> positions</i></a>
					</div>
					<div class="clearfix"></div>
				</div>								
				<div class="panel-body" style="font-size:14px; background:<? echo $companies_items_background; ?>;">  
					 <table style="border-spacing: 10px; border-collapse: separate;">
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Company:</b>
							</td>
							<td>
								<?php echo $arr_companies[$idx]['the_name']; ?>
							</td>
						</tr>
						<?php
						if ($arr_companies[$idx]['locatio'] != '--')
						{
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Location:</b>
							</td>
							<td>
								<?php echo $arr_companies[$idx]['locatio']; ?>
							</td>
						</tr>						
						<?php
						}
						
						if ($arr_companies[$idx]['the_descrip'] == '')
						{
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Description:</b>
							</td>
							<td dir="rtl">
								<?php echo nl2br($arr_companies[$idx]['the_descrip_heb']); ?>
							</td>
						</tr>						
						<?php
						}
						else
						{
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Description:</b>
							</td>
							<td>
								<?php echo nl2br($arr_companies[$idx]['the_descrip']); ?>
							</td>
						</tr>
						<?php
						}
						
						if (($arr_companies[$idx]['industry'] != '') && ($arr_companies[$idx]['industry'] != '0'))
						{
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Industry:</b>
							</td>
							<td>
								<?php echo $arr_companies[$idx]['industry']; ?>
							</td>
						</tr>
						<?php
						}
						
						if (($arr_companies[$idx]['c_type'] != '') && ($arr_companies[$idx]['c_type'] != '0'))
						{
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Type:</b>
							</td>
							<td>
								<?php echo $arr_companies[$idx]['c_type']; ?>
							</td>
						</tr>
						<?php
						}


						if (($arr_companies[$idx]['founded'] != '') && ($arr_companies[$idx]['founded'] != '0'))
						{
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Founded:</b>
							</td>
							<td>
								<?php echo $arr_companies[$idx]['founded']; ?>
							</td>
						</tr>
						<?php
						}						
						
						
						if (($arr_companies[$idx]['num_people'] != '') && ($arr_companies[$idx]['num_people'] != '0'))
						{
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Company Size:</b>
							</td>
							<td>
								<?php echo $arr_companies[$idx]['num_people']; ?>
							</td>
						</tr>
						<?php
						}						
						
						
						if ($arr_companies[$idx]['website'] != '')
						{
						?>						
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Website:</b>
							</td>
							<td>
								<a href='<?php echo $arr_companies[$idx]['website']; ?>' target='_blank'><?php echo $arr_companies[$idx]['website']; ?></a>
							</td>
						</tr>
						<?php
						}
						
						if ($arr_companies[$idx]['address'] != '')
						{
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Address:</b>
							</td>
							<td>
								<?php echo $arr_companies[$idx]['address']; ?>
							</td>
						</tr>					
						<?php
						}							
						elseif ($arr_companies[$idx]['address_heb'] != '')
						{
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Address:</b>
							</td>
							<td dir='rtl'>
								<?php echo $arr_companies[$idx]['address_heb']; ?>
							</td>
						</tr>
						<?php
						}
						
						if ($arr_companies[$idx]['phone_1'] != '')
						{						
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Phone:</b>
							</td>
							<td>
								<?php echo $arr_companies[$idx]['phone_1']; ?>
							</td>
						</tr>
						<?php
						}						
						
						if ($arr_companies[$idx]['fax_1'] != '')
						{						
						?>
						<tr>
							<td style="width:20px; text-align:right;">
								<b>Fax:</b>
							</td>
							<td>
								<?php echo $arr_companies[$idx]['fax_1']; ?>
							</td>
						</tr>
						<?php
						}
						?>
					 </table>					
				</div>
			</div>
 
			<?php
			 }
			?>
			 
			 
			<?php
				
				if ($c == -1)
				{
				
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
					  <a class="page-link" href="companies.php?p=1&ci=<? echo $ci; ?>&se=<? echo $se; ?>" aria-label="Previous">
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
								<li class="page-item active"><a class="page-link" href="companies.php?p=<? echo $idz; ?>&ci=<? echo $ci; ?>&se=<? echo $se; ?>"><? echo $idz; ?></a></li>
					<?	
							}
							else
							{
					?>
								<li class="page-item"><a class="page-link" href="companies.php?p=<? echo $idz; ?>&ci=<? echo $ci; ?>&se=<? echo $se; ?>"><? echo $idz; ?></a></li>
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
					  <a class="page-link" href="companies.php?p=<? echo $num_of_pages; ?>&ci=<? echo $ci; ?>&se=<? echo $se; ?>" aria-label="Next">
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
			?>
				
		</div>	
	
		<!-- right bar -->
		<div class="col-md-3">
		
			<div class="panel panel-default">
				<div class="panel-heading text-left">Get Positions By Company</div>
				<div class="panel-body" style="font-size:14px;">
				<? 
				for ($idx=0; $idx<sizeof($arr_all_the_companies); $idx++)
				{	
					echo ' <span> ';
					echo '<a href="index.php?p=1&c=-1&co='.$arr_all_the_companies[$idx]['id'].'"><b>'.substr($arr_all_the_companies[$idx]['the_name_b'],0,1).'</b>'.substr($arr_all_the_companies[$idx]['the_name_b'],1,100).'</a>&nbsp;&nbsp;&nbsp;';
					echo ' </span> ';					
				}
				?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading text-left">Get Positions By City</div>
				<div class="panel-body" style="font-size:14px;">
				<? 
				for ($idx=0; $idx<sizeof($arr_cities); $idx++)
				{	
					echo ' <span> ';
					echo '<a href="index.php?p=1&c='.$arr_cities[$idx]['id'].'&s="><b>'.substr($arr_cities[$idx]['name_en'],0,1).'</b>'.substr($arr_cities[$idx]['name_en'], 1, 100).'</a>&nbsp;&nbsp;&nbsp;';
					echo ' </span> ';					
				}
				?>
				</div>
			</div>			

			<div class="panel panel-default">
				<div class="panel-body" style='text-align:center'>		
					<div class="fb-page" data-href="https://www.facebook.com/jobs972com/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/jobs972com/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/jobs972com/">Find Job in Israel</a></blockquote></div>		
				</div>
			</div>	
		
			<div class="panel panel-default">
				<div class="panel-body" style='text-align:center'>
					<a class="twitter-timeline" href="https://twitter.com/jobs972com">Tweets by jobs972com</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
				</div>
			</div>		

		</div>	
	
	</div>
 
 </div>

  
 <div class="clearfix" style="margin-bottom:20px;"></div> 
 
<!-- Pre footer -->

	<div id="footer" style="font-size:smaller;">
		<div class="container">
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
		  <form role="form" data-toggle="validator" name="LoginForm" enctype="multipart/form-data" method="post">
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
			<div class="pull-right">
				<div>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" onclick="logInTheUser(); return false;" class="btn btn-primary">Login</button>
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
		  <form role="form" data-toggle="validator" name="signUpForm" enctype="multipart/form-data" method="post">
		  <div class="modal-body" style="font-size:14px;">
				Congratulations! You've registered successfully! You can login now.
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
	
	<!-- no such user modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="logInError">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Log Up</h4>
		  </div>
		  <form role="form" data-toggle="validator" name="signUpForm" enctype="multipart/form-data" method="post">
		  <div class="modal-body" style="font-size:14px;">
				We're unable to find this user.<br/>Please check your Login and Password details.
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>			
		  </div>
		  </form>
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
	
</body>
</html>

