<?php
include '../shared/session.php';
include '../shared/connection.php';

$userAdmin = $_SESSION['user_id'];
$user_disabled = "SELECT users.id,username,user_type,CONCAT(firstname, ' ', lastname) 'name', users.created_at,user_status FROM users INNER JOIN user_details ON users.id=user_id WHERE user_id!=1";
$user_disabledQ = mysqli_query($conn,$user_disabled) or die(mysqli_error($conn)); 
  
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Activate Account</title>

    </head>
    <body>
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
                // if($user['user_status'] == 'active'){ 
                //     echo "<td>eyo</td></tr>";
                //     // echo "<td><input type='button' onclick='Disable()' value='Disable'></td></tr>";
                //     // $wew = "UPDATE user SET user_status='active' WHERE id='$user['id']'";
                //     // $wewQ = mysqli_query($conn,$wew);

                // }else if($user['user_status'] =='disabled'){
                //     echo "<td>disable</td></tr>";
                //          // echo "<meta http-equiv='refresh' content='0'>";
                    
                // }

                    // echo "<td><input type='checkbox' name='active' value='active'>Activate<br></td></tr>";
                    // $wew1 = "UPDATE user SET user_status='disable' WHERE id='$user['id']'";
                    // $wewQ1 = mysqli_query($conn,$wew);
                
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
            $wew = "UPDATE users SET user_status='active' WHERE username='$username'";
            $wewQ = mysqli_query($conn,$wew);
            echo "success";
            echo "<meta http-equiv='refresh' content='0'>";

        }
        if(isset($_POST['disabled'])){
            $username = $_POST['user'];
            $wew = "UPDATE users SET user_status='disabled' WHERE username='$username'";
            $wewQ = mysqli_query($conn,$wew);
            echo "<meta http-equiv='refresh' content='0'>";
        }



        ?>
                
              

    </body>
<script>
</script>
</html
