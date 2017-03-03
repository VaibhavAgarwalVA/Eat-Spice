<?php

	$dbconnect = mysqli_connect("10.5.18.104", "14CS10059", "btech14", "test");
	if(mysqli_connect_errno()) {
		echo "Connection failed:".mysqli_connect_error();
		exit;
	}
?>