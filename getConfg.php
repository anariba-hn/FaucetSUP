<?php
include ("./connex.php");

$option = $_POST['option'];
$response = array();

if(isset($option))
{
	if($option == '1')
	{
		$query = "SELECT value FROM confg WHERE id_confg = '1'";
        if(!$result = mysqli_query($cnn, $query))
            exit(mysqli_error($cnn));
        else{

            $data = mysqli_fetch_row($result);
            $reward = $data[0];
            $response['status'] = 200;
            $response['message'] = "Succes";
            $response['value'] = $reward;
        }
	}

    else if($option == '2')
    {
        $query = "SELECT value FROM confg WHERE id_confg = '2'";
        if(!$result = mysqli_query($cnn, $query))
            exit(mysqli_error($cnn));
        else{

            $data = mysqli_fetch_row($result);
            $time = $data[0];
            $response['status'] = 200;
            $response['message'] = "Succes";
            $response['value'] = $time;
        }
    }

    else if($option == '3')
    {
        $query = "SELECT value FROM confg WHERE id_confg = '3'";
        if(!$result = mysqli_query($cnn, $query))
            exit(mysqli_error($cnn));
        else{

            $data = mysqli_fetch_row($result);
            $href = $data[0];
            $response['status'] = 200;
            $response['message'] = "Succes";
            $response['value'] = $href;
        }
    }
    else{
        $response['status'] = 404;
        $response['message'] = "any option match";
    }

}else{
	$response['status'] = 404;
    $response['message'] = "Variables not set properly";
}

header('Content-type: application/json; charset=utf8');
echo json_encode($response);

?>