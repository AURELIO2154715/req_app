<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="styles/styles.css" rel="stylesheet" media="all" />
    <title>Request App</title>
    <script src="styles/stylesJS.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">


</head>

<?php
session_start();
if(isset($_SESSION['user_id'])){
    header('Location: dashboard/home.php');
}
include 'shared/auth.php';
?>

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
                        <div> <a href="shared/register.php">Create account</a></div>
                    </form>
                </section>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>

</html>