<?php
	$host = 'restaurant-free-tier-please.ckcnlmnjbyec.us-east-1.rds.amazonaws.com';
	$user = 'admin';
	$pass = '4090toobig!';
	$db_name = 'sys'; 
	
	$conn = new mysqli($host, $user, $pass, $db_name);
	if($conn->connect_error){
		die('Connection error: '.$conn->connect_error);
	}
?>