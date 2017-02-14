<?php
include '../shared/session.php';
include '../shared/connection.php';

$userAdmin = $_SESSION['user_id'];
$user_disabled = "SELECT users.id,username,user_type,CONCAT(firstname, ' ', lastname) 'name', users.created_at,user_status FROM users INNER JOIN user_details ON users.id=user_id WHERE user_id!=1";
$user_disabledQ = mysqli_query($conn,$user_disabled) or die(mysqli_error($conn)); 
  
?>

<!DOCTYPE html>
<html>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../assets/main.css"/>
    <head>
        <title>Activate Account</title>

    </head>
    <body>
        <a href="../shared/logout.php" style="float:right">Logout</a>
        <h1>Activate Accounts</h1>
        <a href="home.php">Back to Home</a>
        <div>
        <table border="1" width='60%'>
        <tr>
            <th>User ID </th>
            <th>User Name </th>
            <th>User Type</th>
            <th>Name</th>
            <th>User status </th>
            <th>Date Created</th>

        </tr>

         <?php
         // $wew = "UPDATE user SET user_status='active'";
               while($user = mysqli_fetch_array($user_disabledQ)){
                echo "<tr><td>" . $user['id'] . "</td>";
                echo "<td>" . $user['username'] . "</td>";
                echo "<td>" . $user['user_type'] . "</td>";
                echo "<td>" . $user['name'] . "</td>";
                echo "<td>" . $user['user_status'] . "</td>";
                echo "<td>" . $user['created_at'] . "</td></tr>";
                
               }
              ?>
       
        </table>
        <?php
        echo "<h2> Input Username to Activate/Disable </h2>";
        echo "<form method='POST' action='activator.php'>";
        echo "Username: <input type='text' name='user'>";
        echo "<input type='submit' name='active' value='Activate'>";
        echo "<input type='submit' name='disabled' value='Disable'>";
        echo "</form>";

        if(isset($_POST['active'])){
            $username = $_POST['user'];
            //chcker
            $checkStr = "SELECT username FROM users WHERE username='$username'";
            $checkQ = mysqli_query($conn,$checkStr);
            $checkRow = mysqli_num_rows($checkQ);
            if($checkRow > 0){
                $wew = "UPDATE users SET user_status='active' WHERE username='$username'";
                $wewQ = mysqli_query($conn,$wew);
                echo "<meta http-equiv='refresh' content='0'>";
                header("Location: activator.php?success=success");
            }else{
                echo "Username not found!";
            }

        }
        if(isset($_POST['disabled'])){
            $username = $_POST['user'];
            //chcker
            $checkStr = "SELECT username FROM users WHERE username='$username'";
            $checkQ = mysqli_query($conn,$checkStr);
            $checkRow = mysqli_num_rows($checkQ);
            if($checkRow > 0){
                $wew = "UPDATE users SET user_status='disabled' WHERE username='$username'";
                $wewQ = mysqli_query($conn,$wew);
                echo "<meta http-equiv='refresh' content='0'>";
                header("Location: activator.php?nope=nope");
            }else{
                echo "Username not found!";
            }
        }
        
        ?>

        <?php
        if(isset($_GET['success']) && $_GET['success'] == 'success'){
            echo "Successfully Activated Username!";
        }
        if(isset($_GET['nope']) && $_GET['nope'] == 'nope'){
            echo "<div class='mess'><p>Successfully Disabled Username!</p></div>";
        }
        ?>   
              

    </body>
</html
