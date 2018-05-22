<?php 
include("./connex.php");

$user_address    = $_POST['user_address'];
$response        = array();
//	$cnn          = include;

if($user_address != null)
{
	$query = "SELECT * FROM users WHERE user_address = '$user_address'";
	 if(!$result = mysqli_query($cnn, $query))
	 {
 		exit(mysqli_error($cnn));
 	}
 	$data = mysqli_fetch_row($result);
 	$userid = (int) $data[0];

 	if (mysqli_num_rows($result) > 0) 
 		{
 		 $query2 = "SELECT * FROM wallet WHERE user_id = '$userid'";
	    	 if(!$result = mysqli_query($cnn, $query2))
	 		 	exit(mysqli_error($cnn));
	 		 else{
	 		 	while($row = mysqli_fetch_assoc($result))
		    	{
		    		$response = $row;
		    	}
		     }
	 	 }
	 	 else{
	 	 		$response['status'] = 404;
				$response['message'] = "Invalid Request !";	
 	     }	 
 	     
	    header('Content-type: application/json; charset=utf8');
    	echo json_encode($response);
}else{
		$response['status'] = 404;
		$response['message'] = "Invalid Request !";	
}
?>