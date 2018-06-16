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

    if($action == 1)
    {
        $name = $_POST['name'];
        $email = $_POST['email'];

        $query = "INSERT INTO donation(name, email, integrated, payment_id) VALUES('$name', '$email', '$integAddress', '$integPayment')";
        if(!$result = mysqli_query($cnn, $query))
            exit(mysqli_error($cnn));
        else{
            $response['address'] = $integAddress;
            $response['message'] = "Succes";
            $response['status']  = 200;
        }
    }
    
    if($action == 2)
    {
        
        $query2 = "INSERT INTO donation(integrated, payment_id) VALUES('$integAddress','$integPayment')";
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