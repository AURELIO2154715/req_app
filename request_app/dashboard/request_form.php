<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
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

if(isset($_POST['addrequest'])){
	$user_id = $_SESSION['user_id'];
	$request_status = 'pending';
	$user_of_item = $_POST['reason'];
	$date_needed = $_POST['date_needed'];
	$quantity = $_POST['quantity'];
	$items = $_POST['item'];
	

	$request = "INSERT INTO request_form (requested_by,request_status,use_of_item,date_needed,created_at,updated_at) VALUES ('$user_id','$request_status','$user_of_item','$date_needed',now(),now())";
	$requestQuery = mysqli_query($conn,$request);
	if($requestQuery){
		//get inserted id
		$request_form_id = mysqli_insert_id($conn);
		//loop on items to be saved on database
		for ($i=0; $i < count($quantity); $i++) { 
		# query
			// echo $items[$i] . '<br>';
			$item = "INSERT INTO items (quantity,description,request_form_id,created_at,updated_at) VALUES ('$quantity[$i]','$items[$i]','$request_form_id',now(),now())";
			$itemQuery = mysqli_query($conn,$item);
			if($itemQuery){
				//why ngay
			}else{
				echo "Error: " + $item . mysqli_error($conn);
			}
		}

		//redirect after loop
		header("Location: home.php");
		die();

	}else{
		echo "Error: " . $request . mysqli_error($conn); 
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Request Form</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/main.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">
	</head>
<body>
	<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
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
              <a href="home.php" class='nav-link'>Home </a>
            </li>
           <li class="nav-item">
            <?php
        if($user_type=='scis'){
            echo "<a href='request_form.php' class='nav-link active'>Add New Request<span class='sr-only'>(current)</span></a>";

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
   

	<div class = "req_form">
		<h1>Request Form</h1>
		<form method="POST" action="request_form.php">
			<div class="container">
    		<div class="row col-md-6 col-md-offset-2 custyle">
			<table class="table table-striped custab">
				<thead>
					<tr>
				    	<th>Quantity</th>
				    	<th>Item</th> 
				    	<th>Action</th>
				  	</tr>
			  	</thead>
			  	<tbody id="items">
				  	<tr>
				  		<td><input type="text" name="quantity[]"></td>
				  		<td><input type="text" name="item[]"></td>
				  		<td><button type="button" onclick="event.srcElement.parentElement.parentElement.remove()" class="remove">Delete</button></td>
				  	</tr>
			  	</tbody>
			</table>
			<button type="button" class="addItem" onclick="addItem()">Add another Item</button>			
			<p id="para">Use of Item:</p> <br><textarea name="reason" rows="4" cols="50" id="use"></textarea><br>
			<p id="para">Date needed: </p><input type="date" name="date_needed "><br>
			<input type="submit" name="addrequest" value="Submit Request">
		</form>
		</div>
		</div>
	</div>

</body>
<script type="text/javascript">
(function() {
   // your page initialization code here
   // the DOM will be available here

})();

function addItem(){
	var quantity = document.createElement('input');
	quantity.setAttribute('type','text');
	quantity.setAttribute('name','quantity[]');

	var item = document.createElement('input');
	item.setAttribute('type','text');
	item.setAttribute('name', 'item[]');

	var removeBtn = document.createElement('button');
	var textnode = document.createTextNode('Delete');
	removeBtn.appendChild(textnode);
	removeBtn.setAttribute('type','button');
	removeBtn.setAttribute('onclick','event.srcElement.parentElement.parentElement.remove()');
	

	var quantityTD = document.createElement('td');
	quantityTD.appendChild(quantity);

	var itemTD = document.createElement('td');
	itemTD.appendChild(item);

	var btnTd = document.createElement('td');
	btnTd.appendChild(removeBtn);

	var row = document.createElement('tr');
	row.appendChild(quantityTD);
	row.appendChild(itemTD);
	row.appendChild(btnTd);


	var tablebody = document.getElementById('items');
	tablebody.appendChild(row);
}

</script>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../assets/js/boostrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/viewport.js"></script>
</html>