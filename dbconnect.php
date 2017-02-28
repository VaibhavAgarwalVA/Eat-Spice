<?php

	echo '<!DOCTYPE html>
	<html lang="en">
	<head>
	  <title>Bootstrap Example</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>

	<div class="container">          
	  <table class="table table-hover">
	    <thead>
	      <tr>
	        <th>classname</th>
	        <th>capacity</th>
	      </tr>
	    </thead>
	    <tbody>';

	$servername = "10.5.18.102";
	$username = "14CS10050";
	$password = "btech14";
	$dbname = "test";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT classname, capacity FROM classroom";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	    	echo '<tr>
        <td>';
        echo $row["classname"];
        echo'</td>
        <td>';
        echo $row["capacity"];
        echo '</td>
      </tr>';
	    }
	} else {
		echo "0 records fetched!";
	}
	$conn->close();
?>