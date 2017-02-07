<?php
include '../shared/session.php';
include '../shared/connection.php';
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
</head>
<body>
	<div>
		<h1>Request Form</h1>
		<a href="home.php">Back to Home</a>
		<form method="POST" action="request_form.php">
			<table border="1">
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
				  		<td><button type="button" onclick="event.srcElement.parentElement.parentElement.remove()" class="remove">X</button></td>
				  	</tr>
			  	</tbody>
			</table>
			<button type="button" class="addItem" onclick="addItem()">Add another Item</button><br>
			Use of Item: <br><textarea name="reason" rows="4" cols="50"></textarea><br>
			Date needed: <input type="date" name="date_needed"><br>
			<input type="submit" name="addrequest" value="Submit Request">
		</form>
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
	var textnode = document.createTextNode('X');
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
</html>