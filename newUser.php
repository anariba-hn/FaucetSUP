<?php 
include ("./connex.php"); //include db connection. import $cnn variable.

    $user_name    = $_POST['user_name'];
    $user_email   = $_POST['user_email'];
    $user_pw      = $_POST['user_pw'];
    $user_address = $_POST['user_address'];
    $succes  = false;
    $response= array();
    $type    = 0; //user_type will be 0 by default as player 1 will be donate member
//  $cnn     = include
 if($user_name != null && $user_email != null && $user_pw != null && $user_address != null)   
 {
	$query = "SELECT * FROM users WHERE user_email = '$user_email' or user_address = '$user_address'";
	if (!$result = mysqli_query($cnn, $query))
        exit(mysqli_error($cnn));
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$response = $row;
    	}
    }
    else
    {

    	$salted = "4566654jyttgdjgghjygg".$user_pw."yqwsx6890d"; //encryptin pw
        $hashed = hash("sha512", $salted); //encryptin pw
        $code   = md5(rand(0,1000)); //Generate random 32 character hash and assign it to a local variable. // Example output: f4552671f8909587cf485ea990207f3b
    	$query = "INSERT INTO users(user_name, user_email, user_pw, user_address, registration, active) VALUES('$user_name','$user_email','$hashed','$user_address','$code', '$type')";

    	if(!$result = mysqli_query($cnn,$query)) 
    	{
    		exit(mysqli_error($cnn));
    	}else{
            $query2 = "SELECT id_user FROM users WHERE user_address = '$user_address'";
            if(!$result = mysqli_query($cnn,$query2)) 
            {
                exit(mysqli_error($cnn));
            }

            $data = mysqli_fetch_row($result);
            $user_id = (int) $data[0];

            #SET COOKIE ON SERVER
            setcookie("walle", $user_id, time() + 846000);

            $query3 = "INSERT INTO wallet(wallet_balance,wallet_unlock,wallet_withdraws,wallet_paids,wallet_claims,paids_update,user_id)VALUES(0, 0, 0, 0,0,now(),'$user_id')";
            if(!$result = mysqli_query($cnn,$query3)) 
            {
                exit(mysqli_error($cnn));
            }else{

                #
                ##START VERIFICATION EMAIL ADDRESS
                #
                $to      = $user_email; 
                $subject = 'SignUp | Verification';
                $message =
 'Thanks for sign up to Superior Coin Faucet ! 
 
 Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
 --------------------------------------------------------------------- 
 Username: '.$user_email.' 
 Address : '.$user_address.' 
 Password: '.$user_pw.'
 ---------------------------------------------------------------------
 
 Please click this link to activate your account: https://faucet.the-superior-coin.net/verify.php?email='.$user_email.'&hash='.$code.'
 
 Learn How it works: https://steemit.com/superiorcoin/@joanstewart/how-new-faucet-for-superior-coin-works
 Check our Telegram SUP Channel: https://t.me/superiorcoin
 SuperiorCoin: https://www.superior-coin.com/
 Kryptonia: https://kryptonia.io/
 
 ';

                $headers = 'From:admin@superior.com' . "\r\n"; 
                mail($to, $subject, $message, $headers); //Send the email

                #JSON CREATE
                $response['status'] = 200;
                $response['message'] = "Succes !";
                $succes = true;
            }

        }

        if (!$succes) {
         $response['status'] = 404;
         $response['message'] = "Invalid Request !";
        }

    }
    header('Content-type: application/json; charset=utf8');
    echo json_encode($response);
}
else
{
	$response['status'] = 404;
	$response['message'] = "Invalid Request !";
}

 ?>