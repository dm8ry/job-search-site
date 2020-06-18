<?php

include_once('inc/db_connect.php');

// Create connection
$conn0 = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn0->connect_error) {
	die("Connection failed: " . $conn0->connect_error);
} 

$conn0->query("set names 'utf8'");	

$sql0 = "select * from app_properties where prop_name = 'admin_email'";

$result0 = $conn0->query($sql0);

$admin_email_address = "contact@jobs972.com";

if ($result0->num_rows == 1) 
{    
	$row = $result0->fetch_assoc();
	$admin_email_address = $row["prop_value"];		
} 
else 
{
	// Nothing to do...
	
}

$conn0->close();

?>