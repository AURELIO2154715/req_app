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
    <link href="../assets/css/dashboard.css" rel="stylesheet">
</head>
<body>


<div class="center"><button data-toggle="modal" data-target="#squarespaceModal" class="btn btn-primary center-block">Click Me</button></div>


<!-- line modal -->
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel">My Modal</h3>
        </div>
        <div class="modal-body">
            
            <!-- content goes here -->
            <form>
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile">
                <p class="help-block">Example block-level help text here.</p>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox"> Check me out
                </label>
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>

        </div>
        <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                </div>
                <div class="btn-group btn-delete hidden" role="group">
                    <button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal"  role="button">Delete</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" id="saveImage" class="btn btn-default btn-hover-green" data-action="save" role="button">Save</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

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
                session_unset();
                session_destroy();
                header("Location: ../index.php");
                exit;

            } else {
                echo "Password DOESN'T match!";
            }
        }
 
    ?>
     <a href="../dashboard/home.php">Home</a>
    <a href="../dashboard/profile.php">Back</a>
</body>
</html>