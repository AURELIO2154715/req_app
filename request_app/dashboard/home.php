<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

$details = "SELECT firstname,middlename,lastname from user_details where user_id = '$user_id'";
$detailsQuery = mysqli_query($conn,$details);
if($detailsQuery){
	$row = mysqli_fetch_array($detailsQuery,MYSQLI_ASSOC);
	$firstname = $row['firstname'];
	$lastname = $row['lastname'];
	$middlename = $row['middlename'];
}else{
	echo "Error: " . $detailsQuery . mysqli_error($conn);
}
if($user_type == 'accounting'){
	$requests = "SELECT * FROM request_form WHERE request_status = 'pending' ORDER BY created_at DESC";
}else{
	$requests = "SELECT * FROM request_form ORDER BY created_at DESC";
}
$requestQuery = mysqli_query($conn,$requests) or die(mysqli_error($conn));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
 	<div>
 		<a href="../shared/logout.php" style="float:right">Logout</a>
 		<h1>Hi <?php echo $firstname . ' ' . $middlename . ' ' . $lastname?>!</h1>
 		<div>
 		<!-- check if user iis scis or not -->
 		<?php
 		if($user_type=='scis'){
 			echo "<a href='request_form.php'>Add New Request</a>";
 		}
 		?>
 			
 			<h2>Requested Items</h2>
 			<table style="width:50%" border="1">
			  <tr>
			    <th>Request No.</th>
			    <th>Request Description</th> 
			    <th>Status</th>
			    <th>Date Needed</th>
			    <th>Action</th>
			  </tr>
			  <?php
			  print_r($row);
			  while($row = mysqli_fetch_array($requestQuery)){
			  	echo "<tr><td> RF 00" . $row['request_id'] . "</td>";
			  	echo "<td>" . $row['use_of_item'] . "</td>";
			  	echo "<td>" . $row['request_status'] . "</td>";
			  	echo "<td>" . $row['date_needed'] . "</td>";
			  	echo "<td><a href='request_details.php?request_id=" . $row['request_id'] . "'>View Details</a></td></tr>";
			  }
			  ?>
			</table>
 		</div> 		
 	</div>
</body>
</html>

