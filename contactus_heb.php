<!DOCTYPE html>
<html lang="heb" dir='rtl'>
<head>
 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Find Job in Israel | חיפוש עבודה | Israeli Companies | משרות הייטק | High Paying Jobs in Israel | לוח דרושים איכותי">
  <meta name="keywords" content="find, jobs, Israel, חיפוש,  עבודה, Companies, הייטק, משרות, Paying, איכותי, דרושים, לוח ">

  <title>Jobs972.com - חיפוש עבודה, לוח דרושים איכותי, משרות הייטק</title>
  
  <link rel="stylesheet" href="assets/css/bootstrap.min.css"> 
  <link href="assets/css/font-awesome.css" rel="stylesheet">	
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300" rel='stylesheet' type='text/css'>
	
  <?php

	// some reCaptcha :)
	$a = rand(1, 10);
	$b = rand(2, 9);

  ?>  
	
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
			
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}	
		
	function ajax_post()
	{
		var nErrors =0;
				
		if (document.getElementById("firstname").value==null || document.getElementById("firstname").value=="")
		{
		
			document.getElementById("inp_first_name").className = "form-group has-error";
			nErrors++;
		}
		else
		{
			document.getElementById("inp_first_name").className = "form-group";
		}
		
		if (document.getElementById("lastname").value==null || document.getElementById("lastname").value=="")
		{
		
			document.getElementById("inp_last_name").className = "form-group has-error";
			nErrors++;
		}	
		else
		{
			document.getElementById("inp_last_name").className = "form-group";
		}
		
		if (document.getElementById("email").value==null || document.getElementById("email").value=="")
		{
		
			document.getElementById("inp_email").className = "form-group has-error";
			nErrors++;
		}	
		else if (!validateEmail(document.getElementById("email").value))
		{			
			document.getElementById("inp_email").className = "form-group has-error";
			nErrors++;			
		}		
		else 
		{
			document.getElementById("inp_email").className = "form-group";
		}				
		
		if (document.getElementById("subject").value==null || document.getElementById("subject").value=="")
		{
		
			document.getElementById("inp_subject").className = "form-group has-error";
			nErrors++;
		}	
		else
		{
			document.getElementById("inp_subject").className = "form-group";
		}		
		
		if (document.getElementById("message").value==null || document.getElementById("message").value=="")
		{
		
			document.getElementById("inp_message").className = "form-group has-error";
			nErrors++;
		}	
		else
		{
			document.getElementById("inp_message").className = "form-group";
		}

		if (document.getElementById("captcha").value==null || document.getElementById("captcha").value=="")
		{
		
			document.getElementById("inp_captcha").className = "form-group has-error";
			nErrors++;
		}	
		else if (document.getElementById("captcha").value!=<?php echo $a+$b; ?>)
		{
			document.getElementById("inp_captcha").className = "form-group has-error";
			nErrors++;			
		}
		else
		{
			document.getElementById("inp_captcha").className = "form-group";
		}	

		if (nErrors==0)
		{			
			// Create our XMLHttpRequest object
			var hr = new XMLHttpRequest();
			// Create some variables we need to send to our PHP file
			var url = "send_email_contact_us.php";
			var fn = document.getElementById("firstname").value;
			var ln = document.getElementById("lastname").value;
			var em = document.getElementById("email").value;
			var sb = document.getElementById("subject").value;
			var ms = document.getElementById("message").value;
			
			var vars = "fn="+fn+"&ln="+ln+"&em="+em+"&sb="+sb+"&ms="+ms;
			hr.open("POST", url, true);
			// Set content type header information for sending url encoded variables in the request
			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			// Access the onreadystatechange event for the XMLHttpRequest object
			hr.onreadystatechange = function() {
				if(hr.readyState == 4 && hr.status == 200) {
					var return_data = hr.responseText;
												
					///alert('return_data= '+return_data);
					document.getElementById("txtreply").style.display='block';
					document.getElementById("contact_status").style.display='none';
					document.getElementById("txtreply").scrollIntoView(true);
					 
				}
			}
			// Send the data to PHP now... and wait for response to update the status div			
			hr.send(vars); // Actually execute the request						
		}
	}	
		
	function reload_page()
	{		
		location.reload(true);
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
		
		location.href = "https://jobs972.com/index.php?p=1&c="+strCity+"&s="+strSearch;
	}		
	
<!-- end js -->
</script>


</head>
<body>

<?php
	// conn db parameters
	require_once('inc/db_connect.php');
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$conn->query("set names 'utf8'");		
	
	$sql_cities = "select name_he, name_en, id from city where status='1' order by 1";
								
	$arr_cities = array();		
	$results_cities = mysqli_query($conn, $sql_cities); 	
	
	while($line = mysqli_fetch_assoc($results_cities)){
		$arr_cities[] = $line;
	}				
		
	$sql_trending_jobs = "select pos_title, id from positions order by napply desc, nviews desc limit 0, 7";
								
	$arr_trending_jobs = array();		
	$results_trending_jobs = mysqli_query($conn, $sql_trending_jobs); 	
	
	while($line = mysqli_fetch_assoc($results_trending_jobs)){
		$arr_trending_jobs[] = $line;
	}	

	$sql_regions = "select distinct region_heb from city where status='1' and region_heb != '' order by 1";
								
	$arr_regions = array();		
	$results_regions = mysqli_query($conn, $sql_regions); 	
	
	while($line = mysqli_fetch_assoc($results_regions)){
		$arr_regions[] = $line;
	}	
		
	$conn->close();	
		
?>	

 <div class="navbar navbar-static-top" style="margin-bottom:0;" >
	<div class="container" style="font-size:15px;">
		
		<button class ="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
		
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		
		</button>
		
		<div class="collapse navbar-collapse navHeaderCollapse">		
		
			<div class="hidden-sm">
			<ul class="nav navbar-nav navbar-left">			
				<li class="dropdown">
				  <a href="contactus_heb.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">עיברית<span class="caret"></span></a>
				  <ul class="dropdown-menu">					
					<li><a href="contactus.php">English</a></li>					
				  </ul>
				</li>							
				<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> התחבר</a></li>		
				<li><a href="#"><span class="glyphicon glyphicon-user"></span> הרשם</a></a></li>				
			</ul>	
			</div>			
		
			<ul class="nav navbar-nav navbar-right">							
				<li><a href="contactus_heb.php">צור קשר</a></li>
				<li><a href="companies.php">כל החברות</a></li>				
				<li><a href="categories.php">כל הקטגוריות</a></li>
				<li><a href="positions.php">לוח דרושים</a></li>
				<li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span></a></li>
			</ul>
			
		</div> 
		
	</div> 
 </div> <!-- the end of navbar navbar-inverse navbar-static-top -->
 
 
<!-- jtron start -->
  
<div class="jumbotron">
	
	<div class = "container" style="font-size:16px;">
	
		<a href="https://jobs972.com/index.php" style="text-decoration: none;"><h1>חיפוש עבודה - לוח דרושים</h1></a>
		<p>ברוכים הבאים ל <b>Jobs972</b>: המשרות המאתגרות ביותר, החברות הכי האטרקטיביות – בחינם!</p>
		<p style="font-size:80%">Find Job in Israel | חיפוש עבודה | Israeli Companies | משרות הייטק | High Paying Jobs in Israel | לוח דרושים איכותי</p>
		<table style="border-spacing: 5px; border-collapse: separate;">
			<tr>
				<td style='width:200px;'>
					<input type="text" class="form-control" id="inpJob" placeholder="תואר המשרה, מיומנויות או חברה">
				</td>
				<td style='width:200px;'>					
					<select class="form-control" id="inpCity" name="inpCity">
						<option value="-1">כל האזורים | כל הערים</option>	
						<option value="-2">--------------------</option>
						<?
						for ($idx=0; $idx< sizeof($arr_regions); $idx++)
						{
							echo '<option value="'.$arr_regions[$idx]['region_heb'].'">'.$arr_regions[$idx]['region_heb'].'</option>';
						}
						?>		
						<option value="-3">--------------------</option>
						<?					
						for ($idx=0; $idx<sizeof($arr_cities); $idx++)
						{						
							echo '<option value="'.$arr_cities[$idx]['id'].'">'.$arr_cities[$idx]['name_he'].'</option>';
						}						
						?>												
					</select>					
				</td>
				<td><a class="btn btn-default" style="background: none; color: #ffffff; padding: 6px 12px;" onclick="FindJobsFilter()">חיפוש</a></td>
			</tr>
		</table>
	</div>
 
 </div>
 
 <!-- jtron end -->
 
 
 <div class="container" style="font-size:15px;">
 
	<div class="row">
	
			<div class="col-md-3">

				<div class="panel panel-default">
					<div class="panel-body" style='text-align:center'>
						<img src="images/banner_2.jpg">
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
			
			</div>
		
			<div class="col-md-9">

				<div class="box" id="contact">
					<h1>צור קשר</h1>

					<p class="lead">האם יש לך שאילה? האם את/ה רוצה לדעת יותר על מציאת עבודה בישראל?</p>
					<p>אנא צרו קשר</p>

					<div class="row" style='background-color:#F0F0F0'>
						<!-- /.col-sm-4 -->
						<div class="col-sm-6">
							<h3><i class="fa fa-phone"></i> צור קשר</h3>
							<p class="text-muted">אנא מלאו את הטופס<br>הבא</p>
							<p><strong>ונחזור אליכם בהקדם</strong>
							</p>
						</div>
						<!-- /.col-sm-4 -->
						<div class="col-sm-6">
							<h3><i class="fa fa-envelope"></i> שאלה בדואר אלקטרוני</h3>
							<p class="text-muted">אנא שלח/י לנו דוא"ל, ונשמח לענות</p>
							<ul>
								<li><strong><a href="mailto:contact@jobs972.com?Subject=Contact Us">contact@jobs972.com</a></strong>
								</li>                                  
							</ul>
						</div>
						<!-- /.col-sm-4 -->
					</div>
					<!-- /.row -->
					
					<h2>טופס יצירת קשר</h2>
					
					<form data-toggle="validator" role="form" id="ContactForm">
						<div class="row" id="contact_status">
							<div class="col-sm-6">
								<div id="inp_first_name" class="form-group">
									<label for="firstname">שם פרטי</label>
									<input type="text" class="form-control" name="firstname" id="firstname">
								</div>
							</div>
							<div class="col-sm-6">
								<div id="inp_last_name" class="form-group">
									<label for="lastname">שם משפחה</label>
									<input type="text" class="form-control" name="lastname" id="lastname">
								</div>
							</div>
							<div class="col-sm-6">
								<div id="inp_email" class="form-group">
									<label for="email">כתובת הדוא"ל</label>
									<input type="text" class="form-control" name="email" id="email">
								</div>
							</div>
							<div class="col-sm-6">
								<div id="inp_subject" class="form-group">
									<label for="subject">נושא</label>
									<input type="text" class="form-control" name="subject" id="subject">
								</div>
							</div>
							<div class="col-sm-12">
								<div id="inp_message" class="form-group">
									<label for="message">ההודעה שלך</label>
									<textarea id="message"  name="message" class="form-control"></textarea>
								</div>
							</div>
							<div class="col-sm-4">
								<div id="inp_captcha" class="form-group">
									<label for="captcha"> <?php echo $a; ?> + <?php echo $b; ?> = ?</label>
									<input type="text" class="form-control" name="captcha" id="captcha">
								</div>
							</div>								
							<div class="col-sm-12 text-center">
								<button type="submit" class="btn btn-primary" onclick="ajax_post(); return false;">שלח <i class="fa fa-envelope-o"></i></button>
							</div>
						</div>
						<!-- /.row -->
						
						 
						<div class="jumbotron" id='txtreply' style='display:none'>
							<h2 style='text-align:center'>הודעתך נשלחה בהצלחה!</h2>
							<p style='text-align:center'>נשיב לך בהקדם!</p>
							<p style='text-align:center'><a class="btn btn-primary btn-lg" href="#" onclick="reload_page();" role="button">Ок</a></p>
						</div>
						 
					</form>					

				</div>

             </div>	
	

	
	</div>
 
 </div>

  
 <div class="clearfix" style="margin-bottom:20px;"></div> 
 
<!-- Pre footer -->

	<div id="footer">
		<div class="container" style="font-size:15px;">
			<div class="row">


				<!-- /.col-md-3 -->



				<div class="col-md-3 col-sm-6">

					<h4>הירשם</h4>

					<p class="text-muted" style="font-size:14px;">קבלת משרות חדשות העליונות נמסרו לדוא"ל שלך</p>

					<form  enctype="multipart/form-data" method="post" name="SubscribeEmail">
						<div class="input-group">
							
							<input type="text" class="form-control" name="subscr_email" id="subscr_email">

							<span class="input-group-btn">

								<button class="btn btn-default" type="button" onclick="#">הירשם!</button>

							</span>

						</div>
						<!-- /input-group -->
					</form>

					<hr>

					<h5>הצטרפו אלינו על רשתות חברתיות!</h5>

					<p class="social">						
						<a href="https://www.facebook.com/jobs972com" target='_blank' class="facebook external" data-animate-hover="shake"><i class="fa fa-facebook"></i></a>
						<a href="https://twitter.com/jobs972com" target='_blank' class="twitter external" data-animate-hover="shake"><i class="fa fa-twitter"></i></a>
						<a href="#" target='_blank' class="linkedin external" data-animate-hover="shake"><i class="fa fa-linkedin"></i></a>
						<a href="#" class="gplus external" data-animate-hover="shake"><i class="fa fa-google-plus"></i></a>	
						<a href="mailto: ?Subject=Find Job In Israel!" class="email external" data-animate-hover="shake"><i class="fa fa-envelope"></i></a>						
					</p>


				</div>

				<div class="col-md-3 col-sm-6">

					<h4>צור קשר</h4>

					<a href="contactus_heb.php#come_here">צור קשר</a>

					<hr class="hidden-md hidden-lg">

				</div>				
				

				<div class="col-md-3 col-sm-6">

					<h4>מגמות משרות</h4>
				 
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
				
				<div class="col-md-3 col-sm-6">
					<h4>דפים</h4>

					<ul>
						<li><a href="index.php">דף הבית</a>
						</li>												
						<li><a href="positions.php#come_here">לוח דרושים</a>
						</li>													
						<li><a href="categories.php#come_here">כל הקטגוריות</a>
						</li>
						<li><a href="companies.php#come_here">כל החברות</a>
						</li>							
						<li><a href="contactus_heb.php#come_here">צור קשר</a>
						</li>						
					</ul>				

					<hr class="hidden-md hidden-lg hidden-sm">

				</div>				
				
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
		<div class="col-md-4">
			<p class="pull-left"><a href="#">חזרה למעלה</a></p>
		</div>	
		<div class="col-md-8">
			<p class="pull-right"><span class="hidden-sm hidden-xs">חיפוש עבודה, לוח דרושים איכותי, משרות הייטק - </span>2016 "Jobs972" ©</p>		 
		</div>
	</div>
  </div>
  
 <!-- footer end -->
 

    <script src="jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>

