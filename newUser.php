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

                //Server settings
                //$mail->SMTPDebug = 2;                               // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'mail.faucet.the-superior-coin.net';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'admin@superior-coin.com';          // SMTP username
                $mail->Password = 'secret';                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('admin@superior-coin.com', 'Faucet');
                $mail->addAddress($user_email);               // Name is optional


                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'SignUp | Verification';
                $mail->Body    = 
                ' 
                <!DOCTYPE html>
                <html lang="">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title></title>
                    <style>

                        body{
                            margin: 0px;
                            padding: 0px;
                        }

                        .container{
                            width: 96.7%;
                            box-sizing: border-box;
                            text-align: center;
                            font-family: sans-serif;
                        }

                        .hero{
                            color: #6a4809;
                        }

                        .data{
                            width: auto;
                            text-align: left;
                            margin-left: 120px;
                            margin-right: 120px;
                            margin-top: 30px;
                            padding: 10px;
                            border: solid 1px;
                            border-radius: 25px;
                            background-color: rgba(106, 72, 9, 0.31);
                            box-shadow: 0px 0px 20px 0px inset #6a4809;
                        }

                        .hero img{
                            width: 150px;
                        }

                        .footer{
                            width: 100%;
                            height: 150px;
                            padding: 20px;
                            margin-top: 50px;
                            color: white;
                            background-color: #343a40;
                        }

                        .footer p{
                            font-size: 18px;
                        }

                        .footer a{
                            color: #6a4809;
                        }
                    </style>
                </head>

                <body>
                    <div class="container">
                        <div class="hero">
                            <img src="./assets/img/sup-logo.png" alt="SUP-LOGO">
                            <h2>Thanks for sign up to Superior Coin Faucet !</h2>
                        </div>
                        <div class="content">
                            <p>Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.</p>
                            <div class="data">
                            <p>Username:'.$user_email.'</p>
                            <p>Address:</p>'.$user_address.'
                            <p>Password:</p>'.$user_pw.'
                            </div>
                            <div class="redirect">
                                <p>Please click this link to activate your account: <a href="https://faucet.the-superior-coin.net/verify.php?email='.$user_email.'&hash='.$code.'">https://faucet.the-superior-coin.net/verify.php?email='.$user_email.'&hash='.$code.'</a></p>
                            </div>
                        </div>
                        <div class="footer">
                            <p>Learn How it works: <a href="https://steemit.com/superiorcoin/@joanstewart/how-new-faucet-for-superior-coin-works"> https://steemit.com/superiorcoin/@joanstewart/how-new-faucet-for-superior-coin-works</a></p>
                            <p>Check out our Telegram SUP Channel: <a href="https://t.me/superiorcoin"> https://t.me/superiorcoin</a></p>
                            <p>SuperiorCoin: <a href="https://www.superior-coin.com/"> https://www.superior-coin.com/</a></p>
                            <p>Kryptonia:<a href="https://kryptonia.io/"> https://kryptonia.io/</a></p>
                        </div>
                    </div>
                </body>
                </html>

                ';
                
                $mail->send();

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