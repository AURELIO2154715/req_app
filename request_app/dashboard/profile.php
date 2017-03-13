        <?php 
            include '../shared/session.php';
            include '../shared/connection.php';
            $user_id = $_SESSION['user_id'];
            $user_type = $_SESSION['user_type'];
            if (isset($_POST['search'])) {
            $search = $_POST['search'];
            }
            $user_info = "Select users.id, username, user_type, password,firstname, middlename, lastname from users inner join user_details on users.id = user_id where users.id = '$user_id';";
            
            $requests = "SELECT * FROM request_form WHERE requested_by = '$user_id' ORDER BY created_at DESC"; 
        
            $req_accounting = "SELECT request_id, received_by, request_status, use_of_item, date_needed,request_form.created_at FROM request_form INNER JOIN status_report ON request_form_id = requested_by WHERE received_by = '6' group by 1"; 
            
            $request_accountingQuery = mysqli_query($conn,$req_accounting) or die(mysqli_error($conn));
        
            $requestQuery = mysqli_query($conn,$requests) or die(mysqli_error($conn));
               
            $user_infoQ = mysqli_query($conn,$user_info) or die(mysqli_error($conn)); 
        
        ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">

    </head>
    <body>
    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggleroggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#" >SCIS REQUISITION SYSTEM</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          
        </ul>
        <a href="../shared/logout.php" class='nav-link' >Logout</a>
      </div>
    </nav>

     <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class='nav-link' href="home.php">Home</a>
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
                    echo "<a href='activator.php' class='nav-link'>Manage Accounts</a>";
                }
            ?>
            </li>
            <li class="nav-item">
              <a href="../dashboard/profile.php" class='nav-link active' >Profile<span class='sr-only'>(current)</span></a>
            </li>

            
          </ul>

          

          </nav>

  
        <div class="req_form">
        <h1>Profile</h1>
        <a href="../dashboard/change_password.php" data-toggle="modal" data-target="#squarespaceModal">Change Password</a>
        <br>
        <?php
            $user = mysqli_fetch_array($user_infoQ);
            echo "<b>User ID: </b>" . $user['id'] . "<br>";
            echo "<b>Username: </b>" . $user['username'] . "<br>";
            echo "<b>User Type: </b>" . $user['user_type'] . "<br>";
            echo "<b>First Name: </b>" . $user['firstname'] . "<br>";
            echo "<b>Middle Name: </b>" . $user['middlename'] . "<br>";
            echo "<b>Last Name: </b>" . $user['lastname'] . "<br>";

            ?>

        <br>
            <?php    
            if(mysqli_num_rows($requestQuery)==0 && $user['user_type'] =='scis'){
                echo "<p style='background-color:grey;'> You did not request anything :) </p>";
            }else{
                if ($user['user_type'] == "scis"){
                    echo "<h5>Requested Items</h5>";
                    echo "<table class='table table-striped'>";
                    echo"<tr><th>Request No.</th>";
                    echo "<th>Request Description</th>";
                    echo "<th>Status</th>";
                    echo "<th>Date Needed</th>";
                    echo "<th>Action</th></tr>" ;  

                    while ($log = mysqli_fetch_array($requestQuery)) {
                        echo "<tr><td> RF 00" . $log['request_id'] . "</td>";
                        echo "<td>" . $log['use_of_item'] . "</td>";
                        echo "<td>" . $log['request_status'] . "</td>";
                        echo "<td>" . $log['date_needed'] . "</td>";
                        echo "<td><a href='request_details.php?request_id=" . $log['request_id'] . "'>View Details</a></td></tr>"; 
                    }
                    
                } else {
                    // echo "<h2>Request Log</h2>" . "<table style='width:50%' border='1'>";
                    // echo"<tr><th>Request No.</th>";
                    // echo "<th>Use for</th>" ;
                    // echo "<th>Status</th>";
                    // echo "<th>Date Needed</th>";
                    // echo "<th>Action</th></tr>";
                   
                    while ($log = mysqli_fetch_array($request_accountingQuery)){
                        echo "<tr><td> RF 00" . $log['request_id'] . "</td>";
                        echo "<td>" . $log['use_of_item'] . "</td>";
                        echo "<td>" . $log['request_status'] . "</td>";
                        echo "<td>" . $log['date_needed'] . "</td>";
                        echo "<td><a href='request_details.php?request_id=" . $log['request_id'] . "'>View Details</a></td></tr>"; 
                    }
                }
            }
        ?>
    </table>
       </div>
</div>
    </div>
    </body>
</html>