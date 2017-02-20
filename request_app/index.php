<?php
session_start();
if(isset($_SESSION['user_id'])){
	header('Location: dashboard/home.php');
}
include 'shared/auth.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Request App</title>
</head>
<body>
	<div>
	<p>Not a member yet? <a href="shared/register.php">Register</a></p>
		<form method="POST" action="index.php">
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br>
			<input type="submit" name="login" value="Login">
		</form>
	</div><br><br>
</body>
</html>
