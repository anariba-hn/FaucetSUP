<?php 
include("./connex.php");

$user_address = $_POST['user_address'];
$response = array(); //json_response
$succes = false; // flag
//$cnn  =  include variable

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

    if(mysqli_num_rows($result)>0)
    {
        $query4 = "SELECT wallet_unlock FROM wallet WHERE user_id = '$userid'";
        if (!$result = mysqli_query($cnn,$query4)) 
            exit(mysqli_error($cnn));

        $data3 = mysqli_fetch_row($result);
        $old_unlock = (int) $data3[0];


        #NEW FILTER VALIDATION FOR WALLET CLAIMS CANT BE LESS THAN BALANCE
        $queryAlt = "SELECT wallet_claims FROM wallet where user_id = '$userid'";
        if (!$resultAlt = mysqli_query($cnn,$queryAlt)) 
            exit(mysqli_error($cnn));
        $dataAlt = mysqli_fetch_row($resultAlt);
        $claims  = (int) $dataAlt[0];

        if($old_unlock > $claims || $old_balance > $claims)
            break; 
        else
            $new_unlock = $old_balance + $old_unlock;
    }

    #$data3 = mysqli_fetch_row($result);
    #$old_unlock = (int) $data3[0];
    #$new_unlock = $old_balance + $old_unlock;
    

    if(mysqli_num_rows($result)>0)
    {
        $query5 = "SELECT wallet_paids FROM wallet WHERE user_id = '$userid'";
        if (!$result = mysqli_query($cnn,$query5)) 
            exit(mysqli_error($cnn));
    }

    $data4 = mysqli_fetch_row($result);
    $wallet_paids = (int) $data4[0];
    $new_paids = $wallet_paids + 1;

        $query6 = "UPDATE wallet SET wallet_balance = 0, wallet_unlock = '$new_unlock', wallet_paids = '$new_paids' WHERE user_id ='$userid'";
        if (!$result = mysqli_query($cnn, $query6)) 
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