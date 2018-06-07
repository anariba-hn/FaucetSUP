<?php
include ("../connex.php");

$userid = $_POST['user_id'];
$response = array();

if(isset($userid))
{
    $query = "DELETE FROM admincenter WHERE id = '$userid'";
    if(!$result = mysqli_query($cnn, $query))
        exit(mysqli_error($cnn));
    else
        $response['status'] = 200;
}else{
    $response['status'] = 404;
    $response['message'] = "Variables not set properly";
    $response['flag'] = 2;
}

header('Content-type: application/json; charset=utf8');
echo json_encode($response);
?>