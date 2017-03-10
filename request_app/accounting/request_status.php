<?php
include '../shared/session.php';
include '../shared/connection.php';
$user_type=$_SESSION['user_type'];
$user_id=$_SESSION['user_id'];
$request_id = $_GET['request_id'];
$form_status = $_GET['status'];

if(isset($_POST['goBtn'])){
	$reason = $_POST['reason'];
	$request_id = $_GET['request_id'];
	$form_status = $_GET['status'];
	//$var = $_FILE['doc']['name'];
	//	//totoyB.jpeg
	//$temp = ['totoyB','jpeg'];
	
	if($form_status == "approve"){
		$target_dir = "../uploads/";
		$temp = explode(".", $_FILES["doc"]["name"]);
		$newfilename = round(microtime(true)) . '.' . end($temp);
		$target_file = $target_dir . $newfilename;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		//allow certain file formats
	// if(!isset($_FILES['doc'])){
		// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		// 	&& $imageFileType != "gif" ) {
		// 	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		// 	    $uploadOk = 0;
		// }
	// }


		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["doc"]["tmp_name"], $target_file)) {
		    	//save data on database
		    	//query on status report
		    // ======================added if statement
		    if(isset($newfilename)){
		    	$status_report_query = "INSERT INTO status_report (received_by,request_form_id,remarks,filename,created_at,updated_at) VALUES ($user_id,$request_id,'$reason','$newfilename',now(),now())";
		    }else{
		    	$status_report_query = "INSERT INTO status_report (received_by,request_form_id,remarks,filename,created_at,updated_at) VALUES ($user_id,$request_id,'$reason','NULL',now(),now())";
		    }
		    // ======================added if statement
		    	if(mysqli_query($conn, $status_report_query)){
		    		//if success update status on request form table
		    		$updateRequest = "UPDATE request_form SET request_status='approved' WHERE request_id=$request_id";
		    		if(mysqli_query($conn,$updateRequest)){
		    			header('Location: ../dashboard/home.php');
		    		}else{
		    			echo "Error " . $updateRequest . mysqli_error($conn);
		    		}
		    	}else{
		    		echo "Error " . $status_report_query . mysqli_error($conn);
		    	}
		        echo "The file ". basename( $_FILES["doc"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
	}else{
		//if reject
		$status_report_query = "INSERT INTO status_report (received_by,request_form_id,remarks,created_at,updated_at) VALUES ($user_id,$request_id,'$reason',now(),now())";
		if(mysqli_query($conn,$status_report_query)){
			$updateRequest = "UPDATE request_form SET request_status='rejected' WHERE request_id=$request_id";
    		if(mysqli_query($conn,$updateRequest)){
    			header('Location: ../dashboard/home.php');
    		}else{
    			echo "Error " . $updateRequest . mysqli_error($conn);
    		}
		}else{
			echo "Error " . $status_report_query . mysqli_error($conn);
		}
	}
	
}//isset
?><!DOCTYPE html>
<html>
<head>
	<title>Request Form Status</title>
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
              <a href="home.php" class='nav-link'>Home </a>
            </li>
    <li class="nav-item">
            <?php
        if($user_type=='scis'){
            echo "<a href='request_form.php' class='nav-link'>Add New Request</a>";

        }else{
            echo "<a href='../accounting/approved.php' class='nav-link'> Approved Requests </a>";
            echo "<a href='../accounting/rejected.php' class='nav-link active'> Rejected Requests <span class='sr-only'>(current)</span></a>";
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

	<div class="req_form">
		<a href="../dashboard/request_details.php?request_id=<?php echo $request_id?>">Back to Request Form Details</a>
		<h1>
			<?php if($form_status == 'approve'){
				echo "Approve";
			}else{
				echo "Reject";
			}
			?> Form
		</h1>
		<form method="POST" action="request_status.php?request_id=<?php echo $request_id?>&&status=<?php echo $form_status?>" enctype="multipart/form-data">
			Reason: <textarea name="reason"></textarea><br><br>
			<?php
			if($form_status == 'approve'){
				echo "Upload Document : <input type='file' name='doc'> <br><br>";
			}
			?>
			<input type="submit" name="goBtn" value="Submit">
		</form>
	</div>
</body>
</html>