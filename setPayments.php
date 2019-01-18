<?php 

include("./connex.php");

$user_address   		= $_POST['user_address'];
$user_pw        		= $_POST['user_pw'];
$tranfer_amount 		= $_POST['user_amount'];
$tranfer_destination 	= $_POST['tranfer_address'];
$status                 = "pending";
$response 				= array(); //json_response
$succes 				= false; // flag
//$cnn  				=  include variable

#GET ENCRYPT KEYS
$salted = "4566654jyttgdjgghjygg".$user_pw."yqwsx6890d"; //encryptin pw
$hashed = hash("sha512", $salted); //encryptin pw
#HAShED ITS THE NEW PW

$query = "SELECT id_user FROM users WHERE user_address = '$user_address'";
    if (!$result = mysqli_query($cnn,$query)) 
        exit(mysqli_error($cnn));
    if (mysqli_num_rows($result) > 0) 
    {
        $data = mysqli_fetch_row($result);
        $userid = (int) $data[0];
    }

$query2 = "SELECT user_pw FROM users WHERE id_user = '$userid'";
	if (!$result = mysqli_query($cnn,$query2)) 
        exit(mysqli_error($cnn));
    if (mysqli_num_rows($result) > 0) 
    {
        $data2 = mysqli_fetch_row($result);
        $secret_pw = (string) $data2[0];
    }

    #VARIFY A SECRET PW HAS BEEN INITIALIZED
    if ($secret_pw == $hashed)
    {

	    $query3 = "SELECT * FROM wallet WHERE user_id = '$userid'";
		    if (!$result = mysqli_query($cnn,$query3)) 
		        exit(mysqli_error($cnn));

		    if(mysqli_num_rows($result)>0)
		    {
		        $query4 = "SELECT wallet_unlock FROM wallet WHERE user_id = '$userid'";
		        if (!$result = mysqli_query($cnn,$query4)) 
		            exit(mysqli_error($cnn));
		        else{
		        	$data3 = mysqli_fetch_row($result);
		    		$unlock_balance = (int) $data3[0];

		    		#NEW FILTER VALIDATION FOR WALLET CLAIMS CANT BE LESS THAN BALANCE
			        $queryAlt = "SELECT wallet_claims FROM wallet where user_id = '$userid'";
			        if (!$resultAlt = mysqli_query($cnn,$queryAlt)) 
			            exit(mysqli_error($cnn));
			        $dataAlt = mysqli_fetch_row($resultAlt);
			        $claims  = (int) $dataAlt[0];	
		        }
		        
		    }

		    #VERIFY ENOUGH BALANCE
		    if ($unlock_balance >= $tranfer_amount && $claims >= $unlock_balance) 
		    {
		    	$query5 = "INSERT INTO vf_payments(payments_balance,payments_status,payments_wallet,payments_date,user_id)VALUES('$tranfer_amount','$status','$tranfer_destination',now(),'$userid')";
		    		if (!$result = mysqli_query($cnn, $query5))
			 			exit(mysqli_error($cnn));
			 		else{
						$response['status'] = 200;
				        $response['message'] = "Succes !";
				        $succes = true;
					}

					#UPDATE WALLET BALANCE
					if ($succes) 
					{	

						$new_unlock = $unlock_balance - $tranfer_amount; //seting new unlock-faucet-balance

						$query6 = "SELECT wallet_withdraws FROM wallet WHERE user_id = '$userid'";
						    if (!$result = mysqli_query($cnn,$query6)) 
						        exit(mysqli_error($cnn));

					        $data4 = mysqli_fetch_row($result);
					        $wallet_withdraws = (int) $data4[0];
					        $new_withdraws = $wallet_withdraws + 1;

			 			$query7 = "UPDATE wallet SET wallet_unlock = '$new_unlock', wallet_withdraws = '$new_withdraws', paids_update = now() WHERE user_id ='$userid'";
						    if (!$result = mysqli_query($cnn, $query7)) 
						    {
						        exit(mysqli_error($cnn));
						    }else{
						        $response['status'] = 404;
						        $response['message'] = "Succes";
						        $succes = true;
						    }
					}

		    }else{
		    	$response['flag']   = 2;
		        $response['message'] = "You don't have enough money unluck. Please keep playing";
		        $response['status'] = 200;
			}

    } 
    else{
    	$response['flag']    = 1;
    	$response['message'] = "Your Password does not match. Please try again.";
    	$response['status']  = 200;
    }	
    
    header('Content-type: application/json; charset=utf8');
	echo json_encode($response);

 ?>