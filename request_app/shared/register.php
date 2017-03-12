<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="../styles/styles.css" rel="stylesheet" media="all" />
    <title>Request App</title>
    <script src="../styles/stylesJS.js"></script>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>


                        
      


<?php
	if (isset($_POST['username'])){
	include 'connection.php';
		$username = $_POST['username'];
		$password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
		$usertype = $_POST['user_type'];
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$status = 'disabled';

		//check if username exist
		$check = "SELECT username FROM users WHERE username = '$username'";
		$checkQuery = mysqli_query($conn,$check);
		if($checkQuery){
			$result = mysqli_num_rows($checkQuery);
			if($result > 0){
				//already exist
				header("Location: register.php?error=usernameTaken");
				die();
			}
		}else{
			echo "Error: " . $check . mysqli_error($conn);
		}

        if($password == $cpassword){
            
            $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
            $usersQuery = "INSERT INTO users (username,password,user_type,user_status,created_at,updated_at) VALUES ('$username','$password','$usertype','$status',now(),now())";
            if(mysqli_query($conn, $usersQuery)){
                $user_id = mysqli_insert_id($conn);
                $userDetailsQuery = "INSERT INTO user_details (user_id,firstname,middlename,lastname,created_at,updated_at) VALUES ($user_id,'$firstname','$middlename','$lastname',now(),now())";
                if(mysqli_query($conn,$userDetailsQuery)){
                    header("location: ../index.php");
                }else{
                    echo "Error " . $userDetailsQuery . mysqli_error($conn);
                }
            }else{
                echo "Error " . $usersQuery . mysqli_error($conn);
            }
            
        }else{
            echo "Password doesn't match!";
        }
	}

?>

	<div>
		<?php
		if(isset($_GET['error']) && $_GET['error'] == 'usernameTaken'){
			echo "Username Already Taken";
		}
		?>
		<div class="container">
        <div class="row" id="pwd-container">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <section class="login-form">

		<form method="POST" action="registe 	r.php" role="register">
			 <input type="text" name="username" placeholder="Username" required class="form-control input-lg" /><br>
			 <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password" required="" /><br>
			<div class="pwstrength_viewport_progress"></div>
            <input  type="password" name="cpassword" class="form-control input-lg" id="password" placeholder="Confirm Password"/><br>
			User Type:
			<select name="user_type">
				<option value="scis">SCIS</option>	
				<option value="accounting">Accounting</option>	
			</select><br>
			<input type="text" name="firstname" placeholder="First Name" required class="form-control input-lg"><br>
			<input type="text" name="middlename" placeholder="Middle Name" required class="form-control input-lg"><br>
			<input type="text" name="lastname"  placeholder="Last Name" required class="form-control input-lg"><br>
			<input type="submit" name="register" value="Register">
		</form>
         </section>

            </div>
            <div class="col-md-4"></div>
		<a href="../index.php">Back</a>	
	</div>
	 </div>
    </div>
</div>
</body>
</html>