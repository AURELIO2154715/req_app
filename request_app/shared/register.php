<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
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
		<form method="POST" action="register.php">
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br>
            Confirm Password: <input type="password" name="cpassword"><br>
			User Type:
			<select name="user_type">
				<option value="scis">SCIS</option>	
				<option value="accounting">Accounting</option>	
			</select><br>
			First Name: <input type="text" name="firstname"><br>
			Middle Name: <input type="text" name="middlename"><br>
			Last Name: <input type="text" name="lastname"><br>
			<input type="submit" name="register" value="Register">
		</form>
		<a href="../index.php">Back</a>	
	</div>
</body>
</html>