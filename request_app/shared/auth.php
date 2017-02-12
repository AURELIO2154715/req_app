<?php
	if (isset($_POST['login'])){
	include 'connection.php';
		$username = $_POST['username'];
		$password = $_POST['password'];

		$querystring = "SELECT id,username,user_type,password FROM users WHERE username='$username' AND user_status='active' LIMIT 1";
		$query = mysqli_query($conn,$querystring);
		if($query){
			$result = mysqli_num_rows($query);
			if($result > 0){
				$row = mysqli_fetch_array($query,MYSQLI_ASSOC);	
				if(password_verify($password,$row['password'])){
					//store sessions
					session_start();
					$_SESSION['user_id'] = $row['id'];
					$_SESSION['user_type'] = $row['user_type'];
					
					//redirect to dashboard
					header("location: dashboard/home.php");
				}
			}

		}else{
			$result = 0;
		}
		
		
		// if($result == 1){
		// header("location: dashboard.php");
		// $_SESSION['gwenn'] = true;
		// }else{
		// 	echo"Invalid Credentials!";
		// }
		
		// if($username == "admin" && $password == "admin"){
		// header("location: try.php");
		// $_SESSION['gwenn'] = true;
		
		// }
	
	}

?>