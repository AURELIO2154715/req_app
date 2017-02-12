<?php
include '../shared/session.php';
include '../shared/connection.php';

$user_type=$_SESSION['user_type'];


?>
<!DOCTYPE html>
<html>
<head>
	<title>Status Report</title>
</head>
<body>
	<div>
	<h2>Requested Items</h2>
 			<table style="width:50%" border="1">
			  <tr>
			    <th>RF00</th>
			    <th>Received by</th> 
			    <th>Remarks</th>
			    <th>Filename</th>
			    
			  </tr>


	</div>


</body>
</html>