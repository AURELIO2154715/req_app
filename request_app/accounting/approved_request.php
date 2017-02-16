<?php 
include '../shared/connection.php';
include '../shared/session.php';
$userid = $_SESSION['user_id'];
$userSTR = "SELECT concat(firstname, ' ',middlename,' ',lastname) 'name' from users natural join user_details where user_details.user_id='$userid'";
$userqry = mysqli_query($conn,$userSTR);
$userArr = mysqli_fetch_array($userqry, MYSQLI_ASSOC);
$rowuser = $userArr['name'];

$query = "INSERT INTO status_report (received_by,created_at,update_at) VALUES ('$rowuser',now(),now())";
mysqli_query($conn,$query);



 ?>