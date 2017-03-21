<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_id = $_SESSION['user_id'];
$user_type=$_SESSION['user_type'];
$request_id = $_GET['request_id'];

if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

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

$request = "SELECT rf.*,ud.firstname,ud.middlename,ud.lastname FROM request_form as rf left join user_details as ud on rf.requested_by=ud.user_id where request_id='$request_id'";
$requestQuery = mysqli_query($conn,$request) or die(mysqli_error($conn));
$req = mysqli_fetch_array($requestQuery, MYSQLI_ASSOC);

// $reqid = $req['requested_by']; //
// $nameStr = "SELECT firstname,middlename,lastname from user_details where id='$reqid'";  //
// $nameQry = mysqli_query($conn,$nameStr) or die(mysqli_error($conn));  //
// $nameArr = mysqli_fetch_array($nameQry,MYSQLI_ASSOC); //

$items = "SELECT * FROM items WHERE request_form_id = '$request_id'";
$itemsQuery = mysqli_query($conn,$items);
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>Request Details</title>
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
      <a class="navbar-brand" href="#" >SCIS REQUISITION SYSTEM</a>

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
              <a href="../dashboard/profile.php" class='nav-link active' >Profile<span class='sr-only'>(current)</span></a>
            </li>

            
          </ul>
          </nav>
</div>
</div>

	<div class="req_form">
		<h1>Request Form Details</h1>
		<table class="table table-striped custab">
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
		<h5>Requested By:</h5><h6> <?php echo $req['firstname'] . " " . $req['middlename'] . " " . $req['lastname'];?></h6>
		<h5>Use of Item(s):</h5><h6> <?php echo $req['use_of_item'];?></h6>
		<h5>Needed on:</h5><h6> <?php echo $req['date_needed'];?></h6>
		<?php
		$statusSTR = "SELECT * FROM request_form";
		$statusQRY = mysqli_query($conn,$statusSTR);
		$statusarr = mysqli_fetch_array($statusQRY, MYSQLI_ASSOC);
		if($user_type == 'accounting'){
			echo "<span id='buttons'>";
	 		echo "<a class='btn btn-info' href='../accounting/request_status.php?request_id=" .$request_id. "&&status=approve'>Approve</a>";
			echo "<a class='btn btn-warning' href='../accounting/request_status.php?request_id=" .$request_id. "&&status=reject'>Reject</a>";
			echo "</span>";
		}	
		?>
	</div>
</body>
</html>