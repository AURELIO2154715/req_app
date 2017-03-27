<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

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
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Change password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap core CSS -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/main.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../assets/css/dashboard.css" rel="stylesheet"> </head>

    <body>
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggleroggler-icon"></span> </button> <a class="navbar-brand" href="../dashboard/home.php">SCIS REQUISITION SYSTEM</a>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto"> </ul>
                <?php
        echo "<a href='../dashboard/profile.php' class='nav-link'>" . $firstname . ' ' . $middlename . ' ' . $lastname . "</a>";
        ?>
                    <div class="btn-group" role="group" aria-label="..."> <a href="../shared/logout.php" class='btn btn-primary'>Logout</a> </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item"> <a class='nav-link' href="home.php">Home</a> </li>
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
            ?> </li>
                                <li class="nav-item"> <a href="../dashboard/profile.php" class='nav-link active'>Profile</a> </li>
                    </ul>
                </nav>
                <div class="req_form">
                    <?php 
       
       
        $user_pass = "Select password from users where users.id = '$user_id';";     
        $user_passQ = mysqli_query($conn,$user_pass) or die(mysqli_error($conn));
    
        if (isset($_POST['newpass']) && isset($_POST['connewpass']) &&    isset($_POST['oldpass'])){
            $newpass = $_POST['newpass'];
            $connewpass = $_POST['connewpass'];
            $oldpass = $_POST['oldpass'];
        }
        
        $user = mysqli_fetch_array($user_passQ);
        
        echo "<h2>Change password</h2>";
        echo "<form method='POST' action = 'change_password.php'>";  
        echo "Current Password:<br>" . "<input type='password' name='oldpass'> <br>";
        echo "New Password:<br>" . "<input type='password' name='newpass'> <br>"; 
        echo "Confirm New Password<br>" . "<input type='password' name='connewpass'> <br>";
        echo "<input type='submit' name='change'  class='btn btn-primary'value='Change'>";
        echo "</form>";
    
        if(isset($_POST['change'])){
    
            if ($newpass == $connewpass &&
            password_verify($oldpass,$user['password'])) {
                
                $newpass = password_hash($_POST['newpass'],PASSWORD_DEFAULT);
                $updatepass = "UPDATE users SET password = '$newpass' where id = '$user_id'";
                $upadatepassQ = mysqli_query($conn, $updatepass);
                echo "success";
                session_unset();
                session_destroy();
                header("Location: ../index.php");
                exit;

            } else {
                echo "Password DOESN'T match!";
            }
        }
 
    ?> </body>
    </html>