<?php
include ("../connex.php");

$option = $_POST['option'];
$response = array();

if(isset($option))
{
    if($option == '1')
    {
        $reward = $_POST['reward'];
        if(isset($reward))
        {
            $query = "UPDATE confg SET value = '$reward' WHERE id_confg = '1'";
            if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));
            else{
                $response['status'] = 200;
                $response['message'] = "Success";
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
            $query = "UPDATE confg SET value = '$time' WHERE id_confg = '2'";
            if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));
            else{
                $response['status'] = 200;
                $response['message'] = "Success";
            }
            
        }else{
            $response['status'] = 404;
            $response['message'] = "Time not set properly";
        }
    }

    if($option == '3')
    {
        $href = $_POST['ref'];
        if(isset($href))
        {
            $query = "UPDATE confg SET value = '$href' WHERE id_confg = '3'";
            if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));
            else{
                $response['status'] = 200;
                $response['message'] = "Success";
            }
        }else{
            $response['status'] = 404;
            $response['message'] = "Href not set properly";
        }
    }

    if ($option == '4') 
    {
       $cron_mount = $_POST['cron_mount'];
       if(isset($cron_mount))
       {

            $query = "UPDATE confg SET value = '$cron-transfer' WHERE id_confg = '4' ";
            if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));
            else{
                $response['status'] = 200;
                $response['message'] = "Success";
            }
       }else{
            $response['status'] = 404;
            $response['message'] = "Cron-Transfer-Amount not set properly";
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