<?php session_start(); 

if (!$_SESSION['verify_email'])
{
	header("Location: index.php");
	exit;
}
else
{
	unset($_SESSION['verify_email']);	
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
	
	$conn->close();	

?> 
 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <meta name="description" content="Jobs972 - Find Job in Israel | חיפוש עבודה | Israeli Companies | משרות הייטק | High Paying Jobs in Israel | לוח דרושים איכותי">
  <meta name="keywords" content="Find, Job, Israel, חיפוש, עבודה, Israeli, Companies, משרות, הייטק , High , Paying, Jobs,  Israel, לוח ,דרושים  , איכותי ">
  <title>Jobs972 - About Us</title>
  
 
  <link rel="stylesheet" href="assets/css/bootstrap.min.css"> 
  <link href="assets/css/font-awesome.css" rel="stylesheet">	
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300" rel='stylesheet' type='text/css'>
	
<script>
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
</script>	
	
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

</style>

<script>
	
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

function doLogin()
{
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
				<li><a href="companies.php">Companies</a></li>
				<li><a href="contactus.php">Contact Us</a></li>				
			</ul>
			
			<div class="hidden-sm">
			<ul class="nav navbar-nav navbar-right">							 
					<li><a href="#" onClick="doSignUp()"><span class="glyphicon glyphicon-user"></span> Sign Up</a></a></li>
					<li><a href="#" onClick="doLogin()"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>		

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
						<option value="-1">All the Cities...</option>
						<?php						
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
 
 
 <div class="container" style="font-size:smaller;">
 
	<div class="row">
	
		<!-- central bar -->
		<div class="col-md-9">
		
		<p>Congratulations! <br/>Your email is verified now! And now we're ready to find the best job for you! <br/>Please <a href="#" onClick="doLogin()"><b>Login</b></a> with your email and password.</p>
		
		</div>	
	
	
		<!-- right bar -->
		<div class="col-md-3">
		
			<div class="panel panel-default">
				<div class="panel-body" style='text-align:center'>
					<img src="images/icon3.png">
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

	<div id="footer">
		<div class="container">
			<div class="row" style="font-size:smaller;">
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
						<li><a href="#">Software Engineer</a>
						</li>
						<li><a href="#">IT Manager</a>
						</li>
						<li><a href="#">DevOps Engineer</a>
						</li>
						<li><a href="#">QA</a>
						</li>						
						<li><a href="#">iOS developer</a>
						</li>						
						<li><a href="#">Full stack developer</a>
						</li>						
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
	<div class="container" style="font-size:smaller;">
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
		  <form role="form" data-toggle="validator" name="signUpForm" enctype="multipart/form-data" method="post" autocomplete="off">
		  <div class="modal-body">
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
		  <div class="modal-body">
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
		  <div class="modal-body">
				Congratulations! You've registered successfully! Please check your email to verify account.
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
		  <div class="modal-body">
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
		  <div class="modal-body">
				We're unable to find this user.<br/>Please check your Login and Password details.
		  </div>		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>			
		  </div>
		  </form>
		</div> 
	  </div> 
	</div> 	
	
</body>
</html>

