<?php session_start(); 


	function addhttp($url) {
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}

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

		// get user details
		
		$sql_user_details = "select us.*, date_format(us.last_login, '%d/%m/%Y %H:%i') last_login_f from users us where us.email = upper(trim('".$_SESSION['logged_in_email']."'))";	
		
		$arr_user_details = array();
		$results_user_details = mysqli_query($conn, $sql_user_details); 

		while($line = mysqli_fetch_assoc($results_user_details)){
			$arr_user_details[] = $line;
		}	
			
		// cat subcat 1
		
		if (is_null($arr_user_details[0]['cat_1']) || is_null($arr_user_details[0]['scat_1']))
		{
			$str_cat_scat_1 = "";
			$cat1 = -1;
			$scat1 = -1;			
		}
		else
		{
		
			if ($arr_user_details[0]['cat_1'] == -1 )
			{
				$cat1_name = 'All';
				$cat1 = -1;
			}
			else
			{
				$sql_category = "select cat_name from category where id = ".$arr_user_details[0]['cat_1'];
				
				$arr_category = array();
				$results_category = mysqli_query($conn, $sql_category); 

				while($line = mysqli_fetch_assoc($results_category)){
					$arr_category[] = $line;
				}
				$cat1_name = $arr_category[0]['cat_name'];
				$cat1 = $arr_user_details[0]['cat_1'];
			}

			if ($arr_user_details[0]['scat_1'] == -1 )
			{
				$scat1_name = 'All';
				$scat1 = -1;
			}
			else
			{
				$sql_scategory = "select subcat_name from sub_category where id = ".$arr_user_details[0]['scat_1'];
				
				$arr_scategory = array();
				$results_scategory = mysqli_query($conn, $sql_scategory); 

				while($line = mysqli_fetch_assoc($results_scategory)){
					$arr_scategory[] = $line;
				}
				$scat1_name = $arr_scategory[0]['subcat_name'];			
			}		
		
			$str_cat_scat_1 = $cat1_name.' -> '.$scat1_name;
			$scat1 = $arr_user_details[0]['scat_1'];
		}
		
		
		// cat subcat 2		
				
		if (is_null($arr_user_details[0]['cat_2']) || is_null($arr_user_details[0]['scat_2']))
		{
			$str_cat_scat_2 = "";
			$cat2 = -1;
			$scat2 = -1;			
		}
		else
		{
			if ($arr_user_details[0]['cat_2'] == -1)
			{
				$cat2_name = 'All';
				$cat2 = -1;
			}
			else
			{
				$sql_category = "select cat_name from category where id = ".$arr_user_details[0]['cat_2'];
				
				$arr_category = array();
				$results_category = mysqli_query($conn, $sql_category); 

				while($line = mysqli_fetch_assoc($results_category)){
					$arr_category[] = $line;
				}
				$cat2_name = $arr_category[0]['cat_name'];	
				$cat2 = $arr_user_details[0]['cat_2'];
			}

			if ($arr_user_details[0]['scat_2'] == -1)
			{
				$scat2_name = 'All';
				$scat2 = -1;
			}
			else
			{
				$sql_scategory = "select subcat_name from sub_category where id = ".$arr_user_details[0]['scat_2'];
				
				$arr_scategory = array();
				$results_scategory = mysqli_query($conn, $sql_scategory); 

				while($line = mysqli_fetch_assoc($results_scategory)){
					$arr_scategory[] = $line;
				}
				$scat2_name = $arr_scategory[0]['subcat_name'];	
				$scat2 = $arr_user_details[0]['scat_2'];
			}		
		
			$str_cat_scat_2 = $cat2_name.' -> '.$scat2_name;
		}		
		
		
		// cat subcat 3
		
		if (is_null($arr_user_details[0]['cat_3']) || is_null($arr_user_details[0]['scat_3']))
		{
			$str_cat_scat_3 = "";
			$cat3 = -1;
			$scat3 = -1;			
		}
		else
		{
		
			if ($arr_user_details[0]['cat_3'] == -1)
			{
				$cat3_name = 'All';
				$cat3 = -1;
			}
			else
			{
				$sql_category = "select cat_name from category where id = ".$arr_user_details[0]['cat_3'];
				
				$arr_category = array();
				$results_category = mysqli_query($conn, $sql_category); 

				while($line = mysqli_fetch_assoc($results_category)){
					$arr_category[] = $line;
				}
				$cat3_name = $arr_category[0]['cat_name'];	
				$cat3 = $arr_user_details[0]['cat_3'];
			}

			if ($arr_user_details[0]['scat_3'] == -1)
			{
				$scat3_name = 'All';
				$scat3 = -1;
			}
			else
			{
				$sql_scategory = "select subcat_name from sub_category where id = ".$arr_user_details[0]['scat_3'];
				
				$arr_scategory = array();
				$results_scategory = mysqli_query($conn, $sql_scategory); 

				while($line = mysqli_fetch_assoc($results_scategory)){
					$arr_scategory[] = $line;
				}
				$scat3_name = $arr_scategory[0]['subcat_name'];
				$scat3 = $arr_user_details[0]['scat_3'];
			}		
		
			$str_cat_scat_3 = $cat3_name.' -> '.$scat3_name;
		}			
		
		
		// cat subcat 4		
		
		if (is_null($arr_user_details[0]['cat_4']) || is_null($arr_user_details[0]['scat_4']))
		{
			$str_cat_scat_4 = "";
			$cat4 = -1;
			$scat4 = -1;
		}
		else
		{
		
			if ($arr_user_details[0]['cat_4'] == -1)
			{
				$cat4_name = 'All';
				$cat4 = -1;
			}
			else
			{
				$sql_category = "select cat_name from category where id = ".$arr_user_details[0]['cat_4'];
				
				$arr_category = array();
				$results_category = mysqli_query($conn, $sql_category); 

				while($line = mysqli_fetch_assoc($results_category)){
					$arr_category[] = $line;
				}
				$cat4_name = $arr_category[0]['cat_name'];
				$cat4 = $arr_user_details[0]['cat_4'];
			}

			if ($arr_user_details[0]['scat_4'] == -1)
			{
				$scat4_name = 'All';
				$scat4 = -1;				
			}
			else
			{
				$sql_scategory = "select subcat_name from sub_category where id = ".$arr_user_details[0]['scat_4'];
				
				$arr_scategory = array();
				$results_scategory = mysqli_query($conn, $sql_scategory); 

				while($line = mysqli_fetch_assoc($results_scategory)){
					$arr_scategory[] = $line;
				}
				$scat4_name = $arr_scategory[0]['subcat_name'];	
				$scat4 = $arr_user_details[0]['scat_4'];
			}		
		
			$str_cat_scat_4 = $cat4_name.' -> '.$scat4_name;
		}			
		
		
		// cat subcat 5
					
		if (is_null($arr_user_details[0]['cat_5']) || is_null($arr_user_details[0]['scat_5']))
		{
			$str_cat_scat_5 = "";
			$cat5 = -1;
			$scat5 = -1;
		}
		else
		{
		
			if ($arr_user_details[0]['cat_5'] == -1)
			{
				$cat5_name = 'All';
				$cat5 = -1;
			}
			else
			{
				$sql_category = "select cat_name from category where id = ".$arr_user_details[0]['cat_5'];
				
				$arr_category = array();
				$results_category = mysqli_query($conn, $sql_category); 

				while($line = mysqli_fetch_assoc($results_category)){
					$arr_category[] = $line;
				}
				$cat5_name = $arr_category[0]['cat_name'];		
				$cat5 = $arr_user_details[0]['cat_5'];
			}

			if ($arr_user_details[0]['scat_5'] == -1)
			{
				$scat5_name = 'All';
				$scat5 = -1;
			}
			else
			{
				$sql_scategory = "select subcat_name from sub_category where id = ".$arr_user_details[0]['scat_5'];
				
				$arr_scategory = array();
				$results_scategory = mysqli_query($conn, $sql_scategory); 

				while($line = mysqli_fetch_assoc($results_scategory)){
					$arr_scategory[] = $line;
				}
				$scat5_name = $arr_scategory[0]['subcat_name'];	
				$scat5 = $arr_user_details[0]['scat_5'];
			}		
				
			$str_cat_scat_5 = $cat5_name.' -> '.$scat5_name;
		}			
				
		$conn->close();			
		
		$repl_txt = '';
		
		/// start construct the response
	
		 $repl_txt = $repl_txt.'<table class="table table-striped">'."\n" ;
		 $repl_txt = $repl_txt.'<thead>'."\n" ;
		 $repl_txt = $repl_txt.'<tr>'."\n" ;
		 $repl_txt = $repl_txt.'<th></th>'."\n" ;
		 $repl_txt = $repl_txt.'<th></th>'."\n" ;
		 $repl_txt = $repl_txt.'<th></th>'."\n" ;
		 $repl_txt = $repl_txt.'</tr>'."\n" ;
		 $repl_txt = $repl_txt.'</thead>'."\n" ;
		 $repl_txt = $repl_txt.'<tbody>'."\n" ;
	 	 $repl_txt = $repl_txt.'<tr>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle">You Earned</td>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valPoints"><b>'.$arr_user_details[0]['points'].'</b> Points</td>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="inviteFriendEarnPoints();">Earn More</button></td>'."\n" ;
		 $repl_txt = $repl_txt.'</tr>'."\n" ;		 
		 $repl_txt = $repl_txt.'<tr>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle; width:20%;">Email</td>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle">'.$arr_user_details[0]['email'].'</td>'."\n" ;
		 
		 $is_disabled='';
		 if ($arr_user_details[0]['is_verified'] == 1) 
			$is_disabled = 'disabled'; 

		 $if_verify='';
		 if ($arr_user_details[0]['is_verified'] == 1) 
			$if_verify="Verified"; 
		 else 
			$if_verify="Verify"; 
		 
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle"><button type="button" class="btn btn-default '.$is_disabled.'" onClick="verifyEmail()" '.$is_disabled.'>'.$if_verify.'</button></td>'."\n" ;
		 $repl_txt = $repl_txt.'</tr>'."\n" ;		
		 $repl_txt = $repl_txt.'<tr>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle">Password</td>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valPassword" >'.str_repeat("*", strlen($arr_user_details[0]['pwd'])).'</td>'."\n" ;
 		 $repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'Password\')">Change</button></td>'."\n" ;
		 $repl_txt = $repl_txt.'</tr>'."\n" ;					  
	 	 $repl_txt = $repl_txt.'<tr>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle">First Name</td>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valFirstname">'.$arr_user_details[0]['firstname'].'</td>'."\n" ;
		 $repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'Firstname\')">Edit</button></td>'."\n" ;
		 $repl_txt = $repl_txt.'</tr>'."\n" ;
		 $repl_txt = $repl_txt.'<tr>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Last Name</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valLastname">'.$arr_user_details[0]['lastname'].'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'Lastname\')">Edit</button></td>'."\n" ;
		$repl_txt = $repl_txt.'</tr>'."\n" ;
		$repl_txt = $repl_txt.'<tr>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">City</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valCity">'.$arr_user_details[0]['city'].'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'City\')">Edit</button></td>'."\n" ;
		$repl_txt = $repl_txt.'</tr>'."\n" ;
		$repl_txt = $repl_txt.'<tr>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Mobile</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valMobile">'.$arr_user_details[0]['mobile'].'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'Mobile\')">Edit</button></td>'."\n" ;
		$repl_txt = $repl_txt.'</tr>'."\n" ;
		$repl_txt = $repl_txt.'<tr>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Tell Us About Yourself</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valAbout">'.nl2br($arr_user_details[0]['about']).'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'About\')">Edit</button></td>'."\n";	
		$repl_txt = $repl_txt.'</tr>'."\n";			
		$repl_txt = $repl_txt.'<tr id="m7" >'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Position(s) You are Looking For</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valPositions">'.$arr_user_details[0]['positions'].'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'Positions\')">Edit</button></td>'."\n";	
		$repl_txt = $repl_txt.'</tr>'."\n";	
		$repl_txt = $repl_txt.'<tr id="m8">'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Position(s)<br/> Category | Sub-Category #1<br/>You\'d be interested</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valCatSubcat1">'.$str_cat_scat_1.'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetailsCatSubcat(\'1\',\''.$cat1.'\',\''.$scat1.'\')">Edit</button></td>'."\n";	
		$repl_txt = $repl_txt.'</tr>'."\n";	
		$repl_txt = $repl_txt.'<tr id="m9">'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Position(s)<br/> Category | Sub-Category #2<br/>You\'d be interested</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valCatSubcat2">'.$str_cat_scat_2.'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetailsCatSubcat(\'2\',\''.$cat2.'\',\''.$scat2.'\')">Edit</button></td>'."\n";	
		$repl_txt = $repl_txt.'</tr>'."\n";	
		$repl_txt = $repl_txt.'<tr id="m10">'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Position(s)<br/> Category | Sub-Category #3<br/>You\'d be interested</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valCatSubcat3">'.$str_cat_scat_3.'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetailsCatSubcat(\'3\',\''.$cat3.'\',\''.$scat3.'\')">Edit</button></td>'."\n";	
		$repl_txt = $repl_txt.'</tr>'."\n";	
		$repl_txt = $repl_txt.'<tr id="m11">'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Position(s)<br/> Category | Sub-Category #4<br/>You\'d be interested</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valCatSubcat3">'.$str_cat_scat_4.'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetailsCatSubcat(\'4\',\''.$cat4.'\',\''.$scat4.'\')">Edit</button></td>'."\n";	
		$repl_txt = $repl_txt.'</tr>'."\n";	
		$repl_txt = $repl_txt.'<tr id="m12">'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Position(s)<br/> Category | Sub-Category #5<br/>You\'d be interested</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valCatSubcat5">'.$str_cat_scat_5.'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetailsCatSubcat(\'5\',\''.$cat5.'\',\''.$scat5.'\')">Edit</button></td>'."\n";	
		$repl_txt = $repl_txt.'</tr>'."\n";			
		$repl_txt = $repl_txt.'<tr>'."\n";	
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">LinkedIn Profile URL</td>'."\n";	
		
		$link_to_place = addhttp(strtolower($arr_user_details[0]['linkedin']));
		
		if (strlen($link_to_place) < 60)
		{
			$repl_txt = $repl_txt.'<td style="vertical-align:middle"><a href="'.$link_to_place.'" target="_blank" id="valLinkedin">'.$link_to_place.'</a></td>'."\n";
		}
		else
		{
			$repl_txt = $repl_txt.'<td style="vertical-align:middle"><a href="'.$link_to_place.'" target="_blank" id="valLinkedin">Your LinkedIn Profile URL</a></td>'."\n";
		}
		
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'LinkedInURL\')">Edit</button></td>'."\n";
		$repl_txt = $repl_txt.'</tr>'."\n";	
		$repl_txt = $repl_txt.'<tr>'."\n";
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Are You Citizen of Israel?</td>'."\n";
		
		$is_citizen = '';
		if ($arr_user_details[0]['iscitizen'] == '1') 
			$is_citizen='Yes'; 
		else 
			$is_citizen='No'; 
		
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valIsCitizen">'.$is_citizen.'</td>'."\n";
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'Is_Citizen\')">Edit</button></td>'."\n" ;	
		$repl_txt = $repl_txt.'</tr>'."\n" ;	
		$repl_txt = $repl_txt.'<tr>'."\n" ;	
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Profile Status</td>'."\n" ;	
		
		$is_active_or_not = '';
		if ($arr_user_details[0]['status'] == '1') 
			$is_active_or_not = '<span style="color:green;  font-weight:bold">Active</span>';
		else 
			$is_active_or_not = '<span style="color:red; font-weight:bold">Non-Active</span>';
		
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valIsActive">'.$is_active_or_not.'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;"><button type="button" class="btn btn-default" onClick="changeUserDetails(\'Profile_Status\')">Edit</button></td>'."\n" ;
		$repl_txt = $repl_txt.'</tr>'."\n" ;
		$repl_txt = $repl_txt.'<tr>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle">Last Login</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle" id="valLastLogin">'.$arr_user_details[0]['last_login_f'].'</td>'."\n" ;
		$repl_txt = $repl_txt.'<td style="vertical-align:middle; text-align:left;">&nbsp;</td>'."\n" ;
		$repl_txt = $repl_txt.'</tr>'."\n" ;		
		$repl_txt = $repl_txt.'</tbody>'."\n" ;
		$repl_txt = $repl_txt.'</table>'."\n" ;		
	
		/// end construct the response
	 				
		echo  json_encode(array("val_1" => $repl_txt));
		 
	}	
	else
	{
		echo  json_encode(array("val_1" => 'Error!'));
	}

?>