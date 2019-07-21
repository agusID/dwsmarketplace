<?php

	$dbHost = 'localhost';
	$dbUser = 'prk';
	$dbPass = 'prk';
	$dbName = 'prk';

	$db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
	
	//check connection
	if($db->connect_error){
		echo 'Unable to connect database';
	}
?>