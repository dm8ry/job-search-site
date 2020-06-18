<?php session_start(); 

include_once('./../inc/db_connect.php');
include_once('./../admin_email.php');

$conn0 = new mysqli($servername, $username, $password, $dbname);

if ($conn0->connect_error) {
	die("Connection failed: " . $conn0->connect_error);
} 

$conn0->query("set names 'utf8'");	

$the_sql_query = "update category ca
					set ca.n_pos = (select count(1) 
									from positions p  
									where 
										p.pos_cat = ca.id 
										or 
										p.pos_cat_2 = ca.id
										or 
										p.pos_cat_3 = ca.id
										or 
										p.pos_cat_4 = ca.id
										or 
										p.pos_cat_5 = ca.id)
					where exists 
							(select 1 
								from positions p  
									where p.pos_cat = ca.id 
										or 
										p.pos_cat_2 = ca.id
										or 
										p.pos_cat_3 = ca.id
										or 
										p.pos_cat_4 = ca.id
										or 
										p.pos_cat_5 = ca.id)";

$conn0->query($the_sql_query);	

$the_sql_query_2 = "insert into principal_company_link 
					select 0, id 
					from company 
					where  id not in 
							(select comp_id 
							from principal_company_link  
							where princ_id =0)";

$conn0->query($the_sql_query_2);	

$the_sql_query_3 = "insert into principal_position_link 
					select 0, id 
					from positions 
					where id not in 
							(select pos_id 
							from principal_position_link  
							where princ_id =0)";

$conn0->query($the_sql_query_3);							
							
$conn0->close();

unset($_SESSION['princ_login']);
unset($_SESSION['princ_first_name']);
unset($_SESSION['princ_id']);
unset($_SESSION['princ_email']);
session_destroy();
header("Location: index.php");
exit;

?>