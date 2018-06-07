<?php
include ("./connex.php");

$userid = $_POST['user_id'];
$name = $_POST['user_admin'];
$pass = $_POST['user_pass'];
$response = array();

if(isset($userid, $name, $pass))
{
    $query = "UPDATE admincenter SET user_admin = '$name', user_password = '$pass' WHERE id = '$userid'";
    if(!$result = mysqli_query($cnn, $query))
        exit(mysqli_error($cnn));
    else{
        $response['status'] = 200;
        $response['message'] = "Success";
        $response['flag'] = 1;
    }
}
else{
    $response['status'] = 404;
    $response['message'] = "Variables not set properly";
}

header('Content-type: application/json; charset=utf8');
echo json_encode($response);
?>