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

		//CHECK KUNG HINDI EMPTY, CHECK MO YUNG FORMAT. PAG EMPTY NAMNAN BOLSHET SKIP NA
		if(!empty($FILES_['doc']['name'])){
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				//allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ) {
					    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					    $uploadOk = 0;
				}
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			//ifempty query only set to null
			if(empty($_FILES['doc']['name'])){
			    $status_report_query = "INSERT INTO status_report (received_by,request_form_id,remarks,filename,created_at,updated_at) VALUES ($user_id,$request_id,'$reason','NULL',now(),now())";
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
			}else{//if not empty upload
				if (move_uploaded_file($_FILES["doc"]["tmp_name"], $target_file)) {
			    	//save data on database
			    	//query on status report
			    	$status_report_query = "INSERT INTO status_report (received_by,request_form_id,remarks,filename,created_at,updated_at) VALUES ($user_id,$request_id,'$reason','$newfilename',now(),now())";
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
</head>
<body>
	<div>
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