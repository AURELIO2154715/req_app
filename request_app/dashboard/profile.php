<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
    </head>
    <body>
        <?php 
            include '../shared/session.php';
            include '../shared/connection.php';
            $user_id = $_SESSION['user_id'];
            $user_type = $_SESSION['user_type'];
            $user_info = "Select users.id, username, user_type, password,firstname, middlename, lastname from users inner join user_details on users.id = user_id where users.id = '$user_id';";
            
            $requests = "SELECT * FROM request_form WHERE requested_by = '$user_id' ORDER BY created_at DESC"; 
        
            $req_accounting = "SELECT request_id, received_by, request_status, use_of_item, date_needed,request_form.created_at FROM request_form INNER JOIN status_report ON request_form_id = requested_by WHERE received_by = '6'"; 
            
            $request_accountingQuery = mysqli_query($conn,$req_accounting) or die(mysqli_error($conn));
        
            $requestQuery = mysqli_query($conn,$requests) or die(mysqli_error($conn));
               
            $user_infoQ = mysqli_query($conn,$user_info) or die(mysqli_error($conn)); 
        
        ?>
        <a href="../dashboard/home.php">Home</a>
        <a href="../dashboard/change_password.php">Change Password</a>
        <h1>Profile</h1>
       
        <?php
            $user = mysqli_fetch_array($user_infoQ);
            echo "<b>User ID: </b>" . $user['id'] . "<br>";
            echo "<b>Username: </b>" . $user['username'] . "<br>";
            echo "<b>User Type: </b>" . $user['user_type'] . "<br>";
            echo "<b>First Name: </b>" . $user['firstname'] . "<br>";
            echo "<b>Middle Name: </b>" . $user['middlename'] . "<br>";
            echo "<b>Last Name: </b>" . $user['lastname'] . "<br>";
        
            if ($user['user_type'] == "scis"){
                echo "<h2>Requested Items</h2>" . "<table style='width:50%' border='1'>";
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
                    echo "< td><a href='request_details.php?request_id=" . $log['request_id'] . "'>View Details</a></td></tr>"; 
                }
                
            } else {
                echo "<h2>Request Log</h2>" . "<table style='width:50%' border='1'>";
                echo"<tr><th>Request No.</th>";
                echo "<th>Use for</th>" ;
                echo "<th>Status</th>";
                echo "<th>Date Needed</th>";
                echo "<th>Action</th></tr>";
               
                while ($log = mysqli_fetch_array($request_accountingQuery)){
                    echo "<tr><td> RF 00" . $log['request_id'] . "</td>";
                    echo "<td>" . $log['use_of_item'] . "</td>";
                    echo "<td>" . $log['request_status'] . "</td>";
                    echo "<td>" . $log['date_needed'] . "</td>";
                    echo "<td><a href='request_details.php?request_id=" . $log['request_id'] . "'>View Details</a></td></tr>"; 
                }
            }
        ?>
        
    </body>
</html>