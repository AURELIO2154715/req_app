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
    <link type="text/css" href="altstyles.css" rel="stylesheet" media="all" />
    
    <title>Request App</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">



</head>


<body>
<!--
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <img src="img/scislogin1.png" class="img-responsive" id="asd" alt="" />
        </div>
         <div class="modal-body">
             <div class="form-group">

                 <input type="text" class="form-control input-lg" placeholder="Username"/>
             </div>

             <div class="form-group">
                 <input type="password" class="form-control input-lg" placeholder="Password"/>
             </div>

             <div class="form-group">
                 <input type="submit" class="btn btn-block btn-lg btn-primary" value="Login"/>
                 <span class="pull-right"><a href="#">Register</a></span><span><a href="#">Forgot Password</a></span>
             </div>
         </div>
    </div>
 </div>
-->

<div class="container">
        <div class="row" id="pwd-container">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <section class="login-form">
                    <form method="POST" action="index.php" role="login"> 
                        <img src="img/scislogin1.png" class="img-responsive" alt="" />
                        <input type="text" name="username" placeholder="Username" class="form-control input-lg"/>
                        <input type="password" name="password" class="form-control input-lg" placeholder="Password" required="" />
                        <br>
                        <div class="pwstrength_viewport_progress"></div>
                        <button type="submit" name="login" class="btn btn-lg btn-primary btn-block" value ="Login">Sign in</button>
                        <div> <a href="shared/register.php">Create account</a></div>
                        <div> <a href="index2.php">Alt Login</a></div>
                     </form>
                </section>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>


</body>

</html>