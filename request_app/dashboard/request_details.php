<?php
include '../shared/session.php';
include '../shared/connection.php';

$user_type=$_SESSION['user_type'];
$request_id = $_GET['request_id'];

$request = "SELECT * FROM request_form where request_id='$request_id'";
$requestQuery = mysqli_query($conn,$request) or die(mysqli_error($conn));
$req = mysqli_fetch_array($requestQuery, MYSQLI_ASSOC);

$reqid = $req['requested_by']; //
$nameStr = "SELECT firstname,middlename,lastname from user_details where id='$reqid'";  //
$nameQry = mysqli_query($conn,$nameStr) or die(mysqli_error($conn));  //
$nameArr = mysqli_fetch_array($nameQry,MYSQLI_ASSOC); //

$items = "SELECT * FROM items WHERE request_form_id = '$request_id'";
$itemsQuery = mysqli_query($conn,$items);


?>
<!DOCTYPE html>
<html>
<head>
	<title>Request Details</title>
</head>
<body>
	<a href="../shared/logout.php" style="float:right">Logout</a>
	<div>
		<h1>Request Form Details</h1>
		<a href="home.php">Back to List</a>	
		<table border="1">
			<tr>
			    <th>Quantity</th>
			    <th>Item Description</th> 
		  	</tr>
		  	<?php
		  	while($row = mysqli_fetch_array($itemsQuery)){
			  	echo "<tr><td>" . $row['quantity'] . "</td>";
			  	echo "<td>" . $row['description'] . "</td></tr>";
			  }
		    ?>
		</table>
		<h3>Requested By: <?php echo $nameArr['firstname'] . " " . $nameArr['middlename'] . " " . $nameArr['lastname'];?></h3>
		<h3>Use of Item(s): <?php echo $req['use_of_item'];?></h3>
		<h3>Needed on: <?php echo $req['date_needed'];?></h3>
		<?php
		if($user_type == 'accounting'){
 		echo "<button onclick='approve()'>Approve</button>";
		echo "<button onclick='reject()'>Reject</button>";
		}	
		?>
	</div>
</body>
<script type="text/javascript">
	function reject(){
		console.log('will reject');
		window.location.href='../shared/status_report.php';
	}
	function approve(){
		console.log('approve');
		window.location.href='../shared/status_report.php';
	}
</script>
</html>