<?php 

$response_recaptcha = $_POST['g-recaptcha-response'];
$json_data = array();

if(isset($response_recaptcha)&& $response_recaptcha)
{
	$secret = "6LdKHlcUAAAAANNw_Dbvb5oxQ7cFvwUcrNfKV0J1";
	$ip     = $_SERVER['REMOTE_ADDR'];
	$validation_server = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response_recaptcha&remoteip=$ip");

	if ($validation_server) 
	{
		$json_data['status'] = 404;
		$json_data['message'] = "succes";
	}
	else{
		$json_data['status'] = 200;
		$json_data['message'] = "faild";
	}

	header('Content-type: application/json; charset=utf8');
    echo json_encode($json_data);
}else{
	$json_data['status'] = 404;
	$json_data['message'] = "succes";
}

 ?>