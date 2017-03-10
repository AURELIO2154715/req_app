<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
$request_id = $_GET['request_id'];


$status_rep = "SELECT sr.*,ud.firstname,ud.middlename,ud.lastname,rf.request_status FROM status_report as sr left join user_details as ud on sr.received_by=ud.user_id left join request_form as rf on sr.request_form_id=rf.request_id where request_form_id='$request_id'";
$status_report_query = mysqli_query($conn,$status_rep) or die(mysqli_error($conn));
$stat = mysqli_fetch_array($status_report_query, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Status Report</title>
</head>
<body>
	<div>
		<a href="home.php">Back to List</a>
		<h1>Status Report</h1>
		<h3>Status: <?php echo $stat['request_status'];?></h3>
		<p>Reason</p>
		<p><?php echo $stat['remarks'];?></p>
		<?php
		if($stat['request_status'] == 'approved'){
			echo "<a href='download_doc.php?file=" . $stat['filename'] ."'>Download document</a>";
		}
		?>

	</div>
</body>
</html>