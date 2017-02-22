<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

if (isset($_POST['search'])) {
	$search = $_POST['search'];
}

//name 
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
//request_status
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
 		<a href="../dashboard/profile.php" style="float:right">Profile  |</a>

 		<h1>Hi <?php echo $firstname . ' ' . $middlename . ' ' . $lastname?>!</h1>
 		<div>
 		<!-- check if user iis scis or not -->
 		<?php
 		if($user_type=='scis'){
 			echo "<a href='request_form.php'>Add New Request</a>";

 		}else{
 			echo "<a href='../accounting/approved.php'> Approved Requests </a>";
 		}

 		?>
 		<br>
 		<?php
                if($user_id == 1){
                    echo "<a href='activator.php'>Manage Accounts</a>";
                }
            ?>
 		
 			<h2>Requested Items</h2>
 			<form method="POST" action="home.php">
            	Search: <input type="text" name="search">
            	<input type="submit" name="sub_search" value="Search">
            	<br>
            	<br>
            
            </form>
 			<table style="width:50%" border="1">
			  <tr>
			    <th>Request No.</th>
			    <th>Request Description</th> 
			    <th>Status</th>
			    <th>Date Needed</th>
			    <th>Action</th>
			  </tr>

			<?php
			if($user_type == "scis"){
				if (isset($_POST['sub_search'])) {
					$request_search = "SELECT * from request_form where request_id like '%".$search. "%' or use_of_item like '%".$search. "%' ";
					$request_searchQ = mysqli_query($conn,$request_search) or die(mysqli_error($conn));
	            	while($searchrow = mysqli_fetch_array($request_searchQ)){
						echo "<tr><td> RF 00" . $searchrow['request_id'] . "</td>";
						echo "<td>" . $searchrow['use_of_item'] . "</td>";
						echo "<td>" . $searchrow['request_status'] . "</td>";
						echo "<td>" . $searchrow['date_needed'] . "</td>";
						echo "<td>";
						echo "<a href='request_details.php?request_id=" . $searchrow['request_id'] . "'>View Details</a> ";
						if($searchrow['request_status'] != 'pending'){
							echo "<a href='status_report.php?request_id=" . $searchrow['request_id'] . "'>View Status Report</a>";
						}
						
						echo "</td></tr>";
					}
	           	}else{
					while($row = mysqli_fetch_array($requestQuery)){
						echo "<tr><td> RF 00" . $row['request_id'] . "</td>";
						echo "<td>" . $row['use_of_item'] . "</td>";
						echo "<td>" . $row['request_status'] . "</td>";
						echo "<td>" . $row['date_needed'] . "</td>";
						echo "<td>";
						echo "<a href='request_details.php?request_id=" . $row['request_id'] . "'>View Details</a> ";
						if($row['request_status'] != 'pending'){
							echo "<a href='status_report.php?request_id=" . $row['request_id'] . "'>View Status Report</a>";
						}

						echo "</td></tr>";
					}
				}
			} else {
				if (isset($_POST['sub_search'])) {
					$request_search = "SELECT * from request_form where (request_id like '%".$search. "%' or use_of_item like '%".$search. "%') and request_status = 'pending'";
					$request_searchQ = mysqli_query($conn,$request_search) or die(mysqli_error($conn));
	            	while($searchrow = mysqli_fetch_array($request_searchQ)){
						echo "<tr><td> RF 00" . $searchrow['request_id'] . "</td>";
						echo "<td>" . $searchrow['use_of_item'] . "</td>";
						echo "<td>" . $searchrow['request_status'] . "</td>";
						echo "<td>" . $searchrow['date_needed'] . "</td>";
						echo "<td>";
						echo "<a href='request_details.php?request_id=" . $searchrow['request_id'] . "'>View Details</a> ";
						if($searchrow['request_status'] != 'pending'){
							echo "<a href='status_report.php?request_id=" . $searchrow['request_id'] . "'>View Status Report</a>";
						}
						
						echo "</td></tr>";
					}
	           	}else{
					while($row = mysqli_fetch_array($requestQuery)){
						echo "<tr><td> RF 00" . $row['request_id'] . "</td>";
						echo "<td>" . $row['use_of_item'] . "</td>";
						echo "<td>" . $row['request_status'] . "</td>";
						echo "<td>" . $row['date_needed'] . "</td>";
						echo "<td>";
						echo "<a href='request_details.php?request_id=" . $row['request_id'] . "'>View Details</a> ";
						if($row['request_status'] != 'pending'){
							echo "<a href='status_report.php?request_id=" . $row['request_id'] . "'>View Status Report</a>";
						}

						echo "</td></tr>";
					}
				}
			}	

			?>
			</table>
			
 		</div> 		
 	</div>
 	
</body>
</html>

