<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>SuperiorFaucet Verification</title>
    <style>
        .container {
            text-align: center;
            margin-top: 5%;
            font-size: 20px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="./assets/img/sup-logo.png" alt="SUP-logo">
        <div class="verify">
            <?php
                include("./connex.php");

                $user_email = $_GET['email'];
                $code  		= $_GET['hash'];
                $response   = array();
                //	$cnn    = include;

                if(isset($user_email) && !empty($user_email) AND isset($code) && !empty($code))
                {

                    $search = mysqli_query($cnn, "SELECT user_email, registration, active FROM users WHERE user_email='".$user_email."' AND registration='".$code."' AND active='0'") or die(mysqli_error($cnn));
                    $match = mysqli_num_rows($search);

                    if($match > 0)
                    {
                        //We have a match, active the account
                        mysqli_query($cnn, "UPDATE users SET active='1' WHERE user_email='".$user_email."' AND registration = '".$code."' AND active = '0'")or die(mysqli_error($cnn));
                        echo "Your account has been activated, feel free to LogIn and winning SUP.";
                        echo '<br/><a href="https://faucet.the-superior-coin.net/index.html">https://faucet.the-superior-coin.net/index.html</a>';
                    }else{
                        // No match -> invalid url or account has already been activated.
                        echo "The URL is either invalid or you already have activated your account";
                    }

                }else{
                    // Invalid approach
                    echo "Invalid Activation URL, please use the link that has been sent to your email";
                }

	?>
	</div>
</body>
</html>