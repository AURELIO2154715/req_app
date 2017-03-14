<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

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

$userAdmin = $_SESSION['user_id'];
$user_disabled = "SELECT users.id,username,user_type,CONCAT(firstname, ' ', lastname) 'name', users.created_at,user_status FROM users INNER JOIN user_details ON users.id=user_id WHERE user_id!=1";
$user_disabledQ = mysqli_query($conn,$user_disabled) or die(mysqli_error($conn)); 
  
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Activate Account</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/dashboard.css" rel="stylesheet">

    </head>
    <body>
    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggleroggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../dashboard/home.php" >SCIS REQUISITION SYSTEM</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
        </ul>
        <?php
        echo "<a href='../dashboard/profile.php' class='nav-link'>" . $firstname . ' ' . $middlename . ' ' . $lastname . "</a>";
        ?>
          <a href="../shared/logout.php" class='nav-link' >Logout</a>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a href="home.php" class='nav-link'>Home </a>
            </li>
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
                    echo "<a href='activator.php' class='nav-link active'>Manage Accounts<span class='sr-only'>(current)</span></a>";
                }
            ?>
            </li>          
            <li class="nav-item">
              <a href="../dashboard/profile.php" class='nav-link' >Profile</a>
            </li>

            
          </ul>
          </nav>
</div>
</div>

        <div class = "req_form">
        <h1>Activate Accounts</h1>
        <div>
        <table table class="table table-striped">
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
              

        </div>
    </body>
</html
