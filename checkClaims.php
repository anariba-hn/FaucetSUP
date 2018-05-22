<?php 
include("./connex.php");

$user_address = $_POST['user_address'];
$response     = array();
//$cnn        = include

if($user_address != null)
{
		$query = "SELECT id_user FROM users WHERE user_address = '$user_address'";
		if (!$result = mysqli_query($cnn, $query))
			exit(mysqli_error($cnn));

		$data = mysqli_fetch_row($result);
		$userid = (int) $data[0];

		$query2 = "SELECT TIMESTAMPDIFF(MINUTE,MAX(paids_update),now()) as minutes FROM wallet WHERE user_id = '$userid'";
		if (!$result2 = mysqli_query($cnn, $query2)) 
			exit(mysqli_error($cnn));

		$data2 = mysqli_fetch_row($result2);
		$minutes = (int) $data2[0];
		$response = $minutes;

	header('Content-type: application/json; charset=utf8');
	echo json_encode($response);

}else{

	$response['status'] = 404;
	$response['message'] = "Invalid Request !";
}

 ?>