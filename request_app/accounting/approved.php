<?php
include '../shared/connection.php';
include '../shared/session.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
if (isset($_POST['search'])) {
    $search = $_POST['search'];
	}

$tableStr = "SELECT * FROM request_form INNER JOIN user_details ON (request_form.requested_by=user_details.id) WHERE request_status='approved'";
$tableQry = mysqli_query($conn,$tableStr) or die(mysqli_error($conn));

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
	<title>Appoved requests</title>
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
              <a href="../dashboard/home.php" class='nav-link'>Home </a>
            </li>
           <li class="nav-item">
            <?php
        if($user_type=='scis'){
            echo "<a href='request_form.php' class='nav-link'>Add New Request</a>";

        }else{
            echo "<a href='../accounting/approved.php' class='nav-link active'> Approved Requests <span class='sr-only'>(current)</span></a>";
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
		<h1> Approved request </h1>
	
		  
		<?php
    if(mysqli_num_rows($tableQry)==0){
      echo "<p style='background-color: white';> YOU DID NOT APPROOVE ANY REQUEST :( </p>";
    }
      echo "<table class='table table-striped custab'>";
      echo "<tr>";
      echo "<th>Request No.</th>";
      echo "<th>Request Description</th> ";
      echo "<th>Status</th>";
      echo "<th>Requested by </th>";
      echo "</tr>";
			while($row = mysqli_fetch_array($tableQry)){
				echo "<tr><td> RF 00" . $row['request_id'] . "</td>";
			  	echo "<td>" . $row['use_of_item'] . "</td>";
			  	echo "<td>" . $row['request_status'] . "</td>";
			  	echo "<td>" . $row['firstname'] . " " . $row['middlename'] . " " . $row['lastname'] . "</td>";
			}
      echo "</tr></table>";

		?>

	</div>


</body>
</html>