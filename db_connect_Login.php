<?php

 $server = "localhost";
$user = "root";
 $dbName = "lms_system"; 
 $pass = "";
	$link = mysqli_connect($server, $user, $pass, $dbName);
		if(!$link)
			die("Error connecting database");




?>