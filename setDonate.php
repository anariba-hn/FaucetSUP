<?php
include("./connex.php");
require "../vendor/autoload.php";
use Superior\Wallet;
$walletFaucet = new Superior\Wallet();

$action = $_POST['action'];
$response = array();

if(isset($action))
{
    #
    ##CREATE AN INTEGRATED ADDRESS AND PARSE JSON RESPONSE 
    #
    $integ = $walletFaucet->integratedAddress();
    $integResult = json_decode($integ);
    #PREPARE STRING FROM JSON SPLIT RESPONSE
    list($a) = explode(':', $integResult->{'integrated_address'});
    list($p) = explode(':', $integResult->{'payment_id'});
    #DELETE SPACES FROM STRING
    $integAddress = str_replace(' ', '', $a);
    $integPayment = str_replace(' ', '', $p);

    #
    ## SAVE CURRENT BLOCK 
    #
    $jsonHeight = $walletFaucet->getHeight();
    $block = json_decode($jsonHeight);
    $height = (int)$block->height;


    if($action == 1)
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $hyper = $_POST['hyper'];

        #
        ##COLLECT THE LAST ID - PLUS ONE - TO MAKE AN UNIQUE DONOR_ID 
        #
        $special = "SELECT id FROM donation order by id DESC limit 1";
        if (!$result = mysqli_query($cnn, $special))
            exit(mysqli_error($cnn));
        if(mysqli_num_rows($result) > 0)
        {
            $data = mysqli_fetch_row($result);
            $donor_id = (int)$data[0] + 1;
        }else{
            $donor_id = 1; //for the first donation
        }

        #
        ###VERIFY IF THE URL HAS A SECURE PROTOCOL
        #
        if(!filter_var($hyper, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED))
        {
            $response['message'] = "Your URL is not valid, please enter a Valid HTTPS";
            $response['status']  = 400;
        }
        else{
            $query = "INSERT INTO donation(name, email, integrated, payment_id, block, hyperlink, donor_id) VALUES('$name', '$email', '$integAddress', '$integPayment', '$height', '$hyper', '$donor_id')";
            if(!$result = mysqli_query($cnn, $query))
                exit(mysqli_error($cnn));
            else{
                $response['address'] = $integAddress;
                $response['message'] = "Succes";
                $response['status']  = 200;
            }
        }

        #
        ## IF EMAIL ALREADY EXIST ON DONOR_LIST WILL UPDATE DONOR_ID FROM LAST DONATION
        #
        $sql = "SELECT rel_id FROM get_donor_list WHERE email = '$email'";
        if(!$result = mysqli_query($cnn, $sql))
            exit(mysqli_error($cnn));
        if(mysqli_num_rows($result) > 0)
        {
            $data = mysqli_fetch_row($result);
            $rel_id = (int)$data[0];

            $update = "UPDATE donation SET donor_id = '$rel_id' WHERE payment_id = '$integPayment'";
            if(!$result = mysqli_query($cnn, $update))
                exit(mysqli_error($cnn));
        }
    }
    
    if($action == 2)
    {
        //SET A DEFAULT DONOR_ID AS ZERO FOR ANONYMUS DONATIONS
        $query2 = "INSERT INTO donation(integrated, payment_id, block, donor_id) VALUES('$integAddress','$integPayment', '$height', '0')";
        if(!$result = mysqli_query($cnn, $query2))
            exit(mysqli_error($cnn));
        else{
            $response['address'] = $integAddress;
            $response['message'] = "Succes";
            $response['status']  = 200;
        }
    }
    
}else{
    	$response['message'] = "Variables not set properly.";
    	$response['status']  = 404;    
}

header('Content-type: application/json; charset=utf8');
echo json_encode($response);
?>