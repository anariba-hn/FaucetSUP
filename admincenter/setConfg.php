<?php
include ("./connex.php");

$option = $_POST['option'];
$response = array();

if(isset($option))
{
    if($option == '1')
    {
        $reward = $_POST['reward'];
        if(isset($reward))
        {
            $query = "UPDATE confg SET reward = '$reward'";
            if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));
            else{
                $response['status'] = 200;
                $response['message'] = "Succes";
            }
            
        }else{
            $response['status'] = 404;
            $response['message'] = "Reward not set properly";
        }
    }
    
    if($option == '2')
    {
        $time = $_POST['time'];
        if(isset($time))
        {
            $query = "UPDATE confg SET time = '$time'";
            if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));
            else{
                $response['status'] = 200;
                $response['message'] = "Succes";
            }
            
        }else{
            $response['status'] = 404;
            $response['message'] = "Time not set properly";
        }
    }
    
}else{
    $response['status'] = 404;
    $response['message'] = "Variables not set properly";
    $response['flag'] = 3;
}

header('Content-type: application/json; charset=utf8');
echo json_encode($response);

?>