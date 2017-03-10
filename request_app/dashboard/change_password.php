<!DOCTYPE html>
<html>
<head>
    <title>Change password</title>
</head>
<body>
    <?php 
        include '../shared/session.php';
        include '../shared/connection.php';
        $user_id = $_SESSION['user_id'];
        $user_type = $_SESSION['user_type'];
       
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
        echo "<input type='submit' name='change' value='change'>";
        echo "</form>";
    
        if(isset($_POST['change'])){
    
            if ($newpass == $connewpass &&
            password_verify($oldpass,$user['password'])) {
                
                $newpass = password_hash($_POST['newpass'],PASSWORD_DEFAULT);
                $updatepass = "UPDATE users SET password = '$newpass' where id = '$user_id'";
                $upadatepassQ = mysqli_query($conn, $updatepass);
                echo "success";

            } else {
                echo "Password DOESN'T match!";
            }
        }
 
    ?>
     <a href="../dashboard/home.php">Home</a>
    <a href="../dashboard/profile.php">Back</a>
</body>
</html>