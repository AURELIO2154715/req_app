<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

if (isset($_POST['search']) || isset($_POST['date_create'])){
	$search = $_POST['search'];
	$date = $_POST['date'];
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
//pagination algo
$limit = 5;
$current_page = 1;
if (isset($_GET['page']) && $_GET['page'] > 0) 
{
    $current_page = $_GET['page'];
}
$offset = ($current_page * $limit) - $limit;

//request_status
if($user_type == 'accounting'){
	$requests = "SELECT * FROM request_form WHERE request_status = 'pending' ORDER BY created_at DESC";
	$paginator = "SELECT * FROM request_form WHERE request_status = 'pending' ORDER BY created_at DESC LIMIT $offset, $limit";
}else{
	$requests = "SELECT * FROM request_form  ORDER BY created_at DESC";
	$paginator = "SELECT * FROM request_form ORDER BY created_at DESC LIMIT $offset,$limit";
}
$requestQuery = mysqli_query($conn,$requests) or die(mysqli_error($conn));
$totalrequest = mysqli_num_rows($requestQuery);
$paginatorQuery = mysqli_query($conn,$paginator) or die(mysqli_error($conn));
$pages = ceil($totalrequest/$limit);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="btn-group" role="group" aria-label="...">
        <a href="../shared/logout.php" class='btn btn-primary' >Logout</a>
    	</div>
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

        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Hi <?php echo $firstname . ' ' . $middlename . ' ' . $lastname?>!</h1>

	<div>
 			
 			<h2>Requested Items</h2>
 			<form method="POST" action="home.php">
            	Search: <input type="text" name="search">
            	<div class="btn-group" role="group" aria-label="...">
            	<input class='btn btn-info' type="submit" name="sub_search" value="Search">
            	Date needed: <input type="date" name="date">
            	<input class='btn btn-info' type="submit" name="date_search" value="Search">
            	</div>
            </form>

 			<table class="table table-striped">
              <thead>
                <tr>
                  <th>Request #</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Date Needed</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
			<div class="btn-group" role="group" aria-label="...">
			<?php
			if($user_type == "scis"){

				if (isset($_POST['sub_search'])) {
					$request_search = "SELECT * from request_form where request_id like '%".$search. "%' or use_of_item like '%".$search. "%' or request_status like '%" .$search. "%' ";
					$request_searchQ = mysqli_query($conn,$request_search) or die(mysqli_error($conn));
	            	while($searchrow = mysqli_fetch_array($request_searchQ)){
						echo "<tr><td> RF 00" . $searchrow['request_id'] . "</td>";
						echo "<td>" . $searchrow['use_of_item'] . "</td>";
						echo "<td>" . $searchrow['request_status'] . "</td>";
						echo "<td>" . $searchrow['date_needed'] . "</td>";
						echo "<td>";
						echo "<a href='request_details.php?request_id=" . $searchrow['request_id'] . "' class='btn btn-default' >View Details</a> ";
						if($searchrow['request_status'] != 'pending'){
							echo "<a href='status_report.php?request_id=" . $searchrow['request_id'] . "'>View Status Report</a>";
						}
						
						echo "</td></tr>";
					}
	           	} elseif (isset($_POST['date_search'])){
	           		$req_date = "SELECT * from request_form where date_needed like '%".$date."%' ";
	           		$req_dateQ = mysqli_query($conn,$req_date) or die (mysqli_error($conn));
	           		while($daterow = mysqli_fetch_array($req_dateQ)){
						echo "<tr><td> RF 00" . $daterow['request_id'] . "</td>";
						echo "<td>" . $daterow['use_of_item'] . "</td>";
						echo "<td>" . $daterow['request_status'] . "</td>";
						echo "<td>" . $daterow['date_needed'] . "</td>";
						echo "<td>";
						echo "<a href='request_details.php?request_id=" . $daterow['request_id'] . "'>View Details</a> ";
						if($daterow['request_status'] != 'pending'){
							echo "<a href='status_report.php?request_id=" . $daterow['request_id'] . "'>View Status Report</a>";
						}
						
						echo "</td></tr>";
					}

	            }else{
					while($row = mysqli_fetch_array($paginatorQuery)){
					  	echo "<tr><td> RF 00" . $row['request_id'] . "</td>";
					  	echo "<td>" . $row['use_of_item'] . "</td>";
					  	echo "<td>" . $row['request_status'] . "</td>";
					  	echo "<td>" . $row['date_needed'] . "</td>";
					  	echo "<td>";
					  	echo "<a class='btn btn-info' href='request_details.php?request_id=" . $row['request_id'] . "'>View Details</a> ";
			  		if($row['request_status'] != 'pending'){
			  			echo "<a class='btn btn-warning' href='status_report.php?request_id=" . $row['request_id'] . "'>View Status Report</a>";
			  		}
			  	echo "</td></tr>";
			  }
				}
			} else {
				if (isset($_POST['sub_search'])) {
					echo $date;
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

	           	}elseif (isset($_POST['date_search'])){
	           		$req_date = "SELECT * from request_form where date_needed like '%".$date."%' ";
	           		$req_dateQ = mysqli_query($conn,$req_date) or die (mysqli_error($conn));
	           		while($searchrow = mysqli_fetch_array($req_dateQ)){
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
					while($row = mysqli_fetch_array($paginatorQuery)){
					  	echo "<tr><td> RF 00" . $row['request_id'] . "</td>";
					  	echo "<td>" . $row['use_of_item'] . "</td>";
					  	echo "<td>" . $row['request_status'] . "</td>";
					  	echo "<td>" . $row['date_needed'] . "</td>";
					  	echo "<td>";
					  	echo "<a class='btn btn-info' href='request_details.php?request_id=" . $row['request_id'] . "'>View Details</a> ";
			  		if($row['request_status'] != 'pending'){
			  			echo "<a class='btn btn-warning' href='status_report.php?request_id=" . $row['request_id'] . "'>View Status Report</a>";
			  		}
			  			echo "</td></tr>";
			 		 }
				}
			}	

			?>
			</div>
			</tbody>
			</div>
			</table>
			 	<ul class="pagination">
			 <!--  <li><a href="#">1</a></li>
			  <li class="active"><a href="#">2</a></li>
			  <li><a href="#">3</a></li>
			  <li><a href="#">4</a></li>
			  <li><a href="#">5</a></li> -->
			  	<?php
					if($current_page == 1){
						echo "<li class='disabled'><a href='javascipt:void(0)'>&laquo;</li>";
					}else{
						echo "<li><a href='home.php?page=" .($current_page - 1). "'>&laquo;</a></li>";
					}
					for($var = 1; $var <= $pages; $var++){
						echo "<li><a href='home.php?page=" .$var. "'>" .$var."</a></li>";
					}
					if($current_page == $pages){
						echo "<li class='disabled'><a href='javascipt:void(0)'>&raquo;</a></li>";
					}else{
						echo "<li><a href='home.php?page=" .($current_page + 1). "'>&raquo;</a></li>";
					}
				?>
			</ul>
			
 		</div> 		
 	</div>
 </div>
</div>


</body>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../assets/js/boostrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/viewport.js"></script>
</html>

