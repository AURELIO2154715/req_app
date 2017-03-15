<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
$request_id = $_GET['request_id'];


$status_rep = "SELECT sr.*,ud.firstname,ud.middlename,ud.lastname,rf.request_status FROM status_report as sr left join user_details as ud on sr.received_by=ud.user_id left join request_form as rf on sr.request_form_id=rf.request_id where request_form_id='$request_id'";
$status_report_query = mysqli_query($conn,$status_rep) or die(mysqli_error($conn));
$stat = mysqli_fetch_array($status_report_query, MYSQLI_ASSOC);

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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Status Report</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/dashboard.css" rel="stylesheet">


</head>
<body>

<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggleroggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../dashboard/home.php" >SCIS REQUISITION SYSTEM</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          
        </ul>
        <?php
        echo "<a href='../dashboard/profile.php' class='nav-link'>" . $firstname . ' ' . $middlename . ' ' . $lastname . "</a>";
        ?>
        <a href="../shared/logout.php" class='nav-link' >Logout</a>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
          <ul class="nav nav-pills flex-column">
          	<li class="nav-item">
              <a class="nav-link active" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <?php
 		if($user_type=='scis'){
 			echo "<a href='request_form.php' class='nav-link'>Add New Request</a>";

 		}else{
 			echo "<a href='../accounting/approved.php' class='nav-link'> Approved Requests </a>";
 			echo "<a href='../accounting/rejected.php' class='nav-link'> Rejected Requests </a>";
 		}
 		?>
 		 <li class="nav-item">
 		<?php
                if($user_id == 1){
                    echo "<a href='activator.php' class='nav-link'>Manage Accounts</a>";
                }
            ?>
            </li>
            <li class="nav-item">
              <a href="../dashboard/profile.php" class='nav-link' >Profile</a>
          	</li>
          </ul>
          </nav>
</div>
</div>
<div class="req_form">
	<div>
		<h1>Status Report</h1>
		<h3>Status</h3> <h5><?php echo $stat['request_status'];?></h5>
		<br>
		<h3>Reason</h3>
		<h5><?php echo $stat['remarks'];?></h5>
		<div class="btn-group" role="group" aria-label="...">
		<?php
		if($stat['request_status'] == 'approved'){
			echo "<a class='btn btn-info' href='download_doc.php?file=" . $stat['filename'] ."'>Download document</a>";
		}
		?>
	</div>
	</div>
</div>
</body>
</html>