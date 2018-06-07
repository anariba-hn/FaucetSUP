<?php
include ("./connex.php");

$name = $_POST['user_admin'];
$pass = $_POST['user_password'];
$response = array();

if(isset($name, $pass))
{
    $query = "INSERT INTO admincenter(user_admin, user_password) VALUES('$name', '$pass')";
    if(!$result = mysqli_query($cnn, $query))
        exit(mysqli_error($cnn));
    else{
        $response['status'] = 200;
        $response['message'] = "Success";
    }
}
else{
    $response['status'] = 404;
    $response['message'] = "Variables not set properly";
}

header('Content-type: application/json; charset=utf8');
echo json_encode($response);
?>