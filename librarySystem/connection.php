<?php

	$db=mysqli_connect("localhost","root", '', 'library_management_system');
	/* server name,username,password,database name*/

	if(!$db)
	{
		die("Connection failed: " .mysqli_connect_error());
	}

	/*echo "Connected successfully.";*/	

?>
