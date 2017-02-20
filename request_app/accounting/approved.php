<?php
include '../shared/connection.php';
include '../shared/session.php';

$tableStr = "SELECT * FROM request_form INNER JOIN user_details ON request_form.requested_by=user_details.id WHERE request_status='approved'";
$tableQry = mysqli_query($conn,$tableStr) or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html>
<head>
	<title>Appoved requests</title>
</head>
<body>
	<div>
		<h1 style='text-align: center;'> Approved request </h1>
		<a href="../shared/logout.php" style="float:right">Logout</a>
		<a href="../dashboard/home.php">Back to List</a>	
	</div>

	<div>
		<table style="width:50%" border="1">
		  <tr>
		    <th>Request No.</th>
			<th>Request Description</th> 
			<th>Status</th>
			<th>Requested by </th>
			</tr>
		<?php
			while($row = mysqli_fetch_array($tableQry)){
				echo "<tr><td> RF 00" . $row['request_id'] . "</td>";
			  	echo "<td>" . $row['use_of_item'] . "</td>";
			  	echo "<td>" . $row['request_status'] . "</td>";
			  	echo "<td>" . $row['firstname'] . " " . $row['middlename'] . " " . $row['lastname'] . "</td>";
			  	echo "</tr>";
			}

		?>
	</div>


</body>
</html>