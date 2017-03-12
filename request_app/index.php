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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="styles/styles.css" rel="stylesheet" media="all" />

    <title>Request App</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


</head>


<body>
    <div class="container">
        <div class="row" id="pwd-container">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <section class="login-form">
                    <form method="POST" action="index.php" role="login"> 
                        <img src="img/scislogin1.png" class="img-responsive" alt="" />
                        <input type="text" name="username" placeholder="Username" class="form-control input-lg"/>
                        <input type="password" name="password" class="form-control input-lg" placeholder="Password" required="" />
                        <div class="pwstrength_viewport_progress"></div>
                        <button type="submit" name="login" class="btn btn-lg btn-primary btn-block" value ="Login">Sign in</button>
                        <div> <a data-toggle="modal" data-target="#squarespaceModal" class="btn btn-lg btn-primary btn-block">Create account</a></div>
                        <a href="shared/register.php">Register.php</a>
                     </form>
                </section>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>


    <div class="center"><button data-toggle="modal" data-target="#squarespaceModal" class="btn btn-primary center-block">Click Me</button></div>
    
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
            
        }
    }

?>

<!-- line modal -->
<div>
 <?php
        if(isset($_GET['error']) && $_GET['error'] == 'usernameTaken'){
            echo "Username Already Taken";
        }
        ?>   
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel">Register</h3>
        </div>
        <div class="modal-body">
            
            <!-- content goes here -->
            <form method="POST" action="register.php" role="register">
              <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" name="username" placeholder="JuanDC" required class="form-control input-lg" >
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password" required="" />
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password</label>
               <div class="pwstrength_viewport_progress"></div>
            <input  type="password" name="cpassword" class="form-control input-lg" id="password" placeholder="Confirm Password"/>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">User Type</label>
            <select name="user_type" class="form-control">
                <option value="scis">SCIS</option>  
                <option value="accounting">Accounting</option>  
            </select>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">First Name</label>
               <input type="text" name="firstname" placeholder="Juan" required class="form-control input-lg">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Middle Name</label>
               <input type="text" name="middlename" placeholder="Dalisay" required class="form-control input-lg">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Last Name</label>
               <input type="text" name="lastname" placeholder="Dela Cruz" required class="form-control input-lg">
              </div>

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
                    <button id="saveImage" class="btn btn-default btn-hover-green" data-action="save" type="submit" name="register">Submit</button>
            </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
</div>
</body>

</html>