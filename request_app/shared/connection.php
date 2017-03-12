<?php
	$conn = mysqli_connect("localhost", "root","1234","scis_req_db");

	if (mysqli_connect_errno())
  	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}
?>