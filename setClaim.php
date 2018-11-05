<?php 
include ("./connex.php"); //include db connection. import $cnn variable.
$user_address   =  $_POST['user_address'];
$succes         = false; // flag
$response       =  array(); // json_response 
//  $cnn     = include

#
## REQUEST THE REWARD FROM CONFIG
#
$sql = "SELECT value FROM confg WHERE id_confg = '1'";
if(!$result = mysqli_query($cnn, $sql))
    exit(mysqli_error($cnn));
else{
    $data = mysqli_fetch_row($result);
    $reward = $data[0];
}

if ($user_address != null)
{
    $query = "SELECT id_user FROM users WHERE user_address = '$user_address'";
    if (!$result = mysqli_query($cnn,$query)) 
        exit(mysqli_error($cnn));

    if (mysqli_num_rows($result) > 0) 
    {
        $data = mysqli_fetch_row($result);
        $userid = (int) $data[0];
    }

    $query2 = "SELECT * FROM wallet WHERE user_id = '$userid'";
    if (!$result = mysqli_query($cnn,$query2)) 
        exit(mysqli_error($cnn));

    if(mysqli_num_rows($result)>0)
    {
        $query3 = "SELECT wallet_balance FROM wallet WHERE user_id = '$userid'";
        if (!$result = mysqli_query($cnn,$query3)) 
            exit(mysqli_error($cnn));
    }

    $data2 = mysqli_fetch_row($result);
    $old_balance = (int) $data2[0];
    $new_balance = $old_balance + $reward;

    if(mysqli_num_rows($result)>0)
    {
        $query4 = "SELECT wallet_claims FROM wallet WHERE user_id = '$userid'";
        if (!$result = mysqli_query($cnn,$query4)) 
            exit(mysqli_error($cnn));
    }

    $data3 = mysqli_fetch_row($result);
    $wallet_claims = (int) $data3[0];
    $new_claims = $wallet_claims + 1;

        $query5 = "UPDATE wallet SET wallet_balance = '$new_balance', wallet_claims = '$new_claims', paids_update = now() WHERE user_id ='$userid'";
        if (!$result = mysqli_query($cnn, $query5)) 
        {
            exit(mysqli_error($cnn));
        }else{
            $response['status'] = 200;
            $response['message'] = "Succes !";
            $succes = true;
        }
    

    if (!$succes) {
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