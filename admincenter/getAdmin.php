<?php
include ("../connex.php");

$user_id = $_POST['user_id'];
$response = array();

if(isset($user_id))
{
    $query = "SELECT * FROM admincenter WHERE id = '$user_id'";
    if(!$result = mysqli_query($cnn, $query))
        exit(mysqli_error($cnn));
    if(mysqli_num_rows($result) > 0)
	    {
	    	while($row = mysqli_fetch_assoc($result))
	    	{
	    		$response = $row;
	    	}
	    }else{
	    		$response['status'] = 404;
				$response['message'] = "Invalid Request !";	
	    }
    
        header('Content-type: application/json; charset=utf8');
    	echo json_encode($response);
    
}else{
    
    $response['status'] = 404;
    $response['message'] = "Undefined ID !";
    
}

?>