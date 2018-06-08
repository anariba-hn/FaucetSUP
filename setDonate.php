<?php
include("./connex.php");
require "../vendor/autoload.php";
use Superior\Wallet;
$walletFaucet = new Superior\Wallet();

$name = $_POST['name'];
$email = $_POST['email'];
$action = $_POST['action'];
$response = array();

if(isset($action))
{
    if($action == 1)
    {
        $query = "INSERT INTO donation(name, email) VALUES('$name', '$email')";
        if(!$result = mysqli_query($cnn, $query))
            exit(mysqli_error($cnn));
        else{
            $response['message'] = "Succes.";
    	    $response['status']  = 200; 
        }
    }
    
    if($action == 2)
    {
        $integ = $walletFaucet->integratedAddress();
        $integResult = json_decode($integ);
        #PREPARE STRING FROM JSON SPLIT RESPONSE
		list($wallet) = explode(':', $integResult->{'integrated_address'});
		#DELETE SPACES FROM STRING
		$integAddress = str_replace(' ', '', $wallet);
        
        $query2 = "INSERT INTO donation(integrated) VALUES('$integAddress')";
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